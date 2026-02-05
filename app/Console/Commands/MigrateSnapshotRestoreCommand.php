<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class MigrateSnapshotRestoreCommand extends Command
{
    protected $signature = 'migrate:snapshot:restore {timestamp=latest} {--force}';

    protected $description = 'Restore migrations from snapshot backup';

    public function handle(): int
    {
        $backupRoot = database_path('migrations/_backup');

        if (! is_dir($backupRoot)) {
            $this->error('No backup directory found.');
            return self::FAILURE;
        }

        $timestamp = $this->argument('timestamp');

        $target = $timestamp === 'latest'
            ? $this->getLatestBackup($backupRoot)
            : $backupRoot . DIRECTORY_SEPARATOR . $timestamp;

        if (! is_dir($target)) {
            $this->error("Backup [$timestamp] not found.");
            return self::FAILURE;
        }

        if (! $this->option('force')) {
            if (! $this->confirm("Restore migrations from [$target]?")) {
                $this->info('Aborted.');
                return self::SUCCESS;
            }
        }

        $this->restoreFromBackup($target);

        $this->info('♻️ Migrations restored successfully.');

        return self::SUCCESS;
    }

    protected function getLatestBackup(string $root): string
    {
        $dirs = collect(File::directories($root))->sort()->values();

        return $dirs->last();
    }

    protected function restoreFromBackup(string $backupPath): void
    {
        $finder = Finder::create()->files()->in($backupPath)->name('*.php');

        foreach ($finder as $file) {
            $relative = str_replace($backupPath, '', $file->getRealPath());
            $target = base_path($relative);

            @mkdir(dirname($target), 0777, true);
            rename($file->getRealPath(), $target);
        }
    }
}
