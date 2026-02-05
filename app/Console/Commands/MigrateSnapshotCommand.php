<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class MigrateSnapshotCommand extends Command
{
    protected $signature = 'migrate:snapshot {--force}';
    protected $description = 'Create a full schema snapshot migration (tables, indexes, foreign keys)';

    protected string $snapshotPath = 'database/migrations/0000_00_00_000000_schema_snapshot.php';

    public function handle(): int
    {
        if (File::exists(base_path($this->snapshotPath)) && !$this->option('force')) {
            $this->error('Schema snapshot already exists. Use --force to overwrite.');
            return self::FAILURE;
        }

        $schema = $this->buildSchema();

        File::put(
            base_path($this->snapshotPath),
            $this->migrationStub($schema)
        );

        $this->backupOldMigrations();

        $this->info('✅ Schema snapshot created successfully');
        return self::SUCCESS;
    }

    /**
     * Build schema from INFORMATION_SCHEMA
     */
    protected function buildSchema(): string
    {
        $database = DB::getDatabaseName();
        $tables = DB::select(
            'SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = ?',
            [$database]
        );

        $schema = '';

        foreach ($tables as $table) {
            $schema .= $this->buildTable($table->TABLE_NAME);
        }

        return $schema;
    }

    protected function buildTable(string $table): string
    {
        $columns = DB::select("
            SELECT * FROM information_schema.columns
            WHERE table_schema = DATABASE() AND table_name = ?
            ORDER BY ORDINAL_POSITION
        ", [$table]);

        $indexes = DB::select("
            SELECT * FROM information_schema.statistics
            WHERE table_schema = DATABASE() AND table_name = ?
        ", [$table]);

        $foreignKeys = DB::select("
            SELECT
                kcu.constraint_name,
                kcu.column_name,
                kcu.referenced_table_name,
                kcu.referenced_column_name,
                rc.update_rule,
                rc.delete_rule
            FROM information_schema.key_column_usage kcu
            JOIN information_schema.referential_constraints rc
                ON kcu.constraint_name = rc.constraint_name
            WHERE kcu.table_schema = DATABASE()
              AND kcu.table_name = ?
              AND kcu.referenced_table_name IS NOT NULL
        ", [$table]);

        $code = "Schema::create('$table', function (Blueprint \$table) {\n";

        foreach ($columns as $column) {
            $code .= $this->columnToSchema($column);
        }

        $code .= "});\n\n";

        $code .= $this->buildIndexes($table, $indexes);
        $code .= $this->buildForeignKeys($table, $foreignKeys);

        return $code;
    }

    protected function columnToSchema(object $c): string
    {
        $nullable = $c->IS_NULLABLE === 'YES' ? '->nullable()' : '';
        $default = $c->COLUMN_DEFAULT !== null
            ? "->default(" . var_export($c->COLUMN_DEFAULT, true) . ")"
            : '';

        return match (true) {
            str_contains($c->COLUMN_TYPE, 'bigint') =>
                "    \$table->bigInteger('{$c->COLUMN_NAME}')$nullable$default;\n",
            str_contains($c->COLUMN_TYPE, 'int') =>
                "    \$table->integer('{$c->COLUMN_NAME}')$nullable$default;\n",
            str_contains($c->COLUMN_TYPE, 'varchar') =>
                "    \$table->string('{$c->COLUMN_NAME}', {$c->CHARACTER_MAXIMUM_LENGTH})$nullable$default;\n",
            str_contains($c->COLUMN_TYPE, 'text') =>
                "    \$table->text('{$c->COLUMN_NAME}')$nullable;\n",
            str_contains($c->COLUMN_TYPE, 'timestamp') =>
                "    \$table->timestamp('{$c->COLUMN_NAME}')$nullable$default;\n",
            default =>
                "    \$table->string('{$c->COLUMN_NAME}')$nullable;\n",
        };
    }

    protected function buildIndexes(string $table, array $indexes): string
    {
        $grouped = collect($indexes)->groupBy('INDEX_NAME');

        $code = '';
        foreach ($grouped as $name => $items) {
            if ($name === 'PRIMARY') continue;

            $cols = $items->pluck('COLUMN_NAME')->map(fn($c) => "'$c'")->implode(', ');
            $unique = $items->first()->NON_UNIQUE == 0;

            $method = $unique ? 'unique' : 'index';

            $code .= "Schema::table('$table', function (Blueprint \$table) {\n";
            $code .= "    \$table->$method([$cols], '$name');\n";
            $code .= "});\n\n";
        }

        return $code;
    }

    protected function buildForeignKeys(string $table, array $keys): string
    {
        $code = '';

        foreach ($keys as $fk) {
            $code .= "Schema::table('$table', function (Blueprint \$table) {\n";
            $code .= "    \$table->foreign('{$fk->column_name}')\n";
            $code .= "        ->references('{$fk->referenced_column_name}')\n";
            $code .= "        ->on('{$fk->referenced_table_name}')\n";
            $code .= "        ->onUpdate('{$fk->update_rule}')\n";
            $code .= "        ->onDelete('{$fk->delete_rule}');\n";
            $code .= "});\n\n";
        }

        return $code;
    }

    protected function migrationStub(string $schema): string
    {
        return <<<PHP
<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up(): void
    {
$schema
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach (Schema::getAllTables() as \$table) {
            Schema::drop(\$table);
        }

        Schema::enableForeignKeyConstraints();
    }
};
PHP;
    }

    protected function backupOldMigrations(): void
    {
        $timestamp = now()->format('Y_m_d_His');
        $backupDir = database_path("migrations/_backup/$timestamp");

        File::ensureDirectoryExists($backupDir);

        $finder = (new Finder())
            ->files()
            ->in(database_path('migrations'))
            ->name('*.php')
            ->notName('*schema_snapshot.php')
            ->notPath('_backup');

        foreach ($finder as $file) {
            File::move(
                $file->getRealPath(),
                $backupDir . '/' . $file->getFilename()
            );
        }
    }
}
