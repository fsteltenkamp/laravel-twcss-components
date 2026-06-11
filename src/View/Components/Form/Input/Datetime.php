<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form\Input;

use Fsteltenkamp\TwcssComponents\View\Components\Form\Input;
use Closure;
use Illuminate\Contracts\View\View;

class Datetime extends Input
{
    public string $normalClasses;
    public string $errorClasses;

    public function __construct(
        public string $id = '',
        public string $name = '',
        public string $value = '',
        public string $model = '',
        public bool $live = false,
        public bool $required = false,
        public bool $disabled = false,
        public string $theme = 'sky',
        public string $class = '',
        public string $label = '',
    ) {
        if ($this->name === '') {
            $this->name = $this->id;
        }

        $this->normalClasses = $this->getNormalClasses($theme, $class);
        $this->errorClasses  = $this->getErrorClasses($class);

        if (empty($id)) {
            $this->id = 'datetime-' . uniqid();
        }
    }

    public function render(): View|Closure|string
    {
        return view('twcss::components.form.input.datetime');
    }
}
