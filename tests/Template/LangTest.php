<?php

namespace Tests\Template;

use Tests\TestCase;

class LangTest extends TestCase
{
    /**
     * Test language Change works
     *
     * @group specification
     */
    public function test_example(): void
    {
        $appLang = config('app.locale');
        $response = $this->get('/');
        $response->assertStatus(200);
        $html = $response->getContent();
        $this->assertTrue(str_contains($html, $appLang));

        config(['app.locale' => 'de']);
        $response = $this->get('/');
        $response->assertStatus(200);
        $html = $response->getContent();
        $this->assertTrue(str_contains($html, 'html lang="de"'));

        /* reset */
        config(['app.locale' => $appLang]);
    }
}
