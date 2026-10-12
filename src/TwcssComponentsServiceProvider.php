<?php

namespace Fsteltenkamp\TwcssComponents;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class TwcssComponentsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'fltc');

        Blade::componentNamespace('Fsteltenkamp\\TwcssComponents\\View\\Components', 'fltc');

        Blade::anonymousComponentPath(__DIR__.'/../resources/views/components', 'fltc');

        // Component scripts are wrapped in Livewire's @assets so they load once
        // even when a component first appears in a Livewire update. Without
        // Livewire the directive would leak as literal text, so fall back to
        // @once semantics (render the block once per request).
        if (! class_exists(\Livewire\Livewire::class)) {
            Blade::directive('assets', function () {
                $id = var_export('fltc-assets-'.Str::uuid(), true);

                return "<?php if (! \$__env->hasRenderedOnce({$id})): \$__env->markAsRenderedOnce({$id}); ?>";
            });
            Blade::directive('endassets', fn () => '<?php endif; ?>');
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/fltc'),
            ], 'fltc-components-views');
        }
    }
}
