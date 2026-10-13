<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * A native radio button with its label. Inside x-fltc::form.radio.group it takes the
 * group's name, model, theme and selected value unless it sets its own.
 */
class Radio extends Component
{
    public string $classList;
    public string $labelClasses;

    public function __construct(
        public string $value = '',
        public string $id = '',
        public ?string $name = null,
        public string $label = '',
        public ?string $model = null,
        public ?bool $live = null,
        public ?bool $checked = null,
        public bool $disabled = false,
        public ?bool $required = null,
        public ?string $color = null,
        public string $class = '',
    ) {
        $group = ViewFacade::shared('fltcRadioGroup');

        $this->color = $color ?? ($group['color'] ?? 'base');
        $this->name  = $name ?? ($group['name'] ?? '');
        $this->model = $model ?? ($group['model'] ?? '');
        $this->live  = $live ?? ($group['live'] ?? false);
        $this->required = $required ?? ($group['required'] ?? false);

        // Plain forms: checked when old input or the group's value matches this
        // radio. With a Livewire model, wire:model decides instead.
        if ($checked === null) {
            $selected = $this->name !== '' ? old($this->name, $group['value'] ?? null) : ($group['value'] ?? null);
            $checked = $selected !== null && (string) $selected === $value;
        }
        $this->checked = $checked;

        $controlMap = [
            'slate'     => 'border-slate-300 accent-slate-600 focus-visible:ring-slate-500 dark:border-slate-600 dark:accent-slate-400 dark:focus-visible:ring-slate-400',
            'gray'      => 'border-gray-300 accent-gray-600 focus-visible:ring-gray-500 dark:border-gray-600 dark:accent-gray-400 dark:focus-visible:ring-gray-400',
            'zinc'      => 'border-zinc-300 accent-zinc-600 focus-visible:ring-zinc-500 dark:border-zinc-600 dark:accent-zinc-400 dark:focus-visible:ring-zinc-400',
            'neutral'   => 'border-neutral-300 accent-neutral-600 focus-visible:ring-neutral-500 dark:border-neutral-600 dark:accent-neutral-400 dark:focus-visible:ring-neutral-400',
            'stone'     => 'border-stone-300 accent-stone-600 focus-visible:ring-stone-500 dark:border-stone-600 dark:accent-stone-400 dark:focus-visible:ring-stone-400',
            'red'       => 'border-red-300 accent-red-600 focus-visible:ring-red-500 dark:border-red-600 dark:accent-red-400 dark:focus-visible:ring-red-400',
            'orange'    => 'border-orange-300 accent-orange-600 focus-visible:ring-orange-500 dark:border-orange-600 dark:accent-orange-400 dark:focus-visible:ring-orange-400',
            'amber'     => 'border-amber-300 accent-amber-600 focus-visible:ring-amber-500 dark:border-amber-600 dark:accent-amber-400 dark:focus-visible:ring-amber-400',
            'yellow'    => 'border-yellow-300 accent-yellow-600 focus-visible:ring-yellow-500 dark:border-yellow-600 dark:accent-yellow-400 dark:focus-visible:ring-yellow-400',
            'lime'      => 'border-lime-300 accent-lime-600 focus-visible:ring-lime-500 dark:border-lime-600 dark:accent-lime-400 dark:focus-visible:ring-lime-400',
            'green'     => 'border-green-300 accent-green-600 focus-visible:ring-green-500 dark:border-green-600 dark:accent-green-400 dark:focus-visible:ring-green-400',
            'emerald'   => 'border-emerald-300 accent-emerald-600 focus-visible:ring-emerald-500 dark:border-emerald-600 dark:accent-emerald-400 dark:focus-visible:ring-emerald-400',
            'teal'      => 'border-teal-300 accent-teal-600 focus-visible:ring-teal-500 dark:border-teal-600 dark:accent-teal-400 dark:focus-visible:ring-teal-400',
            'cyan'      => 'border-cyan-300 accent-cyan-600 focus-visible:ring-cyan-500 dark:border-cyan-600 dark:accent-cyan-400 dark:focus-visible:ring-cyan-400',
            'sky'       => 'border-sky-300 accent-sky-600 focus-visible:ring-sky-500 dark:border-sky-600 dark:accent-sky-400 dark:focus-visible:ring-sky-400',
            'blue'      => 'border-blue-300 accent-blue-600 focus-visible:ring-blue-500 dark:border-blue-600 dark:accent-blue-400 dark:focus-visible:ring-blue-400',
            'indigo'    => 'border-indigo-300 accent-indigo-600 focus-visible:ring-indigo-500 dark:border-indigo-600 dark:accent-indigo-400 dark:focus-visible:ring-indigo-400',
            'violet'    => 'border-violet-300 accent-violet-600 focus-visible:ring-violet-500 dark:border-violet-600 dark:accent-violet-400 dark:focus-visible:ring-violet-400',
            'purple'    => 'border-purple-300 accent-purple-600 focus-visible:ring-purple-500 dark:border-purple-600 dark:accent-purple-400 dark:focus-visible:ring-purple-400',
            'fuchsia'   => 'border-fuchsia-300 accent-fuchsia-600 focus-visible:ring-fuchsia-500 dark:border-fuchsia-600 dark:accent-fuchsia-400 dark:focus-visible:ring-fuchsia-400',
            'pink'      => 'border-pink-300 accent-pink-600 focus-visible:ring-pink-500 dark:border-pink-600 dark:accent-pink-400 dark:focus-visible:ring-pink-400',
            'rose'      => 'border-rose-300 accent-rose-600 focus-visible:ring-rose-500 dark:border-rose-600 dark:accent-rose-400 dark:focus-visible:ring-rose-400',
            'taupe'     => 'border-taupe-300 accent-taupe-600 focus-visible:ring-taupe-500 dark:border-taupe-600 dark:accent-taupe-400 dark:focus-visible:ring-taupe-400',
            'mauve'     => 'border-mauve-300 accent-mauve-600 focus-visible:ring-mauve-500 dark:border-mauve-600 dark:accent-mauve-400 dark:focus-visible:ring-mauve-400',
            'mist'      => 'border-mist-300 accent-mist-600 focus-visible:ring-mist-500 dark:border-mist-600 dark:accent-mist-400 dark:focus-visible:ring-mist-400',
            'olive'     => 'border-olive-300 accent-olive-600 focus-visible:ring-olive-500 dark:border-olive-600 dark:accent-olive-400 dark:focus-visible:ring-olive-400',
            'primary'      => 'border-primary-300 accent-primary-600 focus-visible:ring-primary-500 dark:border-primary-600 dark:accent-primary-400 dark:focus-visible:ring-primary-400',
            'secondary'    => 'border-secondary-300 accent-secondary-600 focus-visible:ring-secondary-500 dark:border-secondary-600 dark:accent-secondary-400 dark:focus-visible:ring-secondary-400',
            'accent'       => 'border-accent-300 accent-accent-600 focus-visible:ring-accent-500 dark:border-accent-600 dark:accent-accent-400 dark:focus-visible:ring-accent-400',
            'base'         => 'border-base-300 accent-base-600 focus-visible:ring-base-500 dark:border-base-600 dark:accent-base-400 dark:focus-visible:ring-base-400',
            'info'         => 'border-info-300 accent-info-600 focus-visible:ring-info-500 dark:border-info-600 dark:accent-info-400 dark:focus-visible:ring-info-400',
            'success'      => 'border-success-300 accent-success-600 focus-visible:ring-success-500 dark:border-success-600 dark:accent-success-400 dark:focus-visible:ring-success-400',
            'warning'      => 'border-warning-300 accent-warning-600 focus-visible:ring-warning-500 dark:border-warning-600 dark:accent-warning-400 dark:focus-visible:ring-warning-400',
            'danger'       => 'border-danger-300 accent-danger-600 focus-visible:ring-danger-500 dark:border-danger-600 dark:accent-danger-400 dark:focus-visible:ring-danger-400',
        ];

        $this->classList = trim(implode(' ', [
            'h-4 w-4 shrink-0 cursor-pointer rounded-full transition focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed dark:focus-visible:ring-offset-slate-950',
            $controlMap[$this->color] ?? $controlMap['base'],
        ]));

        $this->labelClasses = 'text-sm select-none '.Shades::secondary($this->color);

        if ($id === '') {
            $this->id = 'radio-'.uniqid();
        }
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.form.radio');
    }
}
