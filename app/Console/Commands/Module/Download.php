<?php

namespace App\Console\Commands\Module;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use ZipArchive;

class Download extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:download {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloaded und Extrahiert das Modul';

    protected $name;
    protected $serverUrl;
    protected $serverPath;
    protected $password;
    
    public function __construct()
    {
        parent::__construct();
        $this->serverUrl = env('MODULE_SERVER_URL');
        $this->serverPath = env('MODULE_SERVER_PATH');
        $this->password = env('MODULE_SERVER_PASSWORD');
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->name = strtolower($this->argument('name'));
        $moduleFolder = base_path(modules_path($this->name));

        $this->prepareDirectory($moduleFolder);
        $this->download();
        $this->extract();

        $this->info("Batch file executed successfully.");
    }
    protected function prepareDirectory(string $moduleFolder)
    {
        if (!File::exist('modules')) {
            File::makeDirectory('modules');
        }

        if (!File::exists($moduleFolder)) {
            if (File::makeDirectory($moduleFolder, 0755, true)) {
                $this->info("Successfully created folder: {$moduleFolder}");
            } else {
                $this->error("Failed to create folder.");
            }
        } else {
            File::cleanDirectory($moduleFolder);
            $this->info("Existing directory cleaned.");
        }
    }

    protected function download()
    {
        $saveFile = modules_path($this->name);
        // Your download and save logic here
        File::put($saveFile, file_get_contents("$this->serverUrl/modules/$this->name.zip"));
    }

    protected function extract()
    {
        $zip = new ZipArchive;
        $path = "modules/$this->name/pack.zip";
        $extractPath = modules_path();

        if ($zip->open($path) === true) {
            $zip->extractTo($extractPath);
            $zip->close();
        } else {
            $this->error("Failed Extract Zip");
        }
    }
}
