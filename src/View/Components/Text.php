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
     * @param  string  $theme  Palette for the Primary Content text colour. Ignored when an
     *                         explicit `color` attribute sets the colour instead.
     */
    public function __construct(public string $theme = 'slate')
    {
        $this->classList = Shades::primary($theme);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.text');
    }
}
