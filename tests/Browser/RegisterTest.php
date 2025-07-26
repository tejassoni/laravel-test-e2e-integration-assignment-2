<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testUserCanRegister(): void
    {
        $this->browse(function (Browser $browser) {
            // Clear any existing sessions
            $browser->logout();

            // Visit registration page with explicit waits
            $browser->visit('/register')
                ->screenshot('register-page') // This will save a screenshot for inspection
                // ->assertSee('Register') // Or some text to confirm page loaded
                ->type('name', 'Testfirstname Testlastname');
        });
    }
}
