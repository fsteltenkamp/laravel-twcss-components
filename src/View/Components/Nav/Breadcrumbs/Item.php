<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Nav\Breadcrumbs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\Component;

class Item extends Component
{
    public string $classList;
    public string $separatorClass;
    public bool $isLink;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public mixed $href = null,
        public mixed $icon = null,
        public bool $isActive = false,
        public bool $showSeparator = true,
        public ?string $theme = null,
        public string $class = '',
    ) {
        $this->theme = $this->theme ?? ViewFacade::shared('tailwindBreadcrumbsTheme', 'slate');

        $this->isLink = !$this->isActive && filled($this->href) && $this->href !== '#';

        $activeMap = [
            'slate'   => 'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-100',
            'gray'    => 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-100',
            'zinc'    => 'bg-zinc-200 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-100',
            'neutral' => 'bg-neutral-200 text-neutral-700 dark:bg-neutral-700 dark:text-neutral-100',
            'stone'   => 'bg-stone-200 text-stone-700 dark:bg-stone-700 dark:text-stone-100',
            'red'     => 'bg-red-100 text-red-700 dark:bg-red-800 dark:text-red-100',
            'orange'  => 'bg-orange-100 text-orange-700 dark:bg-orange-800 dark:text-orange-100',
            'amber'   => 'bg-amber-100 text-amber-700 dark:bg-amber-800 dark:text-amber-100',
            'yellow'  => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-800 dark:text-yellow-100',
            'lime'    => 'bg-lime-100 text-lime-700 dark:bg-lime-800 dark:text-lime-100',
            'green'   => 'bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-100',
            'emerald' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-800 dark:text-emerald-100',
            'teal'    => 'bg-teal-100 text-teal-700 dark:bg-teal-800 dark:text-teal-100',
            'cyan'    => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-800 dark:text-cyan-100',
            'sky'     => 'bg-sky-100 text-sky-700 dark:bg-sky-800 dark:text-sky-100',
            'blue'    => 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-blue-100',
            'indigo'  => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-800 dark:text-indigo-100',
            'violet'  => 'bg-violet-100 text-violet-700 dark:bg-violet-800 dark:text-violet-100',
            'purple'  => 'bg-purple-100 text-purple-700 dark:bg-purple-800 dark:text-purple-100',
            'fuchsia' => 'bg-fuchsia-100 text-fuchsia-700 dark:bg-fuchsia-800 dark:text-fuchsia-100',
            'pink'    => 'bg-pink-100 text-pink-700 dark:bg-pink-800 dark:text-pink-100',
            'rose'    => 'bg-rose-100 text-rose-700 dark:bg-rose-800 dark:text-rose-100',
            'taupe'   => 'bg-taupe-100 text-taupe-700 dark:bg-taupe-800 dark:text-taupe-100',
            'mauve'   => 'bg-mauve-100 text-mauve-700 dark:bg-mauve-800 dark:text-mauve-100',
            'mist'    => 'bg-mist-100 text-mist-700 dark:bg-mist-800 dark:text-mist-100',
            'olive'   => 'bg-olive-100 text-olive-700 dark:bg-olive-800 dark:text-olive-100',
        ];

        $inactiveMap = [
            'slate'   => 'text-slate-500 dark:text-slate-400',
            'gray'    => 'text-gray-500 dark:text-gray-400',
            'zinc'    => 'text-zinc-500 dark:text-zinc-400',
            'neutral' => 'text-neutral-500 dark:text-neutral-400',
            'stone'   => 'text-stone-500 dark:text-stone-400',
            'red'     => 'text-red-500 dark:text-red-400',
            'orange'  => 'text-orange-500 dark:text-orange-400',
            'amber'   => 'text-amber-500 dark:text-amber-400',
            'yellow'  => 'text-yellow-500 dark:text-yellow-400',
            'lime'    => 'text-lime-500 dark:text-lime-400',
            'green'   => 'text-green-500 dark:text-green-400',
            'emerald' => 'text-emerald-500 dark:text-emerald-400',
            'teal'    => 'text-teal-500 dark:text-teal-400',
            'cyan'    => 'text-cyan-500 dark:text-cyan-400',
            'sky'     => 'text-sky-500 dark:text-sky-400',
            'blue'    => 'text-blue-500 dark:text-blue-400',
            'indigo'  => 'text-indigo-500 dark:text-indigo-400',
            'violet'  => 'text-violet-500 dark:text-violet-400',
            'purple'  => 'text-purple-500 dark:text-purple-400',
            'fuchsia' => 'text-fuchsia-500 dark:text-fuchsia-400',
            'pink'    => 'text-pink-500 dark:text-pink-400',
            'rose'    => 'text-rose-500 dark:text-rose-400',
            'taupe'   => 'text-taupe-500 dark:text-taupe-400',
            'mauve'   => 'text-mauve-500 dark:text-mauve-400',
            'mist'    => 'text-mist-500 dark:text-mist-400',
            'olive'   => 'text-olive-500 dark:text-olive-400',
        ];

        $linkHoverMap = [
            'slate'   => 'hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus-visible:bg-slate-100 focus-visible:text-slate-900 focus-visible:ring-2 focus-visible:ring-slate-300 dark:hover:bg-slate-800 dark:hover:text-slate-100 dark:focus-visible:bg-slate-800 dark:focus-visible:text-slate-100 dark:focus-visible:ring-slate-600',
            'gray'    => 'hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus-visible:bg-gray-100 focus-visible:text-gray-900 focus-visible:ring-2 focus-visible:ring-gray-300 dark:hover:bg-gray-800 dark:hover:text-gray-100 dark:focus-visible:bg-gray-800 dark:focus-visible:text-gray-100 dark:focus-visible:ring-gray-600',
            'zinc'    => 'hover:bg-zinc-100 hover:text-zinc-900 focus:outline-none focus-visible:bg-zinc-100 focus-visible:text-zinc-900 focus-visible:ring-2 focus-visible:ring-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-zinc-100 dark:focus-visible:bg-zinc-800 dark:focus-visible:text-zinc-100 dark:focus-visible:ring-zinc-600',
            'neutral' => 'hover:bg-neutral-100 hover:text-neutral-900 focus:outline-none focus-visible:bg-neutral-100 focus-visible:text-neutral-900 focus-visible:ring-2 focus-visible:ring-neutral-300 dark:hover:bg-neutral-800 dark:hover:text-neutral-100 dark:focus-visible:bg-neutral-800 dark:focus-visible:text-neutral-100 dark:focus-visible:ring-neutral-600',
            'stone'   => 'hover:bg-stone-100 hover:text-stone-900 focus:outline-none focus-visible:bg-stone-100 focus-visible:text-stone-900 focus-visible:ring-2 focus-visible:ring-stone-300 dark:hover:bg-stone-800 dark:hover:text-stone-100 dark:focus-visible:bg-stone-800 dark:focus-visible:text-stone-100 dark:focus-visible:ring-stone-600',
            'red'     => 'hover:bg-red-100 hover:text-red-900 focus:outline-none focus-visible:bg-red-100 focus-visible:text-red-900 focus-visible:ring-2 focus-visible:ring-red-300 dark:hover:bg-red-900 dark:hover:text-red-100 dark:focus-visible:bg-red-900 dark:focus-visible:text-red-100 dark:focus-visible:ring-red-700',
            'orange'  => 'hover:bg-orange-100 hover:text-orange-900 focus:outline-none focus-visible:bg-orange-100 focus-visible:text-orange-900 focus-visible:ring-2 focus-visible:ring-orange-300 dark:hover:bg-orange-900 dark:hover:text-orange-100 dark:focus-visible:bg-orange-900 dark:focus-visible:text-orange-100 dark:focus-visible:ring-orange-700',
            'amber'   => 'hover:bg-amber-100 hover:text-amber-900 focus:outline-none focus-visible:bg-amber-100 focus-visible:text-amber-900 focus-visible:ring-2 focus-visible:ring-amber-300 dark:hover:bg-amber-900 dark:hover:text-amber-100 dark:focus-visible:bg-amber-900 dark:focus-visible:text-amber-100 dark:focus-visible:ring-amber-700',
            'yellow'  => 'hover:bg-yellow-100 hover:text-yellow-900 focus:outline-none focus-visible:bg-yellow-100 focus-visible:text-yellow-900 focus-visible:ring-2 focus-visible:ring-yellow-300 dark:hover:bg-yellow-900 dark:hover:text-yellow-100 dark:focus-visible:bg-yellow-900 dark:focus-visible:text-yellow-100 dark:focus-visible:ring-yellow-700',
            'lime'    => 'hover:bg-lime-100 hover:text-lime-900 focus:outline-none focus-visible:bg-lime-100 focus-visible:text-lime-900 focus-visible:ring-2 focus-visible:ring-lime-300 dark:hover:bg-lime-900 dark:hover:text-lime-100 dark:focus-visible:bg-lime-900 dark:focus-visible:text-lime-100 dark:focus-visible:ring-lime-700',
            'green'   => 'hover:bg-green-100 hover:text-green-900 focus:outline-none focus-visible:bg-green-100 focus-visible:text-green-900 focus-visible:ring-2 focus-visible:ring-green-300 dark:hover:bg-green-900 dark:hover:text-green-100 dark:focus-visible:bg-green-900 dark:focus-visible:text-green-100 dark:focus-visible:ring-green-700',
            'emerald' => 'hover:bg-emerald-100 hover:text-emerald-900 focus:outline-none focus-visible:bg-emerald-100 focus-visible:text-emerald-900 focus-visible:ring-2 focus-visible:ring-emerald-300 dark:hover:bg-emerald-900 dark:hover:text-emerald-100 dark:focus-visible:bg-emerald-900 dark:focus-visible:text-emerald-100 dark:focus-visible:ring-emerald-700',
            'teal'    => 'hover:bg-teal-100 hover:text-teal-900 focus:outline-none focus-visible:bg-teal-100 focus-visible:text-teal-900 focus-visible:ring-2 focus-visible:ring-teal-300 dark:hover:bg-teal-900 dark:hover:text-teal-100 dark:focus-visible:bg-teal-900 dark:focus-visible:text-teal-100 dark:focus-visible:ring-teal-700',
            'cyan'    => 'hover:bg-cyan-100 hover:text-cyan-900 focus:outline-none focus-visible:bg-cyan-100 focus-visible:text-cyan-900 focus-visible:ring-2 focus-visible:ring-cyan-300 dark:hover:bg-cyan-900 dark:hover:text-cyan-100 dark:focus-visible:bg-cyan-900 dark:focus-visible:text-cyan-100 dark:focus-visible:ring-cyan-700',
            'sky'     => 'hover:bg-sky-100 hover:text-sky-900 focus:outline-none focus-visible:bg-sky-100 focus-visible:text-sky-900 focus-visible:ring-2 focus-visible:ring-sky-300 dark:hover:bg-sky-900 dark:hover:text-sky-100 dark:focus-visible:bg-sky-900 dark:focus-visible:text-sky-100 dark:focus-visible:ring-sky-700',
            'blue'    => 'hover:bg-blue-100 hover:text-blue-900 focus:outline-none focus-visible:bg-blue-100 focus-visible:text-blue-900 focus-visible:ring-2 focus-visible:ring-blue-300 dark:hover:bg-blue-900 dark:hover:text-blue-100 dark:focus-visible:bg-blue-900 dark:focus-visible:text-blue-100 dark:focus-visible:ring-blue-700',
            'indigo'  => 'hover:bg-indigo-100 hover:text-indigo-900 focus:outline-none focus-visible:bg-indigo-100 focus-visible:text-indigo-900 focus-visible:ring-2 focus-visible:ring-indigo-300 dark:hover:bg-indigo-900 dark:hover:text-indigo-100 dark:focus-visible:bg-indigo-900 dark:focus-visible:text-indigo-100 dark:focus-visible:ring-indigo-700',
            'violet'  => 'hover:bg-violet-100 hover:text-violet-900 focus:outline-none focus-visible:bg-violet-100 focus-visible:text-violet-900 focus-visible:ring-2 focus-visible:ring-violet-300 dark:hover:bg-violet-900 dark:hover:text-violet-100 dark:focus-visible:bg-violet-900 dark:focus-visible:text-violet-100 dark:focus-visible:ring-violet-700',
            'purple'  => 'hover:bg-purple-100 hover:text-purple-900 focus:outline-none focus-visible:bg-purple-100 focus-visible:text-purple-900 focus-visible:ring-2 focus-visible:ring-purple-300 dark:hover:bg-purple-900 dark:hover:text-purple-100 dark:focus-visible:bg-purple-900 dark:focus-visible:text-purple-100 dark:focus-visible:ring-purple-700',
            'fuchsia' => 'hover:bg-fuchsia-100 hover:text-fuchsia-900 focus:outline-none focus-visible:bg-fuchsia-100 focus-visible:text-fuchsia-900 focus-visible:ring-2 focus-visible:ring-fuchsia-300 dark:hover:bg-fuchsia-900 dark:hover:text-fuchsia-100 dark:focus-visible:bg-fuchsia-900 dark:focus-visible:text-fuchsia-100 dark:focus-visible:ring-fuchsia-700',
            'pink'    => 'hover:bg-pink-100 hover:text-pink-900 focus:outline-none focus-visible:bg-pink-100 focus-visible:text-pink-900 focus-visible:ring-2 focus-visible:ring-pink-300 dark:hover:bg-pink-900 dark:hover:text-pink-100 dark:focus-visible:bg-pink-900 dark:focus-visible:text-pink-100 dark:focus-visible:ring-pink-700',
            'rose'    => 'hover:bg-rose-100 hover:text-rose-900 focus:outline-none focus-visible:bg-rose-100 focus-visible:text-rose-900 focus-visible:ring-2 focus-visible:ring-rose-300 dark:hover:bg-rose-900 dark:hover:text-rose-100 dark:focus-visible:bg-rose-900 dark:focus-visible:text-rose-100 dark:focus-visible:ring-rose-700',
            'taupe'   => 'hover:bg-taupe-100 hover:text-taupe-900 focus:outline-none focus-visible:bg-taupe-100 focus-visible:text-taupe-900 focus-visible:ring-2 focus-visible:ring-taupe-300 dark:hover:bg-taupe-900 dark:hover:text-taupe-100 dark:focus-visible:bg-taupe-900 dark:focus-visible:text-taupe-100 dark:focus-visible:ring-taupe-700',
            'mauve'   => 'hover:bg-mauve-100 hover:text-mauve-900 focus:outline-none focus-visible:bg-mauve-100 focus-visible:text-mauve-900 focus-visible:ring-2 focus-visible:ring-mauve-300 dark:hover:bg-mauve-900 dark:hover:text-mauve-100 dark:focus-visible:bg-mauve-900 dark:focus-visible:text-mauve-100 dark:focus-visible:ring-mauve-700',
            'mist'    => 'hover:bg-mist-100 hover:text-mist-900 focus:outline-none focus-visible:bg-mist-100 focus-visible:text-mist-900 focus-visible:ring-2 focus-visible:ring-mist-300 dark:hover:bg-mist-900 dark:hover:text-mist-100 dark:focus-visible:bg-mist-900 dark:focus-visible:text-mist-100 dark:focus-visible:ring-mist-700',
            'olive'   => 'hover:bg-olive-100 hover:text-olive-900 focus:outline-none focus-visible:bg-olive-100 focus-visible:text-olive-900 focus-visible:ring-2 focus-visible:ring-olive-300 dark:hover:bg-olive-900 dark:hover:text-olive-100 dark:focus-visible:bg-olive-900 dark:focus-visible:text-olive-100 dark:focus-visible:ring-olive-700',
        ];

        $separatorMap = [
            'slate'   => 'text-slate-300 dark:text-slate-600',
            'gray'    => 'text-gray-300 dark:text-gray-600',
            'zinc'    => 'text-zinc-300 dark:text-zinc-600',
            'neutral' => 'text-neutral-300 dark:text-neutral-600',
            'stone'   => 'text-stone-300 dark:text-stone-600',
            'red'     => 'text-red-300 dark:text-red-700',
            'orange'  => 'text-orange-300 dark:text-orange-700',
            'amber'   => 'text-amber-300 dark:text-amber-700',
            'yellow'  => 'text-yellow-300 dark:text-yellow-700',
            'lime'    => 'text-lime-300 dark:text-lime-700',
            'green'   => 'text-green-300 dark:text-green-700',
            'emerald' => 'text-emerald-300 dark:text-emerald-700',
            'teal'    => 'text-teal-300 dark:text-teal-700',
            'cyan'    => 'text-cyan-300 dark:text-cyan-700',
            'sky'     => 'text-sky-300 dark:text-sky-700',
            'blue'    => 'text-blue-300 dark:text-blue-700',
            'indigo'  => 'text-indigo-300 dark:text-indigo-700',
            'violet'  => 'text-violet-300 dark:text-violet-700',
            'purple'  => 'text-purple-300 dark:text-purple-700',
            'fuchsia' => 'text-fuchsia-300 dark:text-fuchsia-700',
            'pink'    => 'text-pink-300 dark:text-pink-700',
            'rose'    => 'text-rose-300 dark:text-rose-700',
            'taupe'   => 'text-taupe-300 dark:text-taupe-700',
            'mauve'   => 'text-mauve-300 dark:text-mauve-700',
            'mist'    => 'text-mist-300 dark:text-mist-700',
            'olive'   => 'text-olive-300 dark:text-olive-700',
        ];

        $this->separatorClass = 'text-xs ' . ($separatorMap[$this->theme] ?? $separatorMap['slate']);

        $this->classList = trim(implode(' ', array_filter([
            'inline-flex items-center gap-2 rounded-full px-3 py-1.5 transition',
            $this->isActive
                ? ($activeMap[$this->theme] ?? $activeMap['slate'])
                : ($inactiveMap[$this->theme] ?? $inactiveMap['slate']),
            $this->isLink ? ($linkHoverMap[$this->theme] ?? $linkHoverMap['slate']) : null,
            $this->class,
        ])));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.nav.breadcrumbs.item');
    }
}
