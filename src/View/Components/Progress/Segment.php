<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Progress;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * One part of a split x-fltc::progress bar, `value` of the bar's `max`.
 */
class Segment extends Component
{
    public string $classList;
    public float $percent;

    public function __construct(
        public float $value = 0,
        public ?string $color = null,
        public string $label = '',
    ) {
        $bar = ViewFacade::shared('fltcProgress');
        $segment = $bar
            ? $bar->addSegment($value, $color, $label)
            : ['percent' => max(0, min(100, $value)), 'color' => $color ?? 'base', 'fillClasses' => ''];

        $this->color = $segment['color'];
        $this->percent = $segment['percent'];
        $this->classList = $segment['fillClasses'];
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.progress.segment');
    }
}
