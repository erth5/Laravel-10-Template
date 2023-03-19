<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Routing\Route;

class DocumentationTest extends DuskTestCase
{
    /**
     * Test Swagger GUI is callable
     *
     * @return void
     */
    public function test_swagger_integration_gui()
    {
        $this->browse(function (Browser $browser) {
            // Long shape: env('APP_URL')/api/documentation
            $browser->visit('/api/documentation')
                ->assertTitle('L5 Swagger UI');
        });
    }

    /**
     * Test Swagger GUI get the default error
     *
     * @return void
     */
    public function test_swagger_integration_has_error()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/api/documentation')
                ->assertDontSee('Failed to load API definition.');
        });
    }
}
