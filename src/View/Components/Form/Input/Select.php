<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form\Input;

use Fsteltenkamp\TwcssComponents\View\Components\Form\Input;
use Closure;
use Illuminate\Contracts\View\View;

class Select extends Input
{
    public string $normalClasses;
    public string $errorClasses;

    public function __construct(
        public string $id = '',
        public string $name = '',
        public string $value = '',
        public string $model = '',
        public bool $live = false,
        public string $placeholder = '',
        public bool $required = false,
        public bool $disabled = false,
        public string $theme = 'sky',
        public string $class = '',
        public string $label = '',
        public string $icon = '',
    ) {
        if ($this->name === '') {
            $this->name = $this->id;
        }

        $this->normalClasses = $this->getNormalClasses($theme, $class);
        $this->errorClasses = $this->getErrorClasses($class);

        if (empty($id)) {
            $this->id = 'select-' . uniqid();
        }
    }

    public function render(): View|Closure|string
    {
        return view('twcss::components.form.input.select');
    }
}
