<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Nav;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\SidebarTheme;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Fsteltenkamp\TwcssComponents\View\Component;

class Sidebar extends Component
{
    public string $classList;
    public string $headerClass;
    public string $openClasses;
    public string $backdropClasses;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $color = 'base',
        public string $class = '',
        public string $width = 'w-64',
        public string $heightClass = 'h-screen',
        public bool $collapsible = true,
        public string $name = '',
        public string $headerHeight = 'md',
        public bool $pinnable = false,
        public string $persist = 'fltc-sidebar',
    ) {
        // Brand row height, to line up with the navbar's `height`: sm 48px, md 64px, lg 80px.
        $this->headerClass = ['sm' => 'h-12', 'md' => 'h-16', 'lg' => 'h-20'][$headerHeight] ?? $headerHeight;

        // Pinnable (from lg up): the visitor pins the sidebar as a column or hides it; hidden,
        // it leaves the layout and the navbar toggle slides it over the content like the
        // drawer below lg. The state is data-sidebar="pinned|collapsed" on <html>, kept in
        // localStorage under `persist` (see the view's script).
        $pinnableClasses = $this->pinnable
            ? 'lg:[[data-sidebar=collapsed]_&]:fixed lg:[[data-sidebar=collapsed]_&]:inset-y-0 lg:[[data-sidebar=collapsed]_&]:left-0 lg:[[data-sidebar=collapsed]_&]:z-50 lg:[[data-sidebar=collapsed]_&]:-translate-x-full'
            : null;
        $this->openClasses = $this->pinnable
            ? 'max-lg:!translate-x-0 lg:[[data-sidebar=collapsed]_&]:!translate-x-0 lg:[[data-sidebar=collapsed]_&]:shadow-2xl'
            : 'max-lg:!translate-x-0';
        $this->backdropClasses = $this->pinnable ? 'lg:hidden lg:[[data-sidebar=collapsed]_&]:block' : 'lg:hidden';

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
            $pinnableClasses,
            $this->heightClass,
            $this->width,
            SidebarTheme::surface($this->color),
            $this->class,
        ])));

        // Share the sidebar theme so child links/groups/footer inherit it
        // when no explicit theme is provided.
        ViewFacade::share(['sidebarColor' => $this->color]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.nav.sidebar')
            ->with('color', $this->color)
            ->with('collapsible', $this->collapsible)
            ->with('name', $this->name);
    }
}
