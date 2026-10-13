<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Fsteltenkamp\TwcssComponents\View\Component;

class Header extends Component
{
    public string $classList;

    public function __construct(
        public ?string $color = null,
    ) {
        $this->color = $this->color ?? ViewFacade::shared('tailwindCardColor', 'base');

        $themeMap = [
            'slate'   => 'bg-slate-200 text-slate-800 border-slate-200 dark:bg-slate-900 dark:text-slate-100 dark:border-slate-700',
            'gray'    => 'bg-gray-200 text-gray-800 border-gray-200 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700',
            'zinc'    => 'bg-zinc-200 text-zinc-800 border-zinc-200 dark:bg-zinc-900 dark:text-zinc-100 dark:border-zinc-700',
            'neutral' => 'bg-neutral-200 text-neutral-800 border-neutral-200 dark:bg-neutral-900 dark:text-neutral-100 dark:border-neutral-700',
            'stone'   => 'bg-stone-200 text-stone-800 border-stone-200 dark:bg-stone-900 dark:text-stone-100 dark:border-stone-700',
            'red'     => 'bg-red-200 text-red-900 border-red-200 dark:bg-red-950 dark:text-red-100 dark:border-red-900',
            'orange'  => 'bg-orange-200 text-orange-900 border-orange-200 dark:bg-orange-950 dark:text-orange-100 dark:border-orange-900',
            'amber'   => 'bg-amber-200 text-amber-900 border-amber-200 dark:bg-amber-950 dark:text-amber-100 dark:border-amber-900',
            'yellow'  => 'bg-yellow-200 text-yellow-900 border-yellow-200 dark:bg-yellow-950 dark:text-yellow-100 dark:border-yellow-900',
            'lime'    => 'bg-lime-200 text-lime-900 border-lime-200 dark:bg-lime-950 dark:text-lime-100 dark:border-lime-900',
            'green'   => 'bg-green-200 text-green-900 border-green-200 dark:bg-green-950 dark:text-green-100 dark:border-green-900',
            'emerald' => 'bg-emerald-200 text-emerald-900 border-emerald-200 dark:bg-emerald-950 dark:text-emerald-100 dark:border-emerald-900',
            'teal'    => 'bg-teal-200 text-teal-900 border-teal-200 dark:bg-teal-950 dark:text-teal-100 dark:border-teal-900',
            'cyan'    => 'bg-cyan-200 text-cyan-900 border-cyan-200 dark:bg-cyan-950 dark:text-cyan-100 dark:border-cyan-900',
            'sky'     => 'bg-sky-200 text-sky-900 border-sky-200 dark:bg-sky-950 dark:text-sky-100 dark:border-sky-900',
            'blue'    => 'bg-blue-200 text-blue-900 border-blue-200 dark:bg-blue-950 dark:text-blue-100 dark:border-blue-900',
            'indigo'  => 'bg-indigo-200 text-indigo-900 border-indigo-200 dark:bg-indigo-950 dark:text-indigo-100 dark:border-indigo-900',
            'violet'  => 'bg-violet-200 text-violet-900 border-violet-200 dark:bg-violet-950 dark:text-violet-100 dark:border-violet-900',
            'purple'  => 'bg-purple-200 text-purple-900 border-purple-200 dark:bg-purple-950 dark:text-purple-100 dark:border-purple-900',
            'fuchsia' => 'bg-fuchsia-200 text-fuchsia-900 border-fuchsia-200 dark:bg-fuchsia-950 dark:text-fuchsia-100 dark:border-fuchsia-900',
            'pink'    => 'bg-pink-200 text-pink-900 border-pink-200 dark:bg-pink-950 dark:text-pink-100 dark:border-pink-900',
            'rose'    => 'bg-rose-200 text-rose-900 border-rose-200 dark:bg-rose-950 dark:text-rose-100 dark:border-rose-900',
            'taupe'   => 'bg-taupe-200 text-taupe-900 border-taupe-200 dark:bg-taupe-950 dark:text-taupe-100 dark:border-taupe-900',
            'mauve'   => 'bg-mauve-200 text-mauve-900 border-mauve-200 dark:bg-mauve-950 dark:text-mauve-100 dark:border-mauve-900',
            'mist'    => 'bg-mist-200 text-mist-900 border-mist-200 dark:bg-mist-950 dark:text-mist-100 dark:border-mist-900',
            'olive'   => 'bg-olive-200 text-olive-900 border-olive-200 dark:bg-olive-950 dark:text-olive-100 dark:border-olive-900',
            'primary'    => 'bg-primary-200 text-primary-900 border-primary-200 dark:bg-primary-950 dark:text-primary-100 dark:border-primary-900',
            'secondary'  => 'bg-secondary-200 text-secondary-900 border-secondary-200 dark:bg-secondary-950 dark:text-secondary-100 dark:border-secondary-900',
            'accent'     => 'bg-accent-200 text-accent-900 border-accent-200 dark:bg-accent-950 dark:text-accent-100 dark:border-accent-900',
            'base'       => 'bg-base-200 text-base-900 border-base-200 dark:bg-base-950 dark:text-base-100 dark:border-base-900',
            'info'       => 'bg-info-200 text-info-900 border-info-200 dark:bg-info-950 dark:text-info-100 dark:border-info-900',
            'success'    => 'bg-success-200 text-success-900 border-success-200 dark:bg-success-950 dark:text-success-100 dark:border-success-900',
            'warning'    => 'bg-warning-200 text-warning-900 border-warning-200 dark:bg-warning-950 dark:text-warning-100 dark:border-warning-900',
            'danger'     => 'bg-danger-200 text-danger-900 border-danger-200 dark:bg-danger-950 dark:text-danger-100 dark:border-danger-900',
        ];

        $this->classList = 'border-b px-4 py-3 ' . ($themeMap[$this->color] ?? $themeMap['base']);
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.card.header');
    }
}
