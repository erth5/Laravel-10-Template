<?php

namespace App\Console\Commands\Debian;

use Illuminate\Console\Command;

class ClearKernel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:kernel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(int $keep = 0)
    {
        try {
            if ($keep) {
                $keep = '--keep ' . $keep;
            }
            //TODO: Angabe von keep ist vllt required
            exec("sudo purge-old-kernels " . $keep, $output, $result);
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
            logger()->error($e);
            return $e;
        }
    }
}
