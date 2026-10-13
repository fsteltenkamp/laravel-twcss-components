<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form\Input;

use Fsteltenkamp\TwcssComponents\View\Components\Form\Input;
use Closure;
use Illuminate\Contracts\View\View;

/**
 * Single-line <input>. Also the base of the typed inputs (number, date, time,
 * datetime, email, password): they only change $defaultType and share this view.
 */
class Text extends Input
{
    /**
     * `type` attribute when the `type` prop is not given.
     */
    protected string $defaultType = 'text';

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
        public string $theme = 'slate',
        public string $class = '',
        public string $label = '',
        public string $icon = '',
        public string $iconVariant = 'regular',
        public string $type = '',
        public bool $inline = false,
        public string $note = '',
        public string $wrapperClass = '',
    ) {
        $this->type = $type !== '' ? $type : $this->defaultType;

        if ($this->name === '') {
            $this->name = $this->id;
        }

        $this->normalClasses  = $this->getNormalClasses($theme, $class);
        $this->errorClasses   = $this->getErrorClasses($class);

        if (empty($id)) {
            $this->id = $this->type . '-' . uniqid();
        }
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.form.input.text');
    }
}
