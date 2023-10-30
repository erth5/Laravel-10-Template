<?php

namespace App\Console\Commands\Windows;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
                    Log::error(get_class($this) . ' Runtime Fault');
                    Log::error($output);
                    return $output;
                case 2:
                    Log::error(get_class($this) . ' Syntax Fault');
                    Log::error($output);
                    return $output;
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return $e;
        }
    }
}
