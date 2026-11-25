<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * Muted help text under a form or in a modal: a small paragraph in the colour's
 * Tertiary Content shades.
 */
class Hint extends Component
{
    public string $classList;

    public function __construct(
        public string $color = 'base',
        public string $icon = '',
        public string $size = 'xs',
    ) {
        $this->classList = trim('flex items-start gap-1.5 '.($size === 'sm' ? 'text-sm' : 'text-xs').' '.Shades::tertiary($color));
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.hint');
    }
}
