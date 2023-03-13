<?php

namespace Tests\Unit;

use App\Rules\OddRule;
use PHPUnit\Framework\TestCase;

class RuleTest extends TestCase
{
    /**
     * A basic unit test example.
     * @group specification
     * @return void
     */
    public function test_example()
    {
        $validation = new OddRule();
        $test = $validation->passes('testnumber', 2);
        $this->assertTrue($test);
    }
}
