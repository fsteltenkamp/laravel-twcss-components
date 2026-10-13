<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Darkmode;

use Closure;
use Illuminate\Contracts\View\View;
use Fsteltenkamp\TwcssComponents\View\Component;
use Fsteltenkamp\TwcssComponents\View\Components\Segmented;

class Toggle extends Component
{
    public readonly string $storageKey;
    public readonly array $options;
    public readonly string $containerClasses;
    public readonly string $activeClasses;
    public readonly string $inactiveClasses;

    /**
     * @param  string  $variant   `default` renders a three-button segmented control
     *                            (light / dark / system); `toggle` renders the pill
     *                            switch built on the form checkbox toggle component.
     * @param  string  $color     Accent colour: the active segment (default variant) or
     *                            the "on"/dark track (toggle variant). Full palette.
     * @param  string  $colorOff  The "off"/light track colour for the toggle variant.
     * @param  string  $size      Size token forwarded to the toggle variant (sm/md/lg).
     */
    public function __construct(
        public string $variant = 'default',
        public string $color = 'base',
        public string $colorOff = 'base',
        public string $size = 'md',
    ) {
        // Stored preference is one of: light | dark | system. A missing value is
        // treated as `system` so the OS setting is the default.
        $this->storageKey = 'color';

        $this->options = [
            ['value' => 'light',  'label' => 'Light',  'icon' => 'sun'],
            ['value' => 'dark',   'label' => 'Dark',   'icon' => 'moon'],
            ['value' => 'system', 'label' => 'System', 'icon' => 'desktop'],
        ];

        // The segmented control's colours: the toggle renders through x-fltc::segmented.
        ['container' => $this->containerClasses, 'active' => $this->activeClasses, 'inactive' => $this->inactiveClasses] = Segmented::classes($color);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.darkmode.toggle');
    }
}
