<?php

namespace Fsteltenkamp\fltcComponents\View\Components\Form\Input;

use Fsteltenkamp\fltcComponents\View\Components\Form\Input;
use Closure;
use Illuminate\Contracts\View\View;

class Password extends Input
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
        public string $autocomplete = '',
        public bool $required = false,
        public bool $autofocus = false,
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
            $this->id = 'password-' . uniqid();
        }
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.form.input.password');
    }
}
