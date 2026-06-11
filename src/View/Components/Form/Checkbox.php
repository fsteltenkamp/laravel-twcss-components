<?php

namespace Fsteltenkamp\fltcComponents\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Checkbox extends Component
{
    public string $iconColorUnchecked;
    public string $iconColorChecked;
    public string $iconColorCheckedPeer;
    public string $labelClasses;
    public string $containerBorder;
    public string $rowBg;
    public string $rowBgCheckedHas;

    public function __construct(
        public string $id = '',
        public string $name = '',
        public string $value = '1',
        public string $label = '',
        public string $model = '',
        public bool $live = false,
        public bool $checked = false,
        public bool $disabled = false,
        public string $theme = 'sky',
        public string $class = '',
        public string $iconChecked = 'ph ph-check-circle',
        public string $iconUnchecked = 'ph ph-circle',
        public bool $bordered = true,
    ) {
        $iconColorMap = [
            'slate'   => 'text-slate-500 dark:text-slate-400',
            'gray'    => 'text-gray-500 dark:text-gray-400',
            'zinc'    => 'text-zinc-500 dark:text-zinc-400',
            'neutral' => 'text-neutral-500 dark:text-neutral-400',
            'stone'   => 'text-stone-500 dark:text-stone-400',
            'red'     => 'text-red-500 dark:text-red-400',
            'orange'  => 'text-orange-500 dark:text-orange-400',
            'amber'   => 'text-amber-500 dark:text-amber-400',
            'yellow'  => 'text-yellow-500 dark:text-yellow-400',
            'lime'    => 'text-lime-500 dark:text-lime-400',
            'green'   => 'text-green-500 dark:text-green-400',
            'emerald' => 'text-emerald-500 dark:text-emerald-400',
            'teal'    => 'text-teal-500 dark:text-teal-400',
            'cyan'    => 'text-cyan-500 dark:text-cyan-400',
            'sky'     => 'text-sky-500 dark:text-sky-400',
            'blue'    => 'text-blue-500 dark:text-blue-400',
            'indigo'  => 'text-indigo-500 dark:text-indigo-400',
            'violet'  => 'text-violet-500 dark:text-violet-400',
            'purple'  => 'text-purple-500 dark:text-purple-400',
            'fuchsia' => 'text-fuchsia-500 dark:text-fuchsia-400',
            'pink'    => 'text-pink-500 dark:text-pink-400',
            'rose'    => 'text-rose-500 dark:text-rose-400',
            'taupe'   => 'text-taupe-500 dark:text-taupe-400',
            'mauve'   => 'text-mauve-500 dark:text-mauve-400',
            'mist'    => 'text-mist-500 dark:text-mist-400',
            'olive'   => 'text-olive-500 dark:text-olive-400',
        ];

        $iconColorPeerCheckedMap = [
            'slate'   => 'peer-checked:text-slate-500 dark:peer-checked:text-slate-400',
            'gray'    => 'peer-checked:text-gray-500 dark:peer-checked:text-gray-400',
            'zinc'    => 'peer-checked:text-zinc-500 dark:peer-checked:text-zinc-400',
            'neutral' => 'peer-checked:text-neutral-500 dark:peer-checked:text-neutral-400',
            'stone'   => 'peer-checked:text-stone-500 dark:peer-checked:text-stone-400',
            'red'     => 'peer-checked:text-red-500 dark:peer-checked:text-red-400',
            'orange'  => 'peer-checked:text-orange-500 dark:peer-checked:text-orange-400',
            'amber'   => 'peer-checked:text-amber-500 dark:peer-checked:text-amber-400',
            'yellow'  => 'peer-checked:text-yellow-500 dark:peer-checked:text-yellow-400',
            'lime'    => 'peer-checked:text-lime-500 dark:peer-checked:text-lime-400',
            'green'   => 'peer-checked:text-green-500 dark:peer-checked:text-green-400',
            'emerald' => 'peer-checked:text-emerald-500 dark:peer-checked:text-emerald-400',
            'teal'    => 'peer-checked:text-teal-500 dark:peer-checked:text-teal-400',
            'cyan'    => 'peer-checked:text-cyan-500 dark:peer-checked:text-cyan-400',
            'sky'     => 'peer-checked:text-sky-500 dark:peer-checked:text-sky-400',
            'blue'    => 'peer-checked:text-blue-500 dark:peer-checked:text-blue-400',
            'indigo'  => 'peer-checked:text-indigo-500 dark:peer-checked:text-indigo-400',
            'violet'  => 'peer-checked:text-violet-500 dark:peer-checked:text-violet-400',
            'purple'  => 'peer-checked:text-purple-500 dark:peer-checked:text-purple-400',
            'fuchsia' => 'peer-checked:text-fuchsia-500 dark:peer-checked:text-fuchsia-400',
            'pink'    => 'peer-checked:text-pink-500 dark:peer-checked:text-pink-400',
            'rose'    => 'peer-checked:text-rose-500 dark:peer-checked:text-rose-400',
            'taupe'   => 'peer-checked:text-taupe-500 dark:peer-checked:text-taupe-400',
            'mauve'   => 'peer-checked:text-mauve-500 dark:peer-checked:text-mauve-400',
            'mist'    => 'peer-checked:text-mist-500 dark:peer-checked:text-mist-400',
            'olive'   => 'peer-checked:text-olive-500 dark:peer-checked:text-olive-400',
        ];

        $iconColorUncheckedMap = [
            'slate'   => 'text-slate-300 dark:text-slate-600',
            'gray'    => 'text-gray-300 dark:text-gray-600',
            'zinc'    => 'text-zinc-300 dark:text-zinc-600',
            'neutral' => 'text-neutral-300 dark:text-neutral-600',
            'stone'   => 'text-stone-300 dark:text-stone-600',
            'red'     => 'text-red-300 dark:text-red-700',
            'orange'  => 'text-orange-300 dark:text-orange-700',
            'amber'   => 'text-amber-300 dark:text-amber-700',
            'yellow'  => 'text-yellow-300 dark:text-yellow-700',
            'lime'    => 'text-lime-300 dark:text-lime-700',
            'green'   => 'text-green-300 dark:text-green-700',
            'emerald' => 'text-emerald-300 dark:text-emerald-700',
            'teal'    => 'text-teal-300 dark:text-teal-700',
            'cyan'    => 'text-cyan-300 dark:text-cyan-700',
            'sky'     => 'text-sky-300 dark:text-sky-700',
            'blue'    => 'text-blue-300 dark:text-blue-700',
            'indigo'  => 'text-indigo-300 dark:text-indigo-700',
            'violet'  => 'text-violet-300 dark:text-violet-700',
            'purple'  => 'text-purple-300 dark:text-purple-700',
            'fuchsia' => 'text-fuchsia-300 dark:text-fuchsia-700',
            'pink'    => 'text-pink-300 dark:text-pink-700',
            'rose'    => 'text-rose-300 dark:text-rose-700',
            'taupe'   => 'text-taupe-300 dark:text-taupe-700',
            'mauve'   => 'text-mauve-300 dark:text-mauve-700',
            'mist'    => 'text-mist-300 dark:text-mist-700',
            'olive'   => 'text-olive-300 dark:text-olive-700',
        ];

        $containerBorderMap = [
            'slate'   => 'border-slate-200 dark:border-slate-700',
            'gray'    => 'border-gray-200 dark:border-gray-700',
            'zinc'    => 'border-zinc-200 dark:border-zinc-700',
            'neutral' => 'border-neutral-200 dark:border-neutral-700',
            'stone'   => 'border-stone-200 dark:border-stone-700',
            'red'     => 'border-red-200 dark:border-red-800',
            'orange'  => 'border-orange-200 dark:border-orange-800',
            'amber'   => 'border-amber-200 dark:border-amber-800',
            'yellow'  => 'border-yellow-200 dark:border-yellow-800',
            'lime'    => 'border-lime-200 dark:border-lime-800',
            'green'   => 'border-green-200 dark:border-green-800',
            'emerald' => 'border-emerald-200 dark:border-emerald-800',
            'teal'    => 'border-teal-200 dark:border-teal-800',
            'cyan'    => 'border-cyan-200 dark:border-cyan-800',
            'sky'     => 'border-sky-200 dark:border-sky-800',
            'blue'    => 'border-blue-200 dark:border-blue-800',
            'indigo'  => 'border-indigo-200 dark:border-indigo-800',
            'violet'  => 'border-violet-200 dark:border-violet-800',
            'purple'  => 'border-purple-200 dark:border-purple-800',
            'fuchsia' => 'border-fuchsia-200 dark:border-fuchsia-800',
            'pink'    => 'border-pink-200 dark:border-pink-800',
            'rose'    => 'border-rose-200 dark:border-rose-800',
            'taupe'   => 'border-taupe-200 dark:border-taupe-800',
            'mauve'   => 'border-mauve-200 dark:border-mauve-800',
            'mist'    => 'border-mist-200 dark:border-mist-800',
            'olive'   => 'border-olive-200 dark:border-olive-800',
        ];

        $rowBgMap = [
            'slate'   => 'bg-white dark:bg-slate-900',
            'gray'    => 'bg-white dark:bg-gray-900',
            'zinc'    => 'bg-white dark:bg-zinc-900',
            'neutral' => 'bg-white dark:bg-neutral-900',
            'stone'   => 'bg-white dark:bg-stone-900',
            'red'     => 'bg-red-50/40 dark:bg-red-950/20',
            'orange'  => 'bg-orange-50/40 dark:bg-orange-950/20',
            'amber'   => 'bg-amber-50/40 dark:bg-amber-950/20',
            'yellow'  => 'bg-yellow-50/40 dark:bg-yellow-950/20',
            'lime'    => 'bg-lime-50/40 dark:bg-lime-950/20',
            'green'   => 'bg-green-50/40 dark:bg-green-950/20',
            'emerald' => 'bg-emerald-50/40 dark:bg-emerald-950/20',
            'teal'    => 'bg-teal-50/40 dark:bg-teal-950/20',
            'cyan'    => 'bg-cyan-50/40 dark:bg-cyan-950/20',
            'sky'     => 'bg-sky-50/40 dark:bg-sky-950/20',
            'blue'    => 'bg-blue-50/40 dark:bg-blue-950/20',
            'indigo'  => 'bg-indigo-50/40 dark:bg-indigo-950/20',
            'violet'  => 'bg-violet-50/40 dark:bg-violet-950/20',
            'purple'  => 'bg-purple-50/40 dark:bg-purple-950/20',
            'fuchsia' => 'bg-fuchsia-50/40 dark:bg-fuchsia-950/20',
            'pink'    => 'bg-pink-50/40 dark:bg-pink-950/20',
            'rose'    => 'bg-rose-50/40 dark:bg-rose-950/20',
            'taupe'   => 'bg-taupe-50/40 dark:bg-taupe-950/20',
            'mauve'   => 'bg-mauve-50/40 dark:bg-mauve-950/20',
            'mist'    => 'bg-mist-50/40 dark:bg-mist-950/20',
            'olive'   => 'bg-olive-50/40 dark:bg-olive-950/20',
        ];

        $rowBgCheckedHasMap = [
            'slate'   => 'has-[:checked]:bg-slate-50 dark:has-[:checked]:bg-slate-800/40',
            'gray'    => 'has-[:checked]:bg-gray-50 dark:has-[:checked]:bg-gray-800/40',
            'zinc'    => 'has-[:checked]:bg-zinc-50 dark:has-[:checked]:bg-zinc-800/40',
            'neutral' => 'has-[:checked]:bg-neutral-50 dark:has-[:checked]:bg-neutral-800/40',
            'stone'   => 'has-[:checked]:bg-stone-50 dark:has-[:checked]:bg-stone-800/40',
            'red'     => 'has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-950/30',
            'orange'  => 'has-[:checked]:bg-orange-50 dark:has-[:checked]:bg-orange-950/30',
            'amber'   => 'has-[:checked]:bg-amber-50 dark:has-[:checked]:bg-amber-950/30',
            'yellow'  => 'has-[:checked]:bg-yellow-50 dark:has-[:checked]:bg-yellow-950/30',
            'lime'    => 'has-[:checked]:bg-lime-50 dark:has-[:checked]:bg-lime-950/30',
            'green'   => 'has-[:checked]:bg-green-50 dark:has-[:checked]:bg-green-950/30',
            'emerald' => 'has-[:checked]:bg-emerald-50 dark:has-[:checked]:bg-emerald-950/30',
            'teal'    => 'has-[:checked]:bg-teal-50 dark:has-[:checked]:bg-teal-950/30',
            'cyan'    => 'has-[:checked]:bg-cyan-50 dark:has-[:checked]:bg-cyan-950/30',
            'sky'     => 'has-[:checked]:bg-sky-50 dark:has-[:checked]:bg-sky-950/30',
            'blue'    => 'has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-950/30',
            'indigo'  => 'has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-950/30',
            'violet'  => 'has-[:checked]:bg-violet-50 dark:has-[:checked]:bg-violet-950/30',
            'purple'  => 'has-[:checked]:bg-purple-50 dark:has-[:checked]:bg-purple-950/30',
            'fuchsia' => 'has-[:checked]:bg-fuchsia-50 dark:has-[:checked]:bg-fuchsia-950/30',
            'pink'    => 'has-[:checked]:bg-pink-50 dark:has-[:checked]:bg-pink-950/30',
            'rose'    => 'has-[:checked]:bg-rose-50 dark:has-[:checked]:bg-rose-950/30',
            'taupe'   => 'has-[:checked]:bg-taupe-50 dark:has-[:checked]:bg-taupe-950/30',
            'mauve'   => 'has-[:checked]:bg-mauve-50 dark:has-[:checked]:bg-mauve-950/30',
            'mist'    => 'has-[:checked]:bg-mist-50 dark:has-[:checked]:bg-mist-950/30',
            'olive'   => 'has-[:checked]:bg-olive-50 dark:has-[:checked]:bg-olive-950/30',
        ];

        $this->iconColorUnchecked   = $iconColorUncheckedMap[$theme] ?? $iconColorUncheckedMap['sky'];
        $this->iconColorChecked     = $iconColorMap[$theme] ?? $iconColorMap['sky'];
        $this->iconColorCheckedPeer = $iconColorPeerCheckedMap[$theme] ?? $iconColorPeerCheckedMap['sky'];
        $this->labelClasses         = 'cursor-pointer text-sm font-medium text-slate-700 dark:text-slate-300 select-none';
        $this->containerBorder      = $containerBorderMap[$theme] ?? $containerBorderMap['sky'];
        $this->rowBg                = $rowBgMap[$theme] ?? $rowBgMap['sky'];
        $this->rowBgCheckedHas      = $rowBgCheckedHasMap[$theme] ?? $rowBgCheckedHasMap['sky'];

        if (empty($id)) {
            $this->id = 'checkbox-' . uniqid();
        }
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.form.checkbox');
    }
}
