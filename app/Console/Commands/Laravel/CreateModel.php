<?php

namespace App\Console\Commands\Laravel;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CreateModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-model {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Legt ein Model mit allen Dateien und Nova Resource an.
     */
    public function handle()
    {
        $model = $this->argument('name');
        // dd($model);
        try {
            exec("php artisan make:model " . $model . " -a", $output, $result);
            switch ($result) {
                case 0:
                    $this->info(print_r($output));
                    break;
                case 1:
                    Log::warning(get_class($this) . ' Runtime Fault');
                    $this->info(print_r($output));
                    break;
                case 2:
                    Log::error(get_class($this) . ' Syntax Fault');
                    $this->info(print_r($output));
            }

            /* output bleibt bestehen */
            $output = null;

            exec("php artisan nova:resource " . $model, $output, $result);
            switch ($result) {
                case 0:
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

        } catch(Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}