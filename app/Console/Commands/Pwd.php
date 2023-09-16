<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Pwd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:path';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get current System Path';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            exec("pwd", $output, $result);
            switch ($result) {
                case 0:
                    Log::debug($output);
                    return $output;
                case 1:
                    Log::warning(get_class($this) . ' Runtime Fault');
                    return false;
                case 2:
                    Log::warning(get_class($this) . ' Syntax Fault');
                    return false;
            }
        } catch (Exception $e) {
            Log::error($e);
            return $e;
        }
    }
}
