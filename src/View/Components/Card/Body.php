<?php

namespace Fsteltenkamp\fltcComponents\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\Component;

class Body extends Component
{
    public string $classList;

    public function __construct(
        public ?string $theme = null,
    ) {
        $this->theme = $this->theme ?? ViewFacade::shared('tailwindCardTheme', 'slate');

        $themeMap = [
            'slate'   => 'bg-slate-50 text-slate-700 dark:bg-slate-800 dark:text-slate-200',
            'gray'    => 'bg-gray-50 text-gray-700 dark:bg-gray-800 dark:text-gray-200',
            'zinc'    => 'bg-zinc-50 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200',
            'neutral' => 'bg-neutral-50 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-200',
            'stone'   => 'bg-stone-50 text-stone-700 dark:bg-stone-800 dark:text-stone-200',
            'red'     => 'bg-red-50 text-red-700 dark:bg-red-900 dark:text-red-200',
            'orange'  => 'bg-orange-50 text-orange-700 dark:bg-orange-900 dark:text-orange-200',
            'amber'   => 'bg-amber-50 text-amber-700 dark:bg-amber-900 dark:text-amber-200',
            'yellow'  => 'bg-yellow-50 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-200',
            'lime'    => 'bg-lime-50 text-lime-700 dark:bg-lime-900 dark:text-lime-200',
            'green'   => 'bg-green-50 text-green-700 dark:bg-green-900 dark:text-green-200',
            'emerald' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200',
            'teal'    => 'bg-teal-50 text-teal-700 dark:bg-teal-900 dark:text-teal-200',
            'cyan'    => 'bg-cyan-50 text-cyan-700 dark:bg-cyan-900 dark:text-cyan-200',
            'sky'     => 'bg-sky-50 text-sky-700 dark:bg-sky-900 dark:text-sky-200',
            'blue'    => 'bg-blue-50 text-blue-700 dark:bg-blue-900 dark:text-blue-200',
            'indigo'  => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200',
            'violet'  => 'bg-violet-50 text-violet-700 dark:bg-violet-900 dark:text-violet-200',
            'purple'  => 'bg-purple-50 text-purple-700 dark:bg-purple-900 dark:text-purple-200',
            'fuchsia' => 'bg-fuchsia-50 text-fuchsia-700 dark:bg-fuchsia-900 dark:text-fuchsia-200',
            'pink'    => 'bg-pink-50 text-pink-700 dark:bg-pink-900 dark:text-pink-200',
            'rose'    => 'bg-rose-50 text-rose-700 dark:bg-rose-900 dark:text-rose-200',
            'taupe'   => 'bg-taupe-50 text-taupe-700 dark:bg-taupe-900 dark:text-taupe-200',
            'mauve'   => 'bg-mauve-50 text-mauve-700 dark:bg-mauve-900 dark:text-mauve-200',
            'mist'    => 'bg-mist-50 text-mist-700 dark:bg-mist-900 dark:text-mist-200',
            'olive'   => 'bg-olive-50 text-olive-700 dark:bg-olive-900 dark:text-olive-200',
        ];

        $this->classList = 'px-4 py-4 ' . ($themeMap[$this->theme] ?? $themeMap['slate']);
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.card.body');
    }
}
