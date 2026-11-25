<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Toolbar;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Fsteltenkamp\TwcssComponents\View\Components\Toolbar;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * A button of x-fltc::toolbar: an icon (and/or text), its label as tooltip and
 * accessible name, `active` for a pressed state (aria-pressed).
 */
class Button extends Component
{
    public string $classList;

    public function __construct(
        public string $icon = '',
        public string $label = '',
        public ?bool $active = null,
        public ?string $color = null,
    ) {
        $this->color = $color ?? ViewFacade::shared('fltcToolbarColor', 'base');
        $this->classList = Toolbar::buttonClasses($this->color);
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.toolbar.button');
    }
}
