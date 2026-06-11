<?php

namespace Fsteltenkamp\TwcssComponents\Tests;

use Fsteltenkamp\TwcssComponents\TwcssComponentsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            TwcssComponentsServiceProvider::class,
        ];
    }
}
