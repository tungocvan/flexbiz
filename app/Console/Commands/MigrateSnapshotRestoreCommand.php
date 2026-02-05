<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MigrateSnapshotRestoreCommand extends Command
{
    protected $signature = 'migrate:snapshot:restore {timestamp}';
    protected $description = 'Restore migrations from snapshot backup';

    public function handle(): int
    {
        $timestamp = $this->argument('timestamp');
        $backupPath = database_path("migrations/_backup/$timestamp");

        if (!File::exists($backupPath)) {
            $this->error("Backup [$timestamp] not found.");
            return self::FAILURE;
        }

        foreach (File::files($backupPath) as $file) {
            File::move(
                $file->getRealPath(),
                database_path('migrations/' . $file->getFilename())
            );
        }

        $this->info('✅ Migrations restored successfully');
        return self::SUCCESS;
    }
}
