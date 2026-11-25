<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Fsteltenkamp\TwcssComponents\View\Component;

class Button extends Component
{
    public string $classList;
    public string $heightStyle;

    public function __construct(
        public string $color = 'base',
        public string $width = 'fit',
        public string $height = 'md',
        public string $tooltip = '',
        public bool $disabled = false,
        public string $variant = 'solid',
        public string $icon = '',
        public string $iconVariant = 'regular',
        public string $iconPosition = 'before',
        string $class = '',
        public bool $square = false,
    )
    {
        $solidThemeMap = [
            'slate'   => 'bg-slate-400 text-white hover:bg-slate-500 focus:ring-slate-300 dark:bg-slate-600 dark:hover:bg-slate-500 dark:focus:ring-slate-500',
            'gray'    => 'bg-gray-400 text-white hover:bg-gray-500 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-500',
            'zinc'    => 'bg-zinc-400 text-white hover:bg-zinc-500 focus:ring-zinc-300 dark:bg-zinc-600 dark:hover:bg-zinc-500 dark:focus:ring-zinc-500',
            'neutral' => 'bg-neutral-400 text-white hover:bg-neutral-500 focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-500 dark:focus:ring-neutral-500',
            'stone'   => 'bg-stone-400 text-white hover:bg-stone-500 focus:ring-stone-300 dark:bg-stone-600 dark:hover:bg-stone-500 dark:focus:ring-stone-500',
            'red'     => 'bg-red-400 text-white hover:bg-red-500 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-500 dark:focus:ring-red-500',
            'orange'  => 'bg-orange-400 text-white hover:bg-orange-500 focus:ring-orange-300 dark:bg-orange-600 dark:hover:bg-orange-500 dark:focus:ring-orange-500',
            'amber'   => 'bg-amber-400 text-white hover:bg-amber-500 focus:ring-amber-300 dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-amber-500',
            'yellow'  => 'bg-yellow-400 text-white hover:bg-yellow-500 focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-500 dark:focus:ring-yellow-500',
            'lime'    => 'bg-lime-400 text-white hover:bg-lime-500 focus:ring-lime-300 dark:bg-lime-600 dark:hover:bg-lime-500 dark:focus:ring-lime-500',
            'green'   => 'bg-green-400 text-white hover:bg-green-500 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-500 dark:focus:ring-green-500',
            'emerald' => 'bg-emerald-400 text-white hover:bg-emerald-500 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-500 dark:focus:ring-emerald-500',
            'teal'    => 'bg-teal-400 text-white hover:bg-teal-500 focus:ring-teal-300 dark:bg-teal-600 dark:hover:bg-teal-500 dark:focus:ring-teal-500',
            'cyan'    => 'bg-cyan-400 text-white hover:bg-cyan-500 focus:ring-cyan-300 dark:bg-cyan-600 dark:hover:bg-cyan-500 dark:focus:ring-cyan-500',
            'sky'     => 'bg-sky-400 text-white hover:bg-sky-500 focus:ring-sky-300 dark:bg-sky-600 dark:hover:bg-sky-500 dark:focus:ring-sky-500',
            'blue'    => 'bg-blue-400 text-white hover:bg-blue-500 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-500 dark:focus:ring-blue-500',
            'indigo'  => 'bg-indigo-400 text-white hover:bg-indigo-500 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-500 dark:focus:ring-indigo-500',
            'violet'  => 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-300 dark:bg-violet-600 dark:hover:bg-violet-500 dark:focus:ring-violet-500',
            'purple'  => 'bg-purple-400 text-white hover:bg-purple-500 focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-500 dark:focus:ring-purple-500',
            'fuchsia' => 'bg-fuchsia-400 text-white hover:bg-fuchsia-500 focus:ring-fuchsia-300 dark:bg-fuchsia-600 dark:hover:bg-fuchsia-500 dark:focus:ring-fuchsia-500',
            'pink'    => 'bg-pink-400 text-white hover:bg-pink-500 focus:ring-pink-300 dark:bg-pink-600 dark:hover:bg-pink-500 dark:focus:ring-pink-500',
            'rose'    => 'bg-rose-400 text-white hover:bg-rose-500 focus:ring-rose-300 dark:bg-rose-600 dark:hover:bg-rose-500 dark:focus:ring-rose-500',
            'taupe'   => 'bg-taupe-400 text-white hover:bg-taupe-500 focus:ring-taupe-300 dark:bg-taupe-600 dark:hover:bg-taupe-500 dark:focus:ring-taupe-500',
            'mauve'   => 'bg-mauve-400 text-white hover:bg-mauve-500 focus:ring-mauve-300 dark:bg-mauve-600 dark:hover:bg-mauve-500 dark:focus:ring-mauve-500',
            'mist'    => 'bg-mist-400 text-white hover:bg-mist-500 focus:ring-mist-300 dark:bg-mist-600 dark:hover:bg-mist-500 dark:focus:ring-mist-500',
            'olive'   => 'bg-olive-400 text-white hover:bg-olive-500 focus:ring-olive-300 dark:bg-olive-600 dark:hover:bg-olive-500 dark:focus:ring-olive-500',
            'primary'    => 'bg-primary-400 text-white hover:bg-primary-500 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-500 dark:focus:ring-primary-500',
            'secondary'  => 'bg-secondary-400 text-white hover:bg-secondary-500 focus:ring-secondary-300 dark:bg-secondary-600 dark:hover:bg-secondary-500 dark:focus:ring-secondary-500',
            'accent'     => 'bg-accent-400 text-white hover:bg-accent-500 focus:ring-accent-300 dark:bg-accent-600 dark:hover:bg-accent-500 dark:focus:ring-accent-500',
            'base'       => 'bg-base-400 text-white hover:bg-base-500 focus:ring-base-300 dark:bg-base-600 dark:hover:bg-base-500 dark:focus:ring-base-500',
            'info'       => 'bg-info-400 text-white hover:bg-info-500 focus:ring-info-300 dark:bg-info-600 dark:hover:bg-info-500 dark:focus:ring-info-500',
            'success'    => 'bg-success-400 text-white hover:bg-success-500 focus:ring-success-300 dark:bg-success-600 dark:hover:bg-success-500 dark:focus:ring-success-500',
            'warning'    => 'bg-warning-400 text-white hover:bg-warning-500 focus:ring-warning-300 dark:bg-warning-600 dark:hover:bg-warning-500 dark:focus:ring-warning-500',
            'danger'     => 'bg-danger-400 text-white hover:bg-danger-500 focus:ring-danger-300 dark:bg-danger-600 dark:hover:bg-danger-500 dark:focus:ring-danger-500',
        ];

        $outlineThemeMap = [
            'slate'   => 'border-2 border-slate-300 bg-slate-50/60 text-slate-600 hover:bg-slate-100 focus:ring-slate-200 dark:border-slate-500 dark:bg-slate-900/40 dark:text-slate-200 dark:hover:bg-slate-800/60 dark:focus:ring-slate-500',
            'gray'    => 'border-2 border-gray-300 bg-gray-50/60 text-gray-600 hover:bg-gray-100 focus:ring-gray-200 dark:border-gray-500 dark:bg-gray-900/40 dark:text-gray-200 dark:hover:bg-gray-800/60 dark:focus:ring-gray-500',
            'zinc'    => 'border-2 border-zinc-300 bg-zinc-50/60 text-zinc-600 hover:bg-zinc-100 focus:ring-zinc-200 dark:border-zinc-500 dark:bg-zinc-900/40 dark:text-zinc-200 dark:hover:bg-zinc-800/60 dark:focus:ring-zinc-500',
            'neutral' => 'border-2 border-neutral-300 bg-neutral-50/60 text-neutral-600 hover:bg-neutral-100 focus:ring-neutral-200 dark:border-neutral-500 dark:bg-neutral-900/40 dark:text-neutral-200 dark:hover:bg-neutral-800/60 dark:focus:ring-neutral-500',
            'stone'   => 'border-2 border-stone-300 bg-stone-50/60 text-stone-600 hover:bg-stone-100 focus:ring-stone-200 dark:border-stone-500 dark:bg-stone-900/40 dark:text-stone-200 dark:hover:bg-stone-800/60 dark:focus:ring-stone-500',
            'red'     => 'border-2 border-red-300 bg-red-50/60 text-red-600 hover:bg-red-100 focus:ring-red-200 dark:border-red-500 dark:bg-red-950/40 dark:text-red-200 dark:hover:bg-red-900/60 dark:focus:ring-red-500',
            'orange'  => 'border-2 border-orange-300 bg-orange-50/60 text-orange-600 hover:bg-orange-100 focus:ring-orange-200 dark:border-orange-500 dark:bg-orange-950/40 dark:text-orange-200 dark:hover:bg-orange-900/60 dark:focus:ring-orange-500',
            'amber'   => 'border-2 border-amber-300 bg-amber-50/60 text-amber-600 hover:bg-amber-100 focus:ring-amber-200 dark:border-amber-500 dark:bg-amber-950/40 dark:text-amber-200 dark:hover:bg-amber-900/60 dark:focus:ring-amber-500',
            'yellow'  => 'border-2 border-yellow-300 bg-yellow-50/60 text-yellow-700 hover:bg-yellow-100 focus:ring-yellow-200 dark:border-yellow-500 dark:bg-yellow-950/40 dark:text-yellow-200 dark:hover:bg-yellow-900/60 dark:focus:ring-yellow-500',
            'lime'    => 'border-2 border-lime-300 bg-lime-50/60 text-lime-700 hover:bg-lime-100 focus:ring-lime-200 dark:border-lime-500 dark:bg-lime-950/40 dark:text-lime-200 dark:hover:bg-lime-900/60 dark:focus:ring-lime-500',
            'green'   => 'border-2 border-green-300 bg-green-50/60 text-green-600 hover:bg-green-100 focus:ring-green-200 dark:border-green-500 dark:bg-green-950/40 dark:text-green-200 dark:hover:bg-green-900/60 dark:focus:ring-green-500',
            'emerald' => 'border-2 border-emerald-300 bg-emerald-50/60 text-emerald-600 hover:bg-emerald-100 focus:ring-emerald-200 dark:border-emerald-500 dark:bg-emerald-950/40 dark:text-emerald-200 dark:hover:bg-emerald-900/60 dark:focus:ring-emerald-500',
            'teal'    => 'border-2 border-teal-300 bg-teal-50/60 text-teal-600 hover:bg-teal-100 focus:ring-teal-200 dark:border-teal-500 dark:bg-teal-950/40 dark:text-teal-200 dark:hover:bg-teal-900/60 dark:focus:ring-teal-500',
            'cyan'    => 'border-2 border-cyan-300 bg-cyan-50/60 text-cyan-600 hover:bg-cyan-100 focus:ring-cyan-200 dark:border-cyan-500 dark:bg-cyan-950/40 dark:text-cyan-200 dark:hover:bg-cyan-900/60 dark:focus:ring-cyan-500',
            'sky'     => 'border-2 border-sky-300 bg-sky-50/60 text-sky-600 hover:bg-sky-100 focus:ring-sky-200 dark:border-sky-500 dark:bg-sky-950/40 dark:text-sky-200 dark:hover:bg-sky-900/60 dark:focus:ring-sky-500',
            'blue'    => 'border-2 border-blue-300 bg-blue-50/60 text-blue-600 hover:bg-blue-100 focus:ring-blue-200 dark:border-blue-500 dark:bg-blue-950/40 dark:text-blue-200 dark:hover:bg-blue-900/60 dark:focus:ring-blue-500',
            'indigo'  => 'border-2 border-indigo-300 bg-indigo-50/60 text-indigo-600 hover:bg-indigo-100 focus:ring-indigo-200 dark:border-indigo-500 dark:bg-indigo-950/40 dark:text-indigo-200 dark:hover:bg-indigo-900/60 dark:focus:ring-indigo-500',
            'violet'  => 'border-2 border-violet-300 bg-violet-50/60 text-violet-600 hover:bg-violet-100 focus:ring-violet-200 dark:border-violet-500 dark:bg-violet-950/40 dark:text-violet-200 dark:hover:bg-violet-900/60 dark:focus:ring-violet-500',
            'purple'  => 'border-2 border-purple-300 bg-purple-50/60 text-purple-600 hover:bg-purple-100 focus:ring-purple-200 dark:border-purple-500 dark:bg-purple-950/40 dark:text-purple-200 dark:hover:bg-purple-900/60 dark:focus:ring-purple-500',
            'fuchsia' => 'border-2 border-fuchsia-300 bg-fuchsia-50/60 text-fuchsia-600 hover:bg-fuchsia-100 focus:ring-fuchsia-200 dark:border-fuchsia-500 dark:bg-fuchsia-950/40 dark:text-fuchsia-200 dark:hover:bg-fuchsia-900/60 dark:focus:ring-fuchsia-500',
            'pink'    => 'border-2 border-pink-300 bg-pink-50/60 text-pink-600 hover:bg-pink-100 focus:ring-pink-200 dark:border-pink-500 dark:bg-pink-950/40 dark:text-pink-200 dark:hover:bg-pink-900/60 dark:focus:ring-pink-500',
            'rose'    => 'border-2 border-rose-300 bg-rose-50/60 text-rose-600 hover:bg-rose-100 focus:ring-rose-200 dark:border-rose-500 dark:bg-rose-950/40 dark:text-rose-200 dark:hover:bg-rose-900/60 dark:focus:ring-rose-500',
            'taupe'   => 'border-2 border-taupe-300 bg-taupe-50/60 text-taupe-600 hover:bg-taupe-100 focus:ring-taupe-200 dark:border-taupe-500 dark:bg-taupe-950/40 dark:text-taupe-200 dark:hover:bg-taupe-900/60 dark:focus:ring-taupe-500',
            'mauve'   => 'border-2 border-mauve-300 bg-mauve-50/60 text-mauve-600 hover:bg-mauve-100 focus:ring-mauve-200 dark:border-mauve-500 dark:bg-mauve-950/40 dark:text-mauve-200 dark:hover:bg-mauve-900/60 dark:focus:ring-mauve-500',
            'mist'    => 'border-2 border-mist-300 bg-mist-50/60 text-mist-600 hover:bg-mist-100 focus:ring-mist-200 dark:border-mist-500 dark:bg-mist-950/40 dark:text-mist-200 dark:hover:bg-mist-900/60 dark:focus:ring-mist-500',
            'olive'   => 'border-2 border-olive-300 bg-olive-50/60 text-olive-600 hover:bg-olive-100 focus:ring-olive-200 dark:border-olive-500 dark:bg-olive-950/40 dark:text-olive-200 dark:hover:bg-olive-900/60 dark:focus:ring-olive-500',
            'primary'    => 'border-2 border-primary-300 bg-primary-50/60 text-primary-600 hover:bg-primary-100 focus:ring-primary-200 dark:border-primary-500 dark:bg-primary-950/40 dark:text-primary-200 dark:hover:bg-primary-900/60 dark:focus:ring-primary-500',
            'secondary'  => 'border-2 border-secondary-300 bg-secondary-50/60 text-secondary-600 hover:bg-secondary-100 focus:ring-secondary-200 dark:border-secondary-500 dark:bg-secondary-950/40 dark:text-secondary-200 dark:hover:bg-secondary-900/60 dark:focus:ring-secondary-500',
            'accent'     => 'border-2 border-accent-300 bg-accent-50/60 text-accent-600 hover:bg-accent-100 focus:ring-accent-200 dark:border-accent-500 dark:bg-accent-950/40 dark:text-accent-200 dark:hover:bg-accent-900/60 dark:focus:ring-accent-500',
            'base'       => 'border-2 border-base-300 bg-base-50/60 text-base-600 hover:bg-base-100 focus:ring-base-200 dark:border-base-500 dark:bg-base-950/40 dark:text-base-200 dark:hover:bg-base-900/60 dark:focus:ring-base-500',
            'info'       => 'border-2 border-info-300 bg-info-50/60 text-info-600 hover:bg-info-100 focus:ring-info-200 dark:border-info-500 dark:bg-info-950/40 dark:text-info-200 dark:hover:bg-info-900/60 dark:focus:ring-info-500',
            'success'    => 'border-2 border-success-300 bg-success-50/60 text-success-600 hover:bg-success-100 focus:ring-success-200 dark:border-success-500 dark:bg-success-950/40 dark:text-success-200 dark:hover:bg-success-900/60 dark:focus:ring-success-500',
            'warning'    => 'border-2 border-warning-300 bg-warning-50/60 text-warning-600 hover:bg-warning-100 focus:ring-warning-200 dark:border-warning-500 dark:bg-warning-950/40 dark:text-warning-200 dark:hover:bg-warning-900/60 dark:focus:ring-warning-500',
            'danger'     => 'border-2 border-danger-300 bg-danger-50/60 text-danger-600 hover:bg-danger-100 focus:ring-danger-200 dark:border-danger-500 dark:bg-danger-950/40 dark:text-danger-200 dark:hover:bg-danger-900/60 dark:focus:ring-danger-500',
        ];

        // Ghost: no fill or frame until hovered (toolbar and icon buttons).
        $ghostThemeMap = [
            'slate'     => 'bg-transparent text-slate-700 hover:bg-slate-100 focus:ring-slate-300 dark:text-slate-300 dark:hover:bg-slate-800/60 dark:focus:ring-slate-600',
            'gray'      => 'bg-transparent text-gray-700 hover:bg-gray-100 focus:ring-gray-300 dark:text-gray-300 dark:hover:bg-gray-800/60 dark:focus:ring-gray-600',
            'zinc'      => 'bg-transparent text-zinc-700 hover:bg-zinc-100 focus:ring-zinc-300 dark:text-zinc-300 dark:hover:bg-zinc-800/60 dark:focus:ring-zinc-600',
            'neutral'   => 'bg-transparent text-neutral-700 hover:bg-neutral-100 focus:ring-neutral-300 dark:text-neutral-300 dark:hover:bg-neutral-800/60 dark:focus:ring-neutral-600',
            'stone'     => 'bg-transparent text-stone-700 hover:bg-stone-100 focus:ring-stone-300 dark:text-stone-300 dark:hover:bg-stone-800/60 dark:focus:ring-stone-600',
            'red'       => 'bg-transparent text-red-700 hover:bg-red-100 focus:ring-red-300 dark:text-red-300 dark:hover:bg-red-800/60 dark:focus:ring-red-600',
            'orange'    => 'bg-transparent text-orange-700 hover:bg-orange-100 focus:ring-orange-300 dark:text-orange-300 dark:hover:bg-orange-800/60 dark:focus:ring-orange-600',
            'amber'     => 'bg-transparent text-amber-700 hover:bg-amber-100 focus:ring-amber-300 dark:text-amber-300 dark:hover:bg-amber-800/60 dark:focus:ring-amber-600',
            'yellow'    => 'bg-transparent text-yellow-700 hover:bg-yellow-100 focus:ring-yellow-300 dark:text-yellow-300 dark:hover:bg-yellow-800/60 dark:focus:ring-yellow-600',
            'lime'      => 'bg-transparent text-lime-700 hover:bg-lime-100 focus:ring-lime-300 dark:text-lime-300 dark:hover:bg-lime-800/60 dark:focus:ring-lime-600',
            'green'     => 'bg-transparent text-green-700 hover:bg-green-100 focus:ring-green-300 dark:text-green-300 dark:hover:bg-green-800/60 dark:focus:ring-green-600',
            'emerald'   => 'bg-transparent text-emerald-700 hover:bg-emerald-100 focus:ring-emerald-300 dark:text-emerald-300 dark:hover:bg-emerald-800/60 dark:focus:ring-emerald-600',
            'teal'      => 'bg-transparent text-teal-700 hover:bg-teal-100 focus:ring-teal-300 dark:text-teal-300 dark:hover:bg-teal-800/60 dark:focus:ring-teal-600',
            'cyan'      => 'bg-transparent text-cyan-700 hover:bg-cyan-100 focus:ring-cyan-300 dark:text-cyan-300 dark:hover:bg-cyan-800/60 dark:focus:ring-cyan-600',
            'sky'       => 'bg-transparent text-sky-700 hover:bg-sky-100 focus:ring-sky-300 dark:text-sky-300 dark:hover:bg-sky-800/60 dark:focus:ring-sky-600',
            'blue'      => 'bg-transparent text-blue-700 hover:bg-blue-100 focus:ring-blue-300 dark:text-blue-300 dark:hover:bg-blue-800/60 dark:focus:ring-blue-600',
            'indigo'    => 'bg-transparent text-indigo-700 hover:bg-indigo-100 focus:ring-indigo-300 dark:text-indigo-300 dark:hover:bg-indigo-800/60 dark:focus:ring-indigo-600',
            'violet'    => 'bg-transparent text-violet-700 hover:bg-violet-100 focus:ring-violet-300 dark:text-violet-300 dark:hover:bg-violet-800/60 dark:focus:ring-violet-600',
            'purple'    => 'bg-transparent text-purple-700 hover:bg-purple-100 focus:ring-purple-300 dark:text-purple-300 dark:hover:bg-purple-800/60 dark:focus:ring-purple-600',
            'fuchsia'   => 'bg-transparent text-fuchsia-700 hover:bg-fuchsia-100 focus:ring-fuchsia-300 dark:text-fuchsia-300 dark:hover:bg-fuchsia-800/60 dark:focus:ring-fuchsia-600',
            'pink'      => 'bg-transparent text-pink-700 hover:bg-pink-100 focus:ring-pink-300 dark:text-pink-300 dark:hover:bg-pink-800/60 dark:focus:ring-pink-600',
            'rose'      => 'bg-transparent text-rose-700 hover:bg-rose-100 focus:ring-rose-300 dark:text-rose-300 dark:hover:bg-rose-800/60 dark:focus:ring-rose-600',
            'taupe'     => 'bg-transparent text-taupe-700 hover:bg-taupe-100 focus:ring-taupe-300 dark:text-taupe-300 dark:hover:bg-taupe-800/60 dark:focus:ring-taupe-600',
            'mauve'     => 'bg-transparent text-mauve-700 hover:bg-mauve-100 focus:ring-mauve-300 dark:text-mauve-300 dark:hover:bg-mauve-800/60 dark:focus:ring-mauve-600',
            'mist'      => 'bg-transparent text-mist-700 hover:bg-mist-100 focus:ring-mist-300 dark:text-mist-300 dark:hover:bg-mist-800/60 dark:focus:ring-mist-600',
            'olive'     => 'bg-transparent text-olive-700 hover:bg-olive-100 focus:ring-olive-300 dark:text-olive-300 dark:hover:bg-olive-800/60 dark:focus:ring-olive-600',
            'primary'   => 'bg-transparent text-primary-700 hover:bg-primary-100 focus:ring-primary-300 dark:text-primary-300 dark:hover:bg-primary-800/60 dark:focus:ring-primary-600',
            'secondary' => 'bg-transparent text-secondary-700 hover:bg-secondary-100 focus:ring-secondary-300 dark:text-secondary-300 dark:hover:bg-secondary-800/60 dark:focus:ring-secondary-600',
            'accent'    => 'bg-transparent text-accent-700 hover:bg-accent-100 focus:ring-accent-300 dark:text-accent-300 dark:hover:bg-accent-800/60 dark:focus:ring-accent-600',
            'base'      => 'bg-transparent text-base-700 hover:bg-base-100 focus:ring-base-300 dark:text-base-300 dark:hover:bg-base-800/60 dark:focus:ring-base-600',
            'info'      => 'bg-transparent text-info-700 hover:bg-info-100 focus:ring-info-300 dark:text-info-300 dark:hover:bg-info-800/60 dark:focus:ring-info-600',
            'success'   => 'bg-transparent text-success-700 hover:bg-success-100 focus:ring-success-300 dark:text-success-300 dark:hover:bg-success-800/60 dark:focus:ring-success-600',
            'warning'   => 'bg-transparent text-warning-700 hover:bg-warning-100 focus:ring-warning-300 dark:text-warning-300 dark:hover:bg-warning-800/60 dark:focus:ring-warning-600',
            'danger'    => 'bg-transparent text-danger-700 hover:bg-danger-100 focus:ring-danger-300 dark:text-danger-300 dark:hover:bg-danger-800/60 dark:focus:ring-danger-600',
        ];

        // Link: text that acts as a button, underlined on hover.
        $linkThemeMap = [
            'slate'     => 'bg-transparent text-slate-600 decoration-slate-600/40 hover:underline hover:text-slate-800 focus:ring-slate-300 dark:text-slate-400 dark:decoration-slate-400/40 dark:hover:text-slate-200 dark:focus:ring-slate-600',
            'gray'      => 'bg-transparent text-gray-600 decoration-gray-600/40 hover:underline hover:text-gray-800 focus:ring-gray-300 dark:text-gray-400 dark:decoration-gray-400/40 dark:hover:text-gray-200 dark:focus:ring-gray-600',
            'zinc'      => 'bg-transparent text-zinc-600 decoration-zinc-600/40 hover:underline hover:text-zinc-800 focus:ring-zinc-300 dark:text-zinc-400 dark:decoration-zinc-400/40 dark:hover:text-zinc-200 dark:focus:ring-zinc-600',
            'neutral'   => 'bg-transparent text-neutral-600 decoration-neutral-600/40 hover:underline hover:text-neutral-800 focus:ring-neutral-300 dark:text-neutral-400 dark:decoration-neutral-400/40 dark:hover:text-neutral-200 dark:focus:ring-neutral-600',
            'stone'     => 'bg-transparent text-stone-600 decoration-stone-600/40 hover:underline hover:text-stone-800 focus:ring-stone-300 dark:text-stone-400 dark:decoration-stone-400/40 dark:hover:text-stone-200 dark:focus:ring-stone-600',
            'red'       => 'bg-transparent text-red-600 decoration-red-600/40 hover:underline hover:text-red-800 focus:ring-red-300 dark:text-red-400 dark:decoration-red-400/40 dark:hover:text-red-200 dark:focus:ring-red-600',
            'orange'    => 'bg-transparent text-orange-600 decoration-orange-600/40 hover:underline hover:text-orange-800 focus:ring-orange-300 dark:text-orange-400 dark:decoration-orange-400/40 dark:hover:text-orange-200 dark:focus:ring-orange-600',
            'amber'     => 'bg-transparent text-amber-600 decoration-amber-600/40 hover:underline hover:text-amber-800 focus:ring-amber-300 dark:text-amber-400 dark:decoration-amber-400/40 dark:hover:text-amber-200 dark:focus:ring-amber-600',
            'yellow'    => 'bg-transparent text-yellow-600 decoration-yellow-600/40 hover:underline hover:text-yellow-800 focus:ring-yellow-300 dark:text-yellow-400 dark:decoration-yellow-400/40 dark:hover:text-yellow-200 dark:focus:ring-yellow-600',
            'lime'      => 'bg-transparent text-lime-600 decoration-lime-600/40 hover:underline hover:text-lime-800 focus:ring-lime-300 dark:text-lime-400 dark:decoration-lime-400/40 dark:hover:text-lime-200 dark:focus:ring-lime-600',
            'green'     => 'bg-transparent text-green-600 decoration-green-600/40 hover:underline hover:text-green-800 focus:ring-green-300 dark:text-green-400 dark:decoration-green-400/40 dark:hover:text-green-200 dark:focus:ring-green-600',
            'emerald'   => 'bg-transparent text-emerald-600 decoration-emerald-600/40 hover:underline hover:text-emerald-800 focus:ring-emerald-300 dark:text-emerald-400 dark:decoration-emerald-400/40 dark:hover:text-emerald-200 dark:focus:ring-emerald-600',
            'teal'      => 'bg-transparent text-teal-600 decoration-teal-600/40 hover:underline hover:text-teal-800 focus:ring-teal-300 dark:text-teal-400 dark:decoration-teal-400/40 dark:hover:text-teal-200 dark:focus:ring-teal-600',
            'cyan'      => 'bg-transparent text-cyan-600 decoration-cyan-600/40 hover:underline hover:text-cyan-800 focus:ring-cyan-300 dark:text-cyan-400 dark:decoration-cyan-400/40 dark:hover:text-cyan-200 dark:focus:ring-cyan-600',
            'sky'       => 'bg-transparent text-sky-600 decoration-sky-600/40 hover:underline hover:text-sky-800 focus:ring-sky-300 dark:text-sky-400 dark:decoration-sky-400/40 dark:hover:text-sky-200 dark:focus:ring-sky-600',
            'blue'      => 'bg-transparent text-blue-600 decoration-blue-600/40 hover:underline hover:text-blue-800 focus:ring-blue-300 dark:text-blue-400 dark:decoration-blue-400/40 dark:hover:text-blue-200 dark:focus:ring-blue-600',
            'indigo'    => 'bg-transparent text-indigo-600 decoration-indigo-600/40 hover:underline hover:text-indigo-800 focus:ring-indigo-300 dark:text-indigo-400 dark:decoration-indigo-400/40 dark:hover:text-indigo-200 dark:focus:ring-indigo-600',
            'violet'    => 'bg-transparent text-violet-600 decoration-violet-600/40 hover:underline hover:text-violet-800 focus:ring-violet-300 dark:text-violet-400 dark:decoration-violet-400/40 dark:hover:text-violet-200 dark:focus:ring-violet-600',
            'purple'    => 'bg-transparent text-purple-600 decoration-purple-600/40 hover:underline hover:text-purple-800 focus:ring-purple-300 dark:text-purple-400 dark:decoration-purple-400/40 dark:hover:text-purple-200 dark:focus:ring-purple-600',
            'fuchsia'   => 'bg-transparent text-fuchsia-600 decoration-fuchsia-600/40 hover:underline hover:text-fuchsia-800 focus:ring-fuchsia-300 dark:text-fuchsia-400 dark:decoration-fuchsia-400/40 dark:hover:text-fuchsia-200 dark:focus:ring-fuchsia-600',
            'pink'      => 'bg-transparent text-pink-600 decoration-pink-600/40 hover:underline hover:text-pink-800 focus:ring-pink-300 dark:text-pink-400 dark:decoration-pink-400/40 dark:hover:text-pink-200 dark:focus:ring-pink-600',
            'rose'      => 'bg-transparent text-rose-600 decoration-rose-600/40 hover:underline hover:text-rose-800 focus:ring-rose-300 dark:text-rose-400 dark:decoration-rose-400/40 dark:hover:text-rose-200 dark:focus:ring-rose-600',
            'taupe'     => 'bg-transparent text-taupe-600 decoration-taupe-600/40 hover:underline hover:text-taupe-800 focus:ring-taupe-300 dark:text-taupe-400 dark:decoration-taupe-400/40 dark:hover:text-taupe-200 dark:focus:ring-taupe-600',
            'mauve'     => 'bg-transparent text-mauve-600 decoration-mauve-600/40 hover:underline hover:text-mauve-800 focus:ring-mauve-300 dark:text-mauve-400 dark:decoration-mauve-400/40 dark:hover:text-mauve-200 dark:focus:ring-mauve-600',
            'mist'      => 'bg-transparent text-mist-600 decoration-mist-600/40 hover:underline hover:text-mist-800 focus:ring-mist-300 dark:text-mist-400 dark:decoration-mist-400/40 dark:hover:text-mist-200 dark:focus:ring-mist-600',
            'olive'     => 'bg-transparent text-olive-600 decoration-olive-600/40 hover:underline hover:text-olive-800 focus:ring-olive-300 dark:text-olive-400 dark:decoration-olive-400/40 dark:hover:text-olive-200 dark:focus:ring-olive-600',
            'primary'   => 'bg-transparent text-primary-600 decoration-primary-600/40 hover:underline hover:text-primary-800 focus:ring-primary-300 dark:text-primary-400 dark:decoration-primary-400/40 dark:hover:text-primary-200 dark:focus:ring-primary-600',
            'secondary' => 'bg-transparent text-secondary-600 decoration-secondary-600/40 hover:underline hover:text-secondary-800 focus:ring-secondary-300 dark:text-secondary-400 dark:decoration-secondary-400/40 dark:hover:text-secondary-200 dark:focus:ring-secondary-600',
            'accent'    => 'bg-transparent text-accent-600 decoration-accent-600/40 hover:underline hover:text-accent-800 focus:ring-accent-300 dark:text-accent-400 dark:decoration-accent-400/40 dark:hover:text-accent-200 dark:focus:ring-accent-600',
            'base'      => 'bg-transparent text-base-600 decoration-base-600/40 hover:underline hover:text-base-800 focus:ring-base-300 dark:text-base-400 dark:decoration-base-400/40 dark:hover:text-base-200 dark:focus:ring-base-600',
            'info'      => 'bg-transparent text-info-600 decoration-info-600/40 hover:underline hover:text-info-800 focus:ring-info-300 dark:text-info-400 dark:decoration-info-400/40 dark:hover:text-info-200 dark:focus:ring-info-600',
            'success'   => 'bg-transparent text-success-600 decoration-success-600/40 hover:underline hover:text-success-800 focus:ring-success-300 dark:text-success-400 dark:decoration-success-400/40 dark:hover:text-success-200 dark:focus:ring-success-600',
            'warning'   => 'bg-transparent text-warning-600 decoration-warning-600/40 hover:underline hover:text-warning-800 focus:ring-warning-300 dark:text-warning-400 dark:decoration-warning-400/40 dark:hover:text-warning-200 dark:focus:ring-warning-600',
            'danger'    => 'bg-transparent text-danger-600 decoration-danger-600/40 hover:underline hover:text-danger-800 focus:ring-danger-300 dark:text-danger-400 dark:decoration-danger-400/40 dark:hover:text-danger-200 dark:focus:ring-danger-600',
        ];

        $widthMap = [
            'fit' => 'w-fit',
            'full' => 'w-full',
        ];

        $heightMap = [
            'xs' => 'h-8',
            'sm' => 'h-9',
            'md' => 'h-10',
            'lg' => 'h-11',
            'xl' => 'h-12',
            'auto' => 'h-auto',
        ];

        $this->heightStyle = '';
        $trimmedHeight = trim($height);

        $heightClasses = '';
        $pixelHeight = null;

        if (isset($heightMap[$trimmedHeight])) {
            $heightClasses = $heightMap[$trimmedHeight];
        } elseif (preg_match('/^\d+(?:\.\d+)?(?:px)?$/', $trimmedHeight) === 1) {
            $pixelHeight = str_ends_with($trimmedHeight, 'px') ? $trimmedHeight : $trimmedHeight.'px';
            $heightClasses = '';
            $this->heightStyle = 'height: '.$pixelHeight.';';
        } else {
            $heightClasses = $heightMap['md'];
        }

        $variantMap = [
            'solid' => $solidThemeMap,
            'outline' => $outlineThemeMap,
            'ghost' => $ghostThemeMap,
            'link' => $linkThemeMap,
        ];

        $selectedVariant = strtolower(trim($variant));
        $selectedVariant = isset($variantMap[$selectedVariant]) ? $selectedVariant : 'solid';
        $selectedThemeMap = $variantMap[$selectedVariant];

        // A square button (icon only) is as wide as it is high.
        $squareWidthMap = ['xs' => 'w-8', 'sm' => 'w-9', 'md' => 'w-10', 'lg' => 'w-11', 'xl' => 'w-12', 'auto' => 'aspect-square'];

        if ($selectedVariant === 'link') {
            // Inline text: no box, so no fixed height or padding.
            $sizeClasses = 'h-auto rounded-sm font-medium';
            $this->heightStyle = '';
        } elseif ($square) {
            $squareWidth = $pixelHeight === null ? ($squareWidthMap[$trimmedHeight] ?? $squareWidthMap['md']) : '';
            $sizeClasses = $heightClasses.' '.$squareWidth.' shrink-0 rounded-md px-0 py-0 font-semibold';
            $this->heightStyle .= $pixelHeight === null ? '' : ' width: '.$pixelHeight.';';
        } else {
            $sizeClasses = $heightClasses.' rounded-md px-4 py-2 font-semibold';
        }

        $this->classList = trim(implode(' ', [
            // Variant part hook (fltc-button-solid / -outline / -ghost / -textlink) for skin
            // stylesheets; the link variant's hook avoids fltc-button-link, the button.link hook.
            'fltc-button-'.($selectedVariant === 'link' ? 'textlink' : $selectedVariant),
            $square ? 'fltc-button-square' : '',
            $selectedThemeMap[$color] ?? $selectedThemeMap['base'],
            $square ? '' : ($widthMap[$width] ?? $widthMap['fit']),
            $sizeClasses,
            'cursor-pointer inline-flex items-center justify-center text-sm transition focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-900',
            $disabled ? 'cursor-not-allowed opacity-60 pointer-events-none' : '',
            $class,
        ]));
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.button');
    }
}
