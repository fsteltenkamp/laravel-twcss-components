<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Nav\Sidebar;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\SidebarTheme;
use Illuminate\Contracts\View\View;
use Fsteltenkamp\TwcssComponents\View\Component;

class Footer extends Component
{
    public string $classList;
    public string $linksClasses;

    /**
     * Create a new component instance.
     */
    public function __construct(
        ?string $color = null,
        string $class = '',
        public array $links = [],
    ) {
        $resolvedTheme = $color ?? (app('view')->getShared()['sidebarColor'] ?? 'base');
        $this->hookColor = $resolvedTheme;

        $this->linksClasses = 'fltc-nav-sidebar-footer-links flex flex-wrap items-center gap-x-1.5 px-3 text-xs '.SidebarTheme::inactive($resolvedTheme);

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
