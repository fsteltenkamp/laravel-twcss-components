<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Fsteltenkamp\TwcssComponents\View\Component;

class Foot extends Component
{
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.table.foot');
    }
}
