<?php

namespace App\Console\Commands\Module;

use Illuminate\Console\Command;

class Uninstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:uninstall {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    const SUCCESS = 0;
    const RUNTIME_FAULT = 1;
    const SYNTAX_FAULT = 2;
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = strtolower($this->argument('name'));
        $moduleFolder = base_path(modules_path($this->name));
    }
}
