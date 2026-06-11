<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Nav\Navbar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dropdown extends Component
{
    public string $buttonClass;
    public string $menuClass;
    private string $resolvedTheme;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $class = '',
        ?string $theme = null,
        public bool $hover = false,
    ) {
        $this->resolvedTheme = $theme ?? (app('view')->getShared()['navbarTheme'] ?? 'slate');

        $buttonThemeMap = [
            'slate'   => 'text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800 focus-visible:bg-slate-100 focus-visible:ring-slate-400 dark:focus-visible:bg-slate-800 dark:focus-visible:ring-slate-600',
            'gray'    => 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800 focus-visible:bg-gray-100 focus-visible:ring-gray-400 dark:focus-visible:bg-gray-800 dark:focus-visible:ring-gray-600',
            'zinc'    => 'text-zinc-700 hover:bg-zinc-100 dark:text-zinc-200 dark:hover:bg-zinc-800 focus-visible:bg-zinc-100 focus-visible:ring-zinc-400 dark:focus-visible:bg-zinc-800 dark:focus-visible:ring-zinc-600',
            'neutral' => 'text-neutral-700 hover:bg-neutral-100 dark:text-neutral-200 dark:hover:bg-neutral-800 focus-visible:bg-neutral-100 focus-visible:ring-neutral-400 dark:focus-visible:bg-neutral-800 dark:focus-visible:ring-neutral-600',
            'stone'   => 'text-stone-700 hover:bg-stone-100 dark:text-stone-200 dark:hover:bg-stone-800 focus-visible:bg-stone-100 focus-visible:ring-stone-400 dark:focus-visible:bg-stone-800 dark:focus-visible:ring-stone-600',
            'red'     => 'text-red-700 hover:bg-red-100 dark:text-red-200 dark:hover:bg-red-800 focus-visible:bg-red-100 focus-visible:ring-red-400 dark:focus-visible:bg-red-800 dark:focus-visible:ring-red-600',
            'orange'  => 'text-orange-700 hover:bg-orange-100 dark:text-orange-200 dark:hover:bg-orange-800 focus-visible:bg-orange-100 focus-visible:ring-orange-400 dark:focus-visible:bg-orange-800 dark:focus-visible:ring-orange-600',
            'amber'   => 'text-amber-700 hover:bg-amber-100 dark:text-amber-200 dark:hover:bg-amber-800 focus-visible:bg-amber-100 focus-visible:ring-amber-400 dark:focus-visible:bg-amber-800 dark:focus-visible:ring-amber-600',
            'yellow'  => 'text-yellow-700 hover:bg-yellow-100 dark:text-yellow-200 dark:hover:bg-yellow-800 focus-visible:bg-yellow-100 focus-visible:ring-yellow-400 dark:focus-visible:bg-yellow-800 dark:focus-visible:ring-yellow-600',
            'lime'    => 'text-lime-700 hover:bg-lime-100 dark:text-lime-200 dark:hover:bg-lime-800 focus-visible:bg-lime-100 focus-visible:ring-lime-400 dark:focus-visible:bg-lime-800 dark:focus-visible:ring-lime-600',
            'green'   => 'text-green-700 hover:bg-green-100 dark:text-green-200 dark:hover:bg-green-800 focus-visible:bg-green-100 focus-visible:ring-green-400 dark:focus-visible:bg-green-800 dark:focus-visible:ring-green-600',
            'emerald' => 'text-emerald-700 hover:bg-emerald-100 dark:text-emerald-200 dark:hover:bg-emerald-800 focus-visible:bg-emerald-100 focus-visible:ring-emerald-400 dark:focus-visible:bg-emerald-800 dark:focus-visible:ring-emerald-600',
            'teal'    => 'text-teal-700 hover:bg-teal-100 dark:text-teal-200 dark:hover:bg-teal-800 focus-visible:bg-teal-100 focus-visible:ring-teal-400 dark:focus-visible:bg-teal-800 dark:focus-visible:ring-teal-600',
            'cyan'    => 'text-cyan-700 hover:bg-cyan-100 dark:text-cyan-200 dark:hover:bg-cyan-800 focus-visible:bg-cyan-100 focus-visible:ring-cyan-400 dark:focus-visible:bg-cyan-800 dark:focus-visible:ring-cyan-600',
            'sky'     => 'text-sky-700 hover:bg-sky-100 dark:text-sky-200 dark:hover:bg-sky-800 focus-visible:bg-sky-100 focus-visible:ring-sky-400 dark:focus-visible:bg-sky-800 dark:focus-visible:ring-sky-600',
            'blue'    => 'text-blue-700 hover:bg-blue-100 dark:text-blue-200 dark:hover:bg-blue-800 focus-visible:bg-blue-100 focus-visible:ring-blue-400 dark:focus-visible:bg-blue-800 dark:focus-visible:ring-blue-600',
            'indigo'  => 'text-indigo-700 hover:bg-indigo-100 dark:text-indigo-200 dark:hover:bg-indigo-800 focus-visible:bg-indigo-100 focus-visible:ring-indigo-400 dark:focus-visible:bg-indigo-800 dark:focus-visible:ring-indigo-600',
            'violet'  => 'text-violet-700 hover:bg-violet-100 dark:text-violet-200 dark:hover:bg-violet-800 focus-visible:bg-violet-100 focus-visible:ring-violet-400 dark:focus-visible:bg-violet-800 dark:focus-visible:ring-violet-600',
            'purple'  => 'text-purple-700 hover:bg-purple-100 dark:text-purple-200 dark:hover:bg-purple-800 focus-visible:bg-purple-100 focus-visible:ring-purple-400 dark:focus-visible:bg-purple-800 dark:focus-visible:ring-purple-600',
            'fuchsia' => 'text-fuchsia-700 hover:bg-fuchsia-100 dark:text-fuchsia-200 dark:hover:bg-fuchsia-800 focus-visible:bg-fuchsia-100 focus-visible:ring-fuchsia-400 dark:focus-visible:bg-fuchsia-800 dark:focus-visible:ring-fuchsia-600',
            'pink'    => 'text-pink-700 hover:bg-pink-100 dark:text-pink-200 dark:hover:bg-pink-800 focus-visible:bg-pink-100 focus-visible:ring-pink-400 dark:focus-visible:bg-pink-800 dark:focus-visible:ring-pink-600',
            'rose'    => 'text-rose-700 hover:bg-rose-100 dark:text-rose-200 dark:hover:bg-rose-800 focus-visible:bg-rose-100 focus-visible:ring-rose-400 dark:focus-visible:bg-rose-800 dark:focus-visible:ring-rose-600',
            'taupe'   => 'text-taupe-700 hover:bg-taupe-100 dark:text-taupe-200 dark:hover:bg-taupe-800 focus-visible:bg-taupe-100 focus-visible:ring-taupe-400 dark:focus-visible:bg-taupe-800 dark:focus-visible:ring-taupe-600',
            'mauve'   => 'text-mauve-700 hover:bg-mauve-100 dark:text-mauve-200 dark:hover:bg-mauve-800 focus-visible:bg-mauve-100 focus-visible:ring-mauve-400 dark:focus-visible:bg-mauve-800 dark:focus-visible:ring-mauve-600',
            'mist'    => 'text-mist-700 hover:bg-mist-100 dark:text-mist-200 dark:hover:bg-mist-800 focus-visible:bg-mist-100 focus-visible:ring-mist-400 dark:focus-visible:bg-mist-800 dark:focus-visible:ring-mist-600',
            'olive'   => 'text-olive-700 hover:bg-olive-100 dark:text-olive-200 dark:hover:bg-olive-800 focus-visible:bg-olive-100 focus-visible:ring-olive-400 dark:focus-visible:bg-olive-800 dark:focus-visible:ring-olive-600',
        ];

        $menuThemeMap = [
            'slate'   => 'border-slate-200 dark:border-slate-700 bg-white shadow-lg shadow-slate-900/5 ring-1 ring-black/5 dark:bg-slate-900 dark:shadow-slate-950/40 dark:ring-white/10',
            'gray'    => 'border-gray-200 dark:border-gray-700 bg-white shadow-lg shadow-gray-900/5 ring-1 ring-black/5 dark:bg-gray-900 dark:shadow-gray-950/40 dark:ring-white/10',
            'zinc'    => 'border-zinc-200 dark:border-zinc-700 bg-white shadow-lg shadow-zinc-900/5 ring-1 ring-black/5 dark:bg-zinc-900 dark:shadow-zinc-950/40 dark:ring-white/10',
            'neutral' => 'border-neutral-200 dark:border-neutral-700 bg-white shadow-lg shadow-neutral-900/5 ring-1 ring-black/5 dark:bg-neutral-900 dark:shadow-neutral-950/40 dark:ring-white/10',
            'stone'   => 'border-stone-200 dark:border-stone-700 bg-white shadow-lg shadow-stone-900/5 ring-1 ring-black/5 dark:bg-stone-900 dark:shadow-stone-950/40 dark:ring-white/10',
            'red'     => 'border-red-200 dark:border-red-700 bg-white shadow-lg shadow-red-900/5 ring-1 ring-black/5 dark:bg-red-900 dark:shadow-red-950/40 dark:ring-white/10',
            'orange'  => 'border-orange-200 dark:border-orange-700 bg-white shadow-lg shadow-orange-900/5 ring-1 ring-black/5 dark:bg-orange-900 dark:shadow-orange-950/40 dark:ring-white/10',
            'amber'   => 'border-amber-200 dark:border-amber-700 bg-white shadow-lg shadow-amber-900/5 ring-1 ring-black/5 dark:bg-amber-900 dark:shadow-amber-950/40 dark:ring-white/10',
            'yellow'  => 'border-yellow-200 dark:border-yellow-700 bg-white shadow-lg shadow-yellow-900/5 ring-1 ring-black/5 dark:bg-yellow-900 dark:shadow-yellow-950/40 dark:ring-white/10',
            'lime'    => 'border-lime-200 dark:border-lime-700 bg-white shadow-lg shadow-lime-900/5 ring-1 ring-black/5 dark:bg-lime-900 dark:shadow-lime-950/40 dark:ring-white/10',
            'green'   => 'border-green-200 dark:border-green-700 bg-white shadow-lg shadow-green-900/5 ring-1 ring-black/5 dark:bg-green-900 dark:shadow-green-950/40 dark:ring-white/10',
            'emerald' => 'border-emerald-200 dark:border-emerald-700 bg-white shadow-lg shadow-emerald-900/5 ring-1 ring-black/5 dark:bg-emerald-900 dark:shadow-emerald-950/40 dark:ring-white/10',
            'teal'    => 'border-teal-200 dark:border-teal-700 bg-white shadow-lg shadow-teal-900/5 ring-1 ring-black/5 dark:bg-teal-900 dark:shadow-teal-950/40 dark:ring-white/10',
            'cyan'    => 'border-cyan-200 dark:border-cyan-700 bg-white shadow-lg shadow-cyan-900/5 ring-1 ring-black/5 dark:bg-cyan-900 dark:shadow-cyan-950/40 dark:ring-white/10',
            'sky'     => 'border-sky-200 dark:border-sky-700 bg-white shadow-lg shadow-sky-900/5 ring-1 ring-black/5 dark:bg-sky-900 dark:shadow-sky-950/40 dark:ring-white/10',
            'blue'    => 'border-blue-200 dark:border-blue-700 bg-white shadow-lg shadow-blue-900/5 ring-1 ring-black/5 dark:bg-blue-900 dark:shadow-blue-950/40 dark:ring-white/10',
            'indigo'  => 'border-indigo-200 dark:border-indigo-700 bg-white shadow-lg shadow-indigo-900/5 ring-1 ring-black/5 dark:bg-indigo-900 dark:shadow-indigo-950/40 dark:ring-white/10',
            'violet'  => 'border-violet-200 dark:border-violet-700 bg-white shadow-lg shadow-violet-900/5 ring-1 ring-black/5 dark:bg-violet-900 dark:shadow-violet-950/40 dark:ring-white/10',
            'purple'  => 'border-purple-200 dark:border-purple-700 bg-white shadow-lg shadow-purple-900/5 ring-1 ring-black/5 dark:bg-purple-900 dark:shadow-purple-950/40 dark:ring-white/10',
            'fuchsia' => 'border-fuchsia-200 dark:border-fuchsia-700 bg-white shadow-lg shadow-fuchsia-900/5 ring-1 ring-black/5 dark:bg-fuchsia-900 dark:shadow-fuchsia-950/40 dark:ring-white/10',
            'pink'    => 'border-pink-200 dark:border-pink-700 bg-white shadow-lg shadow-pink-900/5 ring-1 ring-black/5 dark:bg-pink-900 dark:shadow-pink-950/40 dark:ring-white/10',
            'rose'    => 'border-rose-200 dark:border-rose-700 bg-white shadow-lg shadow-rose-900/5 ring-1 ring-black/5 dark:bg-rose-900 dark:shadow-rose-950/40 dark:ring-white/10',
            'taupe'   => 'border-taupe-200 dark:border-taupe-700 bg-white shadow-lg shadow-taupe-900/5 ring-1 ring-black/5 dark:bg-taupe-900 dark:shadow-taupe-950/40 dark:ring-white/10',
            'mauve'   => 'border-mauve-200 dark:border-mauve-700 bg-white shadow-lg shadow-mauve-900/5 ring-1 ring-black/5 dark:bg-mauve-900 dark:shadow-mauve-950/40 dark:ring-white/10',
            'mist'    => 'border-mist-200 dark:border-mist-700 bg-white shadow-lg shadow-mist-900/5 ring-1 ring-black/5 dark:bg-mist-900 dark:shadow-mist-950/40 dark:ring-white/10',
            'olive'   => 'border-olive-200 dark:border-olive-700 bg-white shadow-lg shadow-olive-900/5 ring-1 ring-black/5 dark:bg-olive-900 dark:shadow-olive-950/40 dark:ring-white/10',
        ];

        $buttonThemeClasses = $buttonThemeMap[$this->resolvedTheme] ?? $buttonThemeMap['slate'];
        $menuThemeClasses = $menuThemeMap[$this->resolvedTheme] ?? $menuThemeMap['slate'];

        $this->buttonClass = trim(implode(' ', array_filter([
            'cursor-pointer nav-link inline-flex h-full items-center gap-1 rounded-md px-3 transition focus:outline-none focus-visible:ring-2',
            $buttonThemeClasses,
        ])));

        $this->menuClass = trim(implode(' ', array_filter([
            'dropdown-menu absolute top-full right-0 z-20 hidden w-56 overflow-hidden rounded-b-xl rounded-t-none border',
            $menuThemeClasses,
        ])));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('twcss::components.nav.navbar.dropdown')->with([
            'buttonClass' => $this->buttonClass,
            'menuClass' => $this->menuClass,
            'hover' => $this->hover,
        ]);
    }
}
