<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * A row of mutually exclusive buttons (x-fltc::segmented.option), one of them active.
 * The value is Alpine state and x-modelable, so x-model / wire:model on the group bind
 * it; with `name` a hidden input carries it in a plain form.
 *
 * `interactive` false renders the markup without Alpine, for a script of its own to
 * drive (x-fltc::darkmode.toggle does, through the data-* hooks and aria-pressed).
 */
class Segmented extends Component
{
    public string $classList;
    public string $activeClasses;
    public string $inactiveClasses;

    public function __construct(
        public string $value = '',
        public string $name = '',
        public string $color = 'base',
        public string $label = '',
        public bool $interactive = true,
    ) {
        ['container' => $container, 'active' => $this->activeClasses, 'inactive' => $this->inactiveClasses] = static::classes($color);

        $this->classList = 'inline-flex items-center gap-1 rounded-lg p-1 '.$container;
    }

    /**
     * Track, active and inactive option classes for a theme.
     *
     * @return array{container: string, active: string, inactive: string}
     */
    public static function classes(string $color): array
    {
        // Themed track background behind the segments. Literal strings so the host app's
        // Tailwind scanner picks them up (dynamic class names are not detected).
        $containerMap = [
            'slate'   => 'bg-slate-100 dark:bg-slate-800',
            'gray'    => 'bg-gray-100 dark:bg-gray-800',
            'zinc'    => 'bg-zinc-100 dark:bg-zinc-800',
            'neutral' => 'bg-neutral-100 dark:bg-neutral-800',
            'stone'   => 'bg-stone-100 dark:bg-stone-800',
            'red'     => 'bg-red-100 dark:bg-red-950/50',
            'orange'  => 'bg-orange-100 dark:bg-orange-950/50',
            'amber'   => 'bg-amber-100 dark:bg-amber-950/50',
            'yellow'  => 'bg-yellow-100 dark:bg-yellow-950/50',
            'lime'    => 'bg-lime-100 dark:bg-lime-950/50',
            'green'   => 'bg-green-100 dark:bg-green-950/50',
            'emerald' => 'bg-emerald-100 dark:bg-emerald-950/50',
            'teal'    => 'bg-teal-100 dark:bg-teal-950/50',
            'cyan'    => 'bg-cyan-100 dark:bg-cyan-950/50',
            'sky'     => 'bg-sky-100 dark:bg-sky-950/50',
            'blue'    => 'bg-blue-100 dark:bg-blue-950/50',
            'indigo'  => 'bg-indigo-100 dark:bg-indigo-950/50',
            'violet'  => 'bg-violet-100 dark:bg-violet-950/50',
            'purple'  => 'bg-purple-100 dark:bg-purple-950/50',
            'fuchsia' => 'bg-fuchsia-100 dark:bg-fuchsia-950/50',
            'pink'    => 'bg-pink-100 dark:bg-pink-950/50',
            'rose'    => 'bg-rose-100 dark:bg-rose-950/50',
            'taupe'   => 'bg-taupe-100 dark:bg-taupe-950/50',
            'mauve'   => 'bg-mauve-100 dark:bg-mauve-950/50',
            'mist'    => 'bg-mist-100 dark:bg-mist-950/50',
            'olive'   => 'bg-olive-100 dark:bg-olive-950/50',
            'primary'    => 'bg-primary-100 dark:bg-primary-950/50',
            'secondary'  => 'bg-secondary-100 dark:bg-secondary-950/50',
            'accent'     => 'bg-accent-100 dark:bg-accent-950/50',
            'base'       => 'bg-base-100 dark:bg-base-950/50',
            'info'       => 'bg-info-100 dark:bg-info-950/50',
            'success'    => 'bg-success-100 dark:bg-success-950/50',
            'warning'    => 'bg-warning-100 dark:bg-warning-950/50',
            'danger'     => 'bg-danger-100 dark:bg-danger-950/50',
        ];

        // Inactive segment text — themed but muted, brightening on hover.
        $inactiveMap = [
            'slate'   => 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-100',
            'gray'    => 'text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-100',
            'zinc'    => 'text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-100',
            'neutral' => 'text-neutral-500 hover:text-neutral-800 dark:text-neutral-400 dark:hover:text-neutral-100',
            'stone'   => 'text-stone-500 hover:text-stone-800 dark:text-stone-400 dark:hover:text-stone-100',
            'red'     => 'text-red-500 hover:text-red-800 dark:text-red-400 dark:hover:text-red-100',
            'orange'  => 'text-orange-500 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-100',
            'amber'   => 'text-amber-500 hover:text-amber-800 dark:text-amber-400 dark:hover:text-amber-100',
            'yellow'  => 'text-yellow-500 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-100',
            'lime'    => 'text-lime-500 hover:text-lime-800 dark:text-lime-400 dark:hover:text-lime-100',
            'green'   => 'text-green-500 hover:text-green-800 dark:text-green-400 dark:hover:text-green-100',
            'emerald' => 'text-emerald-500 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-100',
            'teal'    => 'text-teal-500 hover:text-teal-800 dark:text-teal-400 dark:hover:text-teal-100',
            'cyan'    => 'text-cyan-500 hover:text-cyan-800 dark:text-cyan-400 dark:hover:text-cyan-100',
            'sky'     => 'text-sky-500 hover:text-sky-800 dark:text-sky-400 dark:hover:text-sky-100',
            'blue'    => 'text-blue-500 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-100',
            'indigo'  => 'text-indigo-500 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-100',
            'violet'  => 'text-violet-500 hover:text-violet-800 dark:text-violet-400 dark:hover:text-violet-100',
            'purple'  => 'text-purple-500 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-100',
            'fuchsia' => 'text-fuchsia-500 hover:text-fuchsia-800 dark:text-fuchsia-400 dark:hover:text-fuchsia-100',
            'pink'    => 'text-pink-500 hover:text-pink-800 dark:text-pink-400 dark:hover:text-pink-100',
            'rose'    => 'text-rose-500 hover:text-rose-800 dark:text-rose-400 dark:hover:text-rose-100',
            'taupe'   => 'text-taupe-500 hover:text-taupe-800 dark:text-taupe-400 dark:hover:text-taupe-100',
            'mauve'   => 'text-mauve-500 hover:text-mauve-800 dark:text-mauve-400 dark:hover:text-mauve-100',
            'mist'    => 'text-mist-500 hover:text-mist-800 dark:text-mist-400 dark:hover:text-mist-100',
            'olive'   => 'text-olive-500 hover:text-olive-800 dark:text-olive-400 dark:hover:text-olive-100',
            'primary'    => 'text-primary-500 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-100',
            'secondary'  => 'text-secondary-500 hover:text-secondary-800 dark:text-secondary-400 dark:hover:text-secondary-100',
            'accent'     => 'text-accent-500 hover:text-accent-800 dark:text-accent-400 dark:hover:text-accent-100',
            'base'       => 'text-base-500 hover:text-base-800 dark:text-base-400 dark:hover:text-base-100',
            'info'       => 'text-info-500 hover:text-info-800 dark:text-info-400 dark:hover:text-info-100',
            'success'    => 'text-success-500 hover:text-success-800 dark:text-success-400 dark:hover:text-success-100',
            'warning'    => 'text-warning-500 hover:text-warning-800 dark:text-warning-400 dark:hover:text-warning-100',
            'danger'     => 'text-danger-500 hover:text-danger-800 dark:text-danger-400 dark:hover:text-danger-100',
        ];

        // Active segment colour for the segmented control. Literal strings so the host
        // app's Tailwind scanner picks them up (dynamic class names are not detected).
        $activeMap = [
            'slate'   => 'bg-slate-600 text-white shadow-sm dark:bg-slate-500',
            'gray'    => 'bg-gray-600 text-white shadow-sm dark:bg-gray-500',
            'zinc'    => 'bg-zinc-600 text-white shadow-sm dark:bg-zinc-500',
            'neutral' => 'bg-neutral-600 text-white shadow-sm dark:bg-neutral-500',
            'stone'   => 'bg-stone-600 text-white shadow-sm dark:bg-stone-500',
            'red'     => 'bg-red-600 text-white shadow-sm dark:bg-red-500',
            'orange'  => 'bg-orange-600 text-white shadow-sm dark:bg-orange-500',
            'amber'   => 'bg-amber-600 text-white shadow-sm dark:bg-amber-500',
            'yellow'  => 'bg-yellow-600 text-white shadow-sm dark:bg-yellow-500',
            'lime'    => 'bg-lime-600 text-white shadow-sm dark:bg-lime-500',
            'green'   => 'bg-green-600 text-white shadow-sm dark:bg-green-500',
            'emerald' => 'bg-emerald-600 text-white shadow-sm dark:bg-emerald-500',
            'teal'    => 'bg-teal-600 text-white shadow-sm dark:bg-teal-500',
            'cyan'    => 'bg-cyan-600 text-white shadow-sm dark:bg-cyan-500',
            'sky'     => 'bg-sky-600 text-white shadow-sm dark:bg-sky-500',
            'blue'    => 'bg-blue-600 text-white shadow-sm dark:bg-blue-500',
            'indigo'  => 'bg-indigo-600 text-white shadow-sm dark:bg-indigo-500',
            'violet'  => 'bg-violet-600 text-white shadow-sm dark:bg-violet-500',
            'purple'  => 'bg-purple-600 text-white shadow-sm dark:bg-purple-500',
            'fuchsia' => 'bg-fuchsia-600 text-white shadow-sm dark:bg-fuchsia-500',
            'pink'    => 'bg-pink-600 text-white shadow-sm dark:bg-pink-500',
            'rose'    => 'bg-rose-600 text-white shadow-sm dark:bg-rose-500',
            'taupe'   => 'bg-taupe-600 text-white shadow-sm dark:bg-taupe-500',
            'mauve'   => 'bg-mauve-600 text-white shadow-sm dark:bg-mauve-500',
            'mist'    => 'bg-mist-600 text-white shadow-sm dark:bg-mist-500',
            'olive'   => 'bg-olive-600 text-white shadow-sm dark:bg-olive-500',
            'primary'    => 'bg-primary-600 text-white shadow-sm dark:bg-primary-500',
            'secondary'  => 'bg-secondary-600 text-white shadow-sm dark:bg-secondary-500',
            'accent'     => 'bg-accent-600 text-white shadow-sm dark:bg-accent-500',
            'base'       => 'bg-base-600 text-white shadow-sm dark:bg-base-500',
            'info'       => 'bg-info-600 text-white shadow-sm dark:bg-info-500',
            'success'    => 'bg-success-600 text-white shadow-sm dark:bg-success-500',
            'warning'    => 'bg-warning-600 text-white shadow-sm dark:bg-warning-500',
            'danger'     => 'bg-danger-600 text-white shadow-sm dark:bg-danger-500',
        ];

        return [
            'container' => $containerMap[$color] ?? $containerMap['base'],
            'active'    => $activeMap[$color] ?? $activeMap['base'],
            'inactive'  => $inactiveMap[$color] ?? $inactiveMap['base'],
        ];
    }

    public function render(): View|Closure|string
    {
        ViewFacade::share('fltcSegmented', [
            'color' => $this->color,
            'value' => $this->value,
            'interactive' => $this->interactive,
            'active' => $this->activeClasses,
            'inactive' => $this->inactiveClasses,
        ]);

        return view('fltc::components.segmented');
    }
}
