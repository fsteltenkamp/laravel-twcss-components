<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Toast;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Components\Toast;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Container extends Component
{
    public string $classList;
    public array $themeMap;

    public function __construct(
        public string $position = 'bottom-right',
        public string $theme = 'gray',
        public string $variant = 'simple',
        public int $duration = 4000,
        public string $width = 'w-80',
    ) {
        $positionMap = [
            'top-left'      => 'fixed top-4 left-4 z-50 flex flex-col gap-2',
            'top-center'    => 'fixed top-4 left-1/2 z-50 flex -translate-x-1/2 flex-col items-center gap-2',
            'top-right'     => 'fixed top-4 right-4 z-50 flex flex-col gap-2',
            'bottom-left'   => 'fixed bottom-4 left-4 z-50 flex flex-col-reverse gap-2',
            'bottom-center' => 'fixed bottom-4 left-1/2 z-50 flex -translate-x-1/2 flex-col-reverse items-center gap-2',
            'bottom-right'  => 'fixed bottom-4 right-4 z-50 flex flex-col-reverse gap-2',
        ];

        $this->classList = trim(implode(' ', [
            $positionMap[$this->position] ?? $positionMap['bottom-right'],
            $this->width,
        ]));

        $this->themeMap = Toast::themeMap();
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.toast.container');
    }
}
