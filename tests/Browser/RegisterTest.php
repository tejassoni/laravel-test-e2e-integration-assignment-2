<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Class RegisterTest
 *
 * Laravel Dusk browser test class for testing user registration flows.
 *
 * This class includes:
 * - A demonstration of multiple ways to interact with form inputs using Laravel Dusk.
 * - A complete end-to-end test for user registration, including form filling, submission,
 *   and post-registration assertions.
 *
 * @package Tests\Browser
 * @author Tejas
 * @contact soni.tejas@live.com
 */
class RegisterTest extends DuskTestCase
{
    // This trait will ensure a fresh database for each test run,
    // which is crucial for tests involving user creation/authentication.
    use DatabaseMigrations;

    /**
     * Demonstrates various ways to type into an input field using Laravel Dusk.
     *
     * This test visits the registration page and showcases different selectors
     * and methods for interacting with input elements, including CSS selectors
     * (ID, class, full path), XPath, name attribute, Dusk attributes, and
     * additional parameters like waiting, pausing, key presses, scrolling,
     * and slow typing.
     *
     * Note: This function is for demonstration purposes to illustrate
     * different typing techniques, rather than a full test flow.
     */
    public function testUserTypeWays(): void
    {
        $this->browse(function (Browser $browser) {
            // Clear any existing sessions if logout route is available.
            // In a demonstration, this ensures a clean slate, though
            // DatabaseMigrations typically handles most state resets.
            // $browser->logout(); // Uncomment if you have a logout method in DuskTestCase or accessible via a route

            // Visit the registration page and take a screenshot before interaction
            $browser->visit('/register')
                ->screenshot('before-type-ways-register-page'); // This will save a screenshot for inspection

            // # Types of Selector:
            // Laravel Dusk offers several ways to select elements for typing:

            // 1. By CSS Selector (ID): Selects an input field using its `id` attribute.
            //    Example: <input id="name" ... >
            // $browser->type('#name', 'Testfirstname Testlastname');

            // 2. By CSS Selector (Class): Selects an input field using its `class` attribute.
            //    Example: <input class="input-name" ... >
            // $browser->type('.input-name', 'Testfirstname Testlastname');

            // 3. By Full CSS Selector: Useful for specific targeting when multiple elements match.
            //    Example: <form id="register-form"><input name="name" ... ></form>
            // $browser->type('form#register-form input[name="name"]', 'Testfirstname Testlastname');

            // 4. By XPath (Advanced, less preferred for simple cases): Use only if CSS selector fails or structure is complex.
            //    Example: Selects an input with `name="name"`.
            // $browser->driver->findElement(WebDriverBy::xpath('//input[@name="name"]'))->sendKeys('Testfirstname Testlastname');

            // 5. By Name Attribute (Recommended for forms): Directly selects an input field using its `name` attribute.
            //    Example: <input name="name" ... >
            // $browser->type('name', 'Testfirstname Testlastname');

            // 6. By Dusk Attribute: Use `dusk="name"` in your HTML. You can access this input using the `@dusk` selector.
            //    Example HTML: <input type="text" name="name"  dusk="name" />
            // $browser->type('@name', 'Testfirstname Testlastname');

            // # Additional Parameters for Typing:
            // Enhance typing reliability with these methods:

            // 1. Using `waitFor` then `type`: Useful for AJAX-rendered or slow-loading elements.
            // $browser->waitFor('input[name="name"]', 10)->type('name', 'Testfirstname Testlastname');

            // 2. `waitUntilEnabled`: Sometimes, the element is present in the DOM but not yet clickable or focusable.
            // $browser->waitUntilEnabled('input[name="name"]', 10)->type('name', 'Testfirstname Testlastname');

            // 3. `pause`: If your input is revealed via JavaScript animation, `waitFor()` may be too early.
            // $browser->pause(500)->type('name', 'Testfirstname Testlastname');

            // 4. `keys`: When running in headless mode, Chrome sometimes lags with Dusk's `type()`. Try using `keys()` instead (more native and accurate for simulating key presses).
            // $browser->keys('name', 'Testfirstname Testlastname');

            // 5. `scrollIntoView`: Ensures the field is in the browser's viewport, which is better for larger forms.
            // $browser->scrollIntoView('input[name="name"]')->type('name', 'Testfirstname Testlastname');

            // 6. `typeSlowly`: Simulates human typing by adding a delay (e.g., 100ms per character). Useful if typing too quickly causes issues.
            // $browser->typeSlowly('name', 'Testfirstname Testlastname', 100); // 100ms per char

            // # Better Solutions: Try combining these for best results:
            // This combination ensures the element is present, enabled, in view, and typed into realistically.
            $browser->waitFor('input[name="name"]', 10)
                ->waitUntilEnabled('input[name="name"]', 10)
                ->scrollIntoView('input[name="name"]')
                ->typeSlowly('name', 'Testfirstname Testlastname', 100);

            // Continue with other form fields using the robust typing method:
            $browser->waitFor('input[name="email"]', 10)
                ->waitUntilEnabled('input[name="email"]', 10)
                ->scrollIntoView('input[name="email"]')
                ->typeSlowly('email', 'test@yopmail.com', 100);

            $browser->waitFor('input[name="password"]', 10)
                ->waitUntilEnabled('input[name="password"]', 10)
                ->scrollIntoView('input[name="password"]')
                ->typeSlowly('password', 'Test@123', 100);

            $browser->screenshot('after-type-ways-register-page'); // Screenshot after filling relevant fields
        });
    }

    /**
     * Test that a user can successfully register through the application's registration form.
     *
     * This test navigates to the registration page, fills in all required fields
     * (Name, Email, Password, Confirm Password), submits the form, and then
     * takes screenshots at various stages for debugging and verification.
     *
     * Expected outcome: Upon successful registration, the user should be
     * redirected to the dashboard or a similar success page.
     *
     * Note: Assertions for the final path and visible text are commented out
     * for initial debugging and should be uncommented and adjusted based on
     * the actual application flow after a successful registration.
     */
    public function testUserCanRegister(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->screenshot('before-register-page');

            $browser->waitFor('input[name="name"]', 10)->typeSlowly('name', 'Testfirstname Testlastname', 50)
                ->waitFor('input[name="email"]', 10)->typeSlowly('email', 'test@yopmail.com', 50)
                ->waitFor('input[name="password"]', 10)->typeSlowly('password', 'Test@123', 50)
                ->waitFor('input[name="password_confirmation"]', 10)->typeSlowly('password_confirmation', 'Test@123', 50);

            $browser->screenshot('after-filling-form');

            // --- Using CSS selector for the button ---
            $browser->waitFor('button[type="submit"]', 10) // Wait for the submit button
                ->press('button[type="submit"]'); // Press the submit button using its selector
            // OR if you want to be super specific to ensure it's the one with "Register" text:
            // ->waitFor('button[type="submit"]', 10)->press('Register'); // Wait by selector, press by text

            $browser->screenshot('after-pressing-register');

            $browser->assertPathIs('/dashboard')
            ->assertSee('Dashboard'); // Adjust this text based on your actual dashboard content
            $browser->pause(1500);
            $browser->screenshot('after-register-success');
        });
    }
}
