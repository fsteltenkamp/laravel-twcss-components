<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Nav\Sidebar;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\SidebarTheme;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Postlink extends Component
{
    public string $classList;
    public string $action;

    /**
     * Create a new component instance.
     *
     * @param  string  $action  Form action the submit button posts to.
     * @param  string|null  $icon  Full icon class string (e.g. "ph ph-sign-out").
     */
    public function __construct(
        string $action = '',
        public ?string $icon = null,
        ?string $theme = null,
        string $class = '',
    ) {
        $this->action = $action;
        $resolvedTheme = $theme ?? (app('view')->getShared()['sidebarTheme'] ?? 'slate');

        $this->classList = trim(implode(' ', array_filter([
            'nav-link cursor-pointer flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition focus:outline-none focus-visible:ring-2',
            SidebarTheme::inactive($resolvedTheme),
            $class,
        ])));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.nav.sidebar.postlink');
    }
}
