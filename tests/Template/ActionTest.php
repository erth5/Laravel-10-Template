<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Person;
use App\Actions\CallAdjust;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActionTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_Action_works()
    {
        if (DB::table('people')->count() == 0) {
            $this->seed('PersonSeeder');
        }

        $adjusting = (new CallAdjust)->handle();
        $this->assertEquals(
            'Lord Kennedy',
            Person::where('username', 'thespasst')
                ->first()->user->name
        );
    }
}
