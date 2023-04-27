<?php

namespace Tests\Template\Unit;

use App\Models\User;
use App\Services\UtilService;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    /**
     * A basic unit test for controller.
     * @group specification
     * @return void
     */

    public function test_controller_exist()
    {
        $this->assertFileExists('app\Http\Controllers\Controller.php');
    }

    /**
     * A basic unit test for outsourced Controller Functionality.
     *
     * @return void
     */
    public function test_UtilService_exist()
    {
        $this->assertFileExists('app\Services\UtilService.php');
    }
}
