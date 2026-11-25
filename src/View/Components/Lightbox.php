<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * One image viewer for the page, placed once (in the layout). It opens for any click on
 * an element with data-fltc-lightbox="group" (its href, src or data-fltc-lightbox-src;
 * every element of the same group becomes a page of the viewer), or for the window event
 * `fltc-lightbox` with { src, name } or { items: [{ src, name }], index }.
 */
class Lightbox extends Component
{
    public function __construct(
        public string $color = 'base',
        public bool $download = true,
    ) {}

    public function render(): View|Closure|string
    {
        return view('fltc::components.lightbox');
    }
}
