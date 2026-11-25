<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Toast;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * Shows a toast whenever a window event fires — a Livewire event ($this->dispatch('saved'))
 * or any CustomEvent: <x-fltc::toast.on event="saved" title="Saved." color="success" />.
 * Needs an x-fltc::toast.container on the page. Renders no visible markup.
 */
class On extends Component
{
    public function __construct(
        public string $event = '',
        public string $title = '',
        public string $message = '',
        public string $icon = '',
        public string $color = 'success',
        public string $variant = '',
        public ?int $duration = null,
    ) {}

    /**
     * The fltc:toast payload.
     *
     * @return array<string, mixed>
     */
    public function payload(): array
    {
        return array_filter([
            'title' => $this->title,
            'message' => $this->message,
            'icon' => $this->icon,
            'color' => $this->color,
            'variant' => $this->variant,
            'duration' => $this->duration,
        ], fn ($value) => $value !== '' && $value !== null);
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.toast.on');
    }
}
