<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Nav\Sidebar;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\ActiveUrl;
use Fsteltenkamp\TwcssComponents\Support\SidebarTheme;
use Illuminate\Contracts\View\View;
use Fsteltenkamp\TwcssComponents\View\Component;

class Link extends Component
{
    public string $classList;
    public string $href;
    public bool $isActive;

    /**
     * Create a new component instance.
     *
     * @param  string  $href  Link target.
     * @param  string|null  $icon  Full icon class string (e.g. "ph ph-gauge").
     * @param  bool|null  $active  Force the active state; when null it is derived from the URL.
     * @param  string|null  $activePattern  Request::is() pattern for active detection (defaults to the href path).
     */
    public function __construct(
        string $href = '#',
        public ?string $icon = null,
        ?bool $active = null,
        ?string $activePattern = null,
        ?string $color = null,
        string $class = '',
    ) {
        $this->href = $href;
        $resolvedTheme = $color ?? (app('view')->getShared()['sidebarColor'] ?? 'base');
        $this->hookColor = $resolvedTheme;

        $this->isActive = $active ?? ActiveUrl::matches($href, $activePattern);

        $stateClasses = $this->isActive
            ? SidebarTheme::active($resolvedTheme).' font-semibold'
            : SidebarTheme::inactive($resolvedTheme);

        $this->classList = trim(implode(' ', array_filter([
            'nav-link flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition focus:outline-none focus-visible:ring-2',
            $stateClasses,
            $class,
        ])));
    }

    /**
     * Determine whether the link points at the current request URL.
     */
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.nav.sidebar.link');
    }
}
