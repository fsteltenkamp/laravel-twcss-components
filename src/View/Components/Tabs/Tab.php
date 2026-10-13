<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Tabs;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * One tab of x-fltc::tabs: a button that activates the panel with the same `name`,
 * or, with `href`, a link (mark the current page with `current`).
 */
class Tab extends Component
{
    public string $classList;
    public string $activeClasses;
    public string $inactiveClasses;
    public string $tabsId;
    public bool $initiallyActive;

    public function __construct(
        public string $name = '',
        public string $href = '',
        public bool $current = false,
        public bool $disabled = false,
        public string $icon = '',
        public string $iconVariant = 'regular',
        public ?string $theme = null,
    ) {
        $tabs = ViewFacade::shared('fltcTabs', []);

        $this->theme = $theme ?? ($tabs['theme'] ?? 'slate');
        $this->tabsId = $tabs['id'] ?? 'tabs';

            $activeMap = [
                'slate'     => 'border-slate-500 text-slate-900 dark:border-slate-400 dark:text-slate-100',
                'gray'      => 'border-gray-500 text-gray-900 dark:border-gray-400 dark:text-gray-100',
                'zinc'      => 'border-zinc-500 text-zinc-900 dark:border-zinc-400 dark:text-zinc-100',
                'neutral'   => 'border-neutral-500 text-neutral-900 dark:border-neutral-400 dark:text-neutral-100',
                'stone'     => 'border-stone-500 text-stone-900 dark:border-stone-400 dark:text-stone-100',
                'red'       => 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-100',
                'orange'    => 'border-orange-500 text-orange-900 dark:border-orange-400 dark:text-orange-100',
                'amber'     => 'border-amber-500 text-amber-900 dark:border-amber-400 dark:text-amber-100',
                'yellow'    => 'border-yellow-500 text-yellow-900 dark:border-yellow-400 dark:text-yellow-100',
                'lime'      => 'border-lime-500 text-lime-900 dark:border-lime-400 dark:text-lime-100',
                'green'     => 'border-green-500 text-green-900 dark:border-green-400 dark:text-green-100',
                'emerald'   => 'border-emerald-500 text-emerald-900 dark:border-emerald-400 dark:text-emerald-100',
                'teal'      => 'border-teal-500 text-teal-900 dark:border-teal-400 dark:text-teal-100',
                'cyan'      => 'border-cyan-500 text-cyan-900 dark:border-cyan-400 dark:text-cyan-100',
                'sky'       => 'border-sky-500 text-sky-900 dark:border-sky-400 dark:text-sky-100',
                'blue'      => 'border-blue-500 text-blue-900 dark:border-blue-400 dark:text-blue-100',
                'indigo'    => 'border-indigo-500 text-indigo-900 dark:border-indigo-400 dark:text-indigo-100',
                'violet'    => 'border-violet-500 text-violet-900 dark:border-violet-400 dark:text-violet-100',
                'purple'    => 'border-purple-500 text-purple-900 dark:border-purple-400 dark:text-purple-100',
                'fuchsia'   => 'border-fuchsia-500 text-fuchsia-900 dark:border-fuchsia-400 dark:text-fuchsia-100',
                'pink'      => 'border-pink-500 text-pink-900 dark:border-pink-400 dark:text-pink-100',
                'rose'      => 'border-rose-500 text-rose-900 dark:border-rose-400 dark:text-rose-100',
                'taupe'     => 'border-taupe-500 text-taupe-900 dark:border-taupe-400 dark:text-taupe-100',
                'mauve'     => 'border-mauve-500 text-mauve-900 dark:border-mauve-400 dark:text-mauve-100',
                'mist'      => 'border-mist-500 text-mist-900 dark:border-mist-400 dark:text-mist-100',
                'olive'     => 'border-olive-500 text-olive-900 dark:border-olive-400 dark:text-olive-100',
                'skin'      => 'border-skin-500 text-skin-900 dark:border-skin-400 dark:text-skin-100',
                'cyberpunk' => 'border-cyberpunk-500 text-cyberpunk-900 dark:border-cyberpunk-400 dark:text-cyberpunk-100',
                'fantasy'   => 'border-fantasy-500 text-fantasy-900 dark:border-fantasy-400 dark:text-fantasy-100',
                'wh40k'     => 'border-wh40k-500 text-wh40k-900 dark:border-wh40k-400 dark:text-wh40k-100',
            ];

            $inactiveMap = [
                'slate'     => 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400 dark:hover:border-slate-600 dark:hover:text-slate-200',
                'gray'      => 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-200',
                'zinc'      => 'border-transparent text-zinc-500 hover:border-zinc-300 hover:text-zinc-700 dark:text-zinc-400 dark:hover:border-zinc-600 dark:hover:text-zinc-200',
                'neutral'   => 'border-transparent text-neutral-500 hover:border-neutral-300 hover:text-neutral-700 dark:text-neutral-400 dark:hover:border-neutral-600 dark:hover:text-neutral-200',
                'stone'     => 'border-transparent text-stone-500 hover:border-stone-300 hover:text-stone-700 dark:text-stone-400 dark:hover:border-stone-600 dark:hover:text-stone-200',
                'red'       => 'border-transparent text-red-500 hover:border-red-300 hover:text-red-700 dark:text-red-400 dark:hover:border-red-600 dark:hover:text-red-200',
                'orange'    => 'border-transparent text-orange-500 hover:border-orange-300 hover:text-orange-700 dark:text-orange-400 dark:hover:border-orange-600 dark:hover:text-orange-200',
                'amber'     => 'border-transparent text-amber-500 hover:border-amber-300 hover:text-amber-700 dark:text-amber-400 dark:hover:border-amber-600 dark:hover:text-amber-200',
                'yellow'    => 'border-transparent text-yellow-500 hover:border-yellow-300 hover:text-yellow-700 dark:text-yellow-400 dark:hover:border-yellow-600 dark:hover:text-yellow-200',
                'lime'      => 'border-transparent text-lime-500 hover:border-lime-300 hover:text-lime-700 dark:text-lime-400 dark:hover:border-lime-600 dark:hover:text-lime-200',
                'green'     => 'border-transparent text-green-500 hover:border-green-300 hover:text-green-700 dark:text-green-400 dark:hover:border-green-600 dark:hover:text-green-200',
                'emerald'   => 'border-transparent text-emerald-500 hover:border-emerald-300 hover:text-emerald-700 dark:text-emerald-400 dark:hover:border-emerald-600 dark:hover:text-emerald-200',
                'teal'      => 'border-transparent text-teal-500 hover:border-teal-300 hover:text-teal-700 dark:text-teal-400 dark:hover:border-teal-600 dark:hover:text-teal-200',
                'cyan'      => 'border-transparent text-cyan-500 hover:border-cyan-300 hover:text-cyan-700 dark:text-cyan-400 dark:hover:border-cyan-600 dark:hover:text-cyan-200',
                'sky'       => 'border-transparent text-sky-500 hover:border-sky-300 hover:text-sky-700 dark:text-sky-400 dark:hover:border-sky-600 dark:hover:text-sky-200',
                'blue'      => 'border-transparent text-blue-500 hover:border-blue-300 hover:text-blue-700 dark:text-blue-400 dark:hover:border-blue-600 dark:hover:text-blue-200',
                'indigo'    => 'border-transparent text-indigo-500 hover:border-indigo-300 hover:text-indigo-700 dark:text-indigo-400 dark:hover:border-indigo-600 dark:hover:text-indigo-200',
                'violet'    => 'border-transparent text-violet-500 hover:border-violet-300 hover:text-violet-700 dark:text-violet-400 dark:hover:border-violet-600 dark:hover:text-violet-200',
                'purple'    => 'border-transparent text-purple-500 hover:border-purple-300 hover:text-purple-700 dark:text-purple-400 dark:hover:border-purple-600 dark:hover:text-purple-200',
                'fuchsia'   => 'border-transparent text-fuchsia-500 hover:border-fuchsia-300 hover:text-fuchsia-700 dark:text-fuchsia-400 dark:hover:border-fuchsia-600 dark:hover:text-fuchsia-200',
                'pink'      => 'border-transparent text-pink-500 hover:border-pink-300 hover:text-pink-700 dark:text-pink-400 dark:hover:border-pink-600 dark:hover:text-pink-200',
                'rose'      => 'border-transparent text-rose-500 hover:border-rose-300 hover:text-rose-700 dark:text-rose-400 dark:hover:border-rose-600 dark:hover:text-rose-200',
                'taupe'     => 'border-transparent text-taupe-500 hover:border-taupe-300 hover:text-taupe-700 dark:text-taupe-400 dark:hover:border-taupe-600 dark:hover:text-taupe-200',
                'mauve'     => 'border-transparent text-mauve-500 hover:border-mauve-300 hover:text-mauve-700 dark:text-mauve-400 dark:hover:border-mauve-600 dark:hover:text-mauve-200',
                'mist'      => 'border-transparent text-mist-500 hover:border-mist-300 hover:text-mist-700 dark:text-mist-400 dark:hover:border-mist-600 dark:hover:text-mist-200',
                'olive'     => 'border-transparent text-olive-500 hover:border-olive-300 hover:text-olive-700 dark:text-olive-400 dark:hover:border-olive-600 dark:hover:text-olive-200',
                'skin'      => 'border-transparent text-skin-500 hover:border-skin-300 hover:text-skin-700 dark:text-skin-400 dark:hover:border-skin-600 dark:hover:text-skin-200',
                'cyberpunk' => 'border-transparent text-cyberpunk-500 hover:border-cyberpunk-300 hover:text-cyberpunk-700 dark:text-cyberpunk-400 dark:hover:border-cyberpunk-600 dark:hover:text-cyberpunk-200',
                'fantasy'   => 'border-transparent text-fantasy-500 hover:border-fantasy-300 hover:text-fantasy-700 dark:text-fantasy-400 dark:hover:border-fantasy-600 dark:hover:text-fantasy-200',
                'wh40k'     => 'border-transparent text-wh40k-500 hover:border-wh40k-300 hover:text-wh40k-700 dark:text-wh40k-400 dark:hover:border-wh40k-600 dark:hover:text-wh40k-200',
            ];

            $ringMap = [
                'slate'     => 'focus-visible:ring-slate-400 dark:focus-visible:ring-slate-600',
                'gray'      => 'focus-visible:ring-gray-400 dark:focus-visible:ring-gray-600',
                'zinc'      => 'focus-visible:ring-zinc-400 dark:focus-visible:ring-zinc-600',
                'neutral'   => 'focus-visible:ring-neutral-400 dark:focus-visible:ring-neutral-600',
                'stone'     => 'focus-visible:ring-stone-400 dark:focus-visible:ring-stone-600',
                'red'       => 'focus-visible:ring-red-400 dark:focus-visible:ring-red-600',
                'orange'    => 'focus-visible:ring-orange-400 dark:focus-visible:ring-orange-600',
                'amber'     => 'focus-visible:ring-amber-400 dark:focus-visible:ring-amber-600',
                'yellow'    => 'focus-visible:ring-yellow-400 dark:focus-visible:ring-yellow-600',
                'lime'      => 'focus-visible:ring-lime-400 dark:focus-visible:ring-lime-600',
                'green'     => 'focus-visible:ring-green-400 dark:focus-visible:ring-green-600',
                'emerald'   => 'focus-visible:ring-emerald-400 dark:focus-visible:ring-emerald-600',
                'teal'      => 'focus-visible:ring-teal-400 dark:focus-visible:ring-teal-600',
                'cyan'      => 'focus-visible:ring-cyan-400 dark:focus-visible:ring-cyan-600',
                'sky'       => 'focus-visible:ring-sky-400 dark:focus-visible:ring-sky-600',
                'blue'      => 'focus-visible:ring-blue-400 dark:focus-visible:ring-blue-600',
                'indigo'    => 'focus-visible:ring-indigo-400 dark:focus-visible:ring-indigo-600',
                'violet'    => 'focus-visible:ring-violet-400 dark:focus-visible:ring-violet-600',
                'purple'    => 'focus-visible:ring-purple-400 dark:focus-visible:ring-purple-600',
                'fuchsia'   => 'focus-visible:ring-fuchsia-400 dark:focus-visible:ring-fuchsia-600',
                'pink'      => 'focus-visible:ring-pink-400 dark:focus-visible:ring-pink-600',
                'rose'      => 'focus-visible:ring-rose-400 dark:focus-visible:ring-rose-600',
                'taupe'     => 'focus-visible:ring-taupe-400 dark:focus-visible:ring-taupe-600',
                'mauve'     => 'focus-visible:ring-mauve-400 dark:focus-visible:ring-mauve-600',
                'mist'      => 'focus-visible:ring-mist-400 dark:focus-visible:ring-mist-600',
                'olive'     => 'focus-visible:ring-olive-400 dark:focus-visible:ring-olive-600',
                'skin'      => 'focus-visible:ring-skin-400 dark:focus-visible:ring-skin-600',
                'cyberpunk' => 'focus-visible:ring-cyberpunk-400 dark:focus-visible:ring-cyberpunk-600',
                'fantasy'   => 'focus-visible:ring-fantasy-400 dark:focus-visible:ring-fantasy-600',
                'wh40k'     => 'focus-visible:ring-wh40k-400 dark:focus-visible:ring-wh40k-600',
            ];

        $this->activeClasses = $activeMap[$this->theme] ?? $activeMap['slate'];
        $this->inactiveClasses = $inactiveMap[$this->theme] ?? $inactiveMap['slate'];
        $this->initiallyActive = $current || ($name !== '' && $name === ($tabs['active'] ?? ''));

        $this->classList = trim(implode(' ', [
            '-mb-px inline-flex items-center gap-2 whitespace-nowrap border-b-2 px-3 py-2 text-sm font-medium transition focus:outline-none focus-visible:ring-2 focus-visible:ring-inset',
            $ringMap[$this->theme] ?? $ringMap['slate'],
            $disabled ? 'pointer-events-none cursor-not-allowed opacity-50' : 'cursor-pointer',
        ]));
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.tabs.tab');
    }
}
