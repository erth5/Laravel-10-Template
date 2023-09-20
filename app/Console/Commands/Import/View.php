<?php

namespace App\Console\Commands\Import;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class View extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:view {project} {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kopiere Livewire Views von einem Referenzprojekt in dieses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $resource = $this->argument('model');
        $projectPath = dirname(base_path()) . "/" . $this->argument('project');

        if (!File::exists($projectPath . '/app/Http/Livewire/' . ucfirst($resource) . '.php')) {
            echo "Model konnte nicht gefunden werden.";
            return 0;
        }
        echo "Dein Referenzprojekt ist: $projectPath" . PHP_EOL;

        $folderPaths = [app_path('View'), app_path('Http/Livewire'), app_path('View/Components'), resource_path('views/livewire')];
        foreach ($folderPaths as $path) {
            if (!File::exists($path)) {
                File::makeDirectory($path);
                echo "Verzeichnis $path erstellt" . PHP_EOL;
            }
        }

        $paths = [
            'app/Http/Livewire/' . ucfirst($resource) . '.php',
            'resources/views/livewire/' . strtolower($resource) . '.blade.php',
        ];

        foreach ($paths as $filePath) {
            $dest = base_path() . "/" . $filePath;
            $src = $projectPath . "/" . $filePath;

            if (!File::exists($src)) {
                echo "Datei $src nicht gefunden" . PHP_EOL;
                continue;
            }

            try {
                if (File::exists($src)) {
                    if (!copy($src, $dest)) {
                        echo "Fehler beim Kopieren von $src nach $dest" . PHP_EOL;
                    }
                }
            } catch (\Exception $e) {
                echo "Quellpfad: $src" . PHP_EOL;
                echo "Zielpfad: $dest" . PHP_EOL . PHP_EOL;
                echo $e . PHP_EOL;
            }
        }
    }
}
