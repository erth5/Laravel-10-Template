<?php

namespace App\Console\Commands\Module;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:deploy {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Führt den Download und die Installation eines Moduls aus.php artisan make:command Module/Download';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = strtolower($this->argument('name'));
        Artisan::call('module:download', ['name' => $name]);
        Artisan::call('module:install', ['name' => $name]);
    }
}
