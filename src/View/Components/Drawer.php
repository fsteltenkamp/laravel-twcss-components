<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\DrawerTheme;
use Fsteltenkamp\TwcssComponents\Support\SidebarTheme;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Drawer extends Component
{
    /**
     * Width of a tab in the screen-edge rail. The open panel is capped so a
     * tab always still fits beside it, even on a phone.
     */
    public const RAIL_WIDTH = '2.5rem';

    public string $classList;
    public string $headerClasses;
    public string $titleClasses;
    public string $bodyClasses;
    public string $buttonClasses;
    public string $pinClasses;
    public string $tabClasses;
    public string $tabRestingClasses;
    public string $tabActiveClasses;
    public string $pinRestingClasses;
    public string $pinActiveClasses;
    public string $closedClass;
    public string $panelWidth;
    public bool $hasTab;

    /**
     * @param  string       $name       Stable key: target for open/close/toggle events and the
     *                                  localStorage key of a persisted pin. Random when omitted.
     * @param  string       $side       "left" or "right" screen edge.
     * @param  string       $title      Heading shown in the panel header.
     * @param  string|null  $label      Text on the vertical activation tab. Without a label and
     *                                  icon the drawer has no tab and is opened through events.
     * @param  string       $icon       Phosphor icon shown on the tab (e.g. "book-open").
     * @param  int          $order      Tab position within the side's rail, top to bottom.
     * @param  bool         $pinnable   Show a pin button; a pinned drawer stays open on outside
     *                                  clicks/Escape and its pin survives page loads.
     * @param  bool         $open       Initial open state.
     * @param  string       $width      Panel width as a CSS length.
     * @param  string       $offset     Distance from the viewport top as a CSS length (e.g. the
     *                                  height of a sticky navbar).
     */
    public function __construct(
        public string $name = '',
        public string $side = 'right',
        public string $title = '',
        public ?string $label = null,
        public string $icon = '',
        public int $order = 0,
        public string $theme = 'slate',
        public bool $pinnable = false,
        public bool $open = false,
        public string $width = '24rem',
        public string $offset = '0px',
        public string $class = '',
    ) {
        $this->name = $this->name !== '' ? $this->name : 'drawer-'.Str::lower(Str::random(8));
        $this->side = $this->side === 'left' ? 'left' : 'right';
        $this->hasTab = filled($this->label) || filled($this->icon);
        $this->panelWidth = 'min('.$this->width.', calc(100vw - '.self::RAIL_WIDTH.'))';

        $isLeft = $this->side === 'left';

        // Off-canvas resting position. Rendered statically when the drawer
        // starts closed so it never flashes in before Alpine boots; Alpine then
        // toggles `!translate-x-0` on top of it.
        $this->closedClass = $isLeft ? '-translate-x-full' : 'translate-x-full';

        $this->classList = trim(implode(' ', array_filter([
            'fixed bottom-0 z-40 flex flex-col shadow-xl transition-transform duration-200 ease-out',
            $isLeft ? 'left-0 border-r' : 'right-0 border-l',
            SidebarTheme::surface($this->theme),
            $this->class,
        ])));

        $this->headerClasses = 'flex shrink-0 items-center justify-between gap-2 border-b px-4 py-3 '.SidebarTheme::divider($this->theme);
        $this->titleClasses = 'min-w-0 truncate text-sm font-semibold';
        $this->bodyClasses = 'flex-1 overflow-y-auto p-4';

        $buttonBase = 'inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md transition focus:outline-none focus-visible:ring-2';
        $this->buttonClasses = $buttonBase.' '.SidebarTheme::inactive($this->theme);
        // The pin button's colours are bound entirely by Alpine (resting vs
        // pinned) so the two states never fight over the same utilities.
        $this->pinClasses = $buttonBase;
        $this->pinRestingClasses = SidebarTheme::inactive($this->theme);
        $this->pinActiveClasses = SidebarTheme::active($this->theme);

        // Vertical tab: `vertical-rl` stacks icon and label along the tab.
        // Right-side tabs are rotated 180° so the borderless (attached) edge
        // faces the screen edge; the icon is counter-rotated to stay upright.
        $this->tabClasses = trim(implode(' ', [
            'pointer-events-auto flex items-center gap-2 border border-l-0 rounded-r-md px-2 py-3 shadow-md',
            'text-xs font-semibold uppercase tracking-widest transition-colors focus:outline-none focus-visible:ring-2',
            '[writing-mode:vertical-rl] w-10',
            $isLeft ? '' : 'rotate-180',
        ]));
        $this->tabRestingClasses = DrawerTheme::tab($this->theme);
        $this->tabActiveClasses = DrawerTheme::tabActive($this->theme);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.drawer');
    }
}
