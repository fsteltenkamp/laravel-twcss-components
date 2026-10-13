<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\SidebarTheme;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * A menu that opens from any trigger (Alpine). Items are x-fltc::dropdown.item and
 * inherit this theme. Unlike nav.navbar.dropdown it is not tied to the navbar.
 */
class Dropdown extends Component
{
    public string $classList;
    public string $menuClasses;

    public function __construct(
        public string $color = 'base',
        public string $align = 'left',
        public string $position = 'bottom',
        public string $width = 'md',
    ) {
        $alignMap = [
            'left'  => 'left-0 origin-top-left',
            'right' => 'right-0 origin-top-right',
        ];

        $positionMap = [
            'bottom' => 'top-full mt-1',
            'top'    => 'bottom-full mb-1',
        ];

        $widthMap = [
            'sm'   => 'w-40',
            'md'   => 'w-56',
            'lg'   => 'w-72',
            'auto' => 'w-max min-w-full',
        ];

        $this->classList = 'relative inline-block text-left';

        $this->menuClasses = trim(implode(' ', [
            'absolute z-30 overflow-hidden rounded-lg border p-1.5 focus:outline-none',
            $alignMap[$align] ?? $alignMap['left'],
            $positionMap[$position] ?? $positionMap['bottom'],
            $widthMap[$width] ?? $widthMap['md'],
            SidebarTheme::menu($color),
        ]));
    }

    public function render(): View|Closure|string
    {
        ViewFacade::share('fltcDropdownColor', $this->color);

        return view('fltc::components.dropdown');
    }
}
