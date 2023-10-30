<?php

namespace App\Console\Commands\Windows;

use Exception;
use Illuminate\Console\Command;

class Systeminfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'windows:systeminfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Windows system information';

    /**
     * Immer return oder breack angeben
     */
    public function handle()
    {
        try {
            exec("systeminfo", $output, $result);
            switch ($result) {
                case 0:
                    logger($output);
                    break;
                case 1:
                    logger()->error(get_class($this) . ' Runtime Fault');
                    logger()->error($output);
                    return $output;
                case 2:
                    logger()->error(get_class($this) . ' Syntax Fault');
                    logger()->error($output);
                    return $output;
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return $e;
        }
    }
}
