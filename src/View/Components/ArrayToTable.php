<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class ArrayToTable extends TableBase
{
    public string $classList;
    public string $headClasses;
    public string $cellClasses;
    public string $borderClasses;
    public string $stripeClasses;
    public string $hoverClasses;

    public function __construct(
        public string $theme = 'gray',
        public string $prefix = '',
        public string $idPrefix = '',
        public string $idSuffix = '',
        public bool $debug = false,
        public array $array = [],
    ) {
        $colors = $this->getThemeColors($this->theme);

        $this->classList = 'w-full min-w-full font-mono text-sm mb-2 '.$colors['divide'];
        $this->headClasses = 'text-left text-xs font-semibold tracking-wide uppercase border-b '.$colors['head'].' '.$colors['border'];
        $this->cellClasses = 'px-3 py-1.5 text-sm align-top '.$colors['cell'];
        $this->borderClasses = $colors['border'];
        $this->stripeClasses = $colors['stripe'];
        $this->hoverClasses = $colors['hover'];
    }

    public function render(): View|Closure|string
    {
        return view('twcss::components.array-to-table');
    }
}
