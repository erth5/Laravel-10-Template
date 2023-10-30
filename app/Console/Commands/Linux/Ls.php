<?php

namespace App\Console\Commands\Linux;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Ls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'linux:ls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            exec("ls -al", $output, $result);
            switch ($result) {
                case 0:
                    logger($output);
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
            return $e;
        }
    }
}
