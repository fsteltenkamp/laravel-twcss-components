<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tooltip extends Component
{
    public string $classList;
    public string $tooltipClassList;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $text = '',
        public string $theme = 'gray',
        string $class = ''
    )
    {
        $themeMap = [
            'slate'   => 'bg-slate-900 text-slate-50 dark:bg-slate-100 dark:text-slate-900',
            'gray'    => 'bg-gray-900 text-gray-50 dark:bg-gray-100 dark:text-gray-900',
            'zinc'    => 'bg-zinc-900 text-zinc-50 dark:bg-zinc-100 dark:text-zinc-900',
            'neutral' => 'bg-neutral-900 text-neutral-50 dark:bg-neutral-100 dark:text-neutral-900',
            'stone'   => 'bg-stone-900 text-stone-50 dark:bg-stone-100 dark:text-stone-900',
            'red'     => 'bg-red-600 text-red-50 dark:bg-red-500 dark:text-red-50',
            'orange'  => 'bg-orange-600 text-orange-50 dark:bg-orange-500 dark:text-orange-50',
            'amber'   => 'bg-amber-500 text-amber-950 dark:bg-amber-400 dark:text-amber-950',
            'yellow'  => 'bg-yellow-400 text-yellow-950 dark:bg-yellow-300 dark:text-yellow-950',
            'lime'    => 'bg-lime-500 text-lime-950 dark:bg-lime-400 dark:text-lime-950',
            'green'   => 'bg-green-600 text-green-50 dark:bg-green-500 dark:text-green-50',
            'emerald' => 'bg-emerald-600 text-emerald-50 dark:bg-emerald-500 dark:text-emerald-50',
            'teal'    => 'bg-teal-600 text-teal-50 dark:bg-teal-500 dark:text-teal-50',
            'cyan'    => 'bg-cyan-600 text-cyan-50 dark:bg-cyan-500 dark:text-cyan-50',
            'sky'     => 'bg-sky-600 text-sky-50 dark:bg-sky-500 dark:text-sky-50',
            'blue'    => 'bg-blue-600 text-blue-50 dark:bg-blue-500 dark:text-blue-50',
            'indigo'  => 'bg-indigo-600 text-indigo-50 dark:bg-indigo-500 dark:text-indigo-50',
            'violet'  => 'bg-violet-600 text-violet-50 dark:bg-violet-500 dark:text-violet-50',
            'purple'  => 'bg-purple-600 text-purple-50 dark:bg-purple-500 dark:text-purple-50',
            'fuchsia' => 'bg-fuchsia-600 text-fuchsia-50 dark:bg-fuchsia-500 dark:text-fuchsia-50',
            'pink'    => 'bg-pink-600 text-pink-50 dark:bg-pink-500 dark:text-pink-50',
            'rose'    => 'bg-rose-600 text-rose-50 dark:bg-rose-500 dark:text-rose-50',
            'taupe'   => 'bg-taupe-600 text-taupe-50 dark:bg-taupe-500 dark:text-taupe-50',
            'mauve'   => 'bg-mauve-600 text-mauve-50 dark:bg-mauve-500 dark:text-mauve-50',
            'mist'    => 'bg-mist-600 text-mist-50 dark:bg-mist-500 dark:text-mist-50',
            'olive'   => 'bg-olive-600 text-olive-50 dark:bg-olive-500 dark:text-olive-50',
        ];

        $this->classList = trim(implode(' ', [
            'relative inline-flex max-w-full',
            $class,
        ]));

        $this->tooltipClassList = trim(implode(' ', [
            'pointer-events-none fixed left-0 top-0 z-[2147483647] w-max max-w-64 -translate-x-1/2 -translate-y-full rounded-md px-3 py-1.5 text-xs font-medium shadow-lg',
            $themeMap[$theme] ?? $themeMap['gray'],
        ]));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.tooltip');
    }
}
