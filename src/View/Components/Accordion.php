<?php

namespace Fsteltenkamp\fltcComponents\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\Component;

class Accordion extends Component
{
    public string $classList;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $theme = 'slate',
        public bool $draggable = false,
        public bool $openFirst = true,
        public string $class = '',
    ) {
        $containerThemeMap = [
            'slate'   => 'border-slate-200 bg-white divide-slate-200 dark:border-slate-700 dark:bg-slate-900/40 dark:divide-slate-700',
            'gray'    => 'border-gray-200 bg-white divide-gray-200 dark:border-gray-700 dark:bg-gray-900/40 dark:divide-gray-700',
            'zinc'    => 'border-zinc-200 bg-white divide-zinc-200 dark:border-zinc-700 dark:bg-zinc-900/40 dark:divide-zinc-700',
            'neutral' => 'border-neutral-200 bg-white divide-neutral-200 dark:border-neutral-700 dark:bg-neutral-900/40 dark:divide-neutral-700',
            'stone'   => 'border-stone-200 bg-white divide-stone-200 dark:border-stone-700 dark:bg-stone-900/40 dark:divide-stone-700',
            'red'     => 'border-red-200 bg-white divide-red-200 dark:border-red-700 dark:bg-red-950/30 dark:divide-red-800',
            'orange'  => 'border-orange-200 bg-white divide-orange-200 dark:border-orange-700 dark:bg-orange-950/30 dark:divide-orange-800',
            'amber'   => 'border-amber-200 bg-white divide-amber-200 dark:border-amber-700 dark:bg-amber-950/30 dark:divide-amber-800',
            'yellow'  => 'border-yellow-200 bg-white divide-yellow-200 dark:border-yellow-700 dark:bg-yellow-950/30 dark:divide-yellow-800',
            'lime'    => 'border-lime-200 bg-white divide-lime-200 dark:border-lime-700 dark:bg-lime-950/30 dark:divide-lime-800',
            'green'   => 'border-green-200 bg-white divide-green-200 dark:border-green-700 dark:bg-green-950/30 dark:divide-green-800',
            'emerald' => 'border-emerald-200 bg-white divide-emerald-200 dark:border-emerald-700 dark:bg-emerald-950/30 dark:divide-emerald-800',
            'teal'    => 'border-teal-200 bg-white divide-teal-200 dark:border-teal-700 dark:bg-teal-950/30 dark:divide-teal-800',
            'cyan'    => 'border-cyan-200 bg-white divide-cyan-200 dark:border-cyan-700 dark:bg-cyan-950/30 dark:divide-cyan-800',
            'sky'     => 'border-sky-200 bg-white divide-sky-200 dark:border-sky-700 dark:bg-sky-950/30 dark:divide-sky-800',
            'blue'    => 'border-blue-200 bg-white divide-blue-200 dark:border-blue-700 dark:bg-blue-950/30 dark:divide-blue-800',
            'indigo'  => 'border-indigo-200 bg-white divide-indigo-200 dark:border-indigo-700 dark:bg-indigo-950/30 dark:divide-indigo-800',
            'violet'  => 'border-violet-200 bg-white divide-violet-200 dark:border-violet-700 dark:bg-violet-950/30 dark:divide-violet-800',
            'purple'  => 'border-purple-200 bg-white divide-purple-200 dark:border-purple-700 dark:bg-purple-950/30 dark:divide-purple-800',
            'fuchsia' => 'border-fuchsia-200 bg-white divide-fuchsia-200 dark:border-fuchsia-700 dark:bg-fuchsia-950/30 dark:divide-fuchsia-800',
            'pink'    => 'border-pink-200 bg-white divide-pink-200 dark:border-pink-700 dark:bg-pink-950/30 dark:divide-pink-800',
            'rose'    => 'border-rose-200 bg-white divide-rose-200 dark:border-rose-700 dark:bg-rose-950/30 dark:divide-rose-800',
        ];

        $this->classList = trim(implode(' ', array_filter([
            'overflow-hidden rounded-xl border divide-y',
            $containerThemeMap[$this->theme] ?? $containerThemeMap['slate'],
            $this->class,
        ])));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        ViewFacade::share('tailwindAccordionTheme', $this->theme);
        ViewFacade::share('tailwindAccordionDraggable', $this->draggable);
        ViewFacade::share('tailwindAccordionOpenFirst', $this->openFirst);

        return view('fltc::components.accordion');
    }
}
