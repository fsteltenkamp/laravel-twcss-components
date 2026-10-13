<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * Tab strip (the `list` slot, holding x-fltc::tabs.tab) plus panels
 * (x-fltc::tabs.panel in the default slot). The active tab lives in Alpine and is
 * x-modelable, so x-model / wire:model on the tabs bind it.
 */
class Tabs extends Component
{
    public string $classList;
    public string $listClasses;
    public string $tabsId;

    public function __construct(
        public string $active = '',
        public string $color = 'base',
        public string $id = '',
    ) {
        $listMap = [
            'slate'     => 'border-slate-200 dark:border-slate-700',
            'gray'      => 'border-gray-200 dark:border-gray-700',
            'zinc'      => 'border-zinc-200 dark:border-zinc-700',
            'neutral'   => 'border-neutral-200 dark:border-neutral-700',
            'stone'     => 'border-stone-200 dark:border-stone-700',
            'red'       => 'border-red-200 dark:border-red-700',
            'orange'    => 'border-orange-200 dark:border-orange-700',
            'amber'     => 'border-amber-200 dark:border-amber-700',
            'yellow'    => 'border-yellow-200 dark:border-yellow-700',
            'lime'      => 'border-lime-200 dark:border-lime-700',
            'green'     => 'border-green-200 dark:border-green-700',
            'emerald'   => 'border-emerald-200 dark:border-emerald-700',
            'teal'      => 'border-teal-200 dark:border-teal-700',
            'cyan'      => 'border-cyan-200 dark:border-cyan-700',
            'sky'       => 'border-sky-200 dark:border-sky-700',
            'blue'      => 'border-blue-200 dark:border-blue-700',
            'indigo'    => 'border-indigo-200 dark:border-indigo-700',
            'violet'    => 'border-violet-200 dark:border-violet-700',
            'purple'    => 'border-purple-200 dark:border-purple-700',
            'fuchsia'   => 'border-fuchsia-200 dark:border-fuchsia-700',
            'pink'      => 'border-pink-200 dark:border-pink-700',
            'rose'      => 'border-rose-200 dark:border-rose-700',
            'taupe'     => 'border-taupe-200 dark:border-taupe-700',
            'mauve'     => 'border-mauve-200 dark:border-mauve-700',
            'mist'      => 'border-mist-200 dark:border-mist-700',
            'olive'     => 'border-olive-200 dark:border-olive-700',
            'primary'      => 'border-primary-200 dark:border-primary-700',
            'secondary'    => 'border-secondary-200 dark:border-secondary-700',
            'accent'       => 'border-accent-200 dark:border-accent-700',
            'base'         => 'border-base-200 dark:border-base-700',
            'info'         => 'border-info-200 dark:border-info-700',
            'success'      => 'border-success-200 dark:border-success-700',
            'warning'      => 'border-warning-200 dark:border-warning-700',
            'danger'       => 'border-danger-200 dark:border-danger-700',
        ];

        $this->tabsId = $id !== '' ? $id : 'tabs-'.uniqid();
        $this->classList = 'w-full';
        $this->listClasses = 'flex flex-wrap gap-x-1 border-b '.($listMap[$color] ?? $listMap['base']);
    }

    public function render(): View|Closure|string
    {
        ViewFacade::share('fltcTabs', [
            'id' => $this->tabsId,
            'color' => $this->color,
            'active' => $this->active,
        ]);

        return view('fltc::components.tabs');
    }
}
