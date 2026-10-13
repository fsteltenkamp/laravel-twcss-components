<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Fsteltenkamp\TwcssComponents\View\Components\Rating as RatingDisplay;
use Illuminate\Contracts\View\View;

/**
 * Star picker: click or arrow keys choose 1..max stars (clicking the chosen star
 * again clears it when `clearable`). The value is Alpine state, x-modelable, so
 * `model` / wire:model / x-model bind it; with `name` a hidden input posts it.
 */
class Rating extends Component
{
    public string $classList;
    public string $starClasses;
    public string $filledClasses;
    public string $emptyClasses;
    public string $buttonClasses;
    public int $current;

    public function __construct(
        public string $id = '',
        public string $name = '',
        public string $label = '',
        public string $note = '',
        public int $value = 0,
        public int $max = 5,
        public string $color = 'base',
        public string $size = 'md',
        public string $model = '',
        public bool $live = false,
        public bool $required = false,
        public bool $disabled = false,
        public bool $clearable = true,
        public bool $inline = false,
        public string $wrapperClass = '',
    ) {
        $this->max = max(1, $max);
        $this->current = max(0, min($this->max, (int) ($name !== '' ? old($name, $value) : $value)));

        ['star' => $this->starClasses, 'filled' => $this->filledClasses, 'empty' => $this->emptyClasses] = RatingDisplay::classes($color, $size);

        $this->classList = 'inline-flex items-center';
        $this->buttonClasses = 'rounded p-0.5 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-current '
            .($disabled ? 'cursor-not-allowed opacity-50' : 'cursor-pointer');

        if ($id === '') {
            $this->id = 'rating-'.uniqid();
        }
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.form.rating');
    }
}
