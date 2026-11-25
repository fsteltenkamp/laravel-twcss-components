<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Illuminate\Contracts\View\View;
use Fsteltenkamp\TwcssComponents\View\Component;

class Text extends Component
{
    public string $classList;

    /**
     * @param  string  $color  Palette for the Primary Content text colour. Ignored when an
     *                         explicit `color` attribute sets the colour instead.
     */
    public function __construct(public string $color = 'base', public string $size = '', public bool $muted = false)
    {
        // muted: the Tertiary Content shades (hints, secondary remarks); size: xs … lg.
        $this->classList = trim(($muted ? Shades::tertiary($color) : Shades::primary($color)).' '.(['xs' => 'text-xs', 'sm' => 'text-sm', 'md' => 'text-base', 'lg' => 'text-lg'][$size] ?? ''));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.text');
    }
}
