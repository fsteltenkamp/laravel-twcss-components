<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * Code or a token to copy: inline (<code>) or a block (<pre>) with a copy button (a toast
 * confirms it), a wrap toggle and optional line numbers. `data-language` is left for a
 * host's highlighter; the component itself does not colour syntax.
 */
class Code extends Component
{
    public string $classList;
    public string $headClasses;

    /**
     * @param  string  $value  the code (escaped); the slot is used when empty
     * @param  string  $maxHeight  CSS max height of the block before it scrolls, e.g. 20rem
     */
    public function __construct(
        public string $value = '',
        public bool $inline = false,
        public string $language = '',
        public bool $copy = true,
        public bool $wrap = false,
        public bool $lines = false,
        public string $maxHeight = '',
        public string $color = 'base',
    ) {
        $inlineMap = [
            'slate'     => 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-100',
            'gray'      => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100',
            'zinc'      => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-100',
            'neutral'   => 'bg-neutral-100 text-neutral-800 dark:bg-neutral-800 dark:text-neutral-100',
            'stone'     => 'bg-stone-100 text-stone-800 dark:bg-stone-800 dark:text-stone-100',
            'red'       => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
            'orange'    => 'bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100',
            'amber'     => 'bg-amber-100 text-amber-800 dark:bg-amber-800 dark:text-amber-100',
            'yellow'    => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
            'lime'      => 'bg-lime-100 text-lime-800 dark:bg-lime-800 dark:text-lime-100',
            'green'     => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
            'emerald'   => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-800 dark:text-emerald-100',
            'teal'      => 'bg-teal-100 text-teal-800 dark:bg-teal-800 dark:text-teal-100',
            'cyan'      => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-800 dark:text-cyan-100',
            'sky'       => 'bg-sky-100 text-sky-800 dark:bg-sky-800 dark:text-sky-100',
            'blue'      => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
            'indigo'    => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-800 dark:text-indigo-100',
            'violet'    => 'bg-violet-100 text-violet-800 dark:bg-violet-800 dark:text-violet-100',
            'purple'    => 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100',
            'fuchsia'   => 'bg-fuchsia-100 text-fuchsia-800 dark:bg-fuchsia-800 dark:text-fuchsia-100',
            'pink'      => 'bg-pink-100 text-pink-800 dark:bg-pink-800 dark:text-pink-100',
            'rose'      => 'bg-rose-100 text-rose-800 dark:bg-rose-800 dark:text-rose-100',
            'taupe'     => 'bg-taupe-100 text-taupe-800 dark:bg-taupe-800 dark:text-taupe-100',
            'mauve'     => 'bg-mauve-100 text-mauve-800 dark:bg-mauve-800 dark:text-mauve-100',
            'mist'      => 'bg-mist-100 text-mist-800 dark:bg-mist-800 dark:text-mist-100',
            'olive'     => 'bg-olive-100 text-olive-800 dark:bg-olive-800 dark:text-olive-100',
            'primary'   => 'bg-primary-100 text-primary-800 dark:bg-primary-800 dark:text-primary-100',
            'secondary' => 'bg-secondary-100 text-secondary-800 dark:bg-secondary-800 dark:text-secondary-100',
            'accent'    => 'bg-accent-100 text-accent-800 dark:bg-accent-800 dark:text-accent-100',
            'base'      => 'bg-base-100 text-base-800 dark:bg-base-800 dark:text-base-100',
            'info'      => 'bg-info-100 text-info-800 dark:bg-info-800 dark:text-info-100',
            'success'   => 'bg-success-100 text-success-800 dark:bg-success-800 dark:text-success-100',
            'warning'   => 'bg-warning-100 text-warning-800 dark:bg-warning-800 dark:text-warning-100',
            'danger'    => 'bg-danger-100 text-danger-800 dark:bg-danger-800 dark:text-danger-100',
        ];

        $blockMap = [
            'slate'     => 'border-slate-200 bg-slate-50 text-slate-900 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100',
            'gray'      => 'border-gray-200 bg-gray-50 text-gray-900 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100',
            'zinc'      => 'border-zinc-200 bg-zinc-50 text-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100',
            'neutral'   => 'border-neutral-200 bg-neutral-50 text-neutral-900 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-100',
            'stone'     => 'border-stone-200 bg-stone-50 text-stone-900 dark:border-stone-700 dark:bg-stone-950 dark:text-stone-100',
            'red'       => 'border-red-200 bg-red-50 text-red-900 dark:border-red-700 dark:bg-red-950 dark:text-red-100',
            'orange'    => 'border-orange-200 bg-orange-50 text-orange-900 dark:border-orange-700 dark:bg-orange-950 dark:text-orange-100',
            'amber'     => 'border-amber-200 bg-amber-50 text-amber-900 dark:border-amber-700 dark:bg-amber-950 dark:text-amber-100',
            'yellow'    => 'border-yellow-200 bg-yellow-50 text-yellow-900 dark:border-yellow-700 dark:bg-yellow-950 dark:text-yellow-100',
            'lime'      => 'border-lime-200 bg-lime-50 text-lime-900 dark:border-lime-700 dark:bg-lime-950 dark:text-lime-100',
            'green'     => 'border-green-200 bg-green-50 text-green-900 dark:border-green-700 dark:bg-green-950 dark:text-green-100',
            'emerald'   => 'border-emerald-200 bg-emerald-50 text-emerald-900 dark:border-emerald-700 dark:bg-emerald-950 dark:text-emerald-100',
            'teal'      => 'border-teal-200 bg-teal-50 text-teal-900 dark:border-teal-700 dark:bg-teal-950 dark:text-teal-100',
            'cyan'      => 'border-cyan-200 bg-cyan-50 text-cyan-900 dark:border-cyan-700 dark:bg-cyan-950 dark:text-cyan-100',
            'sky'       => 'border-sky-200 bg-sky-50 text-sky-900 dark:border-sky-700 dark:bg-sky-950 dark:text-sky-100',
            'blue'      => 'border-blue-200 bg-blue-50 text-blue-900 dark:border-blue-700 dark:bg-blue-950 dark:text-blue-100',
            'indigo'    => 'border-indigo-200 bg-indigo-50 text-indigo-900 dark:border-indigo-700 dark:bg-indigo-950 dark:text-indigo-100',
            'violet'    => 'border-violet-200 bg-violet-50 text-violet-900 dark:border-violet-700 dark:bg-violet-950 dark:text-violet-100',
            'purple'    => 'border-purple-200 bg-purple-50 text-purple-900 dark:border-purple-700 dark:bg-purple-950 dark:text-purple-100',
            'fuchsia'   => 'border-fuchsia-200 bg-fuchsia-50 text-fuchsia-900 dark:border-fuchsia-700 dark:bg-fuchsia-950 dark:text-fuchsia-100',
            'pink'      => 'border-pink-200 bg-pink-50 text-pink-900 dark:border-pink-700 dark:bg-pink-950 dark:text-pink-100',
            'rose'      => 'border-rose-200 bg-rose-50 text-rose-900 dark:border-rose-700 dark:bg-rose-950 dark:text-rose-100',
            'taupe'     => 'border-taupe-200 bg-taupe-50 text-taupe-900 dark:border-taupe-700 dark:bg-taupe-950 dark:text-taupe-100',
            'mauve'     => 'border-mauve-200 bg-mauve-50 text-mauve-900 dark:border-mauve-700 dark:bg-mauve-950 dark:text-mauve-100',
            'mist'      => 'border-mist-200 bg-mist-50 text-mist-900 dark:border-mist-700 dark:bg-mist-950 dark:text-mist-100',
            'olive'     => 'border-olive-200 bg-olive-50 text-olive-900 dark:border-olive-700 dark:bg-olive-950 dark:text-olive-100',
            'primary'   => 'border-primary-200 bg-primary-50 text-primary-900 dark:border-primary-700 dark:bg-primary-950 dark:text-primary-100',
            'secondary' => 'border-secondary-200 bg-secondary-50 text-secondary-900 dark:border-secondary-700 dark:bg-secondary-950 dark:text-secondary-100',
            'accent'    => 'border-accent-200 bg-accent-50 text-accent-900 dark:border-accent-700 dark:bg-accent-950 dark:text-accent-100',
            'base'      => 'border-base-200 bg-base-50 text-base-900 dark:border-base-700 dark:bg-base-950 dark:text-base-100',
            'info'      => 'border-info-200 bg-info-50 text-info-900 dark:border-info-700 dark:bg-info-950 dark:text-info-100',
            'success'   => 'border-success-200 bg-success-50 text-success-900 dark:border-success-700 dark:bg-success-950 dark:text-success-100',
            'warning'   => 'border-warning-200 bg-warning-50 text-warning-900 dark:border-warning-700 dark:bg-warning-950 dark:text-warning-100',
            'danger'    => 'border-danger-200 bg-danger-50 text-danger-900 dark:border-danger-700 dark:bg-danger-950 dark:text-danger-100',
        ];

        $this->classList = $inline
            ? 'rounded px-1.5 py-0.5 font-mono text-[0.85em] '.($inlineMap[$color] ?? $inlineMap['base'])
            : 'overflow-hidden rounded-lg border text-sm '.($blockMap[$color] ?? $blockMap['base']);
        $this->headClasses = 'flex items-center justify-between gap-2 border-b border-current/10 px-3 py-1 text-xs '.Shades::tertiary($color);
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.code');
    }
}
