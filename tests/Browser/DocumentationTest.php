<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

// class DocumentationTest extends DuskTestCase
// {
//     /**
//      * Test Swagger GUI is callable
//      *
//      * @return void
//      */
//     public function test_swagger_integration_gui()
//     {
//         $this->browse(function (Browser $browser) {
//             // Langform: env('APP_URL')/api/documentation
//             $browser->visit('/api/documentation')
//                 ->assertTitle('L5 Swagger UI');
//         });
//     }

//     /**
//      * Test Swagger GUI get the default error
//      *
//      * @return void
//      */
//     public function test_swagger_integration_has_error()
//     {
//         $this->browse(function (Browser $browser) {
//             $browser->visit('/api/documentation')
//                 ->assertDontSee('Failed to load API definition.');
//         });
//     }

//     /**
//      * Test Swagger GUI can get documentation JSON
//      *
//      * @return void
//      */
//     public function test_swagger_integration_json()
//     {
//         $this->browse(function (Browser $browser) {
//             $browser->visit('/docs/api-docs.json')
//                 ->assertSee('Your title');
//         });
//     }
// }
