<?php

namespace Tests\Template\Unit;

use App\Rules\OddRule;
use PHPUnit\Framework\TestCase;

class RuleTest extends TestCase
{
    /**
     * Test OddRule works
     * @return void
     */
    public function test_example()
    {
        $validation = new OddRule();
        $test = $validation->passes('testnumber', 2);
        $this->assertTrue($test);
    }
}
