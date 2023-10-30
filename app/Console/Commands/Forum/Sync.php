<?php

namespace App\Console\Commands\Forum;

use Illuminate\Console\Command;

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
