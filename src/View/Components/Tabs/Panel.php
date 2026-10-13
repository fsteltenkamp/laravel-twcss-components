<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Tabs;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * Content shown while the tab with the same `name` is active.
 */
class Panel extends Component
{
    public string $classList;
    public string $tabsId;

    /**
     * Rendered hidden: only when the tabs' `active` prop names another panel, so
     * the right panel shows before Alpine starts. Without `active` the panels are
     * x-cloak'ed until Alpine picks the first tab.
     */
    public bool $hidden;

    public bool $cloak;

    public function __construct(
        public string $name = '',
    ) {
        $tabs = ViewFacade::shared('fltcTabs', []);
        $active = $tabs['active'] ?? '';

        $this->tabsId = $tabs['id'] ?? 'tabs';
        $this->hidden = $active !== '' && $active !== $name;
        $this->cloak = $active === '';
        $this->classList = 'pt-4 focus:outline-none';
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.tabs.panel');
    }
}
