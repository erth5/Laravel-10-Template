<?php

namespace Tests\Template\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use function PHPUnit\Framework\assertFalse;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DocumentationTest extends TestCase
{
    /**
     * Testet, ob der Swagger eine Valide JSON zurück gibt
     */
    public function test_swagger_return_json(): void
    {
        if (Route::has('l5-swagger.default.api')) {
            $swagger = $this->get('/docs/api-docs.json');
            $this->assertJson($swagger->getContent());
        } else {
            assertFalse(false);
        }
    }
}
