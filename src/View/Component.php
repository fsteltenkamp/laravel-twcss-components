<?php

namespace Fsteltenkamp\TwcssComponents\View;

use Illuminate\Support\Str;
use Illuminate\View\Component as BaseComponent;

/**
 * Base for every class-backed fltc component.
 *
 * Adds two neutral hook classes to the attribute bag, so they land on whatever
 * element the view renders `$attributes` on (the root, by convention):
 *
 *   fltc-<tag>          the component's tag with dots as dashes:
 *                       <x-fltc::nav.navbar.link> → fltc-nav-navbar-link
 *   fltc-theme-<theme>  the component's `theme` prop, when it has one
 *
 * They carry no styles of their own. Skin stylesheets such as
 * resources/css/skin-effects.css target them to add fonts, rounding and glow
 * per theme without the components knowing about any particular skin.
 */
abstract class Component extends BaseComponent
{
    /**
     * Theme for the fltc-theme-* hook when it is not the `theme` prop: components that
     * inherit their parent's theme (navbar and sidebar children) set it to the theme
     * they resolved, since their own `theme` prop stays null.
     */
    protected ?string $hookTheme = null;

    public function withAttributes(array $attributes)
    {
        parent::withAttributes($attributes);

        // Mutate the bag rather than replacing it: Blade hands this same object to
        // the view (via data()) before it calls withAttributes().
        $this->attributes->setAttributes(
            $this->attributes->class($this->hookClasses())->getAttributes()
        );

        return $this;
    }

    /**
     * @return array<int, string>
     */
    public function hookClasses(): array
    {
        $classes = [static::hookName()];

        $theme = $this->hookTheme ?? (property_exists($this, 'theme') ? $this->theme : null);

        if (is_string($theme) && $theme !== '') {
            $classes[] = 'fltc-theme-'.$theme;
        }

        return $classes;
    }

    /**
     * Fsteltenkamp\TwcssComponents\View\Components\Form\Container\Auth\TwoColLeft
     * → fltc-form-container-auth-two-col-left
     */
    public static function hookName(): string
    {
        $path = Str::after(static::class, __NAMESPACE__.'\\Components\\');

        return 'fltc-'.collect(explode('\\', $path))->map(fn (string $part) => Str::kebab($part))->implode('-');
    }
}
