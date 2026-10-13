<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\SidebarTheme;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * A vertical timeline of x-fltc::timeline.item entries: dots on a line, newest or
 * oldest first as the app orders them. The items take this theme.
 */
class Timeline extends Component
{
    public string $classList;

    public function __construct(
        public string $color = 'base',
    ) {
        $this->classList = 'relative ms-3 space-y-6 border-s-2 ps-6 '.SidebarTheme::divider($color);
    }

    public function render(): View|Closure|string
    {
        ViewFacade::share('fltcTimelineColor', $this->color);

        return view('fltc::components.timeline');
    }
}
