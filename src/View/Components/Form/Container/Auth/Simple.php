<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form\Container\Auth;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Simple extends Component
{
    public string $classList;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $theme = 'slate',
        public string $class = '',
        public ?string $id = null,
    ) {
        $themeMap = [
            'slate' => 'border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900',
            'gray' => 'border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900',
            'zinc' => 'border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900',
            'neutral' => 'border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900',
            'stone' => 'border-stone-200 bg-white dark:border-stone-700 dark:bg-stone-900',
            'red' => 'border-red-200 bg-white dark:border-red-800 dark:bg-red-950/50',
            'orange' => 'border-orange-200 bg-white dark:border-orange-800 dark:bg-orange-950/50',
            'amber' => 'border-amber-200 bg-white dark:border-amber-800 dark:bg-amber-950/50',
            'yellow' => 'border-yellow-200 bg-white dark:border-yellow-800 dark:bg-yellow-950/50',
            'lime' => 'border-lime-200 bg-white dark:border-lime-800 dark:bg-lime-950/50',
            'green' => 'border-green-200 bg-white dark:border-green-800 dark:bg-green-950/50',
            'emerald' => 'border-emerald-200 bg-white dark:border-emerald-800 dark:bg-emerald-950/50',
            'teal' => 'border-teal-200 bg-white dark:border-teal-800 dark:bg-teal-950/50',
            'cyan' => 'border-cyan-200 bg-white dark:border-cyan-800 dark:bg-cyan-950/50',
            'sky' => 'border-sky-200 bg-white dark:border-sky-800 dark:bg-sky-950/50',
            'blue' => 'border-blue-200 bg-white dark:border-blue-800 dark:bg-blue-950/50',
            'indigo' => 'border-indigo-200 bg-white dark:border-indigo-800 dark:bg-indigo-950/50',
            'violet' => 'border-violet-200 bg-white dark:border-violet-800 dark:bg-violet-950/50',
            'purple' => 'border-purple-200 bg-white dark:border-purple-800 dark:bg-purple-950/50',
            'fuchsia' => 'border-fuchsia-200 bg-white dark:border-fuchsia-800 dark:bg-fuchsia-950/50',
            'pink' => 'border-pink-200 bg-white dark:border-pink-800 dark:bg-pink-950/50',
            'rose' => 'border-rose-200 bg-white dark:border-rose-800 dark:bg-rose-950/50',
            'taupe' => 'border-taupe-200 bg-white dark:border-taupe-800 dark:bg-taupe-950/50',
            'mauve' => 'border-mauve-200 bg-white dark:border-mauve-800 dark:bg-mauve-950/50',
            'mist' => 'border-mist-200 bg-white dark:border-mist-800 dark:bg-mist-950/50',
            'olive' => 'border-olive-200 bg-white dark:border-olive-800 dark:bg-olive-950/50',
        ];

        $themeClasses = $themeMap[$this->theme] ?? $themeMap['slate'];

        $this->classList = trim(implode(' ', [
            'rounded-2xl border shadow-xl',
            $themeClasses,
            $this->class,
        ]));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.form.container.auth.simple');
    }
}
