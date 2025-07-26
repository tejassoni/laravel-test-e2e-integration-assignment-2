<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testUserTypeWays(): void
    {
        $this->browse(function (Browser $browser) {
            // Clear any existing sessions
            $browser->logout();

            // Visit registration page with explicit waits
            $browser->visit('/register')
                ->screenshot('before-register-page') // This will save a screenshot for inspection

                # Types of Selector
                //  ->type('#name', 'Testfirstname Testlastname') # This selects: <input id="name" ... >, By CSS selector (ID)
                //   ->type('.input-name', 'Testfirstname Testlastname') # This selects: <input class="input-name" ... >, By CSS selector (class):
                //  ->type('form#register-form input[name="name"]', 'Testfirstname Testlastname') # This selects: <form id="register-form"><input name="name" ... ></form>, By full CSS selector (useful if multiple elements match):
                // ->driver->findElement(WebDriverBy::xpath('//input[@name="name"]'))->sendKeys('Testfirstname Testlastname') # Use only if CSS selector fails or structure is complex., By XPath (advanced, less preferred)
                // ->type('name', 'Testfirstname Testlastname') # This selects: <input name="name" ... >, By name attribute (Recommended for forms)
                // ->type('@name', 'Testfirstname Testlastname') # Use dusk="name" in Dusk Tests, You can access this input using the @dusk selector like this:<input type="text" name="name"  dusk="name" />
                # Additional Parameters
                // ->waitFor('input[name="name"]', 10)->type('name', 'Testfirstname Testlastname') # Useful for AJAX-rendered or slow-loading elements., Using waitFor then type:
                // ->waitUntilEnabled('input[name="name"]', 10)->type('name', 'Testfirstname Testlastname') # Sometimes, the element is present in the DOM but not yet clickable or focusable., Wait until it's visible or enabled:
                // ->pause(500)->type('name', 'Testfirstname Testlastname') # If your input is revealed via JavaScript animation, .waitFor() may be too early., Add a short pause or use waitUntil:
                // ->keys('name', 'Testfirstname Testlastname') # When running in headless mode, Chrome sometimes lags with Dusk's type()., Try using .keys() instead (more native and accurate):
                // ->scrollIntoView('input[name="name"]')->type('name', 'Testfirstname Testlastname') #  Ensure field is in view:, better for larger forms
                // ->typeSlowly('name', 'Testfirstname Testlastname', 100) // 100ms per char,  typing too quickly may cause issues., Type with delay:

                # better solutions, Try combining these for best results:
                ->waitFor('input[name="name"]', 10)
                ->waitUntilEnabled('input[name="name"]', 10)
                ->scrollIntoView('input[name="name"]')
                ->typeSlowly('name', 'Testfirstname Testlastname', 100)
                # continue reset of the form fields
                ->typeSlowly('email', 'test@yopmail.com', 100)
                ->typeSlowly('password', 'Test@123', 100)
                ->screenshot('after-register-page');
        });
    }


    public function testUserCanRegister(): void
    {
        $this->browse(function (Browser $browser) {
            // Clear any existing sessions if you have a logout route defined.
            // If running tests in isolation with RefreshDatabase, logout might not be strictly necessary,
            // but it's good practice if you're testing scenarios that assume no prior session.
            // $browser->logout(); // Uncomment if you have a logout method in DuskTestCase or accessible via a route

            // Visit registration page with explicit waits
            $browser->visit('/register')
                ->screenshot('before-register-page'); // This will save a screenshot for inspection

            // Type into the Name field
            $browser->waitFor('input[name="name"]', 10)
                ->waitUntilEnabled('input[name="name"]', 10)
                ->scrollIntoView('input[name="name"]')
                ->typeSlowly('name', 'Testfirstname Testlastname', 50); // Reduced delay slightly for speed

            // Type into the Email field
            $browser->waitFor('input[name="email"]', 10)
                ->waitUntilEnabled('input[name="email"]', 10)
                ->scrollIntoView('input[name="email"]')
                ->typeSlowly('email', 'test@yopmail.com', 50);

            // Type into the Password field
            $browser->waitFor('input[name="password"]', 10)
                ->waitUntilEnabled('input[name="password"]', 10)
                ->scrollIntoView('input[name="password"]')
                ->typeSlowly('password', 'Test@123', 50);

            // Type into the Confirm Password field
            $browser->waitFor('input[name="password_confirmation"]', 10)
                ->waitUntilEnabled('input[name="password_confirmation"]', 10)
                ->scrollIntoView('input[name="password_confirmation"]')
                ->typeSlowly('password_confirmation', 'Test@123', 50); // Added this line

            $browser->screenshot('after-filling-form'); // Screenshot after filling all fields

            // Press the Register button
            $browser->press('Register'); // Using the text on the button

            // Assertions after registration
            // Depending on your application, this might be a redirect to dashboard, or an email verification page
            $browser->assertPathIs('/dashboard') // Or '/email/verify' or similar
                ->assertSee('You are logged in!'); // Example: Assert a welcome message or successful login status

            $browser->screenshot('after-register-success'); // Screenshot after successful registration
        });
    }
}
