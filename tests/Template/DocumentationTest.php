<?php

namespace Tests\Template;

use Illuminate\Support\Facades\Route;
use function PHPUnit\Framework\assertFalse;
use Tests\TestCase;

class DocumentationTest extends TestCase
{
    /**
     * Verbindet sich zur Hauptseite der Swagger Instanz
     *
     * @group specification
     *
     * @return void
     */
    public function test_swagger_integration_response()
    {
        /* Alternativ hätte man auch mit ignore arbeiten können */
        if (Route::has('l5-swagger.default.api')) {
            echo env('APP_URL').'/api/documentation';
            $swagger = $this->get('/api/documentation');
            $swagger->assertStatus(200);
        } else {
            assertFalse(false);
        }
    }

    /**
     * Testet, ob der Swagger JSON Response erfolgt
     *
     * @group specification
     *
     * @return void
     */
    public function test_swagger_integration_works()
    {
        if (Route::has('l5-swagger.default.api')) {
            $swagger = $this->get('/docs/api-docs.json');
            $swagger->assertStatus(200);
        } else {
            assertFalse(false);
        }
    }
}
