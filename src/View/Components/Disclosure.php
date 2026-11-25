<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * One collapsible section on a native <details> (works without JavaScript): a log,
 * a stack trace, "more options". For several sections use x-fltc::accordion.
 */
class Disclosure extends Component
{
    public string $classList;
    public string $summaryClasses;
    public string $contentClasses;

    /**
     * @param  string  $persist  localStorage key that keeps the open state
     * @param  bool  $lazy  render the content into the page only when first opened
     * @param  string  $variant  `bordered` (default) or `plain`
     */
    public function __construct(
        public string $summary = '',
        public bool $open = false,
        public string $persist = '',
        public bool $lazy = false,
        public string $color = 'base',
        public string $variant = 'bordered',
    ) {
        $frameMap = [
            'slate'     => 'border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900',
            'gray'      => 'border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900',
            'zinc'      => 'border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900',
            'neutral'   => 'border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900',
            'stone'     => 'border-stone-200 bg-white dark:border-stone-700 dark:bg-stone-900',
            'red'       => 'border-red-200 bg-white dark:border-red-700 dark:bg-red-900',
            'orange'    => 'border-orange-200 bg-white dark:border-orange-700 dark:bg-orange-900',
            'amber'     => 'border-amber-200 bg-white dark:border-amber-700 dark:bg-amber-900',
            'yellow'    => 'border-yellow-200 bg-white dark:border-yellow-700 dark:bg-yellow-900',
            'lime'      => 'border-lime-200 bg-white dark:border-lime-700 dark:bg-lime-900',
            'green'     => 'border-green-200 bg-white dark:border-green-700 dark:bg-green-900',
            'emerald'   => 'border-emerald-200 bg-white dark:border-emerald-700 dark:bg-emerald-900',
            'teal'      => 'border-teal-200 bg-white dark:border-teal-700 dark:bg-teal-900',
            'cyan'      => 'border-cyan-200 bg-white dark:border-cyan-700 dark:bg-cyan-900',
            'sky'       => 'border-sky-200 bg-white dark:border-sky-700 dark:bg-sky-900',
            'blue'      => 'border-blue-200 bg-white dark:border-blue-700 dark:bg-blue-900',
            'indigo'    => 'border-indigo-200 bg-white dark:border-indigo-700 dark:bg-indigo-900',
            'violet'    => 'border-violet-200 bg-white dark:border-violet-700 dark:bg-violet-900',
            'purple'    => 'border-purple-200 bg-white dark:border-purple-700 dark:bg-purple-900',
            'fuchsia'   => 'border-fuchsia-200 bg-white dark:border-fuchsia-700 dark:bg-fuchsia-900',
            'pink'      => 'border-pink-200 bg-white dark:border-pink-700 dark:bg-pink-900',
            'rose'      => 'border-rose-200 bg-white dark:border-rose-700 dark:bg-rose-900',
            'taupe'     => 'border-taupe-200 bg-white dark:border-taupe-700 dark:bg-taupe-900',
            'mauve'     => 'border-mauve-200 bg-white dark:border-mauve-700 dark:bg-mauve-900',
            'mist'      => 'border-mist-200 bg-white dark:border-mist-700 dark:bg-mist-900',
            'olive'     => 'border-olive-200 bg-white dark:border-olive-700 dark:bg-olive-900',
            'primary'   => 'border-primary-200 bg-white dark:border-primary-700 dark:bg-primary-900',
            'secondary' => 'border-secondary-200 bg-white dark:border-secondary-700 dark:bg-secondary-900',
            'accent'    => 'border-accent-200 bg-white dark:border-accent-700 dark:bg-accent-900',
            'base'      => 'border-base-200 bg-white dark:border-base-700 dark:bg-base-900',
            'info'      => 'border-info-200 bg-white dark:border-info-700 dark:bg-info-900',
            'success'   => 'border-success-200 bg-white dark:border-success-700 dark:bg-success-900',
            'warning'   => 'border-warning-200 bg-white dark:border-warning-700 dark:bg-warning-900',
            'danger'    => 'border-danger-200 bg-white dark:border-danger-700 dark:bg-danger-900',
        ];

        $this->classList = trim('group '.($variant === 'plain' ? '' : 'rounded-lg border '.($frameMap[$color] ?? $frameMap['base'])));
        $this->summaryClasses = trim('flex cursor-pointer list-none items-center gap-2 text-sm font-medium select-none focus:outline-none focus-visible:underline [&::-webkit-details-marker]:hidden '
            .($variant === 'plain' ? 'py-1 ' : 'px-4 py-2.5 ').Shades::secondary($color));
        $this->contentClasses = trim(($variant === 'plain' ? 'pt-2 ' : 'border-t px-4 py-3 '.($frameMap[$color] ?? $frameMap['base']).' ').'text-sm '.Shades::primary($color));
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.disclosure');
    }
}
