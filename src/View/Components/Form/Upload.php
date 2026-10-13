<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * File upload with a drop zone around a real <input type="file">: click to browse or
 * drop files on it. Dropped files are put into the input and a `change` event is
 * fired, so it works in a plain form and with wire:model (Livewire file uploads)
 * alike. The chosen file names are listed under the zone.
 */
class Upload extends Component
{
    public string $zoneClasses;
    public string $idleClasses;
    public string $dragClasses;
    public string $hintClasses;
    public string $listClasses;

    public function __construct(
        public string $id = '',
        public string $name = '',
        public string $label = '',
        public string $note = '',
        public string $accept = '',
        public bool $multiple = false,
        public string $model = '',
        public bool $live = false,
        public bool $required = false,
        public bool $disabled = false,
        public string $icon = 'upload-simple',
        public string $prompt = '',
        public string $color = 'base',
        public bool $inline = false,
        public string $wrapperClass = '',
    ) {
        $idleMap = [
            'slate'     => 'border-slate-300 bg-slate-50/60 hover:border-slate-400 dark:border-slate-600 dark:bg-slate-900/40 dark:hover:border-slate-500',
            'gray'      => 'border-gray-300 bg-gray-50/60 hover:border-gray-400 dark:border-gray-600 dark:bg-gray-900/40 dark:hover:border-gray-500',
            'zinc'      => 'border-zinc-300 bg-zinc-50/60 hover:border-zinc-400 dark:border-zinc-600 dark:bg-zinc-900/40 dark:hover:border-zinc-500',
            'neutral'   => 'border-neutral-300 bg-neutral-50/60 hover:border-neutral-400 dark:border-neutral-600 dark:bg-neutral-900/40 dark:hover:border-neutral-500',
            'stone'     => 'border-stone-300 bg-stone-50/60 hover:border-stone-400 dark:border-stone-600 dark:bg-stone-900/40 dark:hover:border-stone-500',
            'red'       => 'border-red-300 bg-red-50/60 hover:border-red-400 dark:border-red-600 dark:bg-red-900/40 dark:hover:border-red-500',
            'orange'    => 'border-orange-300 bg-orange-50/60 hover:border-orange-400 dark:border-orange-600 dark:bg-orange-900/40 dark:hover:border-orange-500',
            'amber'     => 'border-amber-300 bg-amber-50/60 hover:border-amber-400 dark:border-amber-600 dark:bg-amber-900/40 dark:hover:border-amber-500',
            'yellow'    => 'border-yellow-300 bg-yellow-50/60 hover:border-yellow-400 dark:border-yellow-600 dark:bg-yellow-900/40 dark:hover:border-yellow-500',
            'lime'      => 'border-lime-300 bg-lime-50/60 hover:border-lime-400 dark:border-lime-600 dark:bg-lime-900/40 dark:hover:border-lime-500',
            'green'     => 'border-green-300 bg-green-50/60 hover:border-green-400 dark:border-green-600 dark:bg-green-900/40 dark:hover:border-green-500',
            'emerald'   => 'border-emerald-300 bg-emerald-50/60 hover:border-emerald-400 dark:border-emerald-600 dark:bg-emerald-900/40 dark:hover:border-emerald-500',
            'teal'      => 'border-teal-300 bg-teal-50/60 hover:border-teal-400 dark:border-teal-600 dark:bg-teal-900/40 dark:hover:border-teal-500',
            'cyan'      => 'border-cyan-300 bg-cyan-50/60 hover:border-cyan-400 dark:border-cyan-600 dark:bg-cyan-900/40 dark:hover:border-cyan-500',
            'sky'       => 'border-sky-300 bg-sky-50/60 hover:border-sky-400 dark:border-sky-600 dark:bg-sky-900/40 dark:hover:border-sky-500',
            'blue'      => 'border-blue-300 bg-blue-50/60 hover:border-blue-400 dark:border-blue-600 dark:bg-blue-900/40 dark:hover:border-blue-500',
            'indigo'    => 'border-indigo-300 bg-indigo-50/60 hover:border-indigo-400 dark:border-indigo-600 dark:bg-indigo-900/40 dark:hover:border-indigo-500',
            'violet'    => 'border-violet-300 bg-violet-50/60 hover:border-violet-400 dark:border-violet-600 dark:bg-violet-900/40 dark:hover:border-violet-500',
            'purple'    => 'border-purple-300 bg-purple-50/60 hover:border-purple-400 dark:border-purple-600 dark:bg-purple-900/40 dark:hover:border-purple-500',
            'fuchsia'   => 'border-fuchsia-300 bg-fuchsia-50/60 hover:border-fuchsia-400 dark:border-fuchsia-600 dark:bg-fuchsia-900/40 dark:hover:border-fuchsia-500',
            'pink'      => 'border-pink-300 bg-pink-50/60 hover:border-pink-400 dark:border-pink-600 dark:bg-pink-900/40 dark:hover:border-pink-500',
            'rose'      => 'border-rose-300 bg-rose-50/60 hover:border-rose-400 dark:border-rose-600 dark:bg-rose-900/40 dark:hover:border-rose-500',
            'taupe'     => 'border-taupe-300 bg-taupe-50/60 hover:border-taupe-400 dark:border-taupe-600 dark:bg-taupe-900/40 dark:hover:border-taupe-500',
            'mauve'     => 'border-mauve-300 bg-mauve-50/60 hover:border-mauve-400 dark:border-mauve-600 dark:bg-mauve-900/40 dark:hover:border-mauve-500',
            'mist'      => 'border-mist-300 bg-mist-50/60 hover:border-mist-400 dark:border-mist-600 dark:bg-mist-900/40 dark:hover:border-mist-500',
            'olive'     => 'border-olive-300 bg-olive-50/60 hover:border-olive-400 dark:border-olive-600 dark:bg-olive-900/40 dark:hover:border-olive-500',
            'primary'      => 'border-primary-300 bg-primary-50/60 hover:border-primary-400 dark:border-primary-600 dark:bg-primary-900/40 dark:hover:border-primary-500',
            'secondary'    => 'border-secondary-300 bg-secondary-50/60 hover:border-secondary-400 dark:border-secondary-600 dark:bg-secondary-900/40 dark:hover:border-secondary-500',
            'accent'       => 'border-accent-300 bg-accent-50/60 hover:border-accent-400 dark:border-accent-600 dark:bg-accent-900/40 dark:hover:border-accent-500',
            'base'         => 'border-base-300 bg-base-50/60 hover:border-base-400 dark:border-base-600 dark:bg-base-900/40 dark:hover:border-base-500',
            'info'         => 'border-info-300 bg-info-50/60 hover:border-info-400 dark:border-info-600 dark:bg-info-900/40 dark:hover:border-info-500',
            'success'      => 'border-success-300 bg-success-50/60 hover:border-success-400 dark:border-success-600 dark:bg-success-900/40 dark:hover:border-success-500',
            'warning'      => 'border-warning-300 bg-warning-50/60 hover:border-warning-400 dark:border-warning-600 dark:bg-warning-900/40 dark:hover:border-warning-500',
            'danger'       => 'border-danger-300 bg-danger-50/60 hover:border-danger-400 dark:border-danger-600 dark:bg-danger-900/40 dark:hover:border-danger-500',
        ];

        $dragMap = [
            'slate'     => 'border-slate-500 bg-slate-100 dark:border-slate-400 dark:bg-slate-800',
            'gray'      => 'border-gray-500 bg-gray-100 dark:border-gray-400 dark:bg-gray-800',
            'zinc'      => 'border-zinc-500 bg-zinc-100 dark:border-zinc-400 dark:bg-zinc-800',
            'neutral'   => 'border-neutral-500 bg-neutral-100 dark:border-neutral-400 dark:bg-neutral-800',
            'stone'     => 'border-stone-500 bg-stone-100 dark:border-stone-400 dark:bg-stone-800',
            'red'       => 'border-red-500 bg-red-100 dark:border-red-400 dark:bg-red-800',
            'orange'    => 'border-orange-500 bg-orange-100 dark:border-orange-400 dark:bg-orange-800',
            'amber'     => 'border-amber-500 bg-amber-100 dark:border-amber-400 dark:bg-amber-800',
            'yellow'    => 'border-yellow-500 bg-yellow-100 dark:border-yellow-400 dark:bg-yellow-800',
            'lime'      => 'border-lime-500 bg-lime-100 dark:border-lime-400 dark:bg-lime-800',
            'green'     => 'border-green-500 bg-green-100 dark:border-green-400 dark:bg-green-800',
            'emerald'   => 'border-emerald-500 bg-emerald-100 dark:border-emerald-400 dark:bg-emerald-800',
            'teal'      => 'border-teal-500 bg-teal-100 dark:border-teal-400 dark:bg-teal-800',
            'cyan'      => 'border-cyan-500 bg-cyan-100 dark:border-cyan-400 dark:bg-cyan-800',
            'sky'       => 'border-sky-500 bg-sky-100 dark:border-sky-400 dark:bg-sky-800',
            'blue'      => 'border-blue-500 bg-blue-100 dark:border-blue-400 dark:bg-blue-800',
            'indigo'    => 'border-indigo-500 bg-indigo-100 dark:border-indigo-400 dark:bg-indigo-800',
            'violet'    => 'border-violet-500 bg-violet-100 dark:border-violet-400 dark:bg-violet-800',
            'purple'    => 'border-purple-500 bg-purple-100 dark:border-purple-400 dark:bg-purple-800',
            'fuchsia'   => 'border-fuchsia-500 bg-fuchsia-100 dark:border-fuchsia-400 dark:bg-fuchsia-800',
            'pink'      => 'border-pink-500 bg-pink-100 dark:border-pink-400 dark:bg-pink-800',
            'rose'      => 'border-rose-500 bg-rose-100 dark:border-rose-400 dark:bg-rose-800',
            'taupe'     => 'border-taupe-500 bg-taupe-100 dark:border-taupe-400 dark:bg-taupe-800',
            'mauve'     => 'border-mauve-500 bg-mauve-100 dark:border-mauve-400 dark:bg-mauve-800',
            'mist'      => 'border-mist-500 bg-mist-100 dark:border-mist-400 dark:bg-mist-800',
            'olive'     => 'border-olive-500 bg-olive-100 dark:border-olive-400 dark:bg-olive-800',
            'primary'      => 'border-primary-500 bg-primary-100 dark:border-primary-400 dark:bg-primary-800',
            'secondary'    => 'border-secondary-500 bg-secondary-100 dark:border-secondary-400 dark:bg-secondary-800',
            'accent'       => 'border-accent-500 bg-accent-100 dark:border-accent-400 dark:bg-accent-800',
            'base'         => 'border-base-500 bg-base-100 dark:border-base-400 dark:bg-base-800',
            'info'         => 'border-info-500 bg-info-100 dark:border-info-400 dark:bg-info-800',
            'success'      => 'border-success-500 bg-success-100 dark:border-success-400 dark:bg-success-800',
            'warning'      => 'border-warning-500 bg-warning-100 dark:border-warning-400 dark:bg-warning-800',
            'danger'       => 'border-danger-500 bg-danger-100 dark:border-danger-400 dark:bg-danger-800',
        ];

        $this->idleClasses = $idleMap[$color] ?? $idleMap['base'];
        $this->dragClasses = $dragMap[$color] ?? $dragMap['base'];
        $this->zoneClasses = 'relative flex flex-col items-center justify-center gap-2 rounded-lg border-2 border-dashed px-6 py-8 text-center transition focus-within:ring-2 focus-within:ring-offset-2 '
            .Shades::secondary($color).' '
            .($disabled ? 'cursor-not-allowed opacity-60' : 'cursor-pointer');
        $this->hintClasses = 'text-xs '.Shades::tertiary($color);
        $this->listClasses = 'mt-2 space-y-1 text-sm '.Shades::secondary($color);

        if ($this->prompt === '') {
            $this->prompt = $multiple ? __('Drop files here or click to browse') : __('Drop a file here or click to browse');
        }

        if ($id === '') {
            $this->id = 'upload-'.uniqid();
        }
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.form.upload');
    }
}
