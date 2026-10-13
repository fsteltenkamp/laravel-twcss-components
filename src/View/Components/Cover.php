<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * A fixed-aspect-ratio image (book cover, poster, avatar) with `object-cover`. When
 * `src` is empty or the image fails to load, a placeholder with the `fallback` text
 * shows instead (the swap is an inline onerror handler, so it needs no Alpine).
 */
class Cover extends Component
{
    public string $classList;
    public string $ratioStyle = '';
    public string $fallbackClasses;

    public function __construct(
        public string $src = '',
        public string $alt = '',
        public string $ratio = '2/3',
        public string $fallback = 'NO COVER',
        public string $fallbackIcon = 'image',
        public string $size = 'full',
        public string $color = 'base',
    ) {
        // Literal aspect classes for the common ratios; any other "w/h" goes inline.
        $ratioMap = [
            '2/3'  => 'aspect-[2/3]',
            '3/4'  => 'aspect-[3/4]',
            '1/1'  => 'aspect-square',
            '4/3'  => 'aspect-[4/3]',
            '3/2'  => 'aspect-[3/2]',
            '16/9' => 'aspect-video',
        ];

        $sizeMap = [
            'thumb-sm' => 'w-12',
            'thumb'    => 'w-24',
            'sm'       => 'w-32',
            'md'       => 'w-48',
            'lg'       => 'w-64',
            'full'     => 'w-full',
        ];

        $fallbackMap = [
            'slate'     => 'border-slate-200 bg-slate-100 text-slate-400 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-500',
            'gray'      => 'border-gray-200 bg-gray-100 text-gray-400 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-500',
            'zinc'      => 'border-zinc-200 bg-zinc-100 text-zinc-400 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-500',
            'neutral'   => 'border-neutral-200 bg-neutral-100 text-neutral-400 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-500',
            'stone'     => 'border-stone-200 bg-stone-100 text-stone-400 dark:border-stone-700 dark:bg-stone-800 dark:text-stone-500',
            'red'       => 'border-red-200 bg-red-100 text-red-400 dark:border-red-700 dark:bg-red-800 dark:text-red-500',
            'orange'    => 'border-orange-200 bg-orange-100 text-orange-400 dark:border-orange-700 dark:bg-orange-800 dark:text-orange-500',
            'amber'     => 'border-amber-200 bg-amber-100 text-amber-400 dark:border-amber-700 dark:bg-amber-800 dark:text-amber-500',
            'yellow'    => 'border-yellow-200 bg-yellow-100 text-yellow-400 dark:border-yellow-700 dark:bg-yellow-800 dark:text-yellow-500',
            'lime'      => 'border-lime-200 bg-lime-100 text-lime-400 dark:border-lime-700 dark:bg-lime-800 dark:text-lime-500',
            'green'     => 'border-green-200 bg-green-100 text-green-400 dark:border-green-700 dark:bg-green-800 dark:text-green-500',
            'emerald'   => 'border-emerald-200 bg-emerald-100 text-emerald-400 dark:border-emerald-700 dark:bg-emerald-800 dark:text-emerald-500',
            'teal'      => 'border-teal-200 bg-teal-100 text-teal-400 dark:border-teal-700 dark:bg-teal-800 dark:text-teal-500',
            'cyan'      => 'border-cyan-200 bg-cyan-100 text-cyan-400 dark:border-cyan-700 dark:bg-cyan-800 dark:text-cyan-500',
            'sky'       => 'border-sky-200 bg-sky-100 text-sky-400 dark:border-sky-700 dark:bg-sky-800 dark:text-sky-500',
            'blue'      => 'border-blue-200 bg-blue-100 text-blue-400 dark:border-blue-700 dark:bg-blue-800 dark:text-blue-500',
            'indigo'    => 'border-indigo-200 bg-indigo-100 text-indigo-400 dark:border-indigo-700 dark:bg-indigo-800 dark:text-indigo-500',
            'violet'    => 'border-violet-200 bg-violet-100 text-violet-400 dark:border-violet-700 dark:bg-violet-800 dark:text-violet-500',
            'purple'    => 'border-purple-200 bg-purple-100 text-purple-400 dark:border-purple-700 dark:bg-purple-800 dark:text-purple-500',
            'fuchsia'   => 'border-fuchsia-200 bg-fuchsia-100 text-fuchsia-400 dark:border-fuchsia-700 dark:bg-fuchsia-800 dark:text-fuchsia-500',
            'pink'      => 'border-pink-200 bg-pink-100 text-pink-400 dark:border-pink-700 dark:bg-pink-800 dark:text-pink-500',
            'rose'      => 'border-rose-200 bg-rose-100 text-rose-400 dark:border-rose-700 dark:bg-rose-800 dark:text-rose-500',
            'taupe'     => 'border-taupe-200 bg-taupe-100 text-taupe-400 dark:border-taupe-700 dark:bg-taupe-800 dark:text-taupe-500',
            'mauve'     => 'border-mauve-200 bg-mauve-100 text-mauve-400 dark:border-mauve-700 dark:bg-mauve-800 dark:text-mauve-500',
            'mist'      => 'border-mist-200 bg-mist-100 text-mist-400 dark:border-mist-700 dark:bg-mist-800 dark:text-mist-500',
            'olive'     => 'border-olive-200 bg-olive-100 text-olive-400 dark:border-olive-700 dark:bg-olive-800 dark:text-olive-500',
            'primary'      => 'border-primary-200 bg-primary-100 text-primary-400 dark:border-primary-700 dark:bg-primary-800 dark:text-primary-500',
            'secondary'    => 'border-secondary-200 bg-secondary-100 text-secondary-400 dark:border-secondary-700 dark:bg-secondary-800 dark:text-secondary-500',
            'accent'       => 'border-accent-200 bg-accent-100 text-accent-400 dark:border-accent-700 dark:bg-accent-800 dark:text-accent-500',
            'base'         => 'border-base-200 bg-base-100 text-base-400 dark:border-base-700 dark:bg-base-800 dark:text-base-500',
            'info'         => 'border-info-200 bg-info-100 text-info-400 dark:border-info-700 dark:bg-info-800 dark:text-info-500',
            'success'      => 'border-success-200 bg-success-100 text-success-400 dark:border-success-700 dark:bg-success-800 dark:text-success-500',
            'warning'      => 'border-warning-200 bg-warning-100 text-warning-400 dark:border-warning-700 dark:bg-warning-800 dark:text-warning-500',
            'danger'       => 'border-danger-200 bg-danger-100 text-danger-400 dark:border-danger-700 dark:bg-danger-800 dark:text-danger-500',
        ];

        if (! isset($ratioMap[$ratio]) && preg_match('/^\d+(\.\d+)?\/\d+(\.\d+)?$/', $ratio)) {
            $this->ratioStyle = 'aspect-ratio: '.str_replace('/', ' / ', $ratio).';';
        }

        $this->classList = trim(implode(' ', [
            'relative block shrink-0 overflow-hidden rounded-md',
            $ratioMap[$ratio] ?? ($this->ratioStyle !== '' ? '' : $ratioMap['2/3']),
            $sizeMap[$size] ?? $sizeMap['full'],
        ]));

        $this->fallbackClasses = 'absolute inset-0 flex flex-col items-center justify-center gap-1 border p-2 text-center [&[hidden]]:hidden '.($fallbackMap[$color] ?? $fallbackMap['base']);
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.cover');
    }
}
