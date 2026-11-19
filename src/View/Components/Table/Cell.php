<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Fsteltenkamp\TwcssComponents\View\Component;

class Cell extends Component
{
    public ?bool $compactOverride;

    /**
     * @param  string  $label  Field name shown before the value when the table stacks
     *                         into cards (`stack` on the table); usually the column heading.
     * @param  string  $card   Role in the card layout: title (leads the card, no label),
     *                         actions (right-aligned, no label) or hide (left out).
     */
    public function __construct(
        public string $as = 'td',
        public bool $header = false,
        public bool $numeric = false,
        public bool $nowrap = false,
        ?bool $compact = null,
        public string $label = '',
        public string $card = '',
    ) {
        $this->compactOverride = $compact;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.table.cell');
    }
}
