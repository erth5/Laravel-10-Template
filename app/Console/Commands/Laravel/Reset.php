<?php

namespace App\Console\Commands\Laravel;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class Reset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Entwicklerwerkzeug: Setzt die Datenbank und Laravel Logs zurück.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('config:clear');

        if (!env('APP_URL')) {
            exit(".env wurde nicht geladen.");
        }

        $log = storage_path('logs/laravel.log');
        if (file_exists($log)) {
            file_put_contents($log, "");
        }

        try {
            if (config('app.dockerized')) {
                $this->info('Migrating in Docker environment.');
                exec("docker compose run --rm artisan migrate:fresh --seed", $output, $result);
            } else {
                $this->info('Migrating on linux or windows');
                exec("php artisan migrate:fresh --seed", $output, $result);
            }
            switch ($result) {
                case 0:
                    Artisan::call('config:cache');
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

        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return $e->getMessage();
        }
    }
}
