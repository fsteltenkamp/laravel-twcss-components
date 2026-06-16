<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Nav;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\SidebarTheme;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public string $classList;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $theme = 'slate',
        public string $class = '',
        public string $width = 'w-64',
        public string $heightClass = 'h-screen',
    ) {
        $this->classList = trim(implode(' ', array_filter([
            'flex flex-col shrink-0 border-r',
            $this->heightClass,
            $this->width,
            SidebarTheme::surface($this->theme),
            $this->class,
        ])));

        // Share the sidebar theme so child links/groups/footer inherit it
        // when no explicit theme is provided.
        ViewFacade::share(['sidebarTheme' => $this->theme]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.nav.sidebar')->with('theme', $this->theme);
    }
}
