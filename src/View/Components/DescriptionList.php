<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * Label → value pairs (<dl>): customer details, a price list, totals. Give `items` or
 * x-fltc::description-list.item children.
 */
class DescriptionList extends Component
{
    public string $classList;

    /** @var array<int, array{label: string, value: mixed, icon: string}> */
    public array $rows = [];

    /**
     * @param  array<int|string, mixed>  $items  label => value, or [label, value, icon?] rows
     * @param  string  $layout  `grid` (labels in a column beside the values, default),
     *                          `stacked` (label above value) or `inline` (label: value)
     * @param  string  $size  `xs`, `sm` (default) or `lg`
     */
    public function __construct(
        public array $items = [],
        public string $layout = 'grid',
        public string $size = 'sm',
        public string $color = 'base',
    ) {
        foreach ($items as $label => $value) {
            $this->rows[] = is_array($value) && array_is_list($value)
                ? ['label' => (string) $value[0], 'value' => $value[1] ?? '', 'icon' => (string) ($value[2] ?? '')]
                : ['label' => (string) $label, 'value' => $value, 'icon' => ''];
        }

        $this->classList = trim(implode(' ', [
            match ($size) { 'xs' => 'text-xs', 'lg' => 'text-base', default => 'text-sm' },
            match ($layout) {
                'stacked' => 'grid gap-3 sm:grid-cols-2',
                'inline' => 'flex flex-wrap gap-x-6 gap-y-1',
                default => 'grid grid-cols-[auto_1fr] gap-x-6 gap-y-2',
            },
        ]));
    }

    public function render(): View|Closure|string
    {
        ViewFacade::share('fltcDescriptionList', ['color' => $this->color, 'layout' => $this->layout]);

        return view('fltc::components.description-list');
    }
}
