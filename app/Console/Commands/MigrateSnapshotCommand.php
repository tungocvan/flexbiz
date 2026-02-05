<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class MigrateSnapshotCommand extends Command
{
    protected $signature = 'migrate:snapshot {--force : Skip confirmation}';

    protected $description = 'Snapshot current database schema into a single migration and backup all existing migrations';

    protected Migrator $migrator;

    public function __construct(Migrator $migrator)
    {
        parent::__construct();
        $this->migrator = $migrator;
    }

    public function handle(): int
    {
        if (! $this->option('force')) {
            if (! $this->confirm('This will snapshot the current database schema and move ALL existing migrations to backup. Continue?')) {
                $this->info('Aborted.');
                return self::SUCCESS;
            }
        }

        $this->info('📸 Generating schema snapshot...');

        $snapshotMigrationPath = database_path('migrations/0000_00_00_000000_schema_snapshot.php');

        if (file_exists($snapshotMigrationPath)) {
            $this->error('Snapshot migration already exists.');
            return self::FAILURE;
        }

        $schemaDump = $this->generateSchemaSnapshot();

        file_put_contents(
            $snapshotMigrationPath,
            $this->wrapMigration($schemaDump)
        );

        $this->info('✅ Snapshot migration created.');

        $this->backupExistingMigrations($snapshotMigrationPath);

        $this->info('📦 All existing migrations backed up.');

        return self::SUCCESS;
    }

    protected function generateSchemaSnapshot(): string
    {
        $tables = DB::select('SHOW FULL TABLES WHERE Table_type = "BASE TABLE"');

        $schema = '';

        foreach ($tables as $row) {
            $table = array_values((array) $row)[0];

            $schema .= $this->renderTable($table) . PHP_EOL . PHP_EOL;
        }

        return trim($schema);
    }

    protected function renderTable(string $table): string
    {
        $columns = DB::select("SHOW FULL COLUMNS FROM `$table`");
        $indexes = DB::select("SHOW INDEX FROM `$table`");
        $foreignKeys = DB::select("
            SELECT
                k.COLUMN_NAME,
                k.REFERENCED_TABLE_NAME,
                k.REFERENCED_COLUMN_NAME,
                r.UPDATE_RULE,
                r.DELETE_RULE
            FROM information_schema.KEY_COLUMN_USAGE k
            JOIN information_schema.REFERENTIAL_CONSTRAINTS r
              ON k.CONSTRAINT_NAME = r.CONSTRAINT_NAME
             AND k.CONSTRAINT_SCHEMA = r.CONSTRAINT_SCHEMA
            WHERE k.TABLE_SCHEMA = DATABASE()
              AND k.TABLE_NAME = ?
              AND k.REFERENCED_TABLE_NAME IS NOT NULL
        ", [$table]);

        $create = "Schema::create('$table', function (Blueprint \$table) {\n";

        foreach ($columns as $column) {
            $create .= '    ' . $this->renderColumn($column) . "\n";
        }

        $this->renderIndexes($indexes, $create);

        foreach ($foreignKeys as $fk) {
            $create .= "    \$table->foreign('{$fk->COLUMN_NAME}')"
                . "->references('{$fk->REFERENCED_COLUMN_NAME}')"
                . "->on('{$fk->REFERENCED_TABLE_NAME}')"
                . "->onUpdate('{$fk->UPDATE_RULE}')"
                . "->onDelete('{$fk->DELETE_RULE}');\n";
        }

        $create .= "});";

        return <<<PHP
if (!Schema::hasTable('$table')) {
    $create
}
PHP;
    }

    protected function renderColumn(object $column): string
    {
        $type = $this->mapColumnType($column->Type);
        $line = "\$table->$type('{$column->Field}')";

        if ($column->Null === 'YES') {
            $line .= '->nullable()';
        }

        if ($column->Default !== null) {
            if (Str::contains($column->Default, 'CURRENT_TIMESTAMP')) {
                if (Str::contains($column->Extra, 'on update')) {
                    $line .= '->useCurrentOnUpdate()';
                } else {
                    $line .= '->useCurrent()';
                }
            } else {
                $line .= "->default(" . var_export($column->Default, true) . ")";
            }
        }

        if ($column->Extra === 'auto_increment') {
            $line = "\$table->id()";
        }

        if ($column->Collation) {
            $line .= "->collation('{$column->Collation}')";
        }

        return $line . ';';
    }

    protected function mapColumnType(string $type): string
    {
        return match (true) {
            str_starts_with($type, 'bigint') => 'bigInteger',
            str_starts_with($type, 'int') => 'integer',
            str_starts_with($type, 'varchar') => 'string',
            str_starts_with($type, 'text') => 'text',
            str_starts_with($type, 'timestamp') => 'timestamp',
            str_starts_with($type, 'datetime') => 'dateTime',
            str_starts_with($type, 'date') => 'date',
            default => 'string',
        };
    }

    protected function renderIndexes(array $indexes, string &$schema): void
    {
        $grouped = [];

        foreach ($indexes as $index) {
            $grouped[$index->Key_name][] = $index;
        }

        foreach ($grouped as $name => $items) {
            if ($name === 'PRIMARY') {
                continue;
            }

            $columns = collect($items)->pluck('Column_name')->all();
            $unique = $items[0]->Non_unique == 0;

            $schema .= '    $table->' . ($unique ? 'unique' : 'index')
                . '(' . var_export($columns, true) . ");\n";
        }
    }

    protected function wrapMigration(string $schema): string
    {
        return <<<PHP
<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::defaultStringLength(191);

$schema
    }

    public function down(): void
    {
        // intentionally empty
    }
};
PHP;
    }

    protected function backupExistingMigrations(string $snapshotPath): void
    {
        $timestamp = now()->format('Ymd_His');
        $backupRoot = database_path("migrations/_backup/$timestamp");

        foreach ($this->migrator->paths() as $path) {
            if (! is_dir($path)) {
                continue;
            }

            $finder = Finder::create()->files()->in($path)->name('*.php');

            foreach ($finder as $file) {
                if ($file->getRealPath() === realpath($snapshotPath)) {
                    continue;
                }

                $relative = Str::after($file->getRealPath(), base_path());
                $target = $backupRoot . $relative;

                @mkdir(dirname($target), 0777, true);
                rename($file->getRealPath(), $target);
            }
        }
    }
}
