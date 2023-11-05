<?php

namespace App\Console\Commands\Windows;

use Illuminate\Console\Command;

class Dir extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'windows:dir';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Folder Content';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            exec("dir", $output, $result);
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
