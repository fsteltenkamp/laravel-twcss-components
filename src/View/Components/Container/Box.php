<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Container;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Box extends Component
{
    public string $classList;
    public ?string $id;

    public function __construct(string $theme = 'slate', string $class = '', ?string $id = null)
    {
        $this->id = $id;

        $themeMap = [
            'slate'   => 'border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900',
            'gray'    => 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900',
            'zinc'    => 'border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900',
            'neutral' => 'border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900',
            'stone'   => 'border-stone-200 dark:border-stone-700 bg-white dark:bg-stone-900',
            'red'     => 'border-red-200 dark:border-red-700 bg-white dark:bg-red-900',
            'orange'  => 'border-orange-200 dark:border-orange-700 bg-white dark:bg-orange-900',
            'amber'   => 'border-amber-200 dark:border-amber-700 bg-white dark:bg-amber-900',
            'yellow'  => 'border-yellow-200 dark:border-yellow-700 bg-white dark:bg-yellow-900',
            'lime'    => 'border-lime-200 dark:border-lime-700 bg-white dark:bg-lime-900',
            'green'   => 'border-green-200 dark:border-green-700 bg-white dark:bg-green-900',
            'emerald' => 'border-emerald-200 dark:border-emerald-700 bg-white dark:bg-emerald-900',
            'teal'    => 'border-teal-200 dark:border-teal-700 bg-white dark:bg-teal-900',
            'cyan'    => 'border-cyan-200 dark:border-cyan-700 bg-white dark:bg-cyan-900',
            'sky'     => 'border-sky-200 dark:border-sky-700 bg-white dark:bg-sky-900',
            'blue'    => 'border-blue-200 dark:border-blue-700 bg-white dark:bg-blue-900',
            'indigo'  => 'border-indigo-200 dark:border-indigo-700 bg-white dark:bg-indigo-900',
            'violet'  => 'border-violet-200 dark:border-violet-700 bg-white dark:bg-violet-900',
            'purple'  => 'border-purple-200 dark:border-purple-700 bg-white dark:bg-purple-900',
            'fuchsia' => 'border-fuchsia-200 dark:border-fuchsia-700 bg-white dark:bg-fuchsia-900',
            'pink'    => 'border-pink-200 dark:border-pink-700 bg-white dark:bg-pink-900',
            'rose'    => 'border-rose-200 dark:border-rose-700 bg-white dark:bg-rose-900',
            'taupe'   => 'border-taupe-200 dark:border-taupe-700 bg-white dark:bg-taupe-900',
            'mauve'   => 'border-mauve-200 dark:border-mauve-700 bg-white dark:bg-mauve-900',
            'mist'    => 'border-mist-200 dark:border-mist-700 bg-white dark:bg-mist-900',
            'olive'   => 'border-olive-200 dark:border-olive-700 bg-white dark:bg-olive-900',
        ];

        // Resolve to a known theme so the interpolated Primary Content classes below
        // always reference a real palette (the literals are emitted by Body.php, so
        // Tailwind generates them for every theme).
        $resolved = isset($themeMap[$theme]) ? $theme : 'slate';

        $this->classList = trim(implode(' ', [
            'rounded-xl border p-4 shadow-sm dark:shadow-lg',
            // Primary Content text so slot content stays legible after a dark-mode switch.
            "text-{$resolved}-900 dark:text-{$resolved}-100",
            $themeMap[$resolved],
            $class,
        ]));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.container.box');
    }
}
