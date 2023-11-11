<?php

namespace App\Console\Commands\Linux;

use Illuminate\Console\Command;

class ClearLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'linux:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set Vacuum Time and delete older logs.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // journalctl --vacuum-size=500M
            exec("sudo journalctl --vacuum-time=2d", $output, $result);
            switch ($result) {
                case 0:
                    logger($output);
                    return $output;
                case 1:
                    logger()->warning(get_class($this) . ' Runtime Fault');
                    return false;
                case 2:
                    logger()->warning(get_class($this) . ' Syntax Fault');
                    return false;
            }
        } catch (\Exception $e) {

            $this->error($e->getMessage());
            return $e;
        }
    }
}
