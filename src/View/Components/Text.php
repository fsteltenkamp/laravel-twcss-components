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
    public function __construct(public string $color = 'base')
    {
        $this->classList = Shades::primary($color);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.text');
    }
}
