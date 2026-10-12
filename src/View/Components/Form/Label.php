<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Label extends Component
{
    public string $classList;

    public function __construct(
        public string $for = '',
        public bool $required = false,
        public string $description = '',
        public string $theme = 'slate',
    ) {
        $this->classList = 'mb-1 block text-sm font-medium '.Shades::secondary($theme);
    }

    /**
     * Create a new component instance.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.form.label');
    }
}
