<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Nav\Sidebar;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\SidebarTheme;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    public string $classList;

    /**
     * Create a new component instance.
     */
    public function __construct(
        ?string $theme = null,
        string $class = '',
    ) {
        $resolvedTheme = $theme ?? (app('view')->getShared()['sidebarTheme'] ?? 'slate');

        $this->classList = trim(implode(' ', array_filter([
            'mt-auto shrink-0 space-y-1 border-t px-3 py-3',
            SidebarTheme::divider($resolvedTheme),
            $class,
        ])));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.nav.sidebar.footer');
    }
}
