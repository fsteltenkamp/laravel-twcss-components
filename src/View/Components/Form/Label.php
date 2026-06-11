<?php

namespace Fsteltenkamp\fltcComponents\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Label extends Component
{
    public function __construct(
        public string $for = '',
        public bool $required = false,
        public string $description = '',
    ) {
    }

    /**
     * Create a new component instance.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.form.label');
    }
}
