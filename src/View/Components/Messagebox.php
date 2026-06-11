<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Messagebox extends Component
{
    public string $boxClasses = '';
    public string $titleClasses = '';

    /**
     * Create a new component instance.
     */
    public function __construct(public string $theme = 'gray', public string $title = '')
    {
        $themeMap = [
            'slate'   => 'border-slate-200 bg-slate-50 text-slate-800 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200',
            'gray'    => 'border-gray-200 bg-gray-50 text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200',
            'zinc'    => 'border-zinc-200 bg-zinc-50 text-zinc-800 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200',
            'neutral' => 'border-neutral-200 bg-neutral-50 text-neutral-800 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-200',
            'stone'   => 'border-stone-200 bg-stone-50 text-stone-800 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-200',
            'red'     => 'border-red-200 bg-red-50 text-red-800 dark:border-red-800 dark:bg-red-950 dark:text-red-200',
            'orange'  => 'border-orange-200 bg-orange-50 text-orange-800 dark:border-orange-800 dark:bg-orange-950 dark:text-orange-200',
            'amber'   => 'border-amber-200 bg-amber-50 text-amber-800 dark:border-amber-800 dark:bg-amber-950 dark:text-amber-200',
            'yellow'  => 'border-yellow-200 bg-yellow-50 text-yellow-800 dark:border-yellow-800 dark:bg-yellow-950 dark:text-yellow-200',
            'lime'    => 'border-lime-200 bg-lime-50 text-lime-800 dark:border-lime-800 dark:bg-lime-950 dark:text-lime-200',
            'green'   => 'border-green-200 bg-green-50 text-green-800 dark:border-green-800 dark:bg-green-950 dark:text-green-200',
            'emerald' => 'border-emerald-200 bg-emerald-50 text-emerald-800 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200',
            'teal'    => 'border-teal-200 bg-teal-50 text-teal-800 dark:border-teal-800 dark:bg-teal-950 dark:text-teal-200',
            'cyan'    => 'border-cyan-200 bg-cyan-50 text-cyan-800 dark:border-cyan-800 dark:bg-cyan-950 dark:text-cyan-200',
            'sky'     => 'border-sky-200 bg-sky-50 text-sky-800 dark:border-sky-800 dark:bg-sky-950 dark:text-sky-200',
            'blue'    => 'border-blue-200 bg-blue-50 text-blue-800 dark:border-blue-800 dark:bg-blue-950 dark:text-blue-200',
            'indigo'  => 'border-indigo-200 bg-indigo-50 text-indigo-800 dark:border-indigo-800 dark:bg-indigo-950 dark:text-indigo-200',
            'violet'  => 'border-violet-200 bg-violet-50 text-violet-800 dark:border-violet-800 dark:bg-violet-950 dark:text-violet-200',
            'purple'  => 'border-purple-200 bg-purple-50 text-purple-800 dark:border-purple-800 dark:bg-purple-950 dark:text-purple-200',
            'fuchsia' => 'border-fuchsia-200 bg-fuchsia-50 text-fuchsia-800 dark:border-fuchsia-800 dark:bg-fuchsia-950 dark:text-fuchsia-200',
            'pink'    => 'border-pink-200 bg-pink-50 text-pink-800 dark:border-pink-800 dark:bg-pink-950 dark:text-pink-200',
            'rose'    => 'border-rose-200 bg-rose-50 text-rose-800 dark:border-rose-800 dark:bg-rose-950 dark:text-rose-200',
            'taupe'   => 'border-taupe-200 bg-taupe-50 text-taupe-800 dark:border-taupe-800 dark:bg-taupe-950 dark:text-taupe-200',
            'mauve'   => 'border-mauve-200 bg-mauve-50 text-mauve-800 dark:border-mauve-800 dark:bg-mauve-950 dark:text-mauve-200',
            'mist'    => 'border-mist-200 bg-mist-50 text-mist-800 dark:border-mist-800 dark:bg-mist-950 dark:text-mist-200',
            'olive'   => 'border-olive-200 bg-olive-50 text-olive-800 dark:border-olive-800 dark:bg-olive-950 dark:text-olive-200',
        ];

        $titleMap = [
            'slate'   => 'bg-slate-200 text-slate-900 dark:bg-slate-800 dark:text-slate-100',
            'gray'    => 'bg-gray-200 text-gray-900 dark:bg-gray-800 dark:text-gray-100',
            'zinc'    => 'bg-zinc-200 text-zinc-900 dark:bg-zinc-800 dark:text-zinc-100',
            'neutral' => 'bg-neutral-200 text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100',
            'stone'   => 'bg-stone-200 text-stone-900 dark:bg-stone-800 dark:text-stone-100',
            'red'     => 'bg-red-200 text-red-900 dark:bg-red-900 dark:text-red-100',
            'orange'  => 'bg-orange-200 text-orange-900 dark:bg-orange-900 dark:text-orange-100',
            'amber'   => 'bg-amber-200 text-amber-900 dark:bg-amber-900 dark:text-amber-100',
            'yellow'  => 'bg-yellow-200 text-yellow-900 dark:bg-yellow-900 dark:text-yellow-100',
            'lime'    => 'bg-lime-200 text-lime-900 dark:bg-lime-900 dark:text-lime-100',
            'green'   => 'bg-green-200 text-green-900 dark:bg-green-900 dark:text-green-100',
            'emerald' => 'bg-emerald-200 text-emerald-900 dark:bg-emerald-900 dark:text-emerald-100',
            'teal'    => 'bg-teal-200 text-teal-900 dark:bg-teal-900 dark:text-teal-100',
            'cyan'    => 'bg-cyan-200 text-cyan-900 dark:bg-cyan-900 dark:text-cyan-100',
            'sky'     => 'bg-sky-200 text-sky-900 dark:bg-sky-900 dark:text-sky-100',
            'blue'    => 'bg-blue-200 text-blue-900 dark:bg-blue-900 dark:text-blue-100',
            'indigo'  => 'bg-indigo-200 text-indigo-900 dark:bg-indigo-900 dark:text-indigo-100',
            'violet'  => 'bg-violet-200 text-violet-900 dark:bg-violet-900 dark:text-violet-100',
            'purple'  => 'bg-purple-200 text-purple-900 dark:bg-purple-900 dark:text-purple-100',
            'fuchsia' => 'bg-fuchsia-200 text-fuchsia-900 dark:bg-fuchsia-900 dark:text-fuchsia-100',
            'pink'    => 'bg-pink-200 text-pink-900 dark:bg-pink-900 dark:text-pink-100',
            'rose'    => 'bg-rose-200 text-rose-900 dark:bg-rose-900 dark:text-rose-100',
            'taupe'   => 'bg-taupe-200 text-taupe-900 dark:bg-taupe-900 dark:text-taupe-100',
            'mauve'   => 'bg-mauve-200 text-mauve-900 dark:bg-mauve-900 dark:text-mauve-100',
            'mist'    => 'bg-mist-200 text-mist-900 dark:bg-mist-900 dark:text-mist-100',
            'olive'   => 'bg-olive-200 text-olive-900 dark:bg-olive-900 dark:text-olive-100',
        ];

        $titleBorderMap = [
            'slate'   => 'border-slate-300 dark:border-slate-700',
            'gray'    => 'border-gray-300 dark:border-gray-700',
            'zinc'    => 'border-zinc-300 dark:border-zinc-700',
            'neutral' => 'border-neutral-300 dark:border-neutral-700',
            'stone'   => 'border-stone-300 dark:border-stone-700',
            'red'     => 'border-red-300 dark:border-red-700',
            'orange'  => 'border-orange-300 dark:border-orange-700',
            'amber'   => 'border-amber-300 dark:border-amber-700',
            'yellow'  => 'border-yellow-300 dark:border-yellow-700',
            'lime'    => 'border-lime-300 dark:border-lime-700',
            'green'   => 'border-green-300 dark:border-green-700',
            'emerald' => 'border-emerald-300 dark:border-emerald-700',
            'teal'    => 'border-teal-300 dark:border-teal-700',
            'cyan'    => 'border-cyan-300 dark:border-cyan-700',
            'sky'     => 'border-sky-300 dark:border-sky-700',
            'blue'    => 'border-blue-300 dark:border-blue-700',
            'indigo'  => 'border-indigo-300 dark:border-indigo-700',
            'violet'  => 'border-violet-300 dark:border-violet-700',
            'purple'  => 'border-purple-300 dark:border-purple-700',
            'fuchsia' => 'border-fuchsia-300 dark:border-fuchsia-700',
            'pink'    => 'border-pink-300 dark:border-pink-700',
            'rose'    => 'border-rose-300 dark:border-rose-700',
            'taupe'   => 'border-taupe-300 dark:border-taupe-700',
            'mauve'   => 'border-mauve-300 dark:border-mauve-700',
            'mist'    => 'border-mist-300 dark:border-mist-700',
            'olive'   => 'border-olive-300 dark:border-olive-700',
        ];

        $this->boxClasses = 'overflow-hidden rounded-md border text-sm';
        $this->boxClasses .= ' '.$themeMap[$theme] ?? $themeMap['gray'];
        $this->titleClasses = 'border-b px-4 py-2 font-semibold';
        $this->titleClasses .= ' '.$titleMap[$theme] ?? $titleMap['gray'];
        $this->titleClasses .= ' '.$titleBorderMap[$theme] ?? $titleBorderMap['gray'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('twcss::components.messagebox');
    }
}
