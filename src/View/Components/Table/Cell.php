<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Cell extends Component
{
    public ?bool $compactOverride;

    public function __construct(
        public string $as = 'td',
        public bool $header = false,
        public bool $numeric = false,
        public bool $nowrap = false,
        ?bool $compact = null,
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
