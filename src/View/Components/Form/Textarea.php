<?php

namespace Fsteltenkamp\fltcComponents\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    public string $classList;

    public function __construct(
        public string $id = '',
        public string $name = '',
        public string $label = '',
        public bool $required = false,
        public string $model = '',
        public bool $live = false,
        public string $theme = 'slate',
        public string $height = 'md',
        public string $width = 'full',
        public int $rows = 6,
        public string $placeholder = '',
        public string $value = '',
        public bool $disabled = false,
        public bool $readonly = false,
        public string $class = '',
    ) {
        if ($this->name === '') {
            $this->name = $this->id;
        }
        $themeMap = [
            'slate'    => 'border-slate-300 bg-slate-50 text-slate-900 placeholder-slate-400 focus:border-slate-400 focus:ring-slate-400 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500 dark:focus:border-slate-400 dark:focus:ring-slate-400',
            'gray'     => 'border-gray-300 bg-gray-50 text-gray-900 placeholder-gray-400 focus:border-gray-400 focus:ring-gray-400 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-gray-400 dark:focus:ring-gray-400',
            'zinc'     => 'border-zinc-300 bg-zinc-50 text-zinc-900 placeholder-zinc-400 focus:border-zinc-400 focus:ring-zinc-400 dark:border-zinc-600 dark:bg-zinc-900 dark:text-zinc-100 dark:placeholder-zinc-500 dark:focus:border-zinc-400 dark:focus:ring-zinc-400',
            'neutral'  => 'border-neutral-300 bg-neutral-50 text-neutral-900 placeholder-neutral-400 focus:border-neutral-400 focus:ring-neutral-400 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-100 dark:placeholder-neutral-500 dark:focus:border-neutral-400 dark:focus:ring-neutral-400',
            'stone'    => 'border-stone-300 bg-stone-50 text-stone-900 placeholder-stone-400 focus:border-stone-400 focus:ring-stone-400 dark:border-stone-600 dark:bg-stone-900 dark:text-stone-100 dark:placeholder-stone-500 dark:focus:border-stone-400 dark:focus:ring-stone-400',
            'red'      => 'border-red-300 bg-red-50 text-red-900 placeholder-red-400 focus:border-red-400 focus:ring-red-400 dark:border-red-600 dark:bg-red-950 dark:text-red-100 dark:placeholder-red-500 dark:focus:border-red-400 dark:focus:ring-red-400',
            'orange'   => 'border-orange-300 bg-orange-50 text-orange-900 placeholder-orange-400 focus:border-orange-400 focus:ring-orange-400 dark:border-orange-600 dark:bg-orange-950 dark:text-orange-100 dark:placeholder-orange-500 dark:focus:border-orange-400 dark:focus:ring-orange-400',
            'amber'    => 'border-amber-300 bg-amber-50 text-amber-900 placeholder-amber-400 focus:border-amber-400 focus:ring-amber-400 dark:border-amber-600 dark:bg-amber-950 dark:text-amber-100 dark:placeholder-amber-500 dark:focus:border-amber-400 dark:focus:ring-amber-400',
            'yellow'   => 'border-yellow-300 bg-yellow-50 text-yellow-900 placeholder-yellow-400 focus:border-yellow-400 focus:ring-yellow-400 dark:border-yellow-600 dark:bg-yellow-950 dark:text-yellow-100 dark:placeholder-yellow-500 dark:focus:border-yellow-400 dark:focus:ring-yellow-400',
            'lime'     => 'border-lime-300 bg-lime-50 text-lime-900 placeholder-lime-400 focus:border-lime-400 focus:ring-lime-400 dark:border-lime-600 dark:bg-lime-950 dark:text-lime-100 dark:placeholder-lime-500 dark:focus:border-lime-400 dark:focus:ring-lime-400',
            'green'    => 'border-green-300 bg-green-50 text-green-900 placeholder-green-400 focus:border-green-400 focus:ring-green-400 dark:border-green-600 dark:bg-green-950 dark:text-green-100 dark:placeholder-green-500 dark:focus:border-green-400 dark:focus:ring-green-400',
            'emerald'  => 'border-emerald-300 bg-emerald-50 text-emerald-900 placeholder-emerald-400 focus:border-emerald-400 focus:ring-emerald-400 dark:border-emerald-600 dark:bg-emerald-950 dark:text-emerald-100 dark:placeholder-emerald-500 dark:focus:border-emerald-400 dark:focus:ring-emerald-400',
            'teal'     => 'border-teal-300 bg-teal-50 text-teal-900 placeholder-teal-400 focus:border-teal-400 focus:ring-teal-400 dark:border-teal-600 dark:bg-teal-950 dark:text-teal-100 dark:placeholder-teal-500 dark:focus:border-teal-400 dark:focus:ring-teal-400',
            'cyan'     => 'border-cyan-300 bg-cyan-50 text-cyan-900 placeholder-cyan-400 focus:border-cyan-400 focus:ring-cyan-400 dark:border-cyan-600 dark:bg-cyan-950 dark:text-cyan-100 dark:placeholder-cyan-500 dark:focus:border-cyan-400 dark:focus:ring-cyan-400',
            'sky'      => 'border-sky-300 bg-sky-50 text-sky-900 placeholder-sky-400 focus:border-sky-400 focus:ring-sky-400 dark:border-sky-600 dark:bg-sky-950 dark:text-sky-100 dark:placeholder-sky-500 dark:focus:border-sky-400 dark:focus:ring-sky-400',
            'blue'     => 'border-blue-300 bg-blue-50 text-blue-900 placeholder-blue-400 focus:border-blue-400 focus:ring-blue-400 dark:border-blue-600 dark:bg-blue-950 dark:text-blue-100 dark:placeholder-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400',
            'indigo'   => 'border-indigo-300 bg-indigo-50 text-indigo-900 placeholder-indigo-400 focus:border-indigo-400 focus:ring-indigo-400 dark:border-indigo-600 dark:bg-indigo-950 dark:text-indigo-100 dark:placeholder-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400',
            'violet'   => 'border-violet-300 bg-violet-50 text-violet-900 placeholder-violet-400 focus:border-violet-400 focus:ring-violet-400 dark:border-violet-600 dark:bg-violet-950 dark:text-violet-100 dark:placeholder-violet-500 dark:focus:border-violet-400 dark:focus:ring-violet-400',
            'purple'   => 'border-purple-300 bg-purple-50 text-purple-900 placeholder-purple-400 focus:border-purple-400 focus:ring-purple-400 dark:border-purple-600 dark:bg-purple-950 dark:text-purple-100 dark:placeholder-purple-500 dark:focus:border-purple-400 dark:focus:ring-purple-400',
            'fuchsia'  => 'border-fuchsia-300 bg-fuchsia-50 text-fuchsia-900 placeholder-fuchsia-400 focus:border-fuchsia-400 focus:ring-fuchsia-400 dark:border-fuchsia-600 dark:bg-fuchsia-950 dark:text-fuchsia-100 dark:placeholder-fuchsia-500 dark:focus:border-fuchsia-400 dark:focus:ring-fuchsia-400',
            'pink'     => 'border-pink-300 bg-pink-50 text-pink-900 placeholder-pink-400 focus:border-pink-400 focus:ring-pink-400 dark:border-pink-600 dark:bg-pink-950 dark:text-pink-100 dark:placeholder-pink-500 dark:focus:border-pink-400 dark:focus:ring-pink-400',
            'rose'     => 'border-rose-300 bg-rose-50 text-rose-900 placeholder-rose-400 focus:border-rose-400 focus:ring-rose-400 dark:border-rose-600 dark:bg-rose-950 dark:text-rose-100 dark:placeholder-rose-500 dark:focus:border-rose-400 dark:focus:ring-rose-400',
            'taupe'    => 'border-taupe-300 bg-taupe-50 text-taupe-900 placeholder-taupe-400 focus:border-taupe-400 focus:ring-taupe-400 dark:border-taupe-600 dark:bg-taupe-950 dark:text-taupe-100 dark:placeholder-taupe-500 dark:focus:border-taupe-400 dark:focus:ring-taupe-400',
            'mauve'    => 'border-mauve-300 bg-mauve-50 text-mauve-900 placeholder-mauve-400 focus:border-mauve-400 focus:ring-mauve-400 dark:border-mauve-600 dark:bg-mauve-950 dark:text-mauve-100 dark:placeholder-mauve-500 dark:focus:border-mauve-400 dark:focus:ring-mauve-400',
            'mist'     => 'border-mist-300 bg-mist-50 text-mist-900 placeholder-mist-400 focus:border-mist-400 focus:ring-mist-400 dark:border-mist-600 dark:bg-mist-950 dark:text-mist-100 dark:placeholder-mist-500 dark:focus:border-mist-400 dark:focus:ring-mist-400',
            'olive'    => 'border-olive-300 bg-olive-50 text-olive-900 placeholder-olive-400 focus:border-olive-400 focus:ring-olive-400 dark:border-olive-600 dark:bg-olive-950 dark:text-olive-100 dark:placeholder-olive-500 dark:focus:border-olive-400 dark:focus:ring-olive-400',
            'monokai'  => 'border-zinc-800 bg-zinc-950 text-lime-400 placeholder-zinc-500 focus:border-lime-500 focus:ring-lime-500',
            'dracula'  => 'border-slate-700 bg-slate-950 text-fuchsia-200 placeholder-slate-500 focus:border-pink-400 focus:ring-pink-400',
            'github'   => 'border-slate-300 bg-white text-slate-900 placeholder-slate-400 focus:border-slate-400 focus:ring-slate-400 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500',
            'nord'     => 'border-slate-700 bg-slate-900 text-sky-100 placeholder-slate-500 focus:border-sky-400 focus:ring-sky-400',
            'solarized' => 'border-slate-700 bg-slate-900 text-amber-100 placeholder-slate-500 focus:border-cyan-400 focus:ring-cyan-400',
        ];

        $heightMap = [
            'xs' => 'h-20',
            'sm' => 'h-28',
            'md' => 'h-40',
            'lg' => 'h-56',
            'xl' => 'h-72',
            '2xl' => 'h-96',
            'fit' => 'h-fit',
            'auto' => 'h-auto',
            'screen' => 'h-screen',
        ];

        $widthMap = [
            'xs' => 'w-48',
            'sm' => 'w-64',
            'md' => 'w-72',
            'lg' => 'w-80',
            'xl' => 'w-96',
            'fit' => 'w-fit',
            'auto' => 'w-auto',
            'full' => 'w-full',
            'screen' => 'w-screen',
        ];

        $baseClasses = 'block resize-y rounded-lg border p-3 font-mono text-xs leading-5 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-slate-950';

        $this->classList = trim(implode(' ', array_filter([
            $baseClasses,
            $heightMap[$height] ?? $heightMap['md'],
            $widthMap[$width] ?? $widthMap['full'],
            $themeMap[$theme] ?? $themeMap['slate'],
            $class,
        ])));

        if (empty($id)) {
            $this->id = 'textarea-' . uniqid();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.form.textarea');
    }
}
