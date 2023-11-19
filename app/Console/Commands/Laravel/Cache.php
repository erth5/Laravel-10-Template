<?php

namespace App\Console\Commands\Laravel;

use Illuminate\Console\Command;

class Cache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cache {clear}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->argument('clear')) {
            // Cache::flush();
            cache()->flush();
            opcache_reset();
            \Artisan::call('optimize:clear'); // Sämtliche Caches löschen

            if (config('on_linux')) {
                $this->clearComposerCache('rm -rf ~/.composer/cache');
            }

            if (config('on_windows')) {
                $this->clearComposerCache('rmdir /s /q %USERPROFILE%\AppData\Roaming\Composer\Cache');
            }
        } else {
            \Artisan::call('optimize');
            // \Artisan::call('route:cache');
            // \Artisan::call('config:cache');
            // \Artisan::call('view:cache');
        }
    }
    public function clearComposerCache($command)
    {
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            logger()->error("Fehler beim Leeren des Composer-Cache: " . implode("\n", $output));
        } else {
            logger()->info("Composer-Cache erfolgreich geleert.");
        }
    }
}
