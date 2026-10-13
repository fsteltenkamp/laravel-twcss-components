<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * Loading indicator. Pair it with wire:loading / wire:target (or x-show) to show it
 * while a request runs; theme="current" takes the surrounding text colour, e.g.
 * inside a button.
 */
class Spinner extends Component
{
    public string $classList;

    public function __construct(
        public string $theme = 'slate',
        public string $size = 'md',
        public string $label = '',
    ) {
        $sizeMap = [
            'xs' => 'h-3 w-3',
            'sm' => 'h-4 w-4',
            'md' => 'h-5 w-5',
            'lg' => 'h-8 w-8',
            'xl' => 'h-12 w-12',
        ];

        $this->classList = trim(implode(' ', [
            'inline-block shrink-0 animate-spin',
            $sizeMap[$size] ?? $sizeMap['md'],
            $theme === 'current' ? 'text-current' : Shades::tertiary($theme),
        ]));

        if ($this->label === '') {
            $this->label = __('Loading');
        }
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.spinner');
    }
}
