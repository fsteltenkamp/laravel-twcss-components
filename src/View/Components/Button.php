<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public string $classList;
    public string $heightStyle;

    public function __construct(
        public string $theme = 'gray',
        public string $width = 'fit',
        public string $height = 'md',
        public string $tooltip = '',
        public bool $disabled = false,
        public string $variant = 'solid',
        string $class = ''
    )
    {
        $solidThemeMap = [
            'slate'   => 'bg-slate-400 text-white hover:bg-slate-500 focus:ring-slate-300 dark:bg-slate-600 dark:hover:bg-slate-500 dark:focus:ring-slate-500',
            'gray'    => 'bg-gray-400 text-white hover:bg-gray-500 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-500',
            'zinc'    => 'bg-zinc-400 text-white hover:bg-zinc-500 focus:ring-zinc-300 dark:bg-zinc-600 dark:hover:bg-zinc-500 dark:focus:ring-zinc-500',
            'neutral' => 'bg-neutral-400 text-white hover:bg-neutral-500 focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-500 dark:focus:ring-neutral-500',
            'stone'   => 'bg-stone-400 text-white hover:bg-stone-500 focus:ring-stone-300 dark:bg-stone-600 dark:hover:bg-stone-500 dark:focus:ring-stone-500',
            'red'     => 'bg-red-400 text-white hover:bg-red-500 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-500 dark:focus:ring-red-500',
            'orange'  => 'bg-orange-400 text-white hover:bg-orange-500 focus:ring-orange-300 dark:bg-orange-600 dark:hover:bg-orange-500 dark:focus:ring-orange-500',
            'amber'   => 'bg-amber-400 text-white hover:bg-amber-500 focus:ring-amber-300 dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-amber-500',
            'yellow'  => 'bg-yellow-400 text-white hover:bg-yellow-500 focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-500 dark:focus:ring-yellow-500',
            'lime'    => 'bg-lime-400 text-white hover:bg-lime-500 focus:ring-lime-300 dark:bg-lime-600 dark:hover:bg-lime-500 dark:focus:ring-lime-500',
            'green'   => 'bg-green-400 text-white hover:bg-green-500 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-500 dark:focus:ring-green-500',
            'emerald' => 'bg-emerald-400 text-white hover:bg-emerald-500 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-500 dark:focus:ring-emerald-500',
            'teal'    => 'bg-teal-400 text-white hover:bg-teal-500 focus:ring-teal-300 dark:bg-teal-600 dark:hover:bg-teal-500 dark:focus:ring-teal-500',
            'cyan'    => 'bg-cyan-400 text-white hover:bg-cyan-500 focus:ring-cyan-300 dark:bg-cyan-600 dark:hover:bg-cyan-500 dark:focus:ring-cyan-500',
            'sky'     => 'bg-sky-400 text-white hover:bg-sky-500 focus:ring-sky-300 dark:bg-sky-600 dark:hover:bg-sky-500 dark:focus:ring-sky-500',
            'blue'    => 'bg-blue-400 text-white hover:bg-blue-500 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-500 dark:focus:ring-blue-500',
            'indigo'  => 'bg-indigo-400 text-white hover:bg-indigo-500 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-500 dark:focus:ring-indigo-500',
            'violet'  => 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-300 dark:bg-violet-600 dark:hover:bg-violet-500 dark:focus:ring-violet-500',
            'purple'  => 'bg-purple-400 text-white hover:bg-purple-500 focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-500 dark:focus:ring-purple-500',
            'fuchsia' => 'bg-fuchsia-400 text-white hover:bg-fuchsia-500 focus:ring-fuchsia-300 dark:bg-fuchsia-600 dark:hover:bg-fuchsia-500 dark:focus:ring-fuchsia-500',
            'pink'    => 'bg-pink-400 text-white hover:bg-pink-500 focus:ring-pink-300 dark:bg-pink-600 dark:hover:bg-pink-500 dark:focus:ring-pink-500',
            'rose'    => 'bg-rose-400 text-white hover:bg-rose-500 focus:ring-rose-300 dark:bg-rose-600 dark:hover:bg-rose-500 dark:focus:ring-rose-500',
            'taupe'   => 'bg-taupe-400 text-white hover:bg-taupe-500 focus:ring-taupe-300 dark:bg-taupe-600 dark:hover:bg-taupe-500 dark:focus:ring-taupe-500',
            'mauve'   => 'bg-mauve-400 text-white hover:bg-mauve-500 focus:ring-mauve-300 dark:bg-mauve-600 dark:hover:bg-mauve-500 dark:focus:ring-mauve-500',
            'mist'    => 'bg-mist-400 text-white hover:bg-mist-500 focus:ring-mist-300 dark:bg-mist-600 dark:hover:bg-mist-500 dark:focus:ring-mist-500',
            'olive'   => 'bg-olive-400 text-white hover:bg-olive-500 focus:ring-olive-300 dark:bg-olive-600 dark:hover:bg-olive-500 dark:focus:ring-olive-500',
        ];

        $outlineThemeMap = [
            'slate'   => 'border-2 border-slate-300 bg-slate-50/60 text-slate-600 hover:bg-slate-100 focus:ring-slate-200 dark:border-slate-500 dark:bg-slate-900/40 dark:text-slate-200 dark:hover:bg-slate-800/60 dark:focus:ring-slate-500',
            'gray'    => 'border-2 border-gray-300 bg-gray-50/60 text-gray-600 hover:bg-gray-100 focus:ring-gray-200 dark:border-gray-500 dark:bg-gray-900/40 dark:text-gray-200 dark:hover:bg-gray-800/60 dark:focus:ring-gray-500',
            'zinc'    => 'border-2 border-zinc-300 bg-zinc-50/60 text-zinc-600 hover:bg-zinc-100 focus:ring-zinc-200 dark:border-zinc-500 dark:bg-zinc-900/40 dark:text-zinc-200 dark:hover:bg-zinc-800/60 dark:focus:ring-zinc-500',
            'neutral' => 'border-2 border-neutral-300 bg-neutral-50/60 text-neutral-600 hover:bg-neutral-100 focus:ring-neutral-200 dark:border-neutral-500 dark:bg-neutral-900/40 dark:text-neutral-200 dark:hover:bg-neutral-800/60 dark:focus:ring-neutral-500',
            'stone'   => 'border-2 border-stone-300 bg-stone-50/60 text-stone-600 hover:bg-stone-100 focus:ring-stone-200 dark:border-stone-500 dark:bg-stone-900/40 dark:text-stone-200 dark:hover:bg-stone-800/60 dark:focus:ring-stone-500',
            'red'     => 'border-2 border-red-300 bg-red-50/60 text-red-600 hover:bg-red-100 focus:ring-red-200 dark:border-red-500 dark:bg-red-950/40 dark:text-red-200 dark:hover:bg-red-900/60 dark:focus:ring-red-500',
            'orange'  => 'border-2 border-orange-300 bg-orange-50/60 text-orange-600 hover:bg-orange-100 focus:ring-orange-200 dark:border-orange-500 dark:bg-orange-950/40 dark:text-orange-200 dark:hover:bg-orange-900/60 dark:focus:ring-orange-500',
            'amber'   => 'border-2 border-amber-300 bg-amber-50/60 text-amber-600 hover:bg-amber-100 focus:ring-amber-200 dark:border-amber-500 dark:bg-amber-950/40 dark:text-amber-200 dark:hover:bg-amber-900/60 dark:focus:ring-amber-500',
            'yellow'  => 'border-2 border-yellow-300 bg-yellow-50/60 text-yellow-700 hover:bg-yellow-100 focus:ring-yellow-200 dark:border-yellow-500 dark:bg-yellow-950/40 dark:text-yellow-200 dark:hover:bg-yellow-900/60 dark:focus:ring-yellow-500',
            'lime'    => 'border-2 border-lime-300 bg-lime-50/60 text-lime-700 hover:bg-lime-100 focus:ring-lime-200 dark:border-lime-500 dark:bg-lime-950/40 dark:text-lime-200 dark:hover:bg-lime-900/60 dark:focus:ring-lime-500',
            'green'   => 'border-2 border-green-300 bg-green-50/60 text-green-600 hover:bg-green-100 focus:ring-green-200 dark:border-green-500 dark:bg-green-950/40 dark:text-green-200 dark:hover:bg-green-900/60 dark:focus:ring-green-500',
            'emerald' => 'border-2 border-emerald-300 bg-emerald-50/60 text-emerald-600 hover:bg-emerald-100 focus:ring-emerald-200 dark:border-emerald-500 dark:bg-emerald-950/40 dark:text-emerald-200 dark:hover:bg-emerald-900/60 dark:focus:ring-emerald-500',
            'teal'    => 'border-2 border-teal-300 bg-teal-50/60 text-teal-600 hover:bg-teal-100 focus:ring-teal-200 dark:border-teal-500 dark:bg-teal-950/40 dark:text-teal-200 dark:hover:bg-teal-900/60 dark:focus:ring-teal-500',
            'cyan'    => 'border-2 border-cyan-300 bg-cyan-50/60 text-cyan-600 hover:bg-cyan-100 focus:ring-cyan-200 dark:border-cyan-500 dark:bg-cyan-950/40 dark:text-cyan-200 dark:hover:bg-cyan-900/60 dark:focus:ring-cyan-500',
            'sky'     => 'border-2 border-sky-300 bg-sky-50/60 text-sky-600 hover:bg-sky-100 focus:ring-sky-200 dark:border-sky-500 dark:bg-sky-950/40 dark:text-sky-200 dark:hover:bg-sky-900/60 dark:focus:ring-sky-500',
            'blue'    => 'border-2 border-blue-300 bg-blue-50/60 text-blue-600 hover:bg-blue-100 focus:ring-blue-200 dark:border-blue-500 dark:bg-blue-950/40 dark:text-blue-200 dark:hover:bg-blue-900/60 dark:focus:ring-blue-500',
            'indigo'  => 'border-2 border-indigo-300 bg-indigo-50/60 text-indigo-600 hover:bg-indigo-100 focus:ring-indigo-200 dark:border-indigo-500 dark:bg-indigo-950/40 dark:text-indigo-200 dark:hover:bg-indigo-900/60 dark:focus:ring-indigo-500',
            'violet'  => 'border-2 border-violet-300 bg-violet-50/60 text-violet-600 hover:bg-violet-100 focus:ring-violet-200 dark:border-violet-500 dark:bg-violet-950/40 dark:text-violet-200 dark:hover:bg-violet-900/60 dark:focus:ring-violet-500',
            'purple'  => 'border-2 border-purple-300 bg-purple-50/60 text-purple-600 hover:bg-purple-100 focus:ring-purple-200 dark:border-purple-500 dark:bg-purple-950/40 dark:text-purple-200 dark:hover:bg-purple-900/60 dark:focus:ring-purple-500',
            'fuchsia' => 'border-2 border-fuchsia-300 bg-fuchsia-50/60 text-fuchsia-600 hover:bg-fuchsia-100 focus:ring-fuchsia-200 dark:border-fuchsia-500 dark:bg-fuchsia-950/40 dark:text-fuchsia-200 dark:hover:bg-fuchsia-900/60 dark:focus:ring-fuchsia-500',
            'pink'    => 'border-2 border-pink-300 bg-pink-50/60 text-pink-600 hover:bg-pink-100 focus:ring-pink-200 dark:border-pink-500 dark:bg-pink-950/40 dark:text-pink-200 dark:hover:bg-pink-900/60 dark:focus:ring-pink-500',
            'rose'    => 'border-2 border-rose-300 bg-rose-50/60 text-rose-600 hover:bg-rose-100 focus:ring-rose-200 dark:border-rose-500 dark:bg-rose-950/40 dark:text-rose-200 dark:hover:bg-rose-900/60 dark:focus:ring-rose-500',
            'taupe'   => 'border-2 border-taupe-300 bg-taupe-50/60 text-taupe-600 hover:bg-taupe-100 focus:ring-taupe-200 dark:border-taupe-500 dark:bg-taupe-950/40 dark:text-taupe-200 dark:hover:bg-taupe-900/60 dark:focus:ring-taupe-500',
            'mauve'   => 'border-2 border-mauve-300 bg-mauve-50/60 text-mauve-600 hover:bg-mauve-100 focus:ring-mauve-200 dark:border-mauve-500 dark:bg-mauve-950/40 dark:text-mauve-200 dark:hover:bg-mauve-900/60 dark:focus:ring-mauve-500',
            'mist'    => 'border-2 border-mist-300 bg-mist-50/60 text-mist-600 hover:bg-mist-100 focus:ring-mist-200 dark:border-mist-500 dark:bg-mist-950/40 dark:text-mist-200 dark:hover:bg-mist-900/60 dark:focus:ring-mist-500',
            'olive'   => 'border-2 border-olive-300 bg-olive-50/60 text-olive-600 hover:bg-olive-100 focus:ring-olive-200 dark:border-olive-500 dark:bg-olive-950/40 dark:text-olive-200 dark:hover:bg-olive-900/60 dark:focus:ring-olive-500',
        ];

        $widthMap = [
            'fit' => 'w-fit',
            'full' => 'w-full',
        ];

        $heightMap = [
            'xs' => 'h-8',
            'sm' => 'h-9',
            'md' => 'h-10',
            'lg' => 'h-11',
            'xl' => 'h-12',
            'auto' => 'h-auto',
        ];

        $this->heightStyle = '';
        $trimmedHeight = trim($height);

        $heightClasses = '';

        if (isset($heightMap[$trimmedHeight])) {
            $heightClasses = $heightMap[$trimmedHeight];
        } elseif (preg_match('/^\d+(?:\.\d+)?(?:px)?$/', $trimmedHeight) === 1) {
            $pixelHeight = str_ends_with($trimmedHeight, 'px') ? $trimmedHeight : $trimmedHeight.'px';
            $heightClasses = '';
            $this->heightStyle = 'height: '.$pixelHeight.';';
        } else {
            $heightClasses = $heightMap['md'];
        }

        $variantMap = [
            'solid' => $solidThemeMap,
            'outline' => $outlineThemeMap,
        ];

        $selectedVariant = strtolower(trim($variant));
        $selectedThemeMap = $variantMap[$selectedVariant] ?? $solidThemeMap;

        $this->classList = trim(implode(' ', [
            $selectedThemeMap[$theme] ?? $selectedThemeMap['gray'],
            $widthMap[$width] ?? $widthMap['fit'],
            $heightClasses,
            'cursor-pointer inline-flex items-center justify-center rounded-md px-4 py-2 text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-900',
            $disabled ? 'cursor-not-allowed opacity-60 pointer-events-none' : '',
            $class,
        ]));
    }

    public function render(): View|Closure|string
    {
        return view('twcss::components.button');
    }
}
