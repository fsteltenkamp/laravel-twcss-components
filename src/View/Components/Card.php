<?php

namespace Fsteltenkamp\fltcComponents\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\Component;

class Card extends Component
{
    public string $classList;

    public function __construct(
        public string $theme = 'slate',
        public bool $fill = false,
        public string $class = '',
    ) {
        $themeMap = [
            // Neutral scales
            'slate'   => ['border' => 'border-slate-200 dark:border-slate-700', 'text' => 'text-slate-900 dark:text-slate-100'],
            'gray'    => ['border' => 'border-gray-200 dark:border-gray-700', 'text' => 'text-gray-900 dark:text-gray-100'],
            'zinc'    => ['border' => 'border-zinc-200 dark:border-zinc-700', 'text' => 'text-zinc-900 dark:text-zinc-100'],
            'neutral' => ['border' => 'border-neutral-200 dark:border-neutral-700', 'text' => 'text-neutral-900 dark:text-neutral-100'],
            'stone'   => ['border' => 'border-stone-200 dark:border-stone-700', 'text' => 'text-stone-900 dark:text-stone-100'],
            // Accent scales
            'red'     => ['border' => 'border-red-200 dark:border-red-900', 'text' => 'text-red-900 dark:text-red-100'],
            'orange'  => ['border' => 'border-orange-200 dark:border-orange-900', 'text' => 'text-orange-900 dark:text-orange-100'],
            'amber'   => ['border' => 'border-amber-200 dark:border-amber-900', 'text' => 'text-amber-900 dark:text-amber-100'],
            'yellow'  => ['border' => 'border-yellow-200 dark:border-yellow-900', 'text' => 'text-yellow-900 dark:text-yellow-100'],
            'lime'    => ['border' => 'border-lime-200 dark:border-lime-900', 'text' => 'text-lime-900 dark:text-lime-100'],
            'green'   => ['border' => 'border-green-200 dark:border-green-900', 'text' => 'text-green-900 dark:text-green-100'],
            'emerald' => ['border' => 'border-emerald-200 dark:border-emerald-900', 'text' => 'text-emerald-900 dark:text-emerald-100'],
            'teal'    => ['border' => 'border-teal-200 dark:border-teal-900', 'text' => 'text-teal-900 dark:text-teal-100'],
            'cyan'    => ['border' => 'border-cyan-200 dark:border-cyan-900', 'text' => 'text-cyan-900 dark:text-cyan-100'],
            'sky'     => ['border' => 'border-sky-200 dark:border-sky-900', 'text' => 'text-sky-900 dark:text-sky-100'],
            'blue'    => ['border' => 'border-blue-200 dark:border-blue-900', 'text' => 'text-blue-900 dark:text-blue-100'],
            'indigo'  => ['border' => 'border-indigo-200 dark:border-indigo-900', 'text' => 'text-indigo-900 dark:text-indigo-100'],
            'violet'  => ['border' => 'border-violet-200 dark:border-violet-900', 'text' => 'text-violet-900 dark:text-violet-100'],
            'purple'  => ['border' => 'border-purple-200 dark:border-purple-900', 'text' => 'text-purple-900 dark:text-purple-100'],
            'fuchsia' => ['border' => 'border-fuchsia-200 dark:border-fuchsia-900', 'text' => 'text-fuchsia-900 dark:text-fuchsia-100'],
            'pink'    => ['border' => 'border-pink-200 dark:border-pink-900', 'text' => 'text-pink-900 dark:text-pink-100'],
            'rose'    => ['border' => 'border-rose-200 dark:border-rose-900', 'text' => 'text-rose-900 dark:text-rose-100'],
            'taupe'   => ['border' => 'border-taupe-200 dark:border-taupe-900', 'text' => 'text-taupe-900 dark:text-taupe-100'],
            'mauve'   => ['border' => 'border-mauve-200 dark:border-mauve-900', 'text' => 'text-mauve-900 dark:text-mauve-100'],
            'mist'    => ['border' => 'border-mist-200 dark:border-mist-900', 'text' => 'text-mist-900 dark:text-mist-100'],
            'olive'   => ['border' => 'border-olive-200 dark:border-olive-900', 'text' => 'text-olive-900 dark:text-olive-100'],
        ];

        $themeClasses = $themeMap[$this->theme] ?? $themeMap['slate'];

        $this->classList = trim(implode(' ', [
            'overflow-hidden rounded-xl border shadow-sm dark:shadow-lg',
            $this->fill ? 'h-full' : 'self-start',
            $themeClasses['border'],
            $themeClasses['text'],
            $this->class,
        ]));
    }

    public function render(): View|Closure|string
    {
        ViewFacade::share('tailwindCardTheme', $this->theme);

        return view('fltc::components.card');
    }
}
