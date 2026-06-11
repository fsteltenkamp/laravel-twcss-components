<?php

namespace Fsteltenkamp\fltcComponents\View\Components\Nav;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    public string $classList;
    public string $listClass;

    /**
     * @var array<int, array{href:mixed, icon:mixed, isActive:bool, showSeparator:bool, label:string}>
     */
    public array $items;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public mixed $crumbs = null,
        public string $theme = 'slate',
        public string $class = '',
        public string $containerClass = 'w-full px-4 sm:px-6 lg:px-8',
    ) {
        $this->classList = trim(implode(' ', array_filter([
            'ml-5',
            'w-full',
            $this->class,
        ])));

        $listTextMap = [
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

        $this->listClass = 'flex flex-wrap items-center gap-x-2 gap-y-2 text-sm ' . ($listTextMap[$this->theme] ?? $listTextMap['slate']);

        $this->items = [];

        if (!is_array($this->crumbs) || count($this->crumbs) === 0) {
            return;
        }

        foreach (array_values($this->crumbs) as $index => $crumb) {
            if (!is_array($crumb)) {
                continue;
            }

            $this->items[] = [
                'href' => $crumb['href'] ?? null,
                'icon' => $crumb['icon'] ?? null,
                'isActive' => (bool) ($crumb['isActive'] ?? ($index === array_key_last($this->crumbs))),
                'showSeparator' => $index > 0,
                'label' => (string) ($crumb['label'] ?? ''),
            ];
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        ViewFacade::share('tailwindBreadcrumbsTheme', $this->theme);

        return view('fltc::components.nav.breadcrumbs');
    }
}
