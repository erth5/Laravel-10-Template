<?php

namespace App\Console\Commands\Forum;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'https://www.teamteatime.net/docs/laravel-forum/5/commands/';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            exec("php artisan forum:sync", $output, $result);
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
            return $e;
        }
    }
}
