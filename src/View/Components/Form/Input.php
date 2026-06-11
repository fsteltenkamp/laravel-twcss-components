<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form;

use Illuminate\Support\Facades\View;
use Illuminate\View\Component;

abstract class Input extends Component
{
    protected array $themeMap = [
        'slate'    => 'border-slate-300 placeholder-slate-400 focus:border-slate-500 focus:ring-slate-500 dark:border-slate-600 dark:placeholder-slate-500 dark:focus:border-slate-400 dark:focus:ring-slate-400',
        'gray'     => 'border-gray-300 placeholder-gray-400 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600 dark:placeholder-gray-500 dark:focus:border-gray-400 dark:focus:ring-gray-400',
        'zinc'     => 'border-zinc-300 placeholder-zinc-400 focus:border-zinc-500 focus:ring-zinc-500 dark:border-zinc-600 dark:placeholder-zinc-500 dark:focus:border-zinc-400 dark:focus:ring-zinc-400',
        'neutral'  => 'border-neutral-300 placeholder-neutral-400 focus:border-neutral-500 focus:ring-neutral-500 dark:border-neutral-600 dark:placeholder-neutral-500 dark:focus:border-neutral-400 dark:focus:ring-neutral-400',
        'stone'    => 'border-stone-300 placeholder-stone-400 focus:border-stone-500 focus:ring-stone-500 dark:border-stone-600 dark:placeholder-stone-500 dark:focus:border-stone-400 dark:focus:ring-stone-400',
        'red'      => 'border-red-300 placeholder-red-400 focus:border-red-500 focus:ring-red-500 dark:border-red-600 dark:placeholder-red-500 dark:focus:border-red-400 dark:focus:ring-red-400',
        'orange'   => 'border-orange-300 placeholder-orange-400 focus:border-orange-500 focus:ring-orange-500 dark:border-orange-600 dark:placeholder-orange-500 dark:focus:border-orange-400 dark:focus:ring-orange-400',
        'amber'    => 'border-amber-300 placeholder-amber-400 focus:border-amber-500 focus:ring-amber-500 dark:border-amber-600 dark:placeholder-amber-500 dark:focus:border-amber-400 dark:focus:ring-amber-400',
        'yellow'   => 'border-yellow-300 placeholder-yellow-400 focus:border-yellow-500 focus:ring-yellow-500 dark:border-yellow-600 dark:placeholder-yellow-500 dark:focus:border-yellow-400 dark:focus:ring-yellow-400',
        'lime'     => 'border-lime-300 placeholder-lime-400 focus:border-lime-500 focus:ring-lime-500 dark:border-lime-600 dark:placeholder-lime-500 dark:focus:border-lime-400 dark:focus:ring-lime-400',
        'green'    => 'border-green-300 placeholder-green-400 focus:border-green-500 focus:ring-green-500 dark:border-green-600 dark:placeholder-green-500 dark:focus:border-green-400 dark:focus:ring-green-400',
        'emerald'  => 'border-emerald-300 placeholder-emerald-400 focus:border-emerald-500 focus:ring-emerald-500 dark:border-emerald-600 dark:placeholder-emerald-500 dark:focus:border-emerald-400 dark:focus:ring-emerald-400',
        'teal'     => 'border-teal-300 placeholder-teal-400 focus:border-teal-500 focus:ring-teal-500 dark:border-teal-600 dark:placeholder-teal-500 dark:focus:border-teal-400 dark:focus:ring-teal-400',
        'cyan'     => 'border-cyan-300 placeholder-cyan-400 focus:border-cyan-500 focus:ring-cyan-500 dark:border-cyan-600 dark:placeholder-cyan-500 dark:focus:border-cyan-400 dark:focus:ring-cyan-400',
        'sky'      => 'border-sky-300 placeholder-sky-400 focus:border-sky-500 focus:ring-sky-500 dark:border-sky-600 dark:placeholder-sky-500 dark:focus:border-sky-400 dark:focus:ring-sky-400',
        'blue'     => 'border-blue-300 placeholder-blue-400 focus:border-blue-500 focus:ring-blue-500 dark:border-blue-600 dark:placeholder-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400',
        'indigo'   => 'border-indigo-300 placeholder-indigo-400 focus:border-indigo-500 focus:ring-indigo-500 dark:border-indigo-600 dark:placeholder-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400',
        'violet'   => 'border-violet-300 placeholder-violet-400 focus:border-violet-500 focus:ring-violet-500 dark:border-violet-600 dark:placeholder-violet-500 dark:focus:border-violet-400 dark:focus:ring-violet-400',
        'purple'   => 'border-purple-300 placeholder-purple-400 focus:border-purple-500 focus:ring-purple-500 dark:border-purple-600 dark:placeholder-purple-500 dark:focus:border-purple-400 dark:focus:ring-purple-400',
        'fuchsia'  => 'border-fuchsia-300 placeholder-fuchsia-400 focus:border-fuchsia-500 focus:ring-fuchsia-500 dark:border-fuchsia-600 dark:placeholder-fuchsia-500 dark:focus:border-fuchsia-400 dark:focus:ring-fuchsia-400',
        'pink'     => 'border-pink-300 placeholder-pink-400 focus:border-pink-500 focus:ring-pink-500 dark:border-pink-600 dark:placeholder-pink-500 dark:focus:border-pink-400 dark:focus:ring-pink-400',
        'rose'     => 'border-rose-300 placeholder-rose-400 focus:border-rose-500 focus:ring-rose-500 dark:border-rose-600 dark:placeholder-rose-500 dark:focus:border-rose-400 dark:focus:ring-rose-400',
        'taupe'    => 'border-taupe-300 placeholder-taupe-400 focus:border-taupe-500 focus:ring-taupe-500 dark:border-taupe-600 dark:placeholder-taupe-500 dark:focus:border-taupe-400 dark:focus:ring-taupe-400',
        'mauve'    => 'border-mauve-300 placeholder-mauve-400 focus:border-mauve-500 focus:ring-mauve-500 dark:border-mauve-600 dark:placeholder-mauve-500 dark:focus:border-mauve-400 dark:focus:ring-mauve-400',
        'mist'     => 'border-mist-300 placeholder-mist-400 focus:border-mist-500 focus:ring-mist-500 dark:border-mist-600 dark:placeholder-mist-500 dark:focus:border-mist-400 dark:focus:ring-mist-400',
        'olive'    => 'border-olive-300 placeholder-olive-400 focus:border-olive-500 focus:ring-olive-500 dark:border-olive-600 dark:placeholder-olive-500 dark:focus:border-olive-400 dark:focus:ring-olive-400',
    ];

    protected string $baseClasses = 'block w-full rounded-md border py-2 pl-10 pr-3 shadow-sm transition duration-150 focus:outline-none focus:ring-2';
    protected string $errorBaseClasses = 'border-red-500 placeholder-red-300 focus:border-red-500 focus:ring-red-500 dark:border-red-400 dark:placeholder-red-400 dark:focus:border-red-400 dark:focus:ring-red-400';

    protected function getBackgroundClasses($theme = 'slate'): string
    {
        $mainTheme = View::shared('mainTheme');
        return "bg-$mainTheme-200 dark:bg-$mainTheme-900 text-$theme-900 dark:text-$theme-400";
    }

    protected function getNormalClasses(string $theme = 'sky', string $class = ''): string
    {
        return trim(implode(' ', [
            $this->baseClasses,
            $this->getBackgroundClasses($theme),
            $this->themeMap[$theme] ?? $this->themeMap['sky'],
            $class,
        ]));
    }

    protected function getErrorClasses(string $class = ''): string
    {
        return trim(implode(' ', [
            $this->baseClasses,
            $this->getBackgroundClasses(),
            $this->errorBaseClasses,
            $class,
        ]));
    }
}
