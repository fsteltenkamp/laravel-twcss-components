<?php

namespace Fsteltenkamp\TwcssComponents;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class TwcssComponentsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'twcss');

        Blade::componentNamespace('Fsteltenkamp\\TwcssComponents\\View\\Components', 'twcss');

        Blade::anonymousComponentPath(__DIR__.'/../resources/views/components', 'twcss');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/twcss'),
            ], 'twcss-components-views');
        }
    }
}
