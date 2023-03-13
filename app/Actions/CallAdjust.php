<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Http\Controllers\PersonController;

class CallAdjust
{
    use AsAction;

    public function handle()
    {
        $adjusting = (new PersonController)->adjust();
    }
}
