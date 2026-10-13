<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\Support\SidebarTheme;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * Hidden content. Inline (default): blacked out until hovered (`reveal="hover"`) or
 * clicked, and it stays revealed after a click. `variant="gate"`: a block whose
 * content is blurred under an overlay with a message and a reveal button; the
 * `message` and `button` slots replace them (an own button calls reveal()), which is
 * how an app builds its own gate (a content warning, a puzzle's answer).
 */
class Spoiler extends Component
{
    public string $classList;
    public string $hiddenClasses;
    public string $shownClasses;
    public string $overlayClasses;
    public string $messageClasses;

    public function __construct(
        public string $variant = 'inline',
        public string $reveal = 'click',
        public string $title = '',
        public string $buttonLabel = '',
        public string $theme = 'slate',
    ) {
        $this->variant = $variant === 'gate' ? 'gate' : 'inline';
        $this->reveal = $reveal === 'hover' ? 'hover' : 'click';

        if ($this->variant === 'inline') {
            $this->classList = 'rounded px-0.5 transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-current';
            // Hidden: a solid bar in the theme's fill colour, text and children invisible.
            $this->hiddenClasses = 'cursor-pointer select-none text-transparent [&_*]:invisible '.Shades::fill($theme);
            $this->shownClasses = Shades::track($theme);
        } else {
            $this->classList = 'relative block overflow-hidden rounded-lg border '.SidebarTheme::divider($theme);
            $this->hiddenClasses = 'pointer-events-none select-none blur-md';
            $this->shownClasses = '';
        }

        $this->overlayClasses = 'absolute inset-0 z-10 flex flex-col items-center justify-center gap-3 bg-white/50 p-6 text-center backdrop-blur-sm dark:bg-black/40';
        $this->messageClasses = 'max-w-md text-sm '.Shades::primary($theme);

        if ($this->title === '' && $this->variant === 'gate') {
            $this->title = __('Spoiler');
        }
        if ($this->buttonLabel === '') {
            $this->buttonLabel = __('Show anyway');
        }
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.spoiler');
    }
}
