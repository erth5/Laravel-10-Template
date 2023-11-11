<?php

namespace App\Console\Commands\Laravel;

use Exception;
use Illuminate\Console\Command;

class CreateModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:model {name}';

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
                    logger()->warning(get_class($this) . ' Runtime Fault');
                    $this->info(print_r($output));
                    break;
                case 2:
                    logger()->error(get_class($this) . ' Syntax Fault');
                    $this->info(print_r($output));
            }

            if (class_exists('Laravel\Nova\Nova')) {
                exec("php artisan nova:resource " . $model, $output, $result);
                switch ($result) {
                    case 0:
                        $this->info(print_r($output));
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
            }

        } catch(Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
