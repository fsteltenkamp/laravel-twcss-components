<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Segmented;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Fsteltenkamp\TwcssComponents\View\Components\Segmented;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * One button of x-fltc::segmented; active while the group's value is `value`.
 */
class Option extends Component
{
    public string $classList;
    public string $activeClasses;
    public string $inactiveClasses;
    public bool $interactive;
    public bool $initiallyActive;

    public function __construct(
        public string $value = '',
        public string $label = '',
        public string $icon = '',
        public string $iconVariant = 'regular',
        public bool $disabled = false,
    ) {
        $group = ViewFacade::shared('fltcSegmented') ?? Segmented::classes('base') + ['color' => 'base', 'value' => '', 'interactive' => true];

        $this->hookColor = $group['color'];
        $this->activeClasses = $group['active'];
        $this->inactiveClasses = $group['inactive'];
        $this->interactive = $group['interactive'];
        $this->initiallyActive = $value !== '' && $value === $group['value'];

        $this->classList = trim(implode(' ', [
            'inline-flex items-center gap-1.5 rounded-md px-3 py-1.5 text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2',
            $disabled ? 'cursor-not-allowed opacity-50' : 'cursor-pointer',
        ]));
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.segmented.option');
    }
}
