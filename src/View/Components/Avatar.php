<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

/**
 * A person's picture, initials or icon, with an optional presence dot.
 */
class Avatar extends Component
{
    public string $classList;
    public string $statusClasses = '';
    public string $statusLabel = '';

    /**
     * @param  string  $status  `online`, `away`, `busy` or `offline` (none when empty)
     * @param  string  $size  `xs`, `sm`, `md` (default), `lg`, `xl`
     * @param  string  $shape  `circle` (default) or `square`
     */
    public function __construct(
        public string $src = '',
        public string $name = '',
        public string $initials = '',
        public string $icon = '',
        public string $status = '',
        public string $size = 'md',
        public string $shape = 'circle',
        public string $color = 'base',
    ) {
        if ($this->initials === '' && $name !== '') {
            $this->initials = Str::of($name)->explode(' ')->filter()->take(2)->map(fn ($part) => Str::upper(Str::substr($part, 0, 1)))->implode('');
        }

        $fillMap = [
            'slate'     => 'bg-slate-200 text-slate-800 dark:bg-slate-700 dark:text-slate-100',
            'gray'      => 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100',
            'zinc'      => 'bg-zinc-200 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-100',
            'neutral'   => 'bg-neutral-200 text-neutral-800 dark:bg-neutral-700 dark:text-neutral-100',
            'stone'     => 'bg-stone-200 text-stone-800 dark:bg-stone-700 dark:text-stone-100',
            'red'       => 'bg-red-200 text-red-800 dark:bg-red-700 dark:text-red-100',
            'orange'    => 'bg-orange-200 text-orange-800 dark:bg-orange-700 dark:text-orange-100',
            'amber'     => 'bg-amber-200 text-amber-800 dark:bg-amber-700 dark:text-amber-100',
            'yellow'    => 'bg-yellow-200 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100',
            'lime'      => 'bg-lime-200 text-lime-800 dark:bg-lime-700 dark:text-lime-100',
            'green'     => 'bg-green-200 text-green-800 dark:bg-green-700 dark:text-green-100',
            'emerald'   => 'bg-emerald-200 text-emerald-800 dark:bg-emerald-700 dark:text-emerald-100',
            'teal'      => 'bg-teal-200 text-teal-800 dark:bg-teal-700 dark:text-teal-100',
            'cyan'      => 'bg-cyan-200 text-cyan-800 dark:bg-cyan-700 dark:text-cyan-100',
            'sky'       => 'bg-sky-200 text-sky-800 dark:bg-sky-700 dark:text-sky-100',
            'blue'      => 'bg-blue-200 text-blue-800 dark:bg-blue-700 dark:text-blue-100',
            'indigo'    => 'bg-indigo-200 text-indigo-800 dark:bg-indigo-700 dark:text-indigo-100',
            'violet'    => 'bg-violet-200 text-violet-800 dark:bg-violet-700 dark:text-violet-100',
            'purple'    => 'bg-purple-200 text-purple-800 dark:bg-purple-700 dark:text-purple-100',
            'fuchsia'   => 'bg-fuchsia-200 text-fuchsia-800 dark:bg-fuchsia-700 dark:text-fuchsia-100',
            'pink'      => 'bg-pink-200 text-pink-800 dark:bg-pink-700 dark:text-pink-100',
            'rose'      => 'bg-rose-200 text-rose-800 dark:bg-rose-700 dark:text-rose-100',
            'taupe'     => 'bg-taupe-200 text-taupe-800 dark:bg-taupe-700 dark:text-taupe-100',
            'mauve'     => 'bg-mauve-200 text-mauve-800 dark:bg-mauve-700 dark:text-mauve-100',
            'mist'      => 'bg-mist-200 text-mist-800 dark:bg-mist-700 dark:text-mist-100',
            'olive'     => 'bg-olive-200 text-olive-800 dark:bg-olive-700 dark:text-olive-100',
            'primary'   => 'bg-primary-200 text-primary-800 dark:bg-primary-700 dark:text-primary-100',
            'secondary' => 'bg-secondary-200 text-secondary-800 dark:bg-secondary-700 dark:text-secondary-100',
            'accent'    => 'bg-accent-200 text-accent-800 dark:bg-accent-700 dark:text-accent-100',
            'base'      => 'bg-base-200 text-base-800 dark:bg-base-700 dark:text-base-100',
            'info'      => 'bg-info-200 text-info-800 dark:bg-info-700 dark:text-info-100',
            'success'   => 'bg-success-200 text-success-800 dark:bg-success-700 dark:text-success-100',
            'warning'   => 'bg-warning-200 text-warning-800 dark:bg-warning-700 dark:text-warning-100',
            'danger'    => 'bg-danger-200 text-danger-800 dark:bg-danger-700 dark:text-danger-100',
        ];

        $sizes = ['xs' => 'h-6 w-6 text-[0.6rem]', 'sm' => 'h-8 w-8 text-xs', 'md' => 'h-10 w-10 text-sm', 'lg' => 'h-12 w-12 text-base', 'xl' => 'h-16 w-16 text-lg'];
        $round = $shape === 'square' ? 'rounded-md' : 'rounded-full';

        $this->classList = trim(implode(' ', [
            'relative inline-flex shrink-0 items-center justify-center font-semibold select-none',
            $sizes[$size] ?? $sizes['md'],
        ]));
        $this->faceClasses = trim('flex h-full w-full items-center justify-center overflow-hidden '.$round.' '.($fillMap[$color] ?? $fillMap['base']));

        // Presence: the status roles, with a ring in the page colour around the dot.
        $statuses = [
            'online' => 'bg-success-500',
            'away' => 'bg-warning-500',
            'busy' => 'bg-danger-500',
            'offline' => 'bg-base-400',
        ];
        if (isset($statuses[$status])) {
            $dot = ['xs' => 'h-1.5 w-1.5', 'sm' => 'h-2 w-2', 'lg' => 'h-3 w-3', 'xl' => 'h-3.5 w-3.5'][$size] ?? 'h-2.5 w-2.5';
            $this->statusClasses = 'absolute right-0 bottom-0 block rounded-full ring-2 ring-white dark:ring-base-950 '.$dot.' '.$statuses[$status];
            $this->statusLabel = __(Str::headline($status));
        }
    }

    public string $faceClasses;

    public function render(): View|Closure|string
    {
        return view('fltc::components.avatar');
    }
}
