<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Badge;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * Wrapping layout for tag and facet lists of x-fltc::badge chips, which take its theme.
 */
class Cloud extends Component
{
    public string $classList;

    public function __construct(
        public string $color = 'base',
        public string $gap = 'md',
        public string $label = '',
    ) {
        $gapMap = [
            'sm' => 'gap-1',
            'md' => 'gap-2',
            'lg' => 'gap-3',
        ];

        $this->classList = 'flex flex-wrap items-center '.($gapMap[$gap] ?? $gapMap['md']);
    }

    public function render(): View|Closure|string
    {
        ViewFacade::share('fltcBadgeColor', $this->color);

        return view('fltc::components.badge.cloud');
    }
}
