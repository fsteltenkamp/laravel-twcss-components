<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\Support\SidebarTheme;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * A titled group of fields with hint text, e.g. one block of a settings page.
 * Consecutive sections are divided by a rule. `split` puts title and hint in a
 * column beside the fields from `md` up.
 */
class Section extends Component
{
    public string $classList;
    public string $titleClasses;
    public string $hintClasses;

    public function __construct(
        public string $title = '',
        public string $hint = '',
        public string $color = 'base',
        public bool $split = false,
    ) {
        $this->classList = trim(implode(' ', [
            'border-b pb-8 mb-8 last:mb-0 last:border-b-0 last:pb-0',
            $split ? 'grid gap-x-8 gap-y-4 md:grid-cols-3' : '',
            SidebarTheme::divider($color),
        ]));
        $this->titleClasses = 'text-base font-semibold '.Shades::primary($color);
        $this->hintClasses = 'mt-1 text-sm '.Shades::tertiary($color);
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.form.section');
    }
}
