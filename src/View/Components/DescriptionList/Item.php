<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\DescriptionList;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * One label → value pair of x-fltc::description-list (the value is the slot).
 */
class Item extends Component
{
    public string $layout;
    public string $termClasses;
    public string $valueClasses;

    /**
     * @param  bool  $numeric  right-aligned tabular figures (amounts)
     * @param  bool  $total  a sum row: bold, with a rule above it
     */
    public function __construct(
        public string $label = '',
        public string $icon = '',
        public bool $numeric = false,
        public bool $total = false,
        public ?string $color = null,
    ) {
        $list = ViewFacade::shared('fltcDescriptionList', []);
        $this->color = $color ?? ($list['color'] ?? 'base');
        $this->layout = $list['layout'] ?? 'grid';

        $ruleMap = [
            'slate'     => 'border-t border-slate-300 pt-2 dark:border-slate-600',
            'gray'      => 'border-t border-gray-300 pt-2 dark:border-gray-600',
            'zinc'      => 'border-t border-zinc-300 pt-2 dark:border-zinc-600',
            'neutral'   => 'border-t border-neutral-300 pt-2 dark:border-neutral-600',
            'stone'     => 'border-t border-stone-300 pt-2 dark:border-stone-600',
            'red'       => 'border-t border-red-300 pt-2 dark:border-red-600',
            'orange'    => 'border-t border-orange-300 pt-2 dark:border-orange-600',
            'amber'     => 'border-t border-amber-300 pt-2 dark:border-amber-600',
            'yellow'    => 'border-t border-yellow-300 pt-2 dark:border-yellow-600',
            'lime'      => 'border-t border-lime-300 pt-2 dark:border-lime-600',
            'green'     => 'border-t border-green-300 pt-2 dark:border-green-600',
            'emerald'   => 'border-t border-emerald-300 pt-2 dark:border-emerald-600',
            'teal'      => 'border-t border-teal-300 pt-2 dark:border-teal-600',
            'cyan'      => 'border-t border-cyan-300 pt-2 dark:border-cyan-600',
            'sky'       => 'border-t border-sky-300 pt-2 dark:border-sky-600',
            'blue'      => 'border-t border-blue-300 pt-2 dark:border-blue-600',
            'indigo'    => 'border-t border-indigo-300 pt-2 dark:border-indigo-600',
            'violet'    => 'border-t border-violet-300 pt-2 dark:border-violet-600',
            'purple'    => 'border-t border-purple-300 pt-2 dark:border-purple-600',
            'fuchsia'   => 'border-t border-fuchsia-300 pt-2 dark:border-fuchsia-600',
            'pink'      => 'border-t border-pink-300 pt-2 dark:border-pink-600',
            'rose'      => 'border-t border-rose-300 pt-2 dark:border-rose-600',
            'taupe'     => 'border-t border-taupe-300 pt-2 dark:border-taupe-600',
            'mauve'     => 'border-t border-mauve-300 pt-2 dark:border-mauve-600',
            'mist'      => 'border-t border-mist-300 pt-2 dark:border-mist-600',
            'olive'     => 'border-t border-olive-300 pt-2 dark:border-olive-600',
            'primary'   => 'border-t border-primary-300 pt-2 dark:border-primary-600',
            'secondary' => 'border-t border-secondary-300 pt-2 dark:border-secondary-600',
            'accent'    => 'border-t border-accent-300 pt-2 dark:border-accent-600',
            'base'      => 'border-t border-base-300 pt-2 dark:border-base-600',
            'info'      => 'border-t border-info-300 pt-2 dark:border-info-600',
            'success'   => 'border-t border-success-300 pt-2 dark:border-success-600',
            'warning'   => 'border-t border-warning-300 pt-2 dark:border-warning-600',
            'danger'    => 'border-t border-danger-300 pt-2 dark:border-danger-600',
        ];

        $rule = $total ? ($ruleMap[$this->color] ?? $ruleMap['base']) : '';

        $this->termClasses = trim(implode(' ', [
            'flex items-center gap-1.5',
            $this->layout === 'inline' ? '' : 'font-medium',
            Shades::tertiary($this->color),
            $rule,
        ]));
        $this->valueClasses = trim(implode(' ', [
            'min-w-0',
            $numeric ? 'text-right tabular-nums' : '',
            $total ? 'font-semibold' : '',
            Shades::primary($this->color),
            $rule,
        ]));
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.description-list.item');
    }
}
