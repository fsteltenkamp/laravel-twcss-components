<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * A conversation: x-fltc::thread.message cards (the viewer's own on the right, in
 * `ownColor`) with x-fltc::thread.event lines for system entries between them.
 */
class Thread extends Component
{
    public function __construct(
        public string $color = 'base',
        public string $ownColor = 'primary',
    ) {}

    public function render(): View|Closure|string
    {
        ViewFacade::share('fltcThread', ['color' => $this->color, 'ownColor' => $this->ownColor]);

        return view('fltc::components.thread');
    }
}
