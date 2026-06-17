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
        public bool $collapsible = true,
        public string $name = '',
    ) {
        // Below `lg` the sidebar becomes an off-canvas drawer: pinned to the
        // viewport edge, lifted above the page on its own z-index and slid out
        // of view until toggled. The Alpine state in the view flips
        // `max-lg:!translate-x-0` on to reveal it. From `lg` up it returns to a
        // normal in-flow column (`lg:translate-x-0` keeps it visible regardless
        // of the toggle state). The closed transform is a static class so the
        // drawer never flashes open before Alpine boots.
        $drawerClasses = $this->collapsible
            ? 'max-lg:fixed max-lg:inset-y-0 max-lg:left-0 max-lg:z-50 max-lg:-translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out'
            : null;

        $this->classList = trim(implode(' ', array_filter([
            'flex flex-col shrink-0 border-r',
            $drawerClasses,
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
        return view('fltc::components.nav.sidebar')
            ->with('theme', $this->theme)
            ->with('collapsible', $this->collapsible)
            ->with('name', $this->name);
    }
}
