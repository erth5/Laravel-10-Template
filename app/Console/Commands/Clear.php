<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Clear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:clear';

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
        // Cache::flush();
        cache()->flush();
        opcache_reset();
        // rm -rf ~/.composer/cache - rmdir /s /q %USERPROFILE%\AppData\Roaming\Composer\Cache
    }
}
