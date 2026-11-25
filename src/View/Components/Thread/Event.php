<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Thread;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * A system line in x-fltc::thread ("Status changed to closed"), centred and small.
 */
class Event extends Component
{
    public string $classList;

    public function __construct(
        public string $icon = '',
        public string $meta = '',
        public ?string $color = null,
    ) {
        $this->color = $color ?? (ViewFacade::shared('fltcThread', [])['color'] ?? 'base');
        $this->classList = 'flex items-center justify-center gap-1.5 text-center text-xs '.Shades::tertiary($this->color);
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.thread.event');
    }
}
