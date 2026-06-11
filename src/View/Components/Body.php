<?php

namespace Fsteltenkamp\fltcComponents\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Body extends Component
{
    public string $classList;

    public function __construct(string $theme = 'slate')
    {
        $themeMap = [
            'slate'   => 'bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100',
            'gray'    => 'bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-gray-100',
            'zinc'    => 'bg-zinc-50 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-100',
            'neutral' => 'bg-neutral-50 text-neutral-900 dark:bg-neutral-950 dark:text-neutral-100',
            'stone'   => 'bg-stone-50 text-stone-900 dark:bg-stone-950 dark:text-stone-100',
            'red'     => 'bg-red-50 text-red-900 dark:bg-red-950 dark:text-red-100',
            'orange'  => 'bg-orange-50 text-orange-900 dark:bg-orange-950 dark:text-orange-100',
            'amber'   => 'bg-amber-50 text-amber-900 dark:bg-amber-950 dark:text-amber-100',
            'yellow'  => 'bg-yellow-50 text-yellow-900 dark:bg-yellow-950 dark:text-yellow-100',
            'lime'    => 'bg-lime-50 text-lime-900 dark:bg-lime-950 dark:text-lime-100',
            'green'   => 'bg-green-50 text-green-900 dark:bg-green-950 dark:text-green-100',
            'emerald' => 'bg-emerald-50 text-emerald-900 dark:bg-emerald-950 dark:text-emerald-100',
            'teal'    => 'bg-teal-50 text-teal-900 dark:bg-teal-950 dark:text-teal-100',
            'cyan'    => 'bg-cyan-50 text-cyan-900 dark:bg-cyan-950 dark:text-cyan-100',
            'sky'     => 'bg-sky-50 text-sky-900 dark:bg-sky-950 dark:text-sky-100',
            'blue'    => 'bg-blue-50 text-blue-900 dark:bg-blue-950 dark:text-blue-100',
            'indigo'  => 'bg-indigo-50 text-indigo-900 dark:bg-indigo-950 dark:text-indigo-100',
            'violet'  => 'bg-violet-50 text-violet-900 dark:bg-violet-950 dark:text-violet-100',
            'purple'  => 'bg-purple-50 text-purple-900 dark:bg-purple-950 dark:text-purple-100',
            'fuchsia' => 'bg-fuchsia-50 text-fuchsia-900 dark:bg-fuchsia-950 dark:text-fuchsia-100',
            'pink'    => 'bg-pink-50 text-pink-900 dark:bg-pink-950 dark:text-pink-100',
            'rose'    => 'bg-rose-50 text-rose-900 dark:bg-rose-950 dark:text-rose-100',
            'taupe'   => 'bg-taupe-50 text-taupe-900 dark:bg-taupe-950 dark:text-taupe-100',
            'mauve'   => 'bg-mauve-50 text-mauve-900 dark:bg-mauve-950 dark:text-mauve-100',
            'mist'    => 'bg-mist-50 text-mist-900 dark:bg-mist-950 dark:text-mist-100',
            'olive'   => 'bg-olive-50 text-olive-900 dark:bg-olive-950 dark:text-olive-100',
        ];

        $this->classList = $themeMap[$theme] ?? $themeMap['slate'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.body');
    }
}
