<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Nav\Sidebar;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\SidebarTheme;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Profile extends Component
{
    public string $triggerClass;
    public string $avatarClass;
    public string $menuClass;
    public string $initials;

    /**
     * Create a new component instance.
     *
     * @param  string  $name  Display name.
     * @param  string|null  $email  Secondary line (e.g. email).
     * @param  string|null  $avatar  Avatar image URL; falls back to initials when null.
     * @param  string|null  $initials  Override the auto-derived initials.
     * @param  string|null  $href  Link target used when no menu slot is provided.
     */
    public function __construct(
        public string $name = '',
        public ?string $email = null,
        public ?string $avatar = null,
        ?string $initials = null,
        public ?string $href = null,
        ?string $theme = null,
        string $class = '',
    ) {
        $resolvedTheme = $theme ?? (app('view')->getShared()['sidebarTheme'] ?? 'slate');

        $this->initials = $initials ?? $this->deriveInitials($name);

        $this->triggerClass = trim(implode(' ', array_filter([
            'nav-link flex w-full items-center gap-3 rounded-lg px-2 py-2 text-sm transition focus:outline-none focus-visible:ring-2',
            SidebarTheme::inactive($resolvedTheme),
            $class,
        ])));

        // Reuse the active fill for the initials avatar badge.
        $this->avatarClass = trim('flex h-9 w-9 shrink-0 items-center justify-center overflow-hidden rounded-full text-xs font-semibold '.SidebarTheme::active($resolvedTheme));

        $this->menuClass = trim('absolute bottom-full left-0 right-0 z-20 mb-2 hidden overflow-hidden rounded-xl border '.SidebarTheme::menu($resolvedTheme));
    }

    /**
     * Build up to two uppercase initials from a display name.
     */
    private function deriveInitials(string $name): string
    {
        $parts = preg_split('/\s+/', trim($name), -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $letters = array_map(fn ($part) => Str::upper(Str::substr($part, 0, 1)), $parts);

        return implode('', array_slice($letters, 0, 2));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.nav.sidebar.profile');
    }
}
