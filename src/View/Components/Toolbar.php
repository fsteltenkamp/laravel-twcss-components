<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * A row of compact icon buttons (an editor's formatting bar). Buttons JavaScript creates
 * can look the same: the toolbar publishes the button classes in
 * data-fltc-toolbar-button-class (and Toolbar::buttonClasses() in PHP).
 */
class Toolbar extends Component
{
    public string $classList;
    public string $buttonClassList;

    public function __construct(
        public string $color = 'base',
        public string $label = '',
    ) {
        $frameMap = [
            'slate'     => 'border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-900',
            'gray'      => 'border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900',
            'zinc'      => 'border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900',
            'neutral'   => 'border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900',
            'stone'     => 'border-stone-200 bg-stone-50 dark:border-stone-700 dark:bg-stone-900',
            'red'       => 'border-red-200 bg-red-50 dark:border-red-700 dark:bg-red-900',
            'orange'    => 'border-orange-200 bg-orange-50 dark:border-orange-700 dark:bg-orange-900',
            'amber'     => 'border-amber-200 bg-amber-50 dark:border-amber-700 dark:bg-amber-900',
            'yellow'    => 'border-yellow-200 bg-yellow-50 dark:border-yellow-700 dark:bg-yellow-900',
            'lime'      => 'border-lime-200 bg-lime-50 dark:border-lime-700 dark:bg-lime-900',
            'green'     => 'border-green-200 bg-green-50 dark:border-green-700 dark:bg-green-900',
            'emerald'   => 'border-emerald-200 bg-emerald-50 dark:border-emerald-700 dark:bg-emerald-900',
            'teal'      => 'border-teal-200 bg-teal-50 dark:border-teal-700 dark:bg-teal-900',
            'cyan'      => 'border-cyan-200 bg-cyan-50 dark:border-cyan-700 dark:bg-cyan-900',
            'sky'       => 'border-sky-200 bg-sky-50 dark:border-sky-700 dark:bg-sky-900',
            'blue'      => 'border-blue-200 bg-blue-50 dark:border-blue-700 dark:bg-blue-900',
            'indigo'    => 'border-indigo-200 bg-indigo-50 dark:border-indigo-700 dark:bg-indigo-900',
            'violet'    => 'border-violet-200 bg-violet-50 dark:border-violet-700 dark:bg-violet-900',
            'purple'    => 'border-purple-200 bg-purple-50 dark:border-purple-700 dark:bg-purple-900',
            'fuchsia'   => 'border-fuchsia-200 bg-fuchsia-50 dark:border-fuchsia-700 dark:bg-fuchsia-900',
            'pink'      => 'border-pink-200 bg-pink-50 dark:border-pink-700 dark:bg-pink-900',
            'rose'      => 'border-rose-200 bg-rose-50 dark:border-rose-700 dark:bg-rose-900',
            'taupe'     => 'border-taupe-200 bg-taupe-50 dark:border-taupe-700 dark:bg-taupe-900',
            'mauve'     => 'border-mauve-200 bg-mauve-50 dark:border-mauve-700 dark:bg-mauve-900',
            'mist'      => 'border-mist-200 bg-mist-50 dark:border-mist-700 dark:bg-mist-900',
            'olive'     => 'border-olive-200 bg-olive-50 dark:border-olive-700 dark:bg-olive-900',
            'primary'   => 'border-primary-200 bg-primary-50 dark:border-primary-700 dark:bg-primary-900',
            'secondary' => 'border-secondary-200 bg-secondary-50 dark:border-secondary-700 dark:bg-secondary-900',
            'accent'    => 'border-accent-200 bg-accent-50 dark:border-accent-700 dark:bg-accent-900',
            'base'      => 'border-base-200 bg-base-50 dark:border-base-700 dark:bg-base-900',
            'info'      => 'border-info-200 bg-info-50 dark:border-info-700 dark:bg-info-900',
            'success'   => 'border-success-200 bg-success-50 dark:border-success-700 dark:bg-success-900',
            'warning'   => 'border-warning-200 bg-warning-50 dark:border-warning-700 dark:bg-warning-900',
            'danger'    => 'border-danger-200 bg-danger-50 dark:border-danger-700 dark:bg-danger-900',
        ];

        $this->classList = 'flex flex-wrap items-center gap-0.5 rounded-md border p-1 '.($frameMap[$color] ?? $frameMap['base']);
        $this->buttonClassList = static::buttonClasses($color);
    }

    /**
     * Classes of a toolbar button in `color` (shared with x-fltc::toolbar.button).
     */
    public static function buttonClasses(string $color): string
    {
        $map = [
            'slate'     => 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 focus-visible:ring-slate-400 aria-pressed:bg-slate-200 aria-pressed:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-slate-100 dark:aria-pressed:bg-slate-700 dark:aria-pressed:text-slate-100',
            'gray'      => 'text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus-visible:ring-gray-400 aria-pressed:bg-gray-200 aria-pressed:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-gray-100 dark:aria-pressed:bg-gray-700 dark:aria-pressed:text-gray-100',
            'zinc'      => 'text-zinc-700 hover:bg-zinc-100 hover:text-zinc-900 focus-visible:ring-zinc-400 aria-pressed:bg-zinc-200 aria-pressed:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-zinc-100 dark:aria-pressed:bg-zinc-700 dark:aria-pressed:text-zinc-100',
            'neutral'   => 'text-neutral-700 hover:bg-neutral-100 hover:text-neutral-900 focus-visible:ring-neutral-400 aria-pressed:bg-neutral-200 aria-pressed:text-neutral-900 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:hover:text-neutral-100 dark:aria-pressed:bg-neutral-700 dark:aria-pressed:text-neutral-100',
            'stone'     => 'text-stone-700 hover:bg-stone-100 hover:text-stone-900 focus-visible:ring-stone-400 aria-pressed:bg-stone-200 aria-pressed:text-stone-900 dark:text-stone-300 dark:hover:bg-stone-800 dark:hover:text-stone-100 dark:aria-pressed:bg-stone-700 dark:aria-pressed:text-stone-100',
            'red'       => 'text-red-700 hover:bg-red-100 hover:text-red-900 focus-visible:ring-red-400 aria-pressed:bg-red-200 aria-pressed:text-red-900 dark:text-red-300 dark:hover:bg-red-800 dark:hover:text-red-100 dark:aria-pressed:bg-red-700 dark:aria-pressed:text-red-100',
            'orange'    => 'text-orange-700 hover:bg-orange-100 hover:text-orange-900 focus-visible:ring-orange-400 aria-pressed:bg-orange-200 aria-pressed:text-orange-900 dark:text-orange-300 dark:hover:bg-orange-800 dark:hover:text-orange-100 dark:aria-pressed:bg-orange-700 dark:aria-pressed:text-orange-100',
            'amber'     => 'text-amber-700 hover:bg-amber-100 hover:text-amber-900 focus-visible:ring-amber-400 aria-pressed:bg-amber-200 aria-pressed:text-amber-900 dark:text-amber-300 dark:hover:bg-amber-800 dark:hover:text-amber-100 dark:aria-pressed:bg-amber-700 dark:aria-pressed:text-amber-100',
            'yellow'    => 'text-yellow-700 hover:bg-yellow-100 hover:text-yellow-900 focus-visible:ring-yellow-400 aria-pressed:bg-yellow-200 aria-pressed:text-yellow-900 dark:text-yellow-300 dark:hover:bg-yellow-800 dark:hover:text-yellow-100 dark:aria-pressed:bg-yellow-700 dark:aria-pressed:text-yellow-100',
            'lime'      => 'text-lime-700 hover:bg-lime-100 hover:text-lime-900 focus-visible:ring-lime-400 aria-pressed:bg-lime-200 aria-pressed:text-lime-900 dark:text-lime-300 dark:hover:bg-lime-800 dark:hover:text-lime-100 dark:aria-pressed:bg-lime-700 dark:aria-pressed:text-lime-100',
            'green'     => 'text-green-700 hover:bg-green-100 hover:text-green-900 focus-visible:ring-green-400 aria-pressed:bg-green-200 aria-pressed:text-green-900 dark:text-green-300 dark:hover:bg-green-800 dark:hover:text-green-100 dark:aria-pressed:bg-green-700 dark:aria-pressed:text-green-100',
            'emerald'   => 'text-emerald-700 hover:bg-emerald-100 hover:text-emerald-900 focus-visible:ring-emerald-400 aria-pressed:bg-emerald-200 aria-pressed:text-emerald-900 dark:text-emerald-300 dark:hover:bg-emerald-800 dark:hover:text-emerald-100 dark:aria-pressed:bg-emerald-700 dark:aria-pressed:text-emerald-100',
            'teal'      => 'text-teal-700 hover:bg-teal-100 hover:text-teal-900 focus-visible:ring-teal-400 aria-pressed:bg-teal-200 aria-pressed:text-teal-900 dark:text-teal-300 dark:hover:bg-teal-800 dark:hover:text-teal-100 dark:aria-pressed:bg-teal-700 dark:aria-pressed:text-teal-100',
            'cyan'      => 'text-cyan-700 hover:bg-cyan-100 hover:text-cyan-900 focus-visible:ring-cyan-400 aria-pressed:bg-cyan-200 aria-pressed:text-cyan-900 dark:text-cyan-300 dark:hover:bg-cyan-800 dark:hover:text-cyan-100 dark:aria-pressed:bg-cyan-700 dark:aria-pressed:text-cyan-100',
            'sky'       => 'text-sky-700 hover:bg-sky-100 hover:text-sky-900 focus-visible:ring-sky-400 aria-pressed:bg-sky-200 aria-pressed:text-sky-900 dark:text-sky-300 dark:hover:bg-sky-800 dark:hover:text-sky-100 dark:aria-pressed:bg-sky-700 dark:aria-pressed:text-sky-100',
            'blue'      => 'text-blue-700 hover:bg-blue-100 hover:text-blue-900 focus-visible:ring-blue-400 aria-pressed:bg-blue-200 aria-pressed:text-blue-900 dark:text-blue-300 dark:hover:bg-blue-800 dark:hover:text-blue-100 dark:aria-pressed:bg-blue-700 dark:aria-pressed:text-blue-100',
            'indigo'    => 'text-indigo-700 hover:bg-indigo-100 hover:text-indigo-900 focus-visible:ring-indigo-400 aria-pressed:bg-indigo-200 aria-pressed:text-indigo-900 dark:text-indigo-300 dark:hover:bg-indigo-800 dark:hover:text-indigo-100 dark:aria-pressed:bg-indigo-700 dark:aria-pressed:text-indigo-100',
            'violet'    => 'text-violet-700 hover:bg-violet-100 hover:text-violet-900 focus-visible:ring-violet-400 aria-pressed:bg-violet-200 aria-pressed:text-violet-900 dark:text-violet-300 dark:hover:bg-violet-800 dark:hover:text-violet-100 dark:aria-pressed:bg-violet-700 dark:aria-pressed:text-violet-100',
            'purple'    => 'text-purple-700 hover:bg-purple-100 hover:text-purple-900 focus-visible:ring-purple-400 aria-pressed:bg-purple-200 aria-pressed:text-purple-900 dark:text-purple-300 dark:hover:bg-purple-800 dark:hover:text-purple-100 dark:aria-pressed:bg-purple-700 dark:aria-pressed:text-purple-100',
            'fuchsia'   => 'text-fuchsia-700 hover:bg-fuchsia-100 hover:text-fuchsia-900 focus-visible:ring-fuchsia-400 aria-pressed:bg-fuchsia-200 aria-pressed:text-fuchsia-900 dark:text-fuchsia-300 dark:hover:bg-fuchsia-800 dark:hover:text-fuchsia-100 dark:aria-pressed:bg-fuchsia-700 dark:aria-pressed:text-fuchsia-100',
            'pink'      => 'text-pink-700 hover:bg-pink-100 hover:text-pink-900 focus-visible:ring-pink-400 aria-pressed:bg-pink-200 aria-pressed:text-pink-900 dark:text-pink-300 dark:hover:bg-pink-800 dark:hover:text-pink-100 dark:aria-pressed:bg-pink-700 dark:aria-pressed:text-pink-100',
            'rose'      => 'text-rose-700 hover:bg-rose-100 hover:text-rose-900 focus-visible:ring-rose-400 aria-pressed:bg-rose-200 aria-pressed:text-rose-900 dark:text-rose-300 dark:hover:bg-rose-800 dark:hover:text-rose-100 dark:aria-pressed:bg-rose-700 dark:aria-pressed:text-rose-100',
            'taupe'     => 'text-taupe-700 hover:bg-taupe-100 hover:text-taupe-900 focus-visible:ring-taupe-400 aria-pressed:bg-taupe-200 aria-pressed:text-taupe-900 dark:text-taupe-300 dark:hover:bg-taupe-800 dark:hover:text-taupe-100 dark:aria-pressed:bg-taupe-700 dark:aria-pressed:text-taupe-100',
            'mauve'     => 'text-mauve-700 hover:bg-mauve-100 hover:text-mauve-900 focus-visible:ring-mauve-400 aria-pressed:bg-mauve-200 aria-pressed:text-mauve-900 dark:text-mauve-300 dark:hover:bg-mauve-800 dark:hover:text-mauve-100 dark:aria-pressed:bg-mauve-700 dark:aria-pressed:text-mauve-100',
            'mist'      => 'text-mist-700 hover:bg-mist-100 hover:text-mist-900 focus-visible:ring-mist-400 aria-pressed:bg-mist-200 aria-pressed:text-mist-900 dark:text-mist-300 dark:hover:bg-mist-800 dark:hover:text-mist-100 dark:aria-pressed:bg-mist-700 dark:aria-pressed:text-mist-100',
            'olive'     => 'text-olive-700 hover:bg-olive-100 hover:text-olive-900 focus-visible:ring-olive-400 aria-pressed:bg-olive-200 aria-pressed:text-olive-900 dark:text-olive-300 dark:hover:bg-olive-800 dark:hover:text-olive-100 dark:aria-pressed:bg-olive-700 dark:aria-pressed:text-olive-100',
            'primary'   => 'text-primary-700 hover:bg-primary-100 hover:text-primary-900 focus-visible:ring-primary-400 aria-pressed:bg-primary-200 aria-pressed:text-primary-900 dark:text-primary-300 dark:hover:bg-primary-800 dark:hover:text-primary-100 dark:aria-pressed:bg-primary-700 dark:aria-pressed:text-primary-100',
            'secondary' => 'text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 focus-visible:ring-secondary-400 aria-pressed:bg-secondary-200 aria-pressed:text-secondary-900 dark:text-secondary-300 dark:hover:bg-secondary-800 dark:hover:text-secondary-100 dark:aria-pressed:bg-secondary-700 dark:aria-pressed:text-secondary-100',
            'accent'    => 'text-accent-700 hover:bg-accent-100 hover:text-accent-900 focus-visible:ring-accent-400 aria-pressed:bg-accent-200 aria-pressed:text-accent-900 dark:text-accent-300 dark:hover:bg-accent-800 dark:hover:text-accent-100 dark:aria-pressed:bg-accent-700 dark:aria-pressed:text-accent-100',
            'base'      => 'text-base-700 hover:bg-base-100 hover:text-base-900 focus-visible:ring-base-400 aria-pressed:bg-base-200 aria-pressed:text-base-900 dark:text-base-300 dark:hover:bg-base-800 dark:hover:text-base-100 dark:aria-pressed:bg-base-700 dark:aria-pressed:text-base-100',
            'info'      => 'text-info-700 hover:bg-info-100 hover:text-info-900 focus-visible:ring-info-400 aria-pressed:bg-info-200 aria-pressed:text-info-900 dark:text-info-300 dark:hover:bg-info-800 dark:hover:text-info-100 dark:aria-pressed:bg-info-700 dark:aria-pressed:text-info-100',
            'success'   => 'text-success-700 hover:bg-success-100 hover:text-success-900 focus-visible:ring-success-400 aria-pressed:bg-success-200 aria-pressed:text-success-900 dark:text-success-300 dark:hover:bg-success-800 dark:hover:text-success-100 dark:aria-pressed:bg-success-700 dark:aria-pressed:text-success-100',
            'warning'   => 'text-warning-700 hover:bg-warning-100 hover:text-warning-900 focus-visible:ring-warning-400 aria-pressed:bg-warning-200 aria-pressed:text-warning-900 dark:text-warning-300 dark:hover:bg-warning-800 dark:hover:text-warning-100 dark:aria-pressed:bg-warning-700 dark:aria-pressed:text-warning-100',
            'danger'    => 'text-danger-700 hover:bg-danger-100 hover:text-danger-900 focus-visible:ring-danger-400 aria-pressed:bg-danger-200 aria-pressed:text-danger-900 dark:text-danger-300 dark:hover:bg-danger-800 dark:hover:text-danger-100 dark:aria-pressed:bg-danger-700 dark:aria-pressed:text-danger-100',
        ];

        return 'fltc-toolbar-button inline-flex h-8 min-w-8 cursor-pointer items-center justify-center gap-1 rounded px-1.5 text-sm transition focus:outline-none focus-visible:ring-2 disabled:cursor-not-allowed disabled:opacity-50 '.($map[$color] ?? $map['base']);
    }

    public function render(): View|Closure|string
    {
        ViewFacade::share('fltcToolbarColor', $this->color);

        return view('fltc::components.toolbar');
    }
}
