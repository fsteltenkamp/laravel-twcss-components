<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Nav\Navbar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Toggle extends Component
{
    public string $classList;

    /**
     * A hamburger button that opens the responsive sidebar drawer.
     *
     * Dispatches the `fltc-sidebar-toggle` window event the sidebar listens
     * for. Set $target to the matching sidebar `name` when more than one
     * sidebar is on the page. Hidden from `lg` up, where the sidebar is a
     * permanent column.
     */
    public function __construct(
        public string $class = '',
        public string $target = '',
        public string $label = 'Toggle navigation',
        ?string $theme = null,
    ) {
        $resolvedTheme = $theme ?? (app('view')->getShared()['navbarTheme'] ?? 'slate');

        $themeMap = [
            'slate'   => 'text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800 focus-visible:ring-slate-400 dark:focus-visible:ring-slate-600',
            'gray'    => 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800 focus-visible:ring-gray-400 dark:focus-visible:ring-gray-600',
            'zinc'    => 'text-zinc-700 hover:bg-zinc-100 dark:text-zinc-200 dark:hover:bg-zinc-800 focus-visible:ring-zinc-400 dark:focus-visible:ring-zinc-600',
            'neutral' => 'text-neutral-700 hover:bg-neutral-100 dark:text-neutral-200 dark:hover:bg-neutral-800 focus-visible:ring-neutral-400 dark:focus-visible:ring-neutral-600',
            'stone'   => 'text-stone-700 hover:bg-stone-100 dark:text-stone-200 dark:hover:bg-stone-800 focus-visible:ring-stone-400 dark:focus-visible:ring-stone-600',
            'red'     => 'text-red-700 hover:bg-red-100 dark:text-red-200 dark:hover:bg-red-800 focus-visible:ring-red-400 dark:focus-visible:ring-red-600',
            'orange'  => 'text-orange-700 hover:bg-orange-100 dark:text-orange-200 dark:hover:bg-orange-800 focus-visible:ring-orange-400 dark:focus-visible:ring-orange-600',
            'amber'   => 'text-amber-700 hover:bg-amber-100 dark:text-amber-200 dark:hover:bg-amber-800 focus-visible:ring-amber-400 dark:focus-visible:ring-amber-600',
            'yellow'  => 'text-yellow-700 hover:bg-yellow-100 dark:text-yellow-200 dark:hover:bg-yellow-800 focus-visible:ring-yellow-400 dark:focus-visible:ring-yellow-600',
            'lime'    => 'text-lime-700 hover:bg-lime-100 dark:text-lime-200 dark:hover:bg-lime-800 focus-visible:ring-lime-400 dark:focus-visible:ring-lime-600',
            'green'   => 'text-green-700 hover:bg-green-100 dark:text-green-200 dark:hover:bg-green-800 focus-visible:ring-green-400 dark:focus-visible:ring-green-600',
            'emerald' => 'text-emerald-700 hover:bg-emerald-100 dark:text-emerald-200 dark:hover:bg-emerald-800 focus-visible:ring-emerald-400 dark:focus-visible:ring-emerald-600',
            'teal'    => 'text-teal-700 hover:bg-teal-100 dark:text-teal-200 dark:hover:bg-teal-800 focus-visible:ring-teal-400 dark:focus-visible:ring-teal-600',
            'cyan'    => 'text-cyan-700 hover:bg-cyan-100 dark:text-cyan-200 dark:hover:bg-cyan-800 focus-visible:ring-cyan-400 dark:focus-visible:ring-cyan-600',
            'sky'     => 'text-sky-700 hover:bg-sky-100 dark:text-sky-200 dark:hover:bg-sky-800 focus-visible:ring-sky-400 dark:focus-visible:ring-sky-600',
            'blue'    => 'text-blue-700 hover:bg-blue-100 dark:text-blue-200 dark:hover:bg-blue-800 focus-visible:ring-blue-400 dark:focus-visible:ring-blue-600',
            'indigo'  => 'text-indigo-700 hover:bg-indigo-100 dark:text-indigo-200 dark:hover:bg-indigo-800 focus-visible:ring-indigo-400 dark:focus-visible:ring-indigo-600',
            'violet'  => 'text-violet-700 hover:bg-violet-100 dark:text-violet-200 dark:hover:bg-violet-800 focus-visible:ring-violet-400 dark:focus-visible:ring-violet-600',
            'purple'  => 'text-purple-700 hover:bg-purple-100 dark:text-purple-200 dark:hover:bg-purple-800 focus-visible:ring-purple-400 dark:focus-visible:ring-purple-600',
            'fuchsia' => 'text-fuchsia-700 hover:bg-fuchsia-100 dark:text-fuchsia-200 dark:hover:bg-fuchsia-800 focus-visible:ring-fuchsia-400 dark:focus-visible:ring-fuchsia-600',
            'pink'    => 'text-pink-700 hover:bg-pink-100 dark:text-pink-200 dark:hover:bg-pink-800 focus-visible:ring-pink-400 dark:focus-visible:ring-pink-600',
            'rose'    => 'text-rose-700 hover:bg-rose-100 dark:text-rose-200 dark:hover:bg-rose-800 focus-visible:ring-rose-400 dark:focus-visible:ring-rose-600',
            'taupe'   => 'text-taupe-700 hover:bg-taupe-100 dark:text-taupe-200 dark:hover:bg-taupe-800 focus-visible:ring-taupe-400 dark:focus-visible:ring-taupe-600',
            'mauve'   => 'text-mauve-700 hover:bg-mauve-100 dark:text-mauve-200 dark:hover:bg-mauve-800 focus-visible:ring-mauve-400 dark:focus-visible:ring-mauve-600',
            'mist'    => 'text-mist-700 hover:bg-mist-100 dark:text-mist-200 dark:hover:bg-mist-800 focus-visible:ring-mist-400 dark:focus-visible:ring-mist-600',
            'olive'   => 'text-olive-700 hover:bg-olive-100 dark:text-olive-200 dark:hover:bg-olive-800 focus-visible:ring-olive-400 dark:focus-visible:ring-olive-600',
        ];

        $themeClasses = $themeMap[$resolvedTheme] ?? $themeMap['slate'];

        $this->classList = trim(implode(' ', array_filter([
            'nav-toggle inline-flex h-10 w-10 shrink-0 items-center justify-center self-center rounded-md text-xl transition focus:outline-none focus-visible:ring-2 lg:hidden',
            $themeClasses,
            $class,
        ])));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.nav.navbar.toggle')
            ->with('detail', ['name' => $this->target]);
    }
}
