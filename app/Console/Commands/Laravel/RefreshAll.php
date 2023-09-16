<?php

namespace App\Console\Commands\Laravel;

use Exception;
use App\Services\UtilService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class RefreshAll extends Command
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
    protected $signature = 'app:rebuild';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the DB for working in this Project. Works on windows, debian, docker';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /* Konfig Clear wirkt manchmal nicht */
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        if (!env('APP_URL')) {
            exit(".env wurde nicht geladen.");
        }

        $log = storage_path('logs/laravel.log');
        if (file_exists($log)) {
            file_put_contents($log, "");
        }


        try {

            /** Konfig-Cache gibt aus der .env null zurück */
            Artisan::call('config:clear');

            if (config('app.dockerized')) {
                $this->info('Migrating in Docker environment.');
                exec("docker compose run --rm artisan migrate:fresh --seed", $output, $result);
            } else {
                $this->info('Migrating on linux or windows');
                exec("php artisan migrate:fresh --seed", $output, $result);
            }
            switch ($result) {
                case 0:
                    // Log::debug($output);
                    $this->info(print_r($output));
                    return $output;
                case 1:
                    Log::warning(get_class($this) . ' Runtime Fault');
                    $this->info(print_r($output));
                    return false;
                case 2:
                    Log::error(get_class($this) . ' Syntax Fault');
                    $this->info(print_r($output));
                    return false;
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return $e->getMessage();
        }

       
    }
}