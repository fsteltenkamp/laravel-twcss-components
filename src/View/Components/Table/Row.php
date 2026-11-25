<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Fsteltenkamp\TwcssComponents\View\Component;

class Row extends Component
{
    /**
     * @param  string  $href  makes the whole row a link: click (not on its own links, buttons
     *                        or fields), Enter, and Ctrl/⌘/middle click for a new tab
     * @param  bool  $navigate  follow the link with wire:navigate (Livewire.navigate)
     */
    public function __construct(public ?bool $striped = null, public ?bool $hover = null, public string $href = '', public bool $navigate = false)
    {
        // Intentionally left empty; values are resolved in Blade with aware parent defaults.
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.table.row');
    }
}
