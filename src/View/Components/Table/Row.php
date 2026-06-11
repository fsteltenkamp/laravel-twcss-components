<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Row extends Component
{
    public function __construct(public ?bool $striped = null, public ?bool $hover = null)
    {
        // Intentionally left empty; values are resolved in Blade with aware parent defaults.
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('twcss::components.table.row');
    }
}
