<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Nav;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Link extends Component
{
    public string $classList;
    public string $href;

    public function __construct(string $theme = 'slate', string $class = '', string $href = '#')
    {
        $this->href = $href;

        $themeMap = [
            'slate'   => 'text-slate-700 hover:text-slate-800 dark:text-slate-300 dark:hover:text-slate-200',
            'gray'    => 'text-gray-700 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-200',
            'zinc'    => 'text-zinc-700 hover:text-zinc-800 dark:text-zinc-300 dark:hover:text-zinc-200',
            'neutral' => 'text-neutral-700 hover:text-neutral-800 dark:text-neutral-300 dark:hover:text-neutral-200',
            'stone'   => 'text-stone-700 hover:text-stone-800 dark:text-stone-300 dark:hover:text-stone-200',
            'red'     => 'text-red-700 hover:text-red-800 dark:text-red-300 dark:hover:text-red-200',
            'orange'  => 'text-orange-700 hover:text-orange-800 dark:text-orange-300 dark:hover:text-orange-200',
            'amber'   => 'text-amber-700 hover:text-amber-800 dark:text-amber-300 dark:hover:text-amber-200',
            'yellow'  => 'text-yellow-700 hover:text-yellow-800 dark:text-yellow-300 dark:hover:text-yellow-200',
            'lime'    => 'text-lime-700 hover:text-lime-800 dark:text-lime-300 dark:hover:text-lime-200',
            'green'   => 'text-green-700 hover:text-green-800 dark:text-green-300 dark:hover:text-green-200',
            'emerald' => 'text-emerald-700 hover:text-emerald-800 dark:text-emerald-300 dark:hover:text-emerald-200',
            'teal'    => 'text-teal-700 hover:text-teal-800 dark:text-teal-300 dark:hover:text-teal-200',
            'cyan'    => 'text-cyan-700 hover:text-cyan-800 dark:text-cyan-300 dark:hover:text-cyan-200',
            'sky'     => 'text-sky-700 hover:text-sky-800 dark:text-sky-300 dark:hover:text-sky-200',
            'blue'    => 'text-blue-700 hover:text-blue-800 dark:text-blue-300 dark:hover:text-blue-200',
            'indigo'  => 'text-indigo-700 hover:text-indigo-800 dark:text-indigo-300 dark:hover:text-indigo-200',
            'violet'  => 'text-violet-700 hover:text-violet-800 dark:text-violet-300 dark:hover:text-violet-200',
            'purple'  => 'text-purple-700 hover:text-purple-800 dark:text-purple-300 dark:hover:text-purple-200',
            'fuchsia' => 'text-fuchsia-700 hover:text-fuchsia-800 dark:text-fuchsia-300 dark:hover:text-fuchsia-200',
            'pink'    => 'text-pink-700 hover:text-pink-800 dark:text-pink-300 dark:hover:text-pink-200',
            'rose'    => 'text-rose-700 hover:text-rose-800 dark:text-rose-300 dark:hover:text-rose-200',
            'taupe'   => 'text-taupe-700 hover:text-taupe-800 dark:text-taupe-300 dark:hover:text-taupe-200',
            'mauve'   => 'text-mauve-700 hover:text-mauve-800 dark:text-mauve-300 dark:hover:text-mauve-200',
            'mist'    => 'text-mist-700 hover:text-mist-800 dark:text-mist-300 dark:hover:text-mist-200',
            'olive'   => 'text-olive-700 hover:text-olive-800 dark:text-olive-300 dark:hover:text-olive-200',
        ];

        $this->classList = trim(implode(' ', [
            'font-medium hover:underline',
            $themeMap[$theme] ?? $themeMap['slate'],
            $class,
        ]));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('twcss::components.nav.link');
    }
}
