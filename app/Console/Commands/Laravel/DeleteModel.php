<?php

namespace App\Console\Commands\Laravel;

use Exception;
use Illuminate\Support\Str;
use App\Services\UtilService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteModel extends Command
{
    protected $utilService;

    public function __construct(
        UtilService $utilService
    ) {
        parent::__construct();
        $this->utilService = $utilService;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-model {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Löscht alle Dateien die sich direkt einem Model zuordnen lassen.
     */
    public function handle()
    {
        if ($this->confirm('This will delete all files they are created with this model.')) {
            $model = $this->argument('name');
            try {
                if (DIRECTORY_SEPARATOR === '/') {
                    /* unix, linux, mac */
                    $modelFile = (app_path('Models/' . $model . '.php'));
                    if (file_exists($modelFile)) {
                        unlink($modelFile);
                        $this->info($modelFile . ' deleted');

                        $ctr = app_path('Http/Controllers/' . $model . 'Controller.php');
                        if (file_exists($ctr)) {
                            unlink($ctr);
                            $this->info($ctr . ' deleted');
                        }
                        $storeRequest = app_path('Http/Requests/Store' . $model . 'Request.php');
                        if (file_exists($storeRequest)) {
                            unlink($storeRequest);
                            $this->info($storeRequest . ' deleted');
                        }
                        $updateRequest = app_path('Http/Requests/Update' . $model . 'Request.php');
                        if (file_exists($updateRequest)) {
                            unlink($updateRequest);
                            $this->info($updateRequest . ' deleted');
                        }

                        $rule = app_path('Policies/' . $model . 'Policy' . '.php');
                        if (file_exists($rule)) {
                            unlink($rule);
                            $this->info($rule . ' deleted');
                        }

                        $factory = (database_path('factories/' . $model . 'Factory' . '.php'));
                        if (file_exists($factory)) {
                            unlink($factory);
                            $this->info($factory . ' deleted');
                        }
                        $seeder = (database_path('seeders/' . $model . 'Seeder' . '.php'));
                        if (file_exists($seeder)) {
                            unlink($seeder);
                            $this->info($seeder . ' deleted');
                        }
                        $service = (app_path('Services/' . $model . 'Service' . '.php'));
                        if (file_exists($service)) {
                            unlink($service);
                            $this->info($service . ' deleted');
                        }

                        $nova = app_path('Nova/' . $model . '.php');
                        if (file_exists($nova)) {
                            unlink($nova);
                            $this->info($nova . ' deleted');
                        }

                        $observer = app_path('Observers/' . $model . 'Observer.php');
                        if (file_exists($observer)){
                            unlink($observer);
                            $this->info($observer . 'deleted');
                        }

                        /* migrations */
                        $allMigrations = scandir(database_path('migrations'));
                        $migrations = null;
                        foreach ($allMigrations as $migration) {
                            if(strpos($migration, $this->utilService->getDbName($model)) !== false) {
                                $migrations[] = $migration;
                            }
                        }
                        if($migrations) {
                            if ($this->confirm(sizeof($migrations) . ' migrations found, delete them?')) {
                                foreach ($migrations as $migration) {
                                    unlink(database_path('migrations/' . $migration));
                                    $this->info($migration . ' deleted');
                                }
                            }
                        }


                    } else {
                        $this->info('Model not found');
                    }
                }

                if (DIRECTORY_SEPARATOR === '\\') {
                    /* windows */
                    $modelFile = (app_path('Models\\' . $model . '.php'));
                    if (file_exists($modelFile)) {
                        unlink($modelFile);
                        $this->info($modelFile . ' deleted');

                        $ctr = app_path('Http\\Controllers\\' . $model . 'Controller.php');
                        if (file_exists($ctr)) {
                            unlink($ctr);
                            $this->info($ctr . ' deleted');
                        }
                        $storeRequest = app_path('Http\\Requests\\Store' . $model . 'Request.php');
                        if (file_exists($storeRequest)) {
                            unlink($storeRequest);
                            $this->info($storeRequest . ' deleted');
                        }
                        $updateRequest = app_path('Http\\Requests\\Update' . $model . 'Request.php');
                        if (file_exists($updateRequest)) {
                            unlink($updateRequest);
                            $this->info($updateRequest . ' deleted');
                        }

                        $rule = app_path('Policies\\' . $model . 'Policy' . '.php');
                        if (file_exists($rule)) {
                            unlink($rule);
                            $this->info($rule . ' deleted');
                        }

                        $factory = (database_path('factories\\' . $model . 'Factory' . '.php'));
                        if (file_exists($factory)) {
                            unlink($factory);
                            $this->info($factory . ' deleted');
                        }
                        $seeder = (database_path('seeders\\' . $model . 'Seeder' . '.php'));
                        if (file_exists($seeder)) {
                            unlink($seeder);
                            $this->info($seeder . ' deleted');
                        }
                        $service = (app_path('Services\\' . $model . 'Service' . '.php'));
                        if (file_exists($service)) {
                            unlink($service);
                            $this->info($service . ' deleted');
                        }

                        $nova = app_path('Nova\\' . $model . '.php');
                        if (file_exists($nova)) {
                            unlink($nova);
                            $this->info($nova . ' deleted');
                        }

                        $observer = app_path('Observers\\' . $model . 'Observer.php');
                        if (file_exists($observer)){
                            unlink($observer);
                            $this->info($observer . 'deleted');
                        }

                        /* migrations */
                        $allMigrations = scandir(database_path('migrations'));
                        $migrations = null;
                        foreach ($allMigrations as $migration) {
                            if(strpos($migration, $this->utilService->getDbName($model)) !== false) {
                                $migrations[] = $migration;
                            }
                        }
                        if($migrations) {
                            if ($this->confirm(sizeof($migrations) . ' migrations found, delete them?')) {
                                foreach ($migrations as $migration) {
                                    unlink(database_path('migrations\\' . $migration));
                                    $this->info($migration . ' deleted');
                                }
                            }
                        }

                    } else {
                        $this->info('Model not found');
                    }
                }

            } catch (Exception $e) {
                Log::error($e);
                $this->error($e->getMessage());
                return $e;
            }
        }
    }
}

// Setzen Sie das Migrationspräfix
//   $migrationPrefix = 'create_' . implode('_', $words);

// Rückgabe des vollständigen Migrationsnamens
//   return $migrationPrefix . '_table';
