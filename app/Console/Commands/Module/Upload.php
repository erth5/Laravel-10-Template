<?php

namespace App\Console\Commands\Module;

use Illuminate\Console\Command;
use ZipArchive;

class Upload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:upload {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Neue Version eines Moduls hochladen';

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
        if(zipFolder($moduleFolder, $moduleFolder)) {

        } else {
            $this->info("Fehlgeschlagen");
        }
    }

    public function zipFolder($folderPath, $zipFilePath)
    {
        $zip = new ZipArchive();

        // ZIP-Datei öffnen bzw. erstellen
        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {

            // Dateien und Unterverzeichnisse im Zielverzeichnis durchlaufen
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($folderPath),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file) {
                // Direktorien überspringen
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($folderPath) + 1);

                    // Datei zur ZIP-Datei hinzufügen
                    $zip->addFile($filePath, $relativePath);
                }
            }

            $zip->close();

            return true;
        } else {
            return false;
        }
    }
    public function upload($moduleFolder){
        // $this->serverUrl ... $moduleFolder
    }

}
