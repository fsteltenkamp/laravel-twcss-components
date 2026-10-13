<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form\Radio;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * A <fieldset> of x-fltc::form.radio options sharing one name, model and theme.
 */
class Group extends Component
{
    public string $classList;
    public string $legendClasses;
    public string $optionsClasses;

    public function __construct(
        public string $name = '',
        public string $label = '',
        public ?string $value = null,
        public string $model = '',
        public bool $live = false,
        public bool $required = false,
        public string $theme = 'slate',
        public bool $horizontal = false,
        public bool $inline = false,
    ) {
        $this->classList = $inline ? 'min-w-0' : 'mb-4 min-w-0';
        $this->legendClasses = 'mb-1 block text-sm font-medium '.Shades::secondary($theme);
        $this->optionsClasses = $horizontal ? 'flex flex-wrap items-center gap-x-6 gap-y-2' : 'flex flex-col gap-2';
    }

    public function render(): View|Closure|string
    {
        // The options read this while the slot renders; the view clears it again so
        // a radio after the group does not pick up its name.
        ViewFacade::share('fltcRadioGroup', [
            'name' => $this->name,
            'value' => $this->value,
            'model' => $this->model,
            'live' => $this->live,
            'required' => $this->required,
            'theme' => $this->theme,
        ]);

        return view('fltc::components.form.radio.group');
    }
}
