<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Dropdown;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\SidebarTheme;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * One entry of x-fltc::dropdown: a link (href), a form submit (href + method other
 * than GET, with CSRF) or a button (no href, for wire:click / x-on:click).
 */
class Item extends Component
{
    public string $classList;
    public string $tag;

    public function __construct(
        public string $href = '',
        public string $method = 'get',
        public string $icon = '',
        public string $iconVariant = 'regular',
        public bool $disabled = false,
        public ?string $theme = null,
    ) {
        $this->theme = $theme ?? ViewFacade::shared('fltcDropdownTheme', 'slate');
        $this->method = strtoupper($method);

        $this->tag = match (true) {
            $href === '' => 'button',
            $this->method === 'GET' => 'a',
            default => 'form',
        };

        $this->classList = trim(implode(' ', [
            'flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm transition focus:outline-none focus-visible:ring-2',
            SidebarTheme::inactive($this->theme),
            $disabled ? 'pointer-events-none cursor-not-allowed opacity-50' : 'cursor-pointer',
        ]));
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.dropdown.item');
    }
}
