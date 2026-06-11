<?php

namespace Fsteltenkamp\fltcComponents\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Head extends Component
{
    public string $stickyClasses;

    public function __construct(public bool $sticky = false)
    {
        $this->stickyClasses = $this->sticky ? 'sticky top-0 z-10' : '';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.table.head');
    }
}
