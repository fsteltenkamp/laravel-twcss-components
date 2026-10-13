<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form\Container\Auth;

use Closure;
use Illuminate\Contracts\View\View;
use Fsteltenkamp\TwcssComponents\View\Component;

class TwoColLeft extends Component
{
    public string $classList;
    public string $mainClasses;
    public string $sideClasses;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $color = 'base',
        public string $class = '',
        public ?string $id = null,
    ) {
        $themeMap = [
            'slate' => [
                'shell' => 'border-slate-200 bg-white/95 dark:border-slate-700 dark:bg-slate-900/90',
                'side' => 'border-slate-200 bg-slate-50 text-slate-900 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100',
            ],
            'gray' => [
                'shell' => 'border-gray-200 bg-white/95 dark:border-gray-700 dark:bg-gray-900/90',
                'side' => 'border-gray-200 bg-gray-50 text-gray-900 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100',
            ],
            'zinc' => [
                'shell' => 'border-zinc-200 bg-white/95 dark:border-zinc-700 dark:bg-zinc-900/90',
                'side' => 'border-zinc-200 bg-zinc-50 text-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100',
            ],
            'neutral' => [
                'shell' => 'border-neutral-200 bg-white/95 dark:border-neutral-700 dark:bg-neutral-900/90',
                'side' => 'border-neutral-200 bg-neutral-50 text-neutral-900 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-100',
            ],
            'stone' => [
                'shell' => 'border-stone-200 bg-white/95 dark:border-stone-700 dark:bg-stone-900/90',
                'side' => 'border-stone-200 bg-stone-50 text-stone-900 dark:border-stone-700 dark:bg-stone-950 dark:text-stone-100',
            ],
            'red' => [
                'shell' => 'border-red-200 bg-white/95 dark:border-red-800 dark:bg-red-950/50',
                'side' => 'border-red-200 bg-red-50 text-red-900 dark:border-red-800 dark:bg-red-950 dark:text-red-100',
            ],
            'orange' => [
                'shell' => 'border-orange-200 bg-white/95 dark:border-orange-800 dark:bg-orange-950/50',
                'side' => 'border-orange-200 bg-orange-50 text-orange-900 dark:border-orange-800 dark:bg-orange-950 dark:text-orange-100',
            ],
            'amber' => [
                'shell' => 'border-amber-200 bg-white/95 dark:border-amber-800 dark:bg-amber-950/50',
                'side' => 'border-amber-200 bg-amber-50 text-amber-900 dark:border-amber-800 dark:bg-amber-950 dark:text-amber-100',
            ],
            'yellow' => [
                'shell' => 'border-yellow-200 bg-white/95 dark:border-yellow-800 dark:bg-yellow-950/50',
                'side' => 'border-yellow-200 bg-yellow-50 text-yellow-900 dark:border-yellow-800 dark:bg-yellow-950 dark:text-yellow-100',
            ],
            'lime' => [
                'shell' => 'border-lime-200 bg-white/95 dark:border-lime-800 dark:bg-lime-950/50',
                'side' => 'border-lime-200 bg-lime-50 text-lime-900 dark:border-lime-800 dark:bg-lime-950 dark:text-lime-100',
            ],
            'green' => [
                'shell' => 'border-green-200 bg-white/95 dark:border-green-800 dark:bg-green-950/50',
                'side' => 'border-green-200 bg-green-50 text-green-900 dark:border-green-800 dark:bg-green-950 dark:text-green-100',
            ],
            'emerald' => [
                'shell' => 'border-emerald-200 bg-white/95 dark:border-emerald-800 dark:bg-emerald-950/50',
                'side' => 'border-emerald-200 bg-emerald-50 text-emerald-900 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-100',
            ],
            'teal' => [
                'shell' => 'border-teal-200 bg-white/95 dark:border-teal-800 dark:bg-teal-950/50',
                'side' => 'border-teal-200 bg-teal-50 text-teal-900 dark:border-teal-800 dark:bg-teal-950 dark:text-teal-100',
            ],
            'cyan' => [
                'shell' => 'border-cyan-200 bg-white/95 dark:border-cyan-800 dark:bg-cyan-950/50',
                'side' => 'border-cyan-200 bg-cyan-50 text-cyan-900 dark:border-cyan-800 dark:bg-cyan-950 dark:text-cyan-100',
            ],
            'sky' => [
                'shell' => 'border-sky-200 bg-white/95 dark:border-sky-800 dark:bg-sky-950/50',
                'side' => 'border-sky-200 bg-sky-50 text-sky-900 dark:border-sky-800 dark:bg-sky-950 dark:text-sky-100',
            ],
            'blue' => [
                'shell' => 'border-blue-200 bg-white/95 dark:border-blue-800 dark:bg-blue-950/50',
                'side' => 'border-blue-200 bg-blue-50 text-blue-900 dark:border-blue-800 dark:bg-blue-950 dark:text-blue-100',
            ],
            'indigo' => [
                'shell' => 'border-indigo-200 bg-white/95 dark:border-indigo-800 dark:bg-indigo-950/50',
                'side' => 'border-indigo-200 bg-indigo-50 text-indigo-900 dark:border-indigo-800 dark:bg-indigo-950 dark:text-indigo-100',
            ],
            'violet' => [
                'shell' => 'border-violet-200 bg-white/95 dark:border-violet-800 dark:bg-violet-950/50',
                'side' => 'border-violet-200 bg-violet-50 text-violet-900 dark:border-violet-800 dark:bg-violet-950 dark:text-violet-100',
            ],
            'purple' => [
                'shell' => 'border-purple-200 bg-white/95 dark:border-purple-800 dark:bg-purple-950/50',
                'side' => 'border-purple-200 bg-purple-50 text-purple-900 dark:border-purple-800 dark:bg-purple-950 dark:text-purple-100',
            ],
            'fuchsia' => [
                'shell' => 'border-fuchsia-200 bg-white/95 dark:border-fuchsia-800 dark:bg-fuchsia-950/50',
                'side' => 'border-fuchsia-200 bg-fuchsia-50 text-fuchsia-900 dark:border-fuchsia-800 dark:bg-fuchsia-950 dark:text-fuchsia-100',
            ],
            'pink' => [
                'shell' => 'border-pink-200 bg-white/95 dark:border-pink-800 dark:bg-pink-950/50',
                'side' => 'border-pink-200 bg-pink-50 text-pink-900 dark:border-pink-800 dark:bg-pink-950 dark:text-pink-100',
            ],
            'rose' => [
                'shell' => 'border-rose-200 bg-white/95 dark:border-rose-800 dark:bg-rose-950/50',
                'side' => 'border-rose-200 bg-rose-50 text-rose-900 dark:border-rose-800 dark:bg-rose-950 dark:text-rose-100',
            ],
            'taupe' => [
                'shell' => 'border-taupe-200 bg-white/95 dark:border-taupe-800 dark:bg-taupe-950/50',
                'side' => 'border-taupe-200 bg-taupe-50 text-taupe-900 dark:border-taupe-800 dark:bg-taupe-950 dark:text-taupe-100',
            ],
            'mauve' => [
                'shell' => 'border-mauve-200 bg-white/95 dark:border-mauve-800 dark:bg-mauve-950/50',
                'side' => 'border-mauve-200 bg-mauve-50 text-mauve-900 dark:border-mauve-800 dark:bg-mauve-950 dark:text-mauve-100',
            ],
            'mist' => [
                'shell' => 'border-mist-200 bg-white/95 dark:border-mist-800 dark:bg-mist-950/50',
                'side' => 'border-mist-200 bg-mist-50 text-mist-900 dark:border-mist-800 dark:bg-mist-950 dark:text-mist-100',
            ],
            'olive' => [
                'shell' => 'border-olive-200 bg-white/95 dark:border-olive-800 dark:bg-olive-950/50',
                'side' => 'border-olive-200 bg-olive-50 text-olive-900 dark:border-olive-800 dark:bg-olive-950 dark:text-olive-100',
            ],
            'primary'  => [
                'shell' => 'border-primary-200 bg-white/95 dark:border-primary-800 dark:bg-primary-950/50',
                'side' => 'border-primary-200 bg-primary-50 text-primary-900 dark:border-primary-800 dark:bg-primary-950 dark:text-primary-100',
            ],
            'secondary' => [
                'shell' => 'border-secondary-200 bg-white/95 dark:border-secondary-800 dark:bg-secondary-950/50',
                'side' => 'border-secondary-200 bg-secondary-50 text-secondary-900 dark:border-secondary-800 dark:bg-secondary-950 dark:text-secondary-100',
            ],
            'accent'   => [
                'shell' => 'border-accent-200 bg-white/95 dark:border-accent-800 dark:bg-accent-950/50',
                'side' => 'border-accent-200 bg-accent-50 text-accent-900 dark:border-accent-800 dark:bg-accent-950 dark:text-accent-100',
            ],
            'base'     => [
                'shell' => 'border-base-200 bg-white/95 dark:border-base-800 dark:bg-base-950/50',
                'side' => 'border-base-200 bg-base-50 text-base-900 dark:border-base-800 dark:bg-base-950 dark:text-base-100',
            ],
            'info'     => [
                'shell' => 'border-info-200 bg-white/95 dark:border-info-800 dark:bg-info-950/50',
                'side' => 'border-info-200 bg-info-50 text-info-900 dark:border-info-800 dark:bg-info-950 dark:text-info-100',
            ],
            'success'  => [
                'shell' => 'border-success-200 bg-white/95 dark:border-success-800 dark:bg-success-950/50',
                'side' => 'border-success-200 bg-success-50 text-success-900 dark:border-success-800 dark:bg-success-950 dark:text-success-100',
            ],
            'warning'  => [
                'shell' => 'border-warning-200 bg-white/95 dark:border-warning-800 dark:bg-warning-950/50',
                'side' => 'border-warning-200 bg-warning-50 text-warning-900 dark:border-warning-800 dark:bg-warning-950 dark:text-warning-100',
            ],
            'danger'   => [
                'shell' => 'border-danger-200 bg-white/95 dark:border-danger-800 dark:bg-danger-950/50',
                'side' => 'border-danger-200 bg-danger-50 text-danger-900 dark:border-danger-800 dark:bg-danger-950 dark:text-danger-100',
            ],
        ];

        $themeClasses = $themeMap[$this->color] ?? $themeMap['base'];

        $this->classList = trim(implode(' ', [
            'overflow-hidden rounded-2xl border shadow-2xl backdrop-blur',
            $themeClasses['shell'],
            $this->class,
        ]));

        $this->mainClasses = 'flex items-center p-6 sm:p-10 md:col-span-7';
        $this->sideClasses = trim(implode(' ', [
            'hidden h-full border-r p-10 md:col-span-5 md:block',
            $themeClasses['side'],
        ]));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.form.container.auth.two-col-left');
    }
}
