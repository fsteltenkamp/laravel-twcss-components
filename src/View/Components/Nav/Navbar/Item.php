<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Nav\Navbar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Item extends Component
{
    public string $classList;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $class = '',
        ?string $theme = null,
    ) {
        $resolvedTheme = $theme ?? (app('view')->getShared()['navbarTheme'] ?? 'slate');

        $themeMap = [
            'slate'   => 'text-slate-700 dark:text-slate-300',
            'gray'    => 'text-gray-700 dark:text-gray-300',
            'zinc'    => 'text-zinc-700 dark:text-zinc-300',
            'neutral' => 'text-neutral-700 dark:text-neutral-300',
            'stone'   => 'text-stone-700 dark:text-stone-300',
            'red'     => 'text-red-700 dark:text-red-300',
            'orange'  => 'text-orange-700 dark:text-orange-300',
            'amber'   => 'text-amber-700 dark:text-amber-300',
            'yellow'  => 'text-yellow-700 dark:text-yellow-300',
            'lime'    => 'text-lime-700 dark:text-lime-300',
            'green'   => 'text-green-700 dark:text-green-300',
            'emerald' => 'text-emerald-700 dark:text-emerald-300',
            'teal'    => 'text-teal-700 dark:text-teal-300',
            'cyan'    => 'text-cyan-700 dark:text-cyan-300',
            'sky'     => 'text-sky-700 dark:text-sky-300',
            'blue'    => 'text-blue-700 dark:text-blue-300',
            'indigo'  => 'text-indigo-700 dark:text-indigo-300',
            'violet'  => 'text-violet-700 dark:text-violet-300',
            'purple'  => 'text-purple-700 dark:text-purple-300',
            'fuchsia' => 'text-fuchsia-700 dark:text-fuchsia-300',
            'pink'    => 'text-pink-700 dark:text-pink-300',
            'rose'    => 'text-rose-700 dark:text-rose-300',
            'taupe'   => 'text-taupe-700 dark:text-taupe-300',
            'mauve'   => 'text-mauve-700 dark:text-mauve-300',
            'mist'    => 'text-mist-700 dark:text-mist-300',
            'olive'   => 'text-olive-700 dark:text-olive-300',
        ];

        $themeClasses = $themeMap[$resolvedTheme] ?? $themeMap['slate'];

        $this->classList = trim(implode(' ', array_filter([
            'nav-item inline-flex h-full items-center px-3',
            $themeClasses,
            $class,
        ])));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('twcss::components.nav.navbar.item');
    }
}
