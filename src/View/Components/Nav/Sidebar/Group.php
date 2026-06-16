<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Nav\Sidebar;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\SidebarTheme;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Group extends Component
{
    public string $triggerClass;
    public string $guideClass;
    public string $key;
    public bool $isOpen;

    /**
     * Create a new component instance.
     *
     * @param  string  $label  Trigger label.
     * @param  string|null  $icon  Full icon class string (e.g. "ph ph-folder").
     * @param  bool|null  $open  Force the initial open state; defaults to open when $activeWhen matches the URL.
     * @param  string|null  $activeWhen  Request::is() pattern that marks the group active (and open by default).
     * @param  string|null  $id  Stable key for persisting the open state in localStorage (defaults to a slug of $label).
     */
    public function __construct(
        public string $label = '',
        public ?string $icon = null,
        ?bool $open = null,
        ?string $activeWhen = null,
        ?string $id = null,
        ?string $theme = null,
        string $class = '',
    ) {
        $resolvedTheme = $theme ?? (app('view')->getShared()['sidebarTheme'] ?? 'slate');

        $isActive = $activeWhen !== null && request()->is($activeWhen);
        $this->isOpen = $open ?? $isActive;
        $this->key = $id ?? (Str::slug($label) ?: 'group');

        $stateClasses = $isActive
            ? SidebarTheme::active($resolvedTheme)
            : SidebarTheme::inactive($resolvedTheme);

        $this->triggerClass = trim(implode(' ', array_filter([
            'nav-link flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition focus:outline-none focus-visible:ring-2',
            $stateClasses,
            $class,
        ])));

        $this->guideClass = SidebarTheme::divider($resolvedTheme);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.nav.sidebar.group');
    }
}
