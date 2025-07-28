<?php

namespace Tests\Browser;

use App\Models\User; // Make sure to import your User model
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * Class LoginTest
 *
 * Browser test for verifying the user login functionality.
 *
 * This class uses Laravel Dusk to simulate end-to-end browser interactions
 * for user authentication. It ensures that a registered user can log in
 * through the login interface and be redirected appropriately.
 *
 * Key steps include:
 * - Creating a test user using a factory.
 * - Navigating to the login page.
 * - Filling and submitting the login form.
 * - Asserting redirection and content on the post-login page.
 *
 * @package Tests\Browser
 * @author Tejas Soni
 * @contact soni.tejas@live.com
 */
class LoginTest extends DuskTestCase
{
    // This trait will ensure a fresh database for each test run,
    // which is crucial for tests involving user creation/authentication.
    use DatabaseMigrations;

    /**
     * Test that a registered user can successfully log in.
     *
     * This test creates a new user, navigates to the login page,
     * enters the user's credentials, submits the form, and asserts
     * that the user is redirected to the dashboard (or home page)
     * and sees specific content indicating successful login.
     */
    public function testUserCanLogin(): void
    {
        // 1. Arrange: Create a user in the database
        // We use the User factory to create a new user for this test.
        // The password will be hashed in the database, but we use the
        // plain text 'password' for the login attempt.
        $user = User::factory()->create([
            'email' => 'login_test_user_' . uniqid() . '@example.com', // Ensure unique email
            'password' => bcrypt('password'), // Hash the password for the database
        ]);

        // 2. Act: Perform browser actions
        $this->browse(function (Browser $browser) use ($user) {
            // Visit the login page
            $browser->visit('/login')
                    ->screenshot('before-login-page'); // Capture initial state screenshot

            // Type the user's email and password into the respective fields.
            // Using `typeSlowly` simulates human interaction and can help with flaky tests.
            $browser->waitFor('input[name="email"]', 10)->typeSlowly('email', $user->email, 50)
                    ->waitFor('input[name="password"]', 10)->typeSlowly('password', 'password', 50); // Use the plain text password

            $browser->screenshot('after-filling-login-form'); // Capture form after filling

            // Click the "Login" button.
            // We use `waitForButton` to ensure the button is present and clickable.
             $browser->waitFor('button[type="submit"]', 10) // Wait for the submit button
                    ->press('button[type="submit"]'); // Press the button using its exact text

            $browser->screenshot('after-pressing-login'); // Capture state after button click

            // 3. Assert: Verify the outcome
            // Assert that the browser is redirected to the dashboard or home page.
            // Adjust '/dashboard' to your actual post-login redirect path (e.g., '/home').
            $browser->assertPathIs('/dashboard');

            // $browser->pause(1500); // 1.5 seconds wait, Pause for observation
            // $browser->waitForText("Tejas Soni",1500); // 1.5 seconds wait, Pause for observation
            // Assert that specific text is visible on the page to confirm successful login.
            // This could be "Dashboard", "You are logged in!", the user's name, etc.
            $browser->assertSee('Dashboard'); // Example: Change to text that appears on your dashboard
            $browser->assertSee('Tejas Soni'); // Example: Change to text that appears on your dashboard
            $browser->screenshot('after-successful-login'); // Final screenshot of the successful state
        });
    }
}