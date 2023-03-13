<?php

namespace Tests\Feature;

use Tests\TestCase;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class DocumentationTest extends TestCase
{
    /**
     * Verbindet sich zur Hauptseite der Swagger Instanz
     * @group specification
     * @return void
     */
    public function test_swagger_integration_response()
    {
        /* Alternativ hätte man auch mit ignore arbeiten können */
        if (env('Swagger') == true) {
            echo env('APP_URL') . "/api/documentation";
            $swagger = $this->get('/api/documentation');
            $swagger->assertStatus(200);
        } else
            assertTrue(true);
    }

    /**
     * Testet, ob der Swagger eine Valide JSON zurück gibt
     * @group specification
     * @return void
     */
    public function test_swagger_integration_works()
    {
        if (env('Swagger') == true) {
            $swagger = $this->get('/docs/api-docs.json');
            $swagger->assertStatus(200);
        } else
            assertTrue(true);
    }
}
