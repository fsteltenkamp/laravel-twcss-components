<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * Label, note and validation error around any control. The library's inputs render
 * their own field through this; use it directly for custom controls.
 */
class Field extends Component
{
    public string $classList;
    public string $noteClasses;
    public string $errorKey;

    /**
     * @param  string  $for   id of the control the label points at
     * @param  string  $name  field name for the validation error (default: `for`); a
     *                        trailing [] is dropped and name.* errors count too
     */
    public function __construct(
        public string $label = '',
        public string $note = '',
        public string $for = '',
        public string $name = '',
        public bool $required = false,
        public string $theme = 'slate',
        public bool $inline = false,
    ) {
        $this->errorKey = rtrim($name !== '' ? $name : $for, '[]');
        $this->classList = $inline ? '' : 'mb-4';
        $this->noteClasses = 'mt-1 text-xs '.Shades::tertiary($theme);
    }

    /**
     * ids for the control's aria-describedby: the note, and the error when there is one.
     */
    public static function describedBy(string $id, string $note, bool $hasError, string $errorKey): string
    {
        return trim(($note !== '' ? $id.'-note ' : '').($hasError ? $errorKey.'-error' : ''));
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.form.field');
    }
}
