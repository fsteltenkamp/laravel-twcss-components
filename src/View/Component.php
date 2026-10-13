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
 *   fltc-color-<color>  the component's `color` prop (a role such as primary, or a
 *                       palette such as green), when it has one
 *
 * They carry no styles of their own. Skin stylesheets such as
 * resources/css/skin-effects.css target them to add fonts, rounding and glow
 * in each component's colour without the components knowing about any skin.
 */
abstract class Component extends BaseComponent
{
    /**
     * Colour for the fltc-color-* hook when it is not the `color` prop: components that
     * inherit their parent's colour (navbar and sidebar children) set it to the colour
     * they resolved, since their own `color` prop stays null.
     */
    protected ?string $hookColor = null;

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

        $color = $this->hookColor ?? (property_exists($this, 'color') ? $this->color : null);

        if (is_string($color) && $color !== '') {
            $classes[] = 'fltc-color-'.$color;
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
