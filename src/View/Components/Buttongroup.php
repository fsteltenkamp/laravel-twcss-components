<?php

namespace Fsteltenkamp\fltcComponents\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Buttongroup extends Component
{
    public string $groupClasses;

    public function __construct(
        public bool $full = false,
        public string $class = '',
    ) {
        $this->groupClasses = trim(implode(' ', array_filter([
            $this->full ? 'flex w-full' : 'inline-flex',
            'isolate items-stretch rounded-md shadow-sm',
            '[&>*]:relative',
            '[&>*]:shrink-0',
            '[&>*]:!rounded-none',
            '[&>*]:!shadow-none',
            '[&>*]:focus:z-10',
            '[&>*>*>*]:!rounded-none',
            '[&>*>*>*]:!shadow-none',
            '[&>*>*>*]:focus:z-10',
            '[&>*+*]:-ml-px',
            '[&>*:first-child]:!rounded-l-md',
            '[&>*:last-child]:!rounded-r-md',
            '[&>*:first-child>*>*]:!rounded-l-md',
            '[&>*:last-child>*>*]:!rounded-r-md',
            $this->full ? '[&>*]:flex-1 [&>*]:justify-center [&>*>*]:w-full [&>*>*>*]:w-full [&>*>*>*]:justify-center' : null,
            $this->class,
        ])));
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.buttongroup');
    }
}
