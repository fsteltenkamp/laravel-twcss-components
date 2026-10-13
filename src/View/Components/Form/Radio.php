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
        public ?string $theme = null,
        public string $class = '',
    ) {
        $group = ViewFacade::shared('fltcRadioGroup');

        $this->theme = $theme ?? ($group['theme'] ?? 'slate');
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
            'skin'      => 'border-skin-300 accent-skin-600 focus-visible:ring-skin-500 dark:border-skin-600 dark:accent-skin-400 dark:focus-visible:ring-skin-400',
            'cyberpunk' => 'border-cyberpunk-300 accent-cyberpunk-600 focus-visible:ring-cyberpunk-500 dark:border-cyberpunk-600 dark:accent-cyberpunk-400 dark:focus-visible:ring-cyberpunk-400',
            'fantasy'   => 'border-fantasy-300 accent-fantasy-600 focus-visible:ring-fantasy-500 dark:border-fantasy-600 dark:accent-fantasy-400 dark:focus-visible:ring-fantasy-400',
            'wh40k'     => 'border-wh40k-300 accent-wh40k-600 focus-visible:ring-wh40k-500 dark:border-wh40k-600 dark:accent-wh40k-400 dark:focus-visible:ring-wh40k-400',
        ];

        $this->classList = trim(implode(' ', [
            'h-4 w-4 shrink-0 cursor-pointer rounded-full transition focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed dark:focus-visible:ring-offset-slate-950',
            $controlMap[$this->theme] ?? $controlMap['slate'],
        ]));

        $this->labelClasses = 'text-sm select-none '.Shades::secondary($this->theme);

        if ($id === '') {
            $this->id = 'radio-'.uniqid();
        }
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.form.radio');
    }
}
