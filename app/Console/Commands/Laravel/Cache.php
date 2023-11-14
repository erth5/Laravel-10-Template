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
        if($this->argument('clear')){
            // Cache::flush();
            cache()->flush();
            opcache_reset();
            \Artisan::call('optimize:clear'); // Sämtliche Caches löschen
        }else{
            \Artisan::call('route:cache');
            \Artisan::call('config:cache');
            \Artisan::call('view:cache');
        }
    }
}
