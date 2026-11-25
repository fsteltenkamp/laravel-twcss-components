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
    public string $descriptionClasses;
    public string $cardClasses;

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
        public string $description = '',
        public ?string $variant = null,
    ) {
        $group = ViewFacade::shared('fltcRadioGroup');

        $this->color = $color ?? ($group['color'] ?? 'base');
        $this->name  = $name ?? ($group['name'] ?? '');
        $this->model = $model ?? ($group['model'] ?? '');
        $this->live  = $live ?? ($group['live'] ?? false);
        $this->required = $required ?? ($group['required'] ?? false);
        $this->variant = $variant ?? ($group['variant'] ?? 'default');

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
        $this->descriptionClasses = 'mt-0.5 block text-xs '.Shades::tertiary($this->color);

        // Cards: each option is a bordered row that takes the colour when chosen.
        $cardMap = [
            'slate'     => 'border-slate-200 hover:bg-slate-50 has-[:checked]:border-slate-500 has-[:checked]:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-900/40 dark:has-[:checked]:border-slate-400 dark:has-[:checked]:bg-slate-900/60',
            'gray'      => 'border-gray-200 hover:bg-gray-50 has-[:checked]:border-gray-500 has-[:checked]:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-900/40 dark:has-[:checked]:border-gray-400 dark:has-[:checked]:bg-gray-900/60',
            'zinc'      => 'border-zinc-200 hover:bg-zinc-50 has-[:checked]:border-zinc-500 has-[:checked]:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-900/40 dark:has-[:checked]:border-zinc-400 dark:has-[:checked]:bg-zinc-900/60',
            'neutral'   => 'border-neutral-200 hover:bg-neutral-50 has-[:checked]:border-neutral-500 has-[:checked]:bg-neutral-50 dark:border-neutral-700 dark:hover:bg-neutral-900/40 dark:has-[:checked]:border-neutral-400 dark:has-[:checked]:bg-neutral-900/60',
            'stone'     => 'border-stone-200 hover:bg-stone-50 has-[:checked]:border-stone-500 has-[:checked]:bg-stone-50 dark:border-stone-700 dark:hover:bg-stone-900/40 dark:has-[:checked]:border-stone-400 dark:has-[:checked]:bg-stone-900/60',
            'red'       => 'border-red-200 hover:bg-red-50 has-[:checked]:border-red-500 has-[:checked]:bg-red-50 dark:border-red-700 dark:hover:bg-red-900/40 dark:has-[:checked]:border-red-400 dark:has-[:checked]:bg-red-900/60',
            'orange'    => 'border-orange-200 hover:bg-orange-50 has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50 dark:border-orange-700 dark:hover:bg-orange-900/40 dark:has-[:checked]:border-orange-400 dark:has-[:checked]:bg-orange-900/60',
            'amber'     => 'border-amber-200 hover:bg-amber-50 has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50 dark:border-amber-700 dark:hover:bg-amber-900/40 dark:has-[:checked]:border-amber-400 dark:has-[:checked]:bg-amber-900/60',
            'yellow'    => 'border-yellow-200 hover:bg-yellow-50 has-[:checked]:border-yellow-500 has-[:checked]:bg-yellow-50 dark:border-yellow-700 dark:hover:bg-yellow-900/40 dark:has-[:checked]:border-yellow-400 dark:has-[:checked]:bg-yellow-900/60',
            'lime'      => 'border-lime-200 hover:bg-lime-50 has-[:checked]:border-lime-500 has-[:checked]:bg-lime-50 dark:border-lime-700 dark:hover:bg-lime-900/40 dark:has-[:checked]:border-lime-400 dark:has-[:checked]:bg-lime-900/60',
            'green'     => 'border-green-200 hover:bg-green-50 has-[:checked]:border-green-500 has-[:checked]:bg-green-50 dark:border-green-700 dark:hover:bg-green-900/40 dark:has-[:checked]:border-green-400 dark:has-[:checked]:bg-green-900/60',
            'emerald'   => 'border-emerald-200 hover:bg-emerald-50 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50 dark:border-emerald-700 dark:hover:bg-emerald-900/40 dark:has-[:checked]:border-emerald-400 dark:has-[:checked]:bg-emerald-900/60',
            'teal'      => 'border-teal-200 hover:bg-teal-50 has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50 dark:border-teal-700 dark:hover:bg-teal-900/40 dark:has-[:checked]:border-teal-400 dark:has-[:checked]:bg-teal-900/60',
            'cyan'      => 'border-cyan-200 hover:bg-cyan-50 has-[:checked]:border-cyan-500 has-[:checked]:bg-cyan-50 dark:border-cyan-700 dark:hover:bg-cyan-900/40 dark:has-[:checked]:border-cyan-400 dark:has-[:checked]:bg-cyan-900/60',
            'sky'       => 'border-sky-200 hover:bg-sky-50 has-[:checked]:border-sky-500 has-[:checked]:bg-sky-50 dark:border-sky-700 dark:hover:bg-sky-900/40 dark:has-[:checked]:border-sky-400 dark:has-[:checked]:bg-sky-900/60',
            'blue'      => 'border-blue-200 hover:bg-blue-50 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:border-blue-700 dark:hover:bg-blue-900/40 dark:has-[:checked]:border-blue-400 dark:has-[:checked]:bg-blue-900/60',
            'indigo'    => 'border-indigo-200 hover:bg-indigo-50 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 dark:border-indigo-700 dark:hover:bg-indigo-900/40 dark:has-[:checked]:border-indigo-400 dark:has-[:checked]:bg-indigo-900/60',
            'violet'    => 'border-violet-200 hover:bg-violet-50 has-[:checked]:border-violet-500 has-[:checked]:bg-violet-50 dark:border-violet-700 dark:hover:bg-violet-900/40 dark:has-[:checked]:border-violet-400 dark:has-[:checked]:bg-violet-900/60',
            'purple'    => 'border-purple-200 hover:bg-purple-50 has-[:checked]:border-purple-500 has-[:checked]:bg-purple-50 dark:border-purple-700 dark:hover:bg-purple-900/40 dark:has-[:checked]:border-purple-400 dark:has-[:checked]:bg-purple-900/60',
            'fuchsia'   => 'border-fuchsia-200 hover:bg-fuchsia-50 has-[:checked]:border-fuchsia-500 has-[:checked]:bg-fuchsia-50 dark:border-fuchsia-700 dark:hover:bg-fuchsia-900/40 dark:has-[:checked]:border-fuchsia-400 dark:has-[:checked]:bg-fuchsia-900/60',
            'pink'      => 'border-pink-200 hover:bg-pink-50 has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50 dark:border-pink-700 dark:hover:bg-pink-900/40 dark:has-[:checked]:border-pink-400 dark:has-[:checked]:bg-pink-900/60',
            'rose'      => 'border-rose-200 hover:bg-rose-50 has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50 dark:border-rose-700 dark:hover:bg-rose-900/40 dark:has-[:checked]:border-rose-400 dark:has-[:checked]:bg-rose-900/60',
            'taupe'     => 'border-taupe-200 hover:bg-taupe-50 has-[:checked]:border-taupe-500 has-[:checked]:bg-taupe-50 dark:border-taupe-700 dark:hover:bg-taupe-900/40 dark:has-[:checked]:border-taupe-400 dark:has-[:checked]:bg-taupe-900/60',
            'mauve'     => 'border-mauve-200 hover:bg-mauve-50 has-[:checked]:border-mauve-500 has-[:checked]:bg-mauve-50 dark:border-mauve-700 dark:hover:bg-mauve-900/40 dark:has-[:checked]:border-mauve-400 dark:has-[:checked]:bg-mauve-900/60',
            'mist'      => 'border-mist-200 hover:bg-mist-50 has-[:checked]:border-mist-500 has-[:checked]:bg-mist-50 dark:border-mist-700 dark:hover:bg-mist-900/40 dark:has-[:checked]:border-mist-400 dark:has-[:checked]:bg-mist-900/60',
            'olive'     => 'border-olive-200 hover:bg-olive-50 has-[:checked]:border-olive-500 has-[:checked]:bg-olive-50 dark:border-olive-700 dark:hover:bg-olive-900/40 dark:has-[:checked]:border-olive-400 dark:has-[:checked]:bg-olive-900/60',
            'primary'   => 'border-primary-200 hover:bg-primary-50 has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50 dark:border-primary-700 dark:hover:bg-primary-900/40 dark:has-[:checked]:border-primary-400 dark:has-[:checked]:bg-primary-900/60',
            'secondary' => 'border-secondary-200 hover:bg-secondary-50 has-[:checked]:border-secondary-500 has-[:checked]:bg-secondary-50 dark:border-secondary-700 dark:hover:bg-secondary-900/40 dark:has-[:checked]:border-secondary-400 dark:has-[:checked]:bg-secondary-900/60',
            'accent'    => 'border-accent-200 hover:bg-accent-50 has-[:checked]:border-accent-500 has-[:checked]:bg-accent-50 dark:border-accent-700 dark:hover:bg-accent-900/40 dark:has-[:checked]:border-accent-400 dark:has-[:checked]:bg-accent-900/60',
            'base'      => 'border-base-200 hover:bg-base-50 has-[:checked]:border-base-500 has-[:checked]:bg-base-50 dark:border-base-700 dark:hover:bg-base-900/40 dark:has-[:checked]:border-base-400 dark:has-[:checked]:bg-base-900/60',
            'info'      => 'border-info-200 hover:bg-info-50 has-[:checked]:border-info-500 has-[:checked]:bg-info-50 dark:border-info-700 dark:hover:bg-info-900/40 dark:has-[:checked]:border-info-400 dark:has-[:checked]:bg-info-900/60',
            'success'   => 'border-success-200 hover:bg-success-50 has-[:checked]:border-success-500 has-[:checked]:bg-success-50 dark:border-success-700 dark:hover:bg-success-900/40 dark:has-[:checked]:border-success-400 dark:has-[:checked]:bg-success-900/60',
            'warning'   => 'border-warning-200 hover:bg-warning-50 has-[:checked]:border-warning-500 has-[:checked]:bg-warning-50 dark:border-warning-700 dark:hover:bg-warning-900/40 dark:has-[:checked]:border-warning-400 dark:has-[:checked]:bg-warning-900/60',
            'danger'    => 'border-danger-200 hover:bg-danger-50 has-[:checked]:border-danger-500 has-[:checked]:bg-danger-50 dark:border-danger-700 dark:hover:bg-danger-900/40 dark:has-[:checked]:border-danger-400 dark:has-[:checked]:bg-danger-900/60',
        ];

        $this->cardClasses = 'flex items-start gap-3 rounded-lg border p-3 transition '.($cardMap[$this->color] ?? $cardMap['base']);

        if ($id === '') {
            $this->id = 'radio-'.uniqid();
        }
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.form.radio');
    }
}
