<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Counter extends Component
{
    public string $classList;
    public string $iconClasses;
    public string $counterClasses;

    public function __construct(
        public string $theme = 'slate',
        public string $title = '',
        public string $count = '',
        public string $description = '',
        public string $icon = '',
        public string $link = '',
        public bool $navigate = false,
        public string $class = '',
    ) {
        $themeMap = [
            // Neutral scales
            'slate'   => ['count' => 'text-slate-900 dark:text-slate-100', 'icon' => 'text-slate-400 dark:text-slate-500'],
            'gray'    => ['count' => 'text-gray-900 dark:text-gray-100', 'icon' => 'text-gray-400 dark:text-gray-500'],
            'zinc'    => ['count' => 'text-zinc-900 dark:text-zinc-100', 'icon' => 'text-zinc-400 dark:text-zinc-500'],
            'neutral' => ['count' => 'text-neutral-900 dark:text-neutral-100', 'icon' => 'text-neutral-400 dark:text-neutral-500'],
            'stone'   => ['count' => 'text-stone-900 dark:text-stone-100', 'icon' => 'text-stone-400 dark:text-stone-500'],
            // Accent scales
            'red'     => ['count' => 'text-red-700 dark:text-red-300', 'icon' => 'text-red-400 dark:text-red-500'],
            'orange'  => ['count' => 'text-orange-700 dark:text-orange-300', 'icon' => 'text-orange-400 dark:text-orange-500'],
            'amber'   => ['count' => 'text-amber-700 dark:text-amber-300', 'icon' => 'text-amber-400 dark:text-amber-500'],
            'yellow'  => ['count' => 'text-yellow-700 dark:text-yellow-300', 'icon' => 'text-yellow-400 dark:text-yellow-500'],
            'lime'    => ['count' => 'text-lime-700 dark:text-lime-300', 'icon' => 'text-lime-400 dark:text-lime-500'],
            'green'   => ['count' => 'text-green-700 dark:text-green-300', 'icon' => 'text-green-400 dark:text-green-500'],
            'emerald' => ['count' => 'text-emerald-700 dark:text-emerald-300', 'icon' => 'text-emerald-400 dark:text-emerald-500'],
            'teal'    => ['count' => 'text-teal-700 dark:text-teal-300', 'icon' => 'text-teal-400 dark:text-teal-500'],
            'cyan'    => ['count' => 'text-cyan-700 dark:text-cyan-300', 'icon' => 'text-cyan-400 dark:text-cyan-500'],
            'sky'     => ['count' => 'text-sky-700 dark:text-sky-300', 'icon' => 'text-sky-400 dark:text-sky-500'],
            'blue'    => ['count' => 'text-blue-700 dark:text-blue-300', 'icon' => 'text-blue-400 dark:text-blue-500'],
            'indigo'  => ['count' => 'text-indigo-700 dark:text-indigo-300', 'icon' => 'text-indigo-400 dark:text-indigo-500'],
            'violet'  => ['count' => 'text-violet-700 dark:text-violet-300', 'icon' => 'text-violet-400 dark:text-violet-500'],
            'purple'  => ['count' => 'text-purple-700 dark:text-purple-300', 'icon' => 'text-purple-400 dark:text-purple-500'],
            'fuchsia' => ['count' => 'text-fuchsia-700 dark:text-fuchsia-300', 'icon' => 'text-fuchsia-400 dark:text-fuchsia-500'],
            'pink'    => ['count' => 'text-pink-700 dark:text-pink-300', 'icon' => 'text-pink-400 dark:text-pink-500'],
            'rose'    => ['count' => 'text-rose-700 dark:text-rose-300', 'icon' => 'text-rose-400 dark:text-rose-500'],
            'taupe'   => ['count' => 'text-taupe-700 dark:text-taupe-300', 'icon' => 'text-taupe-400 dark:text-taupe-500'],
            'mauve'   => ['count' => 'text-mauve-700 dark:text-mauve-300', 'icon' => 'text-mauve-400 dark:text-mauve-500'],
            'mist'    => ['count' => 'text-mist-700 dark:text-mist-300', 'icon' => 'text-mist-400 dark:text-mist-500'],
            'olive'   => ['count' => 'text-olive-700 dark:text-olive-300', 'icon' => 'text-olive-400 dark:text-olive-500'],
        ];

        $themeClasses = $themeMap[$this->theme] ?? $themeMap['slate'];

        $this->classList = trim(implode(' ', [
            'flex flex-col rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:shadow-lg',
            filled($this->link) ? 'cursor-pointer transition hover:shadow-md dark:hover:shadow-xl' : '',
            $this->class,
        ]));

        $this->counterClasses = 'mt-3 text-3xl font-semibold tracking-tight '.$themeClasses['count'];
        $this->iconClasses = $themeClasses['icon'];
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.counter');
    }
}
