<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
     * pwd ist auf Windows und Linux verfügbar
     */
    public function handle()
    {
        try {
            exec("pwd", $output, $result);
            switch ($result) {
                case 0:
                    logger($output);
                    return $output;
                case 1:
                    logger()->warning(get_class($this) . ' Runtime Fault');
                    logger($output);
                    return false;
                case 2:
                    logger()->warning(get_class($this) . ' Syntax Fault');
                    return false;
            }
        } catch (\Exception $e) {
            logger()->error($e);
            return $e;
        }
    }
}
