<?php

namespace Fsteltenkamp\fltcComponents;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class fltcComponentsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'fltc');

        Blade::componentNamespace('Fsteltenkamp\\fltcComponents\\View\\Components', 'fltc');

        Blade::anonymousComponentPath(__DIR__.'/../resources/views/components', 'fltc');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/fltc'),
            ], 'fltc-components-views');
        }
    }
}
