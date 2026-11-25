<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * The head of a page: title (and description) on the left, actions on the right,
 * wrapping below each other on narrow screens. Slots: default (under the title, e.g.
 * breadcrumbs or badges), `actions`.
 */
class PageHeader extends Component
{
    public string $classList;

    public function __construct(
        public string $title = '',
        public string $description = '',
        public string $color = 'base',
        public int $level = 1,
        public string $size = 'xl',
        public bool $divided = false,
    ) {
        $this->classList = trim('mb-6 flex flex-wrap items-center justify-between gap-x-4 gap-y-3'.($divided ? ' border-b pb-4 '.\Fsteltenkamp\TwcssComponents\Support\SidebarTheme::divider($color) : ''));
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.page-header');
    }
}
