<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * A validation error outside a field: `message`, else the slot, else the error bag's
 * first message for `name` (name.* errors count too). Renders nothing without one.
 */
class Error extends Component
{
    public string $classList;

    public function __construct(
        public string $name = '',
        public string $message = '',
        public string $icon = '',
        public string $color = 'danger',
    ) {
        $map = [
            'slate'     => 'text-slate-600 dark:text-slate-400',
            'gray'      => 'text-gray-600 dark:text-gray-400',
            'zinc'      => 'text-zinc-600 dark:text-zinc-400',
            'neutral'   => 'text-neutral-600 dark:text-neutral-400',
            'stone'     => 'text-stone-600 dark:text-stone-400',
            'red'       => 'text-red-600 dark:text-red-400',
            'orange'    => 'text-orange-600 dark:text-orange-400',
            'amber'     => 'text-amber-600 dark:text-amber-400',
            'yellow'    => 'text-yellow-600 dark:text-yellow-400',
            'lime'      => 'text-lime-600 dark:text-lime-400',
            'green'     => 'text-green-600 dark:text-green-400',
            'emerald'   => 'text-emerald-600 dark:text-emerald-400',
            'teal'      => 'text-teal-600 dark:text-teal-400',
            'cyan'      => 'text-cyan-600 dark:text-cyan-400',
            'sky'       => 'text-sky-600 dark:text-sky-400',
            'blue'      => 'text-blue-600 dark:text-blue-400',
            'indigo'    => 'text-indigo-600 dark:text-indigo-400',
            'violet'    => 'text-violet-600 dark:text-violet-400',
            'purple'    => 'text-purple-600 dark:text-purple-400',
            'fuchsia'   => 'text-fuchsia-600 dark:text-fuchsia-400',
            'pink'      => 'text-pink-600 dark:text-pink-400',
            'rose'      => 'text-rose-600 dark:text-rose-400',
            'taupe'     => 'text-taupe-600 dark:text-taupe-400',
            'mauve'     => 'text-mauve-600 dark:text-mauve-400',
            'mist'      => 'text-mist-600 dark:text-mist-400',
            'olive'     => 'text-olive-600 dark:text-olive-400',
            'primary'   => 'text-primary-600 dark:text-primary-400',
            'secondary' => 'text-secondary-600 dark:text-secondary-400',
            'accent'    => 'text-accent-600 dark:text-accent-400',
            'base'      => 'text-base-600 dark:text-base-400',
            'info'      => 'text-info-600 dark:text-info-400',
            'success'   => 'text-success-600 dark:text-success-400',
            'warning'   => 'text-warning-600 dark:text-warning-400',
            'danger'    => 'text-danger-600 dark:text-danger-400',
        ];

        $this->classList = 'flex items-start gap-1.5 text-sm '.($map[$color] ?? $map['base']);
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.form.error');
    }
}
