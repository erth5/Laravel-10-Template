<?php

namespace App\Console\Commands\Module;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Delete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:delete {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Entfernt einen Modul Ordner';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = strtolower($this->argument('name'));
        if (!is_dir(modules_path($name))) {
            File::deleteDirectory(modules_path($name));
        } else {
            $this->warning("Modul Ordner existiert nicht.");
        }
    }
}
