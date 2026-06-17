<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Button;

use Fsteltenkamp\TwcssComponents\View\Components\Button;
use Closure;
use Illuminate\Contracts\View\View;

class Link extends Button
{
    public function __construct(
        public string $href = '#',
        public bool $navigate = false,
        string $theme = 'gray',
        string $width = 'fit',
        string $height = 'md',
        string $tooltip = '',
        public bool $disabled = false,
        public string $variant = 'solid',
        string $icon = '',
        string $iconVariant = 'regular',
        string $iconPosition = 'before',
        string $class = ''
    )
    {
        parent::__construct(theme: $theme, width: $width, height: $height, tooltip: $tooltip, disabled: $disabled, variant: $variant, icon: $icon, iconVariant: $iconVariant, iconPosition: $iconPosition, class: $class);
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.button.link');
    }
}
