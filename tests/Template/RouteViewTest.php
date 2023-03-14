<?php

namespace Tests\Template;

use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class RouteViewTest extends TestCase
{
    /**
     * A basic unit test that proof if the domain root is visible.
     * @group routing
     * @return void
     */
    public function test_routing_main()
    {
        $pathResponse = $this->get('/');
        $pathResponse->assertStatus(200);
    }

    /**
     * A basic unit test for debug.
     * @group routing
     * @return void
     */
    public function test_routing_debug()
    {
        if (env('APP_DEBUG')) {
            $pathResponse = $this->get('/debug');
            $pathResponse->assertStatus(200);
        } else
            assertTrue(true);
    }

    public function test_db_connection_view()
    {
        if (env('APP_DEBUG')) {
            $viewDb = $this->get('/test/db');
            $viewDb->assertStatus(200);
        } else
            assertTrue(true);
    }

    public function test_users_and_peoples_table_view()
    {
        if (env('APP_DEBUG')) {
            $viewUser = $this->get('/debug/user');
            $viewUser->assertStatus(200);
            // AssertEuqals(Person surname = User surname);
        } else
            assertTrue(true);
    }
}
