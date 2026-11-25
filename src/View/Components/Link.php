<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * A text link in running text, tables and lists (nav.link is for navigation bars).
 */
class Link extends Component
{
    public string $classList;

    /**
     * @param  string  $underline  `hover` (default), `always` or `none`
     * @param  bool  $external  opens in a new tab (rel="noopener noreferrer") with an outward arrow
     */
    public function __construct(
        public string $href = '#',
        public string $color = 'base',
        public bool $navigate = false,
        public bool $external = false,
        public string $underline = 'hover',
        public string $icon = '',
    ) {
        $map = [
            'slate'     => 'text-slate-600 decoration-slate-600/40 hover:text-slate-800 focus-visible:ring-slate-400 dark:text-slate-400 dark:decoration-slate-400/40 dark:hover:text-slate-200',
            'gray'      => 'text-gray-600 decoration-gray-600/40 hover:text-gray-800 focus-visible:ring-gray-400 dark:text-gray-400 dark:decoration-gray-400/40 dark:hover:text-gray-200',
            'zinc'      => 'text-zinc-600 decoration-zinc-600/40 hover:text-zinc-800 focus-visible:ring-zinc-400 dark:text-zinc-400 dark:decoration-zinc-400/40 dark:hover:text-zinc-200',
            'neutral'   => 'text-neutral-600 decoration-neutral-600/40 hover:text-neutral-800 focus-visible:ring-neutral-400 dark:text-neutral-400 dark:decoration-neutral-400/40 dark:hover:text-neutral-200',
            'stone'     => 'text-stone-600 decoration-stone-600/40 hover:text-stone-800 focus-visible:ring-stone-400 dark:text-stone-400 dark:decoration-stone-400/40 dark:hover:text-stone-200',
            'red'       => 'text-red-600 decoration-red-600/40 hover:text-red-800 focus-visible:ring-red-400 dark:text-red-400 dark:decoration-red-400/40 dark:hover:text-red-200',
            'orange'    => 'text-orange-600 decoration-orange-600/40 hover:text-orange-800 focus-visible:ring-orange-400 dark:text-orange-400 dark:decoration-orange-400/40 dark:hover:text-orange-200',
            'amber'     => 'text-amber-600 decoration-amber-600/40 hover:text-amber-800 focus-visible:ring-amber-400 dark:text-amber-400 dark:decoration-amber-400/40 dark:hover:text-amber-200',
            'yellow'    => 'text-yellow-600 decoration-yellow-600/40 hover:text-yellow-800 focus-visible:ring-yellow-400 dark:text-yellow-400 dark:decoration-yellow-400/40 dark:hover:text-yellow-200',
            'lime'      => 'text-lime-600 decoration-lime-600/40 hover:text-lime-800 focus-visible:ring-lime-400 dark:text-lime-400 dark:decoration-lime-400/40 dark:hover:text-lime-200',
            'green'     => 'text-green-600 decoration-green-600/40 hover:text-green-800 focus-visible:ring-green-400 dark:text-green-400 dark:decoration-green-400/40 dark:hover:text-green-200',
            'emerald'   => 'text-emerald-600 decoration-emerald-600/40 hover:text-emerald-800 focus-visible:ring-emerald-400 dark:text-emerald-400 dark:decoration-emerald-400/40 dark:hover:text-emerald-200',
            'teal'      => 'text-teal-600 decoration-teal-600/40 hover:text-teal-800 focus-visible:ring-teal-400 dark:text-teal-400 dark:decoration-teal-400/40 dark:hover:text-teal-200',
            'cyan'      => 'text-cyan-600 decoration-cyan-600/40 hover:text-cyan-800 focus-visible:ring-cyan-400 dark:text-cyan-400 dark:decoration-cyan-400/40 dark:hover:text-cyan-200',
            'sky'       => 'text-sky-600 decoration-sky-600/40 hover:text-sky-800 focus-visible:ring-sky-400 dark:text-sky-400 dark:decoration-sky-400/40 dark:hover:text-sky-200',
            'blue'      => 'text-blue-600 decoration-blue-600/40 hover:text-blue-800 focus-visible:ring-blue-400 dark:text-blue-400 dark:decoration-blue-400/40 dark:hover:text-blue-200',
            'indigo'    => 'text-indigo-600 decoration-indigo-600/40 hover:text-indigo-800 focus-visible:ring-indigo-400 dark:text-indigo-400 dark:decoration-indigo-400/40 dark:hover:text-indigo-200',
            'violet'    => 'text-violet-600 decoration-violet-600/40 hover:text-violet-800 focus-visible:ring-violet-400 dark:text-violet-400 dark:decoration-violet-400/40 dark:hover:text-violet-200',
            'purple'    => 'text-purple-600 decoration-purple-600/40 hover:text-purple-800 focus-visible:ring-purple-400 dark:text-purple-400 dark:decoration-purple-400/40 dark:hover:text-purple-200',
            'fuchsia'   => 'text-fuchsia-600 decoration-fuchsia-600/40 hover:text-fuchsia-800 focus-visible:ring-fuchsia-400 dark:text-fuchsia-400 dark:decoration-fuchsia-400/40 dark:hover:text-fuchsia-200',
            'pink'      => 'text-pink-600 decoration-pink-600/40 hover:text-pink-800 focus-visible:ring-pink-400 dark:text-pink-400 dark:decoration-pink-400/40 dark:hover:text-pink-200',
            'rose'      => 'text-rose-600 decoration-rose-600/40 hover:text-rose-800 focus-visible:ring-rose-400 dark:text-rose-400 dark:decoration-rose-400/40 dark:hover:text-rose-200',
            'taupe'     => 'text-taupe-600 decoration-taupe-600/40 hover:text-taupe-800 focus-visible:ring-taupe-400 dark:text-taupe-400 dark:decoration-taupe-400/40 dark:hover:text-taupe-200',
            'mauve'     => 'text-mauve-600 decoration-mauve-600/40 hover:text-mauve-800 focus-visible:ring-mauve-400 dark:text-mauve-400 dark:decoration-mauve-400/40 dark:hover:text-mauve-200',
            'mist'      => 'text-mist-600 decoration-mist-600/40 hover:text-mist-800 focus-visible:ring-mist-400 dark:text-mist-400 dark:decoration-mist-400/40 dark:hover:text-mist-200',
            'olive'     => 'text-olive-600 decoration-olive-600/40 hover:text-olive-800 focus-visible:ring-olive-400 dark:text-olive-400 dark:decoration-olive-400/40 dark:hover:text-olive-200',
            'primary'   => 'text-primary-600 decoration-primary-600/40 hover:text-primary-800 focus-visible:ring-primary-400 dark:text-primary-400 dark:decoration-primary-400/40 dark:hover:text-primary-200',
            'secondary' => 'text-secondary-600 decoration-secondary-600/40 hover:text-secondary-800 focus-visible:ring-secondary-400 dark:text-secondary-400 dark:decoration-secondary-400/40 dark:hover:text-secondary-200',
            'accent'    => 'text-accent-600 decoration-accent-600/40 hover:text-accent-800 focus-visible:ring-accent-400 dark:text-accent-400 dark:decoration-accent-400/40 dark:hover:text-accent-200',
            'base'      => 'text-base-600 decoration-base-600/40 hover:text-base-800 focus-visible:ring-base-400 dark:text-base-400 dark:decoration-base-400/40 dark:hover:text-base-200',
            'info'      => 'text-info-600 decoration-info-600/40 hover:text-info-800 focus-visible:ring-info-400 dark:text-info-400 dark:decoration-info-400/40 dark:hover:text-info-200',
            'success'   => 'text-success-600 decoration-success-600/40 hover:text-success-800 focus-visible:ring-success-400 dark:text-success-400 dark:decoration-success-400/40 dark:hover:text-success-200',
            'warning'   => 'text-warning-600 decoration-warning-600/40 hover:text-warning-800 focus-visible:ring-warning-400 dark:text-warning-400 dark:decoration-warning-400/40 dark:hover:text-warning-200',
            'danger'    => 'text-danger-600 decoration-danger-600/40 hover:text-danger-800 focus-visible:ring-danger-400 dark:text-danger-400 dark:decoration-danger-400/40 dark:hover:text-danger-200',
        ];

        $this->classList = trim(implode(' ', [
            'inline-flex items-baseline gap-1 rounded-sm font-medium underline-offset-2 transition focus:outline-none focus-visible:ring-2',
            ['always' => 'underline', 'none' => 'no-underline'][$underline] ?? 'hover:underline',
            $map[$color] ?? $map['base'],
        ]));
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.link');
    }
}
