<?php

namespace App\Console\Commands\Module;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Purge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:purge {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deinstalliert ein Modul und entfernt dessen Daten.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = strtolower($this->argument('name'));
        Artisan::call('module:uninstall', ['name' => $name]);
        Artisan::call('module:delete', ['name' => $name]);
    }
}
