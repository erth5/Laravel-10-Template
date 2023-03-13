<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DebugTest extends DuskTestCase
{

    /**
     * Verwendung möglich
     * use DatabaseMigrations;
     */

    /**
     * Test Navigation durch die Debug Seiten
     *
     * @return void
     */
    public function testDebugTelescope()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/telescope/requests')
                // Prüft, ob im Body Element das Schlüsselwort "Telescope" steht
                ->assertTitle('Requests - Telescope')
                ->assertPathIs('/telescope/requests');
        });
    }

    public function testDump_and_Debug()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/test/views')
                ->assertSee('array')
                ->assertPathIs('/test/views');
        });
    }

    public function testRidirect()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/debug/debug')
                ->assertPathIs('/debug');
        });
    }
}
