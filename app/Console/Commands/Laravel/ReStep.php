<?php

namespace App\Console\Commands\Laravel;

use Illuminate\Console\Command;

class ReStep extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:restep {mode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback und erneute Durchführung der letzten Datenbankmigration.';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $mode = $this->argument('mode');

        if ($mode == 'n' || $mode == 'normal' || $mode == 'last') {
            $this->info('Rolling back the last migration...');
            \Artisan::call('migrate:rollback', ['--step' => 1]);
            $this->info(\Artisan::output());

            $this->info('Re-running the last migration...');
            \Artisan::call('migrate');
            $this->info(\Artisan::output());
            return Command::SUCCESS;
        }

        /** Dieser Modus ignoriert neue Tabellen.
         * Es wird die neueste mit "q" bezeichnete Tabelle neu Migriert und das Datum erneuert.
         * Diese soll als eine Art Arbeitstabelle dienen.
         */
        if ($mode == 'q' || $mode == 'quartal' || $mode == 'current') {
            if (!\Schema::hasTable('migrations')) {
                $this->error('Migration table not found.');
                return Command::FAILURE;
            }

            // Get the last batch number
            $lastBatchNumber = \DB::table('migrations')->max('batch');

            // Get the last migration with a 'q' in the name from the last batch
            $lastMigrationWithQ = \DB::table('migrations')
                ->where('migration', 'like', '%q%')
                ->where('batch', $lastBatchNumber)
                ->orderBy('migration', 'desc')
                ->first();

            if (!$lastMigrationWithQ) {
                $this->info('No migration with "q" in the name found in the last batch.');
                return Command::SUCCESS;
            }
        }

        return Command::FAILURE;
    }

    public function MoveQTableToTop($lastMigrationWithQ)
    {
        $currentTime = now();

        // Re-run the specific migration
        $this->info("Re-running the migration: {$lastMigrationWithQ->migration}");
        \Artisan::call('migrate', [
            '--path' => $this->getMigrationPath($lastMigrationWithQ->migration)
        ]);

        // Update the migration batch to the current time to maintain the order
        \DB::table('migrations')
            ->where('migration', $lastMigrationWithQ->migration)
            ->update(['batch' => $currentTime]);

        $this->info("Migration {$lastMigrationWithQ->migration} has been re-run and updated successfully.");
    }
}
