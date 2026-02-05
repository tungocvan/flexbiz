<?php

namespace App\Support\SchemaSnapshot;

use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Str;

class MigrationBackup
{
    protected function backup(Migrator $migrator): void
    {
        $timestamp = now()->format('Y_m_d_His');
        $backupRoot = database_path("migrations/_backup/$timestamp");

        File::ensureDirectoryExists($backupRoot);

        $paths = array_merge(
            [database_path('migrations')],
            $migrator->paths()
        );

        $finder = new Finder();
        $finder
            ->files()
            ->in($paths)
            ->name('*.php')
            ->notName('*schema_snapshot.php')
            ->notPath('_backup');

        foreach ($finder as $file) {
            $relative = Str::after(
                $file->getRealPath(),
                base_path() . DIRECTORY_SEPARATOR
            );

            $target = $backupRoot . DIRECTORY_SEPARATOR . $relative;

            File::ensureDirectoryExists(dirname($target));
            File::move($file->getRealPath(), $target);
        }

        $this->info("📦 Backed up migrations to: database/migrations/_backup/$timestamp");
    }

    public function restore(string $source): void
    {
        foreach (File::files($source) as $file) {
            File::move(
                $file->getRealPath(),
                database_path('migrations/' . $file->getFilename())
            );
        }
    }
}
