<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Collection;
use Laravel\Dusk\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\BeforeClass;

abstract class DuskTestCase extends BaseTestCase
{
    /**
     * Prepare for Dusk test execution.
     */
    #[BeforeClass]
    public static function prepare(): void
    {
        if (! static::runningInSail()) {
            static::startChromeDriver(['--port=9515']);
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     */
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments(collect([
            $this->shouldStartMaximized() ? '--start-maximized' :  '--window-size=1920,1080', // Set a fixed window size to ensure consistent rendering across environments.
            '--disable-search-engine-choice-screen', // Disable the initial search engine selection screen on first run.
            '--disable-smooth-scrolling', // Disable smooth scrolling for faster and more deterministic test execution.
            '--disable-extensions', // Disable all Chrome extensions to reduce interference during testing.
            '--disable-dev-shm-usage', // Avoid using /dev/shm; useful in Docker/Linux environments with limited shared memory.
            '--no-sandbox', // Disable Chrome's security sandbox (required in some headless or restricted environments).
            '--disable-blink-features=AutomationControlled', // Hide that Chrome is controlled by automation (for anti-bot bypassing).
            '--disable-infobars', // Remove the “Chrome is being controlled by automated test software” infobar.
        ])->all());

        return RemoteWebDriver::create(
            $_ENV['DUSK_DRIVER_URL'] ?? env('DUSK_DRIVER_URL') ?? 'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $options
            )
        );
    }

    /**
     * Old Create the RemoteWebDriver instance.
     * if you don't have gui 
     */
    protected function driverOld(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments(collect([
            $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080',
            '--disable-search-engine-choice-screen',
            '--disable-smooth-scrolling',
        ])->unless($this->hasHeadlessDisabled(), function (Collection $items) {
            return $items->merge([
                '--disable-gpu',
                '--headless=new',
            ]);
        })->all());

        return RemoteWebDriver::create(
            $_ENV['DUSK_DRIVER_URL'] ?? env('DUSK_DRIVER_URL') ?? 'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $options
            )
        );
    }
}
