<?php

namespace App\Console\Commands\Laravel;

use Illuminate\Console\Command;

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
        $this->info(\Artisan::call('config:clear'));
        $this->info(\Artisan::output());

        if (!env('APP_URL')) {
            exit(".env wurde nicht geladen.");
        }

        $log = storage_path('logs/laravel.log');
        if (file_exists($log)) {
            file_put_contents($log, "");
        }

        if (!config('app.dockerized')) {
            $this->info('Migrating on linux or windows');
            $this->info(\Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]));
            $this->info(\Artisan::output());

            $this->info(\Artisan::call('config:cache'));
            $this->info(\Artisan::output());
        } else {
            try {
                $this->info('Migrating in Docker environment.');
                exec("docker compose run --rm artisan migrate:fresh --seed --force", $output, $result);
                switch ($result) {
                    case 0:
                        $this->info(\Artisan::call('config:cache'));
                        $this->info(\Artisan::output());
                        return $output;
                    case 1:
                        logger()->warning(get_class($this) . ' Runtime Fault');
                        $this->info(print_r($output));
                        return false;
                    case 2:
                        logger()->error(get_class($this) . ' Syntax Fault');
                        $this->info(print_r($output));
                        return false;
                }
            } catch (\Exception $e) {
                $this->error($e->getMessage());
                return $e->getMessage();
            }
        }
    }
}
