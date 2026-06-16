<?php

namespace Fsteltenkamp\TwcssComponents\Tests;

use Fsteltenkamp\TwcssComponents\TwcssComponentsServiceProvider;
use Illuminate\Support\Facades\Blade;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            TwcssComponentsServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // The navbar template references the host app's <x-application-logo/>.
        // Register a stub so navbar examples compile under testbench.
        Blade::anonymousComponentPath(__DIR__.'/stubs/components');
    }
}
