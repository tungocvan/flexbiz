<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class SplitMigrationsCommand extends Command
{
    protected $signature = 'split:migrations {file}';

    protected $description = 'Split a migration containing multiple Schema::create into separate migration files and move original to _backup';

    public function handle(): int
    {
        $fileName = $this->argument('file');

        $paths = [
            database_path('migrations'),
            base_path('Modules'),
        ];

        $migrationPath = $this->findMigrationFile($fileName, $paths);

        if (! $migrationPath) {
            $this->error("Migration file not found: {$fileName}");
            return self::FAILURE;
        }

        $content = file_get_contents($migrationPath);

        preg_match_all(
            "/Schema::create\\(\\s*['\"]([^'\"]+)['\"]\\s*,\\s*function\\s*\\([^)]*\\)\\s*\\{([\\s\\S]*?)\\}\\s*\\);/m",
            $content,
            $matches,
            PREG_SET_ORDER
        );

        if (count($matches) < 2) {
            $this->info('Migration already compliant. No split needed.');
            return self::SUCCESS;
        }

        $this->info('Splitting migration: ' . basename($migrationPath));

        $timestampBase = $this->extractTimestamp(basename($migrationPath));
        $directory = dirname($migrationPath);

        foreach ($matches as $index => $match) {
            $table = $match[1];
            $schemaBody = trim($match[2]);

            $timestamp = date(
                'Y_m_d_His',
                strtotime($timestampBase . " +{$index} seconds")
            );

            $newFileName = "{$timestamp}_create_{$table}_table.php";
            $newPath = $directory . DIRECTORY_SEPARATOR . $newFileName;

            $migrationStub = <<<PHP
<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('{$table}', function (Blueprint \$table) {
{$schemaBody}
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('{$table}');
    }
};
PHP;

            file_put_contents($newPath, $migrationStub);

            $this->line("  → created {$newFileName}");
        }

        $this->moveToBackup($migrationPath);

        $this->info('Split completed successfully.');

        return self::SUCCESS;
    }

    private function extractTimestamp(string $fileName): string
    {
        // 2024_01_01_000001_xxx.php
        $parts = explode('_', $fileName);

        return "{$parts[0]}-{$parts[1]}-{$parts[2]} {$parts[3]}:{$parts[4]}:{$parts[5]}";
    }

    private function moveToBackup(string $migrationPath): void
    {
        $backupDir = database_path('migrations/_backup');

        if (! is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $backupPath = $backupDir
            . DIRECTORY_SEPARATOR
            . basename($migrationPath)
            . '.backup';

        if (file_exists($backupPath)) {
            $this->warn('Backup already exists: ' . basename($backupPath));
            return;
        }

        rename($migrationPath, $backupPath);

        $this->info('Original migration moved to _backup: ' . basename($backupPath));
    }

    private function findMigrationFile(string $input, array $paths): ?string
    {
        // Case 1: full / relative path
        if (file_exists(base_path($input))) {
            return realpath(base_path($input));
        }

        // Case 2: filename only (recursive search)
        foreach ($paths as $path) {
            if (! is_dir($path)) {
                continue;
            }

            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($path)
            );

            foreach ($iterator as $file) {
                if (
                    $file->isFile() &&
                    $file->getFilename() === $input &&
                    ! str_contains($file->getPathname(), '_backup')
                ) {
                    return $file->getRealPath();
                }
            }
        }

        return null;
    }
}
