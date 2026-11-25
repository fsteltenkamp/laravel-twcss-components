<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * A frame for a QR code (two-factor setup, a payment code): square, always on white so
 * scanners read it in dark mode, with a spinner while the slot (the SVG) is empty.
 */
class Qr extends Component
{
    public string $classList;

    public function __construct(
        public string $size = 'md',
        public string $label = '',
        public string $color = 'base',
    ) {
        $frameMap = [
            'slate'     => 'border-slate-200 dark:border-slate-600',
            'gray'      => 'border-gray-200 dark:border-gray-600',
            'zinc'      => 'border-zinc-200 dark:border-zinc-600',
            'neutral'   => 'border-neutral-200 dark:border-neutral-600',
            'stone'     => 'border-stone-200 dark:border-stone-600',
            'red'       => 'border-red-200 dark:border-red-600',
            'orange'    => 'border-orange-200 dark:border-orange-600',
            'amber'     => 'border-amber-200 dark:border-amber-600',
            'yellow'    => 'border-yellow-200 dark:border-yellow-600',
            'lime'      => 'border-lime-200 dark:border-lime-600',
            'green'     => 'border-green-200 dark:border-green-600',
            'emerald'   => 'border-emerald-200 dark:border-emerald-600',
            'teal'      => 'border-teal-200 dark:border-teal-600',
            'cyan'      => 'border-cyan-200 dark:border-cyan-600',
            'sky'       => 'border-sky-200 dark:border-sky-600',
            'blue'      => 'border-blue-200 dark:border-blue-600',
            'indigo'    => 'border-indigo-200 dark:border-indigo-600',
            'violet'    => 'border-violet-200 dark:border-violet-600',
            'purple'    => 'border-purple-200 dark:border-purple-600',
            'fuchsia'   => 'border-fuchsia-200 dark:border-fuchsia-600',
            'pink'      => 'border-pink-200 dark:border-pink-600',
            'rose'      => 'border-rose-200 dark:border-rose-600',
            'taupe'     => 'border-taupe-200 dark:border-taupe-600',
            'mauve'     => 'border-mauve-200 dark:border-mauve-600',
            'mist'      => 'border-mist-200 dark:border-mist-600',
            'olive'     => 'border-olive-200 dark:border-olive-600',
            'primary'   => 'border-primary-200 dark:border-primary-600',
            'secondary' => 'border-secondary-200 dark:border-secondary-600',
            'accent'    => 'border-accent-200 dark:border-accent-600',
            'base'      => 'border-base-200 dark:border-base-600',
            'info'      => 'border-info-200 dark:border-info-600',
            'success'   => 'border-success-200 dark:border-success-600',
            'warning'   => 'border-warning-200 dark:border-warning-600',
            'danger'    => 'border-danger-200 dark:border-danger-600',
        ];

        $this->classList = trim(implode(' ', [
            'inline-flex aspect-square items-center justify-center rounded-lg border bg-white p-3 text-black [&_svg]:h-full [&_svg]:w-full',
            ['sm' => 'w-32', 'lg' => 'w-64'][$size] ?? 'w-48',
            $frameMap[$color] ?? $frameMap['base'],
        ]));
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.qr');
    }
}
