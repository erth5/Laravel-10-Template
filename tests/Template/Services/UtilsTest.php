<?php

namespace Tests\Template\Services;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UtilService;
use Illuminate\Foundation\Testing\WithFaker;

class UtilsTest extends TestCase
{
    use WithFaker;

    public $userArray = [
        'name' => 'Jane',
        'email' => 'uil22093@omeie.com',
        'password' => '7mZ7bc@JRubyq$',
    ];

    public $stackedUserArray = [
        'name' => 'Jane',
        'more' => [
            'email' => 'uil22093@omeie.com',
            'password' => '7mZ7bc@JRubyq$',
        ],
        'invalid' => [
            'data',
        ],
    ];

    /**
     * Teste
     */
    public function test_validateRequest(): void
    {
        $UtilService = new UtilService;

        $request = new Request($this->userArray);
        $SuccessValidation = $UtilService->validateRequest(
            $request,
            [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'password' => 'required|min:8|max:255',
            ],
        );
        $this->assertTrue($SuccessValidation);

        $FailureValidation = $UtilService->validateRequest(
            $request,
            ['failure' => 'required']
        );
        $this->assertFalse($FailureValidation);
    }

    /**
     * Teste das füllen eines Modells aus einem Request
     */
    public function test_fillObjectFromRequest(): void
    {
        /* Request with data to fill */
        $request = new Request($this->userArray);
        /* object that will be filled */
        $user = new User();
        /* call the function to populate the object with values from the array */
        $UtilService = new UtilService;
        $user = $UtilService->fillObjectFromRequest($user, $request, withNullValues:false);
        /* assert that the object was correctly populated with values from the array */
        $this->assertEquals('Jane', $user->name);
        $this->assertEquals('uil22093@omeie.com', $user->email);
        $this->assertEquals('7mZ7bc@JRubyq$', $user->password);
    }

    /**
     * Teste Rekursive Objekt Fill Funktion
     */
    public function test_fillObject(): void
    {

        $data = new User([
            'name' => 'Jane',
            'email' => 'uil22093@omeie.com',
            'password' => '7mZ7bc@JRubyq$',
        ]);
        $this->assertIsObject($data);

        $UtilService = new UtilService;
        $user = new User();
        // $user = $UtilService->fillObject($user, $this->userArray);
        $user = $UtilService->fillObject($user, $this->stackedUserArray);
        // $user = $UtilService->fillObject($user, $data);

        $this->assertEquals('Jane', $user->name);
        $this->assertEquals('uil22093@omeie.com', $user->email);
        $this->assertEquals('7mZ7bc@JRubyq$', $user->password);
    }
}
