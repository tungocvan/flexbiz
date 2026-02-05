<?php

namespace App\Support\SchemaSnapshot;

class SnapshotRenderer
{
    public function render(array $tables): string
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
{$this->renderTables($tables)}
{$this->renderIndexes($tables)}
{$this->renderForeignKeys($tables)}
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

    protected function renderTables(array $tables): string
    {
        $out = '';
        foreach ($tables as $table) {
            $out .= "        Schema::create('{$table['name']}', function (Blueprint \$table) {\n";
            foreach ($table['columns'] as $col) {
                $out .= $this->column($col);
            }
            $out .= "        });\n\n";
        }
        return $out;
    }

    protected function renderIndexes(array $tables): string
    {
        $out = '';
        foreach ($tables as $table) {
            foreach ($table['indexes'] as $name => $idx) {
                if ($name === 'PRIMARY') continue;

                $cols = implode("','", $idx['columns']);
                $method = $idx['unique'] ? 'unique' : 'index';

                $out .= <<<PHP
        Schema::table('{$table['name']}', function (Blueprint \$table) {
            \$table->$method(['$cols'], '$name');
        });

PHP;
            }
        }
        return $out;
    }

    protected function renderForeignKeys(array $tables): string
    {
        $out = '';
        foreach ($tables as $table) {
            foreach ($table['foreign_keys'] as $fk) {
                $out .= <<<PHP
        Schema::table('{$table['name']}', function (Blueprint \$table) {
            \$table->foreign('{$fk['column']}', '{$fk['name']}')
                ->references('{$fk['ref_column']}')
                ->on('{$fk['ref_table']}')
                ->onUpdate('{$fk['on_update']}')
                ->onDelete('{$fk['on_delete']}');
        });

PHP;
            }
        }
        return $out;
    }

    /**
     * Column rendering – CRITICAL logic
     */
    protected function column(object $c): string
    {
        $line = "            ";
        $type = strtolower($c->type);
        $extra = strtolower($c->extra ?? '');

        /* ---------- TYPE ---------- */
        if (str_contains($type, 'bigint')) {
            $line .= "\$table->bigInteger('{$c->name}')";
        } elseif (str_contains($type, 'int')) {
            $line .= "\$table->integer('{$c->name}')";
        } elseif (str_contains($type, 'varchar')) {
            $line .= "\$table->string('{$c->name}', {$c->length})";
        } elseif (str_contains($type, 'text')) {
            $line .= "\$table->text('{$c->name}')";
        } elseif (str_contains($type, 'timestamp')) {
            $line .= "\$table->timestamp('{$c->name}')";
        } else {
            $line .= "\$table->string('{$c->name}')";
        }

        /* ---------- NULLABLE ---------- */
        if ($c->nullable === 'YES') {
            $line .= "->nullable()";
        }

        /* ---------- TIMESTAMP SEMANTICS ---------- */
        if (str_contains($type, 'timestamp')) {

            if (
                $c->default_value &&
                str_contains(strtoupper($c->default_value), 'CURRENT_TIMESTAMP')
            ) {
                $line .= "->useCurrent()";
            }

            if (str_contains($extra, 'on update current_timestamp')) {
                $line .= "->useCurrentOnUpdate()";
            }

            return $line . ";\n";
        }

        /* ---------- NORMAL DEFAULT ---------- */
        if ($c->default_value !== null) {
            $line .= "->default(" . var_export($c->default_value, true) . ")";
        }

        return $line . ";\n";
    }


}
