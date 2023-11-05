<?php

namespace App\Console\Commands\Laravel;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Validation\Rules\Lowercase;

class ComponentList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $paths = [
        // Laravel Standardpfade
        'model' => 'app/Models/',
        'controller' => 'app/Http/Controllers/',
        'middleware' => 'app/Http/Middleware/',
        'request' => 'app/Http/Requests/',
        'event' => 'app/Events/',
        'listener' => 'app/Listeners/',
        'policy' => 'app/Policies/',
        'provider' => 'app/Providers/',
        'command' => 'app/Console/Commands/',
        'job' => 'app/Jobs/',
        'mail' => 'app/Mail/',
        'notification' => 'app/Notifications/',
        'resource' => 'app/Http/Resources/',
        'rule' => 'app/Rules/',
        'seeder' => 'database/seeders/',
        'factory' => 'database/factories/',
        'migration' => 'database/migrations/',
        'test' => 'tests/',

        // Laravel Nova Pfade
        'nova-action' => 'app/Nova/Actions/',
        'nova-dashboard' => 'app/Nova/Dashboards/',
        'nova-filter' => 'app/Nova/Filters/',
        'nova-lens' => 'app/Nova/Lenses/',
        'nova-resource' => 'app/Nova/',
        'nova-tool' => 'nova-components/',

        // Filament Pfade
        'filament-resource' => 'app/Filament/Resources/',
        'filament-widget' => 'app/Filament/Widgets/',
        'filament-page' => 'app/Filament/Pages/',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = strtolower($this->argument('type'));
        if (isset($this->paths[$type])) {
            $path = $this->paths[$type];
        }
        if (isset($this->paths[$this->removeLastS($type)])) {
            $path = $this->paths[$this->removeLastS($type)];
        }
        if (!$path) {
            $this->info('Resource not Found');
            exit(1);
        }

        if (!is_dir($path)) {
            $this->info('Directory missing');
            exit(1);
        }

        $files = File::allFiles($path);

        $fileNames = [];

        foreach ($files as $model) {
            if ($model->getExtension() === 'php') {
                $name = $model->getFilenameWithoutExtension();
                array_push($fileNames, $name);
            }
        }

        $outputPath = app_path("Console/Commands/$type.txt");
        File::ensureDirectoryExists(dirname($outputPath));
        File::put($outputPath, implode("\n", $fileNames));

        $this->info('Names have been written to ' . $outputPath);
    }

    function removeLastS($string)
    {
        // Zuerst überprüfen wir, ob der letzte Buchstabe ein "s" oder "S" ist.
        if (strtolower(substr($string, -1)) === 's') {
            // Wenn ja, entfernen wir ihn.
            $string = substr($string, 0, -1);
        }
        return $string;
    }
}
