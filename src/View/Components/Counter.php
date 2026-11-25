<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Illuminate\Contracts\View\View;
use Fsteltenkamp\TwcssComponents\View\Component;

class Counter extends Component
{
    public string $tag;
    public string $classList;
    public string $counterClasses;
    public string $titleClasses;
    public string $descriptionClasses;

    public function __construct(
        public string $color = 'base',
        public string $iconColor = '',
        public string $title = '',
        public string $count = '',
        public string $description = '',
        public string $icon = '',
        public string $link = '',
        public bool $navigate = false,
        public string $class = '',
        public bool $button = false,
        public ?bool $active = null,
    ) {
        // A counter that filters: a <button> (wire:click, x-on:click) with aria-pressed.
        $this->tag = filled($link) ? 'a' : (($button || $active !== null) ? 'button' : 'div');
        $ringMap = [
            'slate'     => 'ring-2 ring-slate-500 ring-offset-2 dark:ring-slate-400 dark:ring-offset-slate-950',
            'gray'      => 'ring-2 ring-gray-500 ring-offset-2 dark:ring-gray-400 dark:ring-offset-gray-950',
            'zinc'      => 'ring-2 ring-zinc-500 ring-offset-2 dark:ring-zinc-400 dark:ring-offset-zinc-950',
            'neutral'   => 'ring-2 ring-neutral-500 ring-offset-2 dark:ring-neutral-400 dark:ring-offset-neutral-950',
            'stone'     => 'ring-2 ring-stone-500 ring-offset-2 dark:ring-stone-400 dark:ring-offset-stone-950',
            'red'       => 'ring-2 ring-red-500 ring-offset-2 dark:ring-red-400 dark:ring-offset-red-950',
            'orange'    => 'ring-2 ring-orange-500 ring-offset-2 dark:ring-orange-400 dark:ring-offset-orange-950',
            'amber'     => 'ring-2 ring-amber-500 ring-offset-2 dark:ring-amber-400 dark:ring-offset-amber-950',
            'yellow'    => 'ring-2 ring-yellow-500 ring-offset-2 dark:ring-yellow-400 dark:ring-offset-yellow-950',
            'lime'      => 'ring-2 ring-lime-500 ring-offset-2 dark:ring-lime-400 dark:ring-offset-lime-950',
            'green'     => 'ring-2 ring-green-500 ring-offset-2 dark:ring-green-400 dark:ring-offset-green-950',
            'emerald'   => 'ring-2 ring-emerald-500 ring-offset-2 dark:ring-emerald-400 dark:ring-offset-emerald-950',
            'teal'      => 'ring-2 ring-teal-500 ring-offset-2 dark:ring-teal-400 dark:ring-offset-teal-950',
            'cyan'      => 'ring-2 ring-cyan-500 ring-offset-2 dark:ring-cyan-400 dark:ring-offset-cyan-950',
            'sky'       => 'ring-2 ring-sky-500 ring-offset-2 dark:ring-sky-400 dark:ring-offset-sky-950',
            'blue'      => 'ring-2 ring-blue-500 ring-offset-2 dark:ring-blue-400 dark:ring-offset-blue-950',
            'indigo'    => 'ring-2 ring-indigo-500 ring-offset-2 dark:ring-indigo-400 dark:ring-offset-indigo-950',
            'violet'    => 'ring-2 ring-violet-500 ring-offset-2 dark:ring-violet-400 dark:ring-offset-violet-950',
            'purple'    => 'ring-2 ring-purple-500 ring-offset-2 dark:ring-purple-400 dark:ring-offset-purple-950',
            'fuchsia'   => 'ring-2 ring-fuchsia-500 ring-offset-2 dark:ring-fuchsia-400 dark:ring-offset-fuchsia-950',
            'pink'      => 'ring-2 ring-pink-500 ring-offset-2 dark:ring-pink-400 dark:ring-offset-pink-950',
            'rose'      => 'ring-2 ring-rose-500 ring-offset-2 dark:ring-rose-400 dark:ring-offset-rose-950',
            'taupe'     => 'ring-2 ring-taupe-500 ring-offset-2 dark:ring-taupe-400 dark:ring-offset-taupe-950',
            'mauve'     => 'ring-2 ring-mauve-500 ring-offset-2 dark:ring-mauve-400 dark:ring-offset-mauve-950',
            'mist'      => 'ring-2 ring-mist-500 ring-offset-2 dark:ring-mist-400 dark:ring-offset-mist-950',
            'olive'     => 'ring-2 ring-olive-500 ring-offset-2 dark:ring-olive-400 dark:ring-offset-olive-950',
            'primary'   => 'ring-2 ring-primary-500 ring-offset-2 dark:ring-primary-400 dark:ring-offset-primary-950',
            'secondary' => 'ring-2 ring-secondary-500 ring-offset-2 dark:ring-secondary-400 dark:ring-offset-secondary-950',
            'accent'    => 'ring-2 ring-accent-500 ring-offset-2 dark:ring-accent-400 dark:ring-offset-accent-950',
            'base'      => 'ring-2 ring-base-500 ring-offset-2 dark:ring-base-400 dark:ring-offset-base-950',
            'info'      => 'ring-2 ring-info-500 ring-offset-2 dark:ring-info-400 dark:ring-offset-info-950',
            'success'   => 'ring-2 ring-success-500 ring-offset-2 dark:ring-success-400 dark:ring-offset-success-950',
            'warning'   => 'ring-2 ring-warning-500 ring-offset-2 dark:ring-warning-400 dark:ring-offset-warning-950',
            'danger'    => 'ring-2 ring-danger-500 ring-offset-2 dark:ring-danger-400 dark:ring-offset-danger-950',
        ];

        $themeMap = [
            // Neutral scales
            'slate'   => ['bg' => 'bg-white dark:bg-slate-900', 'border' => 'border-slate-200 dark:border-slate-700', 'count' => 'text-slate-900 dark:text-slate-100'],
            'gray'    => ['bg' => 'bg-white dark:bg-gray-900', 'border' => 'border-gray-200 dark:border-gray-700', 'count' => 'text-gray-900 dark:text-gray-100'],
            'zinc'    => ['bg' => 'bg-white dark:bg-zinc-900', 'border' => 'border-zinc-200 dark:border-zinc-700', 'count' => 'text-zinc-900 dark:text-zinc-100'],
            'neutral' => ['bg' => 'bg-white dark:bg-neutral-900', 'border' => 'border-neutral-200 dark:border-neutral-700', 'count' => 'text-neutral-900 dark:text-neutral-100'],
            'stone'   => ['bg' => 'bg-white dark:bg-stone-900', 'border' => 'border-stone-200 dark:border-stone-700', 'count' => 'text-stone-900 dark:text-stone-100'],
            // Accent scales
            'red'     => ['bg' => 'bg-red-50 dark:bg-red-950', 'border' => 'border-red-200 dark:border-red-800', 'count' => 'text-red-700 dark:text-red-300'],
            'orange'  => ['bg' => 'bg-orange-50 dark:bg-orange-950', 'border' => 'border-orange-200 dark:border-orange-800', 'count' => 'text-orange-700 dark:text-orange-300'],
            'amber'   => ['bg' => 'bg-amber-50 dark:bg-amber-950', 'border' => 'border-amber-200 dark:border-amber-800', 'count' => 'text-amber-700 dark:text-amber-300'],
            'yellow'  => ['bg' => 'bg-yellow-50 dark:bg-yellow-950', 'border' => 'border-yellow-200 dark:border-yellow-800', 'count' => 'text-yellow-700 dark:text-yellow-300'],
            'lime'    => ['bg' => 'bg-lime-50 dark:bg-lime-950', 'border' => 'border-lime-200 dark:border-lime-800', 'count' => 'text-lime-700 dark:text-lime-300'],
            'green'   => ['bg' => 'bg-green-50 dark:bg-green-950', 'border' => 'border-green-200 dark:border-green-800', 'count' => 'text-green-700 dark:text-green-300'],
            'emerald' => ['bg' => 'bg-emerald-50 dark:bg-emerald-950', 'border' => 'border-emerald-200 dark:border-emerald-800', 'count' => 'text-emerald-700 dark:text-emerald-300'],
            'teal'    => ['bg' => 'bg-teal-50 dark:bg-teal-950', 'border' => 'border-teal-200 dark:border-teal-800', 'count' => 'text-teal-700 dark:text-teal-300'],
            'cyan'    => ['bg' => 'bg-cyan-50 dark:bg-cyan-950', 'border' => 'border-cyan-200 dark:border-cyan-800', 'count' => 'text-cyan-700 dark:text-cyan-300'],
            'sky'     => ['bg' => 'bg-sky-50 dark:bg-sky-950', 'border' => 'border-sky-200 dark:border-sky-800', 'count' => 'text-sky-700 dark:text-sky-300'],
            'blue'    => ['bg' => 'bg-blue-50 dark:bg-blue-950', 'border' => 'border-blue-200 dark:border-blue-800', 'count' => 'text-blue-700 dark:text-blue-300'],
            'indigo'  => ['bg' => 'bg-indigo-50 dark:bg-indigo-950', 'border' => 'border-indigo-200 dark:border-indigo-800', 'count' => 'text-indigo-700 dark:text-indigo-300'],
            'violet'  => ['bg' => 'bg-violet-50 dark:bg-violet-950', 'border' => 'border-violet-200 dark:border-violet-800', 'count' => 'text-violet-700 dark:text-violet-300'],
            'purple'  => ['bg' => 'bg-purple-50 dark:bg-purple-950', 'border' => 'border-purple-200 dark:border-purple-800', 'count' => 'text-purple-700 dark:text-purple-300'],
            'fuchsia' => ['bg' => 'bg-fuchsia-50 dark:bg-fuchsia-950', 'border' => 'border-fuchsia-200 dark:border-fuchsia-800', 'count' => 'text-fuchsia-700 dark:text-fuchsia-300'],
            'pink'    => ['bg' => 'bg-pink-50 dark:bg-pink-950', 'border' => 'border-pink-200 dark:border-pink-800', 'count' => 'text-pink-700 dark:text-pink-300'],
            'rose'    => ['bg' => 'bg-rose-50 dark:bg-rose-950', 'border' => 'border-rose-200 dark:border-rose-800', 'count' => 'text-rose-700 dark:text-rose-300'],
            'taupe'   => ['bg' => 'bg-taupe-50 dark:bg-taupe-950', 'border' => 'border-taupe-200 dark:border-taupe-800', 'count' => 'text-taupe-700 dark:text-taupe-300'],
            'mauve'   => ['bg' => 'bg-mauve-50 dark:bg-mauve-950', 'border' => 'border-mauve-200 dark:border-mauve-800', 'count' => 'text-mauve-700 dark:text-mauve-300'],
            'mist'    => ['bg' => 'bg-mist-50 dark:bg-mist-950', 'border' => 'border-mist-200 dark:border-mist-800', 'count' => 'text-mist-700 dark:text-mist-300'],
            'olive'   => ['bg' => 'bg-olive-50 dark:bg-olive-950', 'border' => 'border-olive-200 dark:border-olive-800', 'count' => 'text-olive-700 dark:text-olive-300'],
            'primary'    => ['bg' => 'bg-primary-50 dark:bg-primary-950', 'border' => 'border-primary-200 dark:border-primary-800', 'count' => 'text-primary-700 dark:text-primary-300'],
            'secondary'  => ['bg' => 'bg-secondary-50 dark:bg-secondary-950', 'border' => 'border-secondary-200 dark:border-secondary-800', 'count' => 'text-secondary-700 dark:text-secondary-300'],
            'accent'     => ['bg' => 'bg-accent-50 dark:bg-accent-950', 'border' => 'border-accent-200 dark:border-accent-800', 'count' => 'text-accent-700 dark:text-accent-300'],
            'base'       => ['bg' => 'bg-base-50 dark:bg-base-950', 'border' => 'border-base-200 dark:border-base-800', 'count' => 'text-base-700 dark:text-base-300'],
            'info'       => ['bg' => 'bg-info-50 dark:bg-info-950', 'border' => 'border-info-200 dark:border-info-800', 'count' => 'text-info-700 dark:text-info-300'],
            'success'    => ['bg' => 'bg-success-50 dark:bg-success-950', 'border' => 'border-success-200 dark:border-success-800', 'count' => 'text-success-700 dark:text-success-300'],
            'warning'    => ['bg' => 'bg-warning-50 dark:bg-warning-950', 'border' => 'border-warning-200 dark:border-warning-800', 'count' => 'text-warning-700 dark:text-warning-300'],
            'danger'     => ['bg' => 'bg-danger-50 dark:bg-danger-950', 'border' => 'border-danger-200 dark:border-danger-800', 'count' => 'text-danger-700 dark:text-danger-300'],
        ];

        $themeClasses = $themeMap[$this->color] ?? $themeMap['base'];

        $this->classList = trim(implode(' ', [
            'flex flex-col rounded-xl border p-5 shadow-sm dark:shadow-lg',
            $themeClasses['bg'],
            $themeClasses['border'],
            $this->tag !== 'div' ? 'cursor-pointer text-left transition hover:shadow-md focus:outline-none focus-visible:ring-2 dark:hover:shadow-xl' : '',
            $active ? ($ringMap[$this->color] ?? $ringMap['base']) : '',
            $this->class,
        ]));

        $this->counterClasses = 'mt-3 text-3xl font-semibold tracking-tight '.$themeClasses['count'];
        $this->titleClasses = 'text-sm font-medium '.Shades::secondary($this->color);
        $this->descriptionClasses = 'mt-1 text-xs '.Shades::tertiary($this->color);
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.counter');
    }
}
