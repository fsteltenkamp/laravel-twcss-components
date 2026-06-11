<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Accordion;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\Component;

class Item extends Component
{
    public string $classList;
    public string $buttonClass;
    public string $titleClass;
    public string $subtextClass;
    public string $contentClass;
    public string $chevronClass;
    public string $handleClass;
    public bool $isDraggable;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title = '',
        public ?string $subtext = null,
        public ?bool $draggable = null,
        public ?string $theme = null,
        public string $class = '',
    ) {
        $this->theme = $this->theme ?? ViewFacade::shared('tailwindAccordionTheme', 'slate');
        $this->isDraggable = $this->draggable ?? (bool) ViewFacade::shared('tailwindAccordionDraggable', false);

        $buttonThemeMap = [
            'slate'   => 'text-slate-800 hover:bg-slate-50 focus-visible:ring-slate-400 dark:text-slate-100 dark:hover:bg-slate-800 dark:focus-visible:ring-slate-600',
            'gray'    => 'text-gray-800 hover:bg-gray-50 focus-visible:ring-gray-400 dark:text-gray-100 dark:hover:bg-gray-800 dark:focus-visible:ring-gray-600',
            'zinc'    => 'text-zinc-800 hover:bg-zinc-50 focus-visible:ring-zinc-400 dark:text-zinc-100 dark:hover:bg-zinc-800 dark:focus-visible:ring-zinc-600',
            'neutral' => 'text-neutral-800 hover:bg-neutral-50 focus-visible:ring-neutral-400 dark:text-neutral-100 dark:hover:bg-neutral-800 dark:focus-visible:ring-neutral-600',
            'stone'   => 'text-stone-800 hover:bg-stone-50 focus-visible:ring-stone-400 dark:text-stone-100 dark:hover:bg-stone-800 dark:focus-visible:ring-stone-600',
            'red'     => 'text-red-800 hover:bg-red-50 focus-visible:ring-red-400 dark:text-red-100 dark:hover:bg-red-900/60 dark:focus-visible:ring-red-600',
            'orange'  => 'text-orange-800 hover:bg-orange-50 focus-visible:ring-orange-400 dark:text-orange-100 dark:hover:bg-orange-900/60 dark:focus-visible:ring-orange-600',
            'amber'   => 'text-amber-800 hover:bg-amber-50 focus-visible:ring-amber-400 dark:text-amber-100 dark:hover:bg-amber-900/60 dark:focus-visible:ring-amber-600',
            'yellow'  => 'text-yellow-800 hover:bg-yellow-50 focus-visible:ring-yellow-400 dark:text-yellow-100 dark:hover:bg-yellow-900/60 dark:focus-visible:ring-yellow-600',
            'lime'    => 'text-lime-800 hover:bg-lime-50 focus-visible:ring-lime-400 dark:text-lime-100 dark:hover:bg-lime-900/60 dark:focus-visible:ring-lime-600',
            'green'   => 'text-green-800 hover:bg-green-50 focus-visible:ring-green-400 dark:text-green-100 dark:hover:bg-green-900/60 dark:focus-visible:ring-green-600',
            'emerald' => 'text-emerald-800 hover:bg-emerald-50 focus-visible:ring-emerald-400 dark:text-emerald-100 dark:hover:bg-emerald-900/60 dark:focus-visible:ring-emerald-600',
            'teal'    => 'text-teal-800 hover:bg-teal-50 focus-visible:ring-teal-400 dark:text-teal-100 dark:hover:bg-teal-900/60 dark:focus-visible:ring-teal-600',
            'cyan'    => 'text-cyan-800 hover:bg-cyan-50 focus-visible:ring-cyan-400 dark:text-cyan-100 dark:hover:bg-cyan-900/60 dark:focus-visible:ring-cyan-600',
            'sky'     => 'text-sky-800 hover:bg-sky-50 focus-visible:ring-sky-400 dark:text-sky-100 dark:hover:bg-sky-900/60 dark:focus-visible:ring-sky-600',
            'blue'    => 'text-blue-800 hover:bg-blue-50 focus-visible:ring-blue-400 dark:text-blue-100 dark:hover:bg-blue-900/60 dark:focus-visible:ring-blue-600',
            'indigo'  => 'text-indigo-800 hover:bg-indigo-50 focus-visible:ring-indigo-400 dark:text-indigo-100 dark:hover:bg-indigo-900/60 dark:focus-visible:ring-indigo-600',
            'violet'  => 'text-violet-800 hover:bg-violet-50 focus-visible:ring-violet-400 dark:text-violet-100 dark:hover:bg-violet-900/60 dark:focus-visible:ring-violet-600',
            'purple'  => 'text-purple-800 hover:bg-purple-50 focus-visible:ring-purple-400 dark:text-purple-100 dark:hover:bg-purple-900/60 dark:focus-visible:ring-purple-600',
            'fuchsia' => 'text-fuchsia-800 hover:bg-fuchsia-50 focus-visible:ring-fuchsia-400 dark:text-fuchsia-100 dark:hover:bg-fuchsia-900/60 dark:focus-visible:ring-fuchsia-600',
            'pink'    => 'text-pink-800 hover:bg-pink-50 focus-visible:ring-pink-400 dark:text-pink-100 dark:hover:bg-pink-900/60 dark:focus-visible:ring-pink-600',
            'rose'    => 'text-rose-800 hover:bg-rose-50 focus-visible:ring-rose-400 dark:text-rose-100 dark:hover:bg-rose-900/60 dark:focus-visible:ring-rose-600',
        ];

        $subtextThemeMap = [
            'slate'   => 'text-slate-500 dark:text-slate-400',
            'gray'    => 'text-gray-500 dark:text-gray-400',
            'zinc'    => 'text-zinc-500 dark:text-zinc-400',
            'neutral' => 'text-neutral-500 dark:text-neutral-400',
            'stone'   => 'text-stone-500 dark:text-stone-400',
            'red'     => 'text-red-500 dark:text-red-300',
            'orange'  => 'text-orange-500 dark:text-orange-300',
            'amber'   => 'text-amber-500 dark:text-amber-300',
            'yellow'  => 'text-yellow-600 dark:text-yellow-300',
            'lime'    => 'text-lime-600 dark:text-lime-300',
            'green'   => 'text-green-500 dark:text-green-300',
            'emerald' => 'text-emerald-500 dark:text-emerald-300',
            'teal'    => 'text-teal-500 dark:text-teal-300',
            'cyan'    => 'text-cyan-500 dark:text-cyan-300',
            'sky'     => 'text-sky-500 dark:text-sky-300',
            'blue'    => 'text-blue-500 dark:text-blue-300',
            'indigo'  => 'text-indigo-500 dark:text-indigo-300',
            'violet'  => 'text-violet-500 dark:text-violet-300',
            'purple'  => 'text-purple-500 dark:text-purple-300',
            'fuchsia' => 'text-fuchsia-500 dark:text-fuchsia-300',
            'pink'    => 'text-pink-500 dark:text-pink-300',
            'rose'    => 'text-rose-500 dark:text-rose-300',
        ];

        $handleThemeMap = [
            'slate'   => 'text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300',
            'gray'    => 'text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300',
            'zinc'    => 'text-zinc-400 hover:text-zinc-600 dark:text-zinc-500 dark:hover:text-zinc-300',
            'neutral' => 'text-neutral-400 hover:text-neutral-600 dark:text-neutral-500 dark:hover:text-neutral-300',
            'stone'   => 'text-stone-400 hover:text-stone-600 dark:text-stone-500 dark:hover:text-stone-300',
            'red'     => 'text-red-400 hover:text-red-600 dark:text-red-500 dark:hover:text-red-300',
            'orange'  => 'text-orange-400 hover:text-orange-600 dark:text-orange-500 dark:hover:text-orange-300',
            'amber'   => 'text-amber-400 hover:text-amber-600 dark:text-amber-500 dark:hover:text-amber-300',
            'yellow'  => 'text-yellow-500 hover:text-yellow-700 dark:text-yellow-500 dark:hover:text-yellow-300',
            'lime'    => 'text-lime-500 hover:text-lime-700 dark:text-lime-500 dark:hover:text-lime-300',
            'green'   => 'text-green-400 hover:text-green-600 dark:text-green-500 dark:hover:text-green-300',
            'emerald' => 'text-emerald-400 hover:text-emerald-600 dark:text-emerald-500 dark:hover:text-emerald-300',
            'teal'    => 'text-teal-400 hover:text-teal-600 dark:text-teal-500 dark:hover:text-teal-300',
            'cyan'    => 'text-cyan-400 hover:text-cyan-600 dark:text-cyan-500 dark:hover:text-cyan-300',
            'sky'     => 'text-sky-400 hover:text-sky-600 dark:text-sky-500 dark:hover:text-sky-300',
            'blue'    => 'text-blue-400 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-300',
            'indigo'  => 'text-indigo-400 hover:text-indigo-600 dark:text-indigo-500 dark:hover:text-indigo-300',
            'violet'  => 'text-violet-400 hover:text-violet-600 dark:text-violet-500 dark:hover:text-violet-300',
            'purple'  => 'text-purple-400 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-300',
            'fuchsia' => 'text-fuchsia-400 hover:text-fuchsia-600 dark:text-fuchsia-500 dark:hover:text-fuchsia-300',
            'pink'    => 'text-pink-400 hover:text-pink-600 dark:text-pink-500 dark:hover:text-pink-300',
            'rose'    => 'text-rose-400 hover:text-rose-600 dark:text-rose-500 dark:hover:text-rose-300',
        ];

        $headerSurfaceMap = [
            'slate'   => 'bg-slate-100/80 dark:bg-slate-900/70',
            'gray'    => 'bg-gray-100/80 dark:bg-gray-900/70',
            'zinc'    => 'bg-zinc-100/80 dark:bg-zinc-900/70',
            'neutral' => 'bg-neutral-100/80 dark:bg-neutral-900/70',
            'stone'   => 'bg-stone-100/80 dark:bg-stone-900/70',
            'red'     => 'bg-red-100/70 dark:bg-red-950/70',
            'orange'  => 'bg-orange-100/70 dark:bg-orange-950/70',
            'amber'   => 'bg-amber-100/70 dark:bg-amber-950/70',
            'yellow'  => 'bg-yellow-100/70 dark:bg-yellow-950/70',
            'lime'    => 'bg-lime-100/70 dark:bg-lime-950/70',
            'green'   => 'bg-green-100/70 dark:bg-green-950/70',
            'emerald' => 'bg-emerald-100/70 dark:bg-emerald-950/70',
            'teal'    => 'bg-teal-100/70 dark:bg-teal-950/70',
            'cyan'    => 'bg-cyan-100/70 dark:bg-cyan-950/70',
            'sky'     => 'bg-sky-100/70 dark:bg-sky-950/70',
            'blue'    => 'bg-blue-100/70 dark:bg-blue-950/70',
            'indigo'  => 'bg-indigo-100/70 dark:bg-indigo-950/70',
            'violet'  => 'bg-violet-100/70 dark:bg-violet-950/70',
            'purple'  => 'bg-purple-100/70 dark:bg-purple-950/70',
            'fuchsia' => 'bg-fuchsia-100/70 dark:bg-fuchsia-950/70',
            'pink'    => 'bg-pink-100/70 dark:bg-pink-950/70',
            'rose'    => 'bg-rose-100/70 dark:bg-rose-950/70',
        ];

        $bodySurfaceMap = [
            'slate'   => 'bg-white dark:bg-slate-900/35',
            'gray'    => 'bg-white dark:bg-gray-900/35',
            'zinc'    => 'bg-white dark:bg-zinc-900/35',
            'neutral' => 'bg-white dark:bg-neutral-900/35',
            'stone'   => 'bg-white dark:bg-stone-900/35',
            'red'     => 'bg-red-50/40 dark:bg-red-950/45',
            'orange'  => 'bg-orange-50/40 dark:bg-orange-950/45',
            'amber'   => 'bg-amber-50/40 dark:bg-amber-950/45',
            'yellow'  => 'bg-yellow-50/40 dark:bg-yellow-950/45',
            'lime'    => 'bg-lime-50/40 dark:bg-lime-950/45',
            'green'   => 'bg-green-50/40 dark:bg-green-950/45',
            'emerald' => 'bg-emerald-50/40 dark:bg-emerald-950/45',
            'teal'    => 'bg-teal-50/40 dark:bg-teal-950/45',
            'cyan'    => 'bg-cyan-50/40 dark:bg-cyan-950/45',
            'sky'     => 'bg-sky-50/40 dark:bg-sky-950/45',
            'blue'    => 'bg-blue-50/40 dark:bg-blue-950/45',
            'indigo'  => 'bg-indigo-50/40 dark:bg-indigo-950/45',
            'violet'  => 'bg-violet-50/40 dark:bg-violet-950/45',
            'purple'  => 'bg-purple-50/40 dark:bg-purple-950/45',
            'fuchsia' => 'bg-fuchsia-50/40 dark:bg-fuchsia-950/45',
            'pink'    => 'bg-pink-50/40 dark:bg-pink-950/45',
            'rose'    => 'bg-rose-50/40 dark:bg-rose-950/45',
        ];

        $this->classList = trim(implode(' ', array_filter([
            'group',
            $this->class,
        ])));

        $this->buttonClass = trim(implode(' ', array_filter([
            'flex w-full items-start justify-between gap-4 px-4 py-3 text-left transition focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-0',
            $buttonThemeMap[$this->theme] ?? $buttonThemeMap['slate'],
            $headerSurfaceMap[$this->theme] ?? $headerSurfaceMap['slate'],
        ])));

        $this->titleClass = 'block truncate text-sm font-semibold leading-5';
        $this->subtextClass = 'mt-1 block truncate text-xs leading-4 ' . ($subtextThemeMap[$this->theme] ?? $subtextThemeMap['slate']);
        $this->contentClass = trim(implode(' ', array_filter([
            'px-0 pb-0',
            $bodySurfaceMap[$this->theme] ?? $bodySurfaceMap['slate'],
        ])));
        $this->chevronClass = 'ph ph-caret-down mt-0.5 shrink-0 text-base transition-transform duration-200';

        $this->handleClass = trim(implode(' ', array_filter([
            'mt-0.5 inline-flex h-5 w-5 shrink-0 cursor-grab items-center justify-center rounded-sm transition active:cursor-grabbing',
            $this->isDraggable ? '' : 'pointer-events-none opacity-40',
            $handleThemeMap[$this->theme] ?? $handleThemeMap['slate'],
        ])));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('twcss::components.accordion.item');
    }
}
