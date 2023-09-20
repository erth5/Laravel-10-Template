<?php

namespace App\Console\Commands\Import;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Doctrine\Inflector\InflectorFactory;

class Resource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:resource {project} {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kopiere eine Resource von einem anderen Projekt in dieses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $resource = ucwords($this->argument('model'));
        $projectPath = dirname(base_path()) . "/" . $this->argument('project');

        if (!File::exists($projectPath . '/app/Models/' . $resource . '.php')) {
            echo "Model konnte nicht gefunden werden." . PHP_EOL;
            return 0;
        }

        // $modelPath = $projectPath . '/app/Models/' . $resource . '.php';
        // $files = File::files(dirname($modelPath));
        // $fileFound = collect($files)->contains(function ($file) use ($modelPath) {
        //     echo $file->getPathname();
        //     return $modelPath === $file->getPathname();
        // });

        // if (!$fileFound) {
        //     echo "Model konnte nicht gefunden werden (case-sensitive Prüfung)." . PHP_EOL;
        //     return 0;
        // }
        echo "Dein Referenzprojekt ist: $projectPath" . PHP_EOL;

        $folderPaths = [app_path('Services'), app_path('Http/Requests'), app_path('Policies'), app_path('Observers')];
        foreach ($folderPaths as $path) {
            if (!File::exists($path)) {
                File::makeDirectory($path);
                echo "Verzeichnis $path erstellt" . PHP_EOL;
            }
        }

        $paths = [
            'app/Models/' . $resource . '.php',
            'app/Http/Controllers/' . $resource . 'Controller.php',
            'app/Policies/' . $resource . 'Policy.php',
            'app/Http/Requests/Store' . $resource . 'Request.php',
            'app/Http/Requests/Update' . $resource . 'Request.php',
            'database/factories/' . $resource . 'Factory.php',
            'database/seeders/' . $resource . 'Seeder.php',

            'app/Observers/' . $resource . 'Observer.php',
        ];

        /* ### Migration ### */
        $inflector = InflectorFactory::create()->build();
        $tableName = "_create_" . strtolower(Str::plural(Str::snake($resource))) . "_table.php";
        $allMigrations = scandir("$projectPath/database/migrations/");
        $migrationPath = "$projectPath/database/migrations/*.php";
        $migrations = null;

        foreach (glob($migrationPath) as $migration) {

            if (str_ends_with($migration, $tableName) !== false) {
                $migrations[] = $migration;
            }
        }
        if ($migrations == null) {
            echo "Keine Migration gefunden" . PHP_EOL;
            echo  $tableName . PHP_EOL;
        } else {
            if (count($migrations) == 1) {
                echo "Gefundene Migration: " . $migrations[0] . PHP_EOL;
                $dest = database_path('migrations/' . basename($migrations[0]));
                if (!copy($migrations[0], $dest)) {
                    echo "Fehler beim Kopieren von $migration nach $dest" . PHP_EOL;
                }
            }

            if (count($migrations) > 1) {
                echo "mehrere Migrations gefunden:" . PHP_EOL;
                foreach ($migrations as $migration) {
                    echo $migration . PHP_EOL;
                }
            }
        }
        /* ### */

        /* ### Filament ### */
        exec('composer show filament/filament', $output, $return_var);
        if ($return_var === 0) {

            $filamentFolder = app_path('Filament');
            $filamentResourceFolder =  app_path('Filament/Resources');
            $filamentResourcePath = $filamentResourceFolder . "/" . $resource . "Resource";
            $filamentPagesPath = $filamentResourcePath . "/Pages";
            if (!File::exists($filamentFolder)) {
                File::makeDirectory($filamentFolder);
                echo "Verzeichnis $filamentFolder erstellt" . PHP_EOL;
            }
            if (!File::exists($filamentResourceFolder)) {
                File::makeDirectory($filamentResourceFolder);
            }
            if (!File::exists($filamentResourcePath)) {
                File::makeDirectory($filamentResourcePath);
            }
            if (!File::exists($filamentPagesPath)) {
                File::makeDirectory($filamentPagesPath);
            }

            $filament = [
                "app/Filament/Resources/" . $resource . "Resource/Pages/Create" . $resource . ".php",
                "app/Filament/Resources/" . $resource . "Resource/Pages/Edit" . $resource . ".php",
                "app/Filament/Resources/" . $resource . "Resource/Pages/List" . $inflector->pluralize($resource) . ".php",
                "app/Filament/Resources/" . $resource . "Resource/Pages/View" . $resource . ".php"
            ];
            $paths = array_merge($paths, $filament);
        }
        /* ### */

        /* Kopiervorgang */
        foreach ($paths as $filePath) {
            $dest = base_path() . "/" . $filePath;
            $src = $projectPath . "/" . $filePath;

            if (!File::exists($src)) {
                echo "Datei $src nicht gefunden" . PHP_EOL;
                continue;
            }

            // try {
            if (File::exists($src)) {
                if (!copy($src, $dest)) {
                    echo "Fehler beim Kopieren von $src nach $dest" . PHP_EOL;
                }
            }
            // } catch (\Exception $e) {
            //     echo "Quellpfad: $src" . PHP_EOL;
            //     echo "Zielpfad: $dest" . PHP_EOL . PHP_EOL;
            //     echo $e . PHP_EOL;
            // }
        }
    }
}
