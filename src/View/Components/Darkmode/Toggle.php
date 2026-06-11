<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Darkmode;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Toggle extends Component
{
    public readonly string $darkIcon;
    public readonly string $lightIcon;
    public readonly array $lightState;
    public readonly array $darkState;
    public readonly string $storageKey;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->darkIcon = <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
</svg>
SVG;

        $this->lightIcon = <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
</svg>
SVG;

        // Light mode: yellow background, positioned to the left
        $this->lightState = [
            'icon' => $this->lightIcon,
            'bgColor' => 'bg-yellow-500',
            'removeClasses' => ['bg-gray-700', 'translate-x-full'],
            'addClasses' => ['bg-yellow-500', '-translate-x-2'],
        ];

        // Dark mode: gray background, positioned to the right
        $this->darkState = [
            'icon' => $this->darkIcon,
            'bgColor' => 'bg-gray-700',
            'removeClasses' => ['bg-yellow-500', '-translate-x-2'],
            'addClasses' => ['bg-gray-700', 'translate-x-full'],
        ];

        $this->storageKey = 'isDarkmode';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.darkmode.toggle');
    }
}
