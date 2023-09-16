<?php

namespace App\Console\Commands\Windows;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
                    Log::debug($output);
                    return $output;
                case 1:
                    Log::warning(get_class($this) . ' Runtime Fault');
                    return false;
                case 2:
                    Log::warning(get_class($this) . ' Syntax Fault');
                    return false;
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            // Log::error($e);
            return $e;
        }
    }
}
