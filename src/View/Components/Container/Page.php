<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Container;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Centred page-content column that keeps clear of drawer tabs.
 *
 * Each side with a drawer rail gets a 3rem gutter: the rail's 2.5rem
 * (Drawer::RAIL_WIDTH) plus a 0.5rem gap, so the tabs sit in the margin
 * between the screen edge and the content and never overlap it. From `sm` up,
 * the gutter also grows by the width of a pinned drawer
 * (--fltc-drawer-pin-left/right), so the content slides over beside it.
 *
 * `box-content` applies the max width to the content alone, so on wide
 * screens the column keeps its full width and the gutters sit outside it.
 */
class Page extends Component
{
    public string $classList;

    /**
     * @param  string  $width   Max content width: sm … 7xl, prose or full.
     * @param  string  $gutter  Sides that reserve room for drawer tabs:
     *                          both, left, right or none.
     */
    public function __construct(
        public string $width = '7xl',
        public string $gutter = 'both',
        string $class = '',
    ) {
        $widthMap = [
            'sm'    => 'max-w-sm',
            'md'    => 'max-w-md',
            'lg'    => 'max-w-lg',
            'xl'    => 'max-w-xl',
            '2xl'   => 'max-w-2xl',
            '3xl'   => 'max-w-3xl',
            '4xl'   => 'max-w-4xl',
            '5xl'   => 'max-w-5xl',
            '6xl'   => 'max-w-6xl',
            '7xl'   => 'max-w-7xl',
            'prose' => 'max-w-prose',
            'full'  => 'max-w-none',
        ];

        $railLeft = 'ps-12 sm:ps-[calc(var(--fltc-drawer-pin-left,0px)_+_3rem)]';
        $railRight = 'pe-12 sm:pe-[calc(var(--fltc-drawer-pin-right,0px)_+_3rem)]';
        $plainLeft = 'ps-4 sm:ps-6';
        $plainRight = 'pe-4 sm:pe-6';

        $gutterMap = [
            'both'  => [$railLeft, $railRight],
            'left'  => [$railLeft, $plainRight],
            'right' => [$plainLeft, $railRight],
            'none'  => [$plainLeft, $plainRight],
        ];

        $this->classList = trim(implode(' ', [
            'mx-auto box-content transition-[padding] duration-200 ease-out',
            $widthMap[$width] ?? $widthMap['7xl'],
            ...($gutterMap[$gutter] ?? $gutterMap['both']),
            $class,
        ]));
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.container.page');
    }
}
