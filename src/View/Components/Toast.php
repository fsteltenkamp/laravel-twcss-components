<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Toast extends Component
{
    public string $classList;
    public string $iconClasses;
    public string $closeClasses;
    public string $descClasses;

    public function __construct(
        public string $theme = 'gray',
        public string $variant = 'toast',
        public string $title = '',
        public ?string $message = null,
        public ?string $icon = null,
        public int $duration = 0,
        public bool $dismissible = true,
    ) {
        $map   = static::themeMap();
        $entry = $map[$this->theme][$this->variant] ?? $map['gray']['toast'];

        $this->classList    = $entry['wrapper'];
        $this->iconClasses  = $entry['icon'];
        $this->closeClasses = $entry['close'];
        $this->descClasses  = $entry['desc'];
    }

    /**
     * Full theme × variant class map.
     * All class strings are written out literally so Tailwind's scanner picks them up.
     * Called by Toast\Container to pass the map to Alpine via @js().
     * All variants share the same palette per theme; structural differences live in the blade template.
     */
    public static function themeMap(): array
    {
        $v = ['pill', 'card', 'toast', 'baguette'];

        return [
            // ── Neutral scales ────────────────────────────────────────────────────────
            'slate' => array_fill_keys($v, [
                'wrapper' => 'border border-slate-200 bg-slate-100 text-slate-700 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300',
                'icon'    => 'text-slate-500 dark:text-slate-400',
                'close'   => 'text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 transition-colors',
                'desc'    => 'text-slate-500 dark:text-slate-400',
            ]),
            'gray' => array_fill_keys($v, [
                'wrapper' => 'border border-gray-200 bg-gray-100 text-gray-700 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300',
                'icon'    => 'text-gray-500 dark:text-gray-400',
                'close'   => 'text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors',
                'desc'    => 'text-gray-500 dark:text-gray-400',
            ]),
            'zinc' => array_fill_keys($v, [
                'wrapper' => 'border border-zinc-200 bg-zinc-100 text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300',
                'icon'    => 'text-zinc-500 dark:text-zinc-400',
                'close'   => 'text-zinc-400 hover:text-zinc-600 dark:text-zinc-500 dark:hover:text-zinc-300 transition-colors',
                'desc'    => 'text-zinc-500 dark:text-zinc-400',
            ]),
            'neutral' => array_fill_keys($v, [
                'wrapper' => 'border border-neutral-200 bg-neutral-100 text-neutral-700 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300',
                'icon'    => 'text-neutral-500 dark:text-neutral-400',
                'close'   => 'text-neutral-400 hover:text-neutral-600 dark:text-neutral-500 dark:hover:text-neutral-300 transition-colors',
                'desc'    => 'text-neutral-500 dark:text-neutral-400',
            ]),
            'stone' => array_fill_keys($v, [
                'wrapper' => 'border border-stone-200 bg-stone-100 text-stone-700 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-300',
                'icon'    => 'text-stone-500 dark:text-stone-400',
                'close'   => 'text-stone-400 hover:text-stone-600 dark:text-stone-500 dark:hover:text-stone-300 transition-colors',
                'desc'    => 'text-stone-500 dark:text-stone-400',
            ]),

            // ── Accent scales ─────────────────────────────────────────────────────────
            'red' => array_fill_keys($v, [
                'wrapper' => 'border border-red-200 bg-red-100 text-red-700 dark:border-red-800 dark:bg-red-950 dark:text-red-300',
                'icon'    => 'text-red-500 dark:text-red-400',
                'close'   => 'text-red-400 hover:text-red-600 dark:text-red-500 dark:hover:text-red-300 transition-colors',
                'desc'    => 'text-red-500 dark:text-red-400',
            ]),
            'orange' => array_fill_keys($v, [
                'wrapper' => 'border border-orange-200 bg-orange-100 text-orange-700 dark:border-orange-800 dark:bg-orange-950 dark:text-orange-300',
                'icon'    => 'text-orange-500 dark:text-orange-400',
                'close'   => 'text-orange-400 hover:text-orange-600 dark:text-orange-500 dark:hover:text-orange-300 transition-colors',
                'desc'    => 'text-orange-500 dark:text-orange-400',
            ]),
            'amber' => array_fill_keys($v, [
                'wrapper' => 'border border-amber-200 bg-amber-100 text-amber-700 dark:border-amber-800 dark:bg-amber-950 dark:text-amber-300',
                'icon'    => 'text-amber-500 dark:text-amber-400',
                'close'   => 'text-amber-400 hover:text-amber-600 dark:text-amber-500 dark:hover:text-amber-300 transition-colors',
                'desc'    => 'text-amber-500 dark:text-amber-400',
            ]),
            'yellow' => array_fill_keys($v, [
                'wrapper' => 'border border-yellow-200 bg-yellow-100 text-yellow-700 dark:border-yellow-800 dark:bg-yellow-950 dark:text-yellow-300',
                'icon'    => 'text-yellow-500 dark:text-yellow-400',
                'close'   => 'text-yellow-400 hover:text-yellow-600 dark:text-yellow-500 dark:hover:text-yellow-300 transition-colors',
                'desc'    => 'text-yellow-500 dark:text-yellow-400',
            ]),
            'lime' => array_fill_keys($v, [
                'wrapper' => 'border border-lime-200 bg-lime-100 text-lime-700 dark:border-lime-800 dark:bg-lime-950 dark:text-lime-300',
                'icon'    => 'text-lime-500 dark:text-lime-400',
                'close'   => 'text-lime-400 hover:text-lime-600 dark:text-lime-500 dark:hover:text-lime-300 transition-colors',
                'desc'    => 'text-lime-500 dark:text-lime-400',
            ]),
            'green' => array_fill_keys($v, [
                'wrapper' => 'border border-green-200 bg-green-100 text-green-700 dark:border-green-800 dark:bg-green-950 dark:text-green-300',
                'icon'    => 'text-green-500 dark:text-green-400',
                'close'   => 'text-green-400 hover:text-green-600 dark:text-green-500 dark:hover:text-green-300 transition-colors',
                'desc'    => 'text-green-500 dark:text-green-400',
            ]),
            'emerald' => array_fill_keys($v, [
                'wrapper' => 'border border-emerald-200 bg-emerald-100 text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-300',
                'icon'    => 'text-emerald-500 dark:text-emerald-400',
                'close'   => 'text-emerald-400 hover:text-emerald-600 dark:text-emerald-500 dark:hover:text-emerald-300 transition-colors',
                'desc'    => 'text-emerald-500 dark:text-emerald-400',
            ]),
            'teal' => array_fill_keys($v, [
                'wrapper' => 'border border-teal-200 bg-teal-100 text-teal-700 dark:border-teal-800 dark:bg-teal-950 dark:text-teal-300',
                'icon'    => 'text-teal-500 dark:text-teal-400',
                'close'   => 'text-teal-400 hover:text-teal-600 dark:text-teal-500 dark:hover:text-teal-300 transition-colors',
                'desc'    => 'text-teal-500 dark:text-teal-400',
            ]),
            'cyan' => array_fill_keys($v, [
                'wrapper' => 'border border-cyan-200 bg-cyan-100 text-cyan-700 dark:border-cyan-800 dark:bg-cyan-950 dark:text-cyan-300',
                'icon'    => 'text-cyan-500 dark:text-cyan-400',
                'close'   => 'text-cyan-400 hover:text-cyan-600 dark:text-cyan-500 dark:hover:text-cyan-300 transition-colors',
                'desc'    => 'text-cyan-500 dark:text-cyan-400',
            ]),
            'sky' => array_fill_keys($v, [
                'wrapper' => 'border border-sky-200 bg-sky-100 text-sky-700 dark:border-sky-800 dark:bg-sky-950 dark:text-sky-300',
                'icon'    => 'text-sky-500 dark:text-sky-400',
                'close'   => 'text-sky-400 hover:text-sky-600 dark:text-sky-500 dark:hover:text-sky-300 transition-colors',
                'desc'    => 'text-sky-500 dark:text-sky-400',
            ]),
            'blue' => array_fill_keys($v, [
                'wrapper' => 'border border-blue-200 bg-blue-100 text-blue-700 dark:border-blue-800 dark:bg-blue-950 dark:text-blue-300',
                'icon'    => 'text-blue-500 dark:text-blue-400',
                'close'   => 'text-blue-400 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-300 transition-colors',
                'desc'    => 'text-blue-500 dark:text-blue-400',
            ]),
            'indigo' => array_fill_keys($v, [
                'wrapper' => 'border border-indigo-200 bg-indigo-100 text-indigo-700 dark:border-indigo-800 dark:bg-indigo-950 dark:text-indigo-300',
                'icon'    => 'text-indigo-500 dark:text-indigo-400',
                'close'   => 'text-indigo-400 hover:text-indigo-600 dark:text-indigo-500 dark:hover:text-indigo-300 transition-colors',
                'desc'    => 'text-indigo-500 dark:text-indigo-400',
            ]),
            'violet' => array_fill_keys($v, [
                'wrapper' => 'border border-violet-200 bg-violet-100 text-violet-700 dark:border-violet-800 dark:bg-violet-950 dark:text-violet-300',
                'icon'    => 'text-violet-500 dark:text-violet-400',
                'close'   => 'text-violet-400 hover:text-violet-600 dark:text-violet-500 dark:hover:text-violet-300 transition-colors',
                'desc'    => 'text-violet-500 dark:text-violet-400',
            ]),
            'purple' => array_fill_keys($v, [
                'wrapper' => 'border border-purple-200 bg-purple-100 text-purple-700 dark:border-purple-800 dark:bg-purple-950 dark:text-purple-300',
                'icon'    => 'text-purple-500 dark:text-purple-400',
                'close'   => 'text-purple-400 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-300 transition-colors',
                'desc'    => 'text-purple-500 dark:text-purple-400',
            ]),
            'fuchsia' => array_fill_keys($v, [
                'wrapper' => 'border border-fuchsia-200 bg-fuchsia-100 text-fuchsia-700 dark:border-fuchsia-800 dark:bg-fuchsia-950 dark:text-fuchsia-300',
                'icon'    => 'text-fuchsia-500 dark:text-fuchsia-400',
                'close'   => 'text-fuchsia-400 hover:text-fuchsia-600 dark:text-fuchsia-500 dark:hover:text-fuchsia-300 transition-colors',
                'desc'    => 'text-fuchsia-500 dark:text-fuchsia-400',
            ]),
            'pink' => array_fill_keys($v, [
                'wrapper' => 'border border-pink-200 bg-pink-100 text-pink-700 dark:border-pink-800 dark:bg-pink-950 dark:text-pink-300',
                'icon'    => 'text-pink-500 dark:text-pink-400',
                'close'   => 'text-pink-400 hover:text-pink-600 dark:text-pink-500 dark:hover:text-pink-300 transition-colors',
                'desc'    => 'text-pink-500 dark:text-pink-400',
            ]),
            'rose' => array_fill_keys($v, [
                'wrapper' => 'border border-rose-200 bg-rose-100 text-rose-700 dark:border-rose-800 dark:bg-rose-950 dark:text-rose-300',
                'icon'    => 'text-rose-500 dark:text-rose-400',
                'close'   => 'text-rose-400 hover:text-rose-600 dark:text-rose-500 dark:hover:text-rose-300 transition-colors',
                'desc'    => 'text-rose-500 dark:text-rose-400',
            ]),

            // ── Extended neutrals ─────────────────────────────────────────────────────
            'taupe' => array_fill_keys($v, [
                'wrapper' => 'border border-taupe-200 bg-taupe-100 text-taupe-700 dark:border-taupe-800 dark:bg-taupe-950 dark:text-taupe-300',
                'icon'    => 'text-taupe-500 dark:text-taupe-400',
                'close'   => 'text-taupe-400 hover:text-taupe-600 dark:text-taupe-500 dark:hover:text-taupe-300 transition-colors',
                'desc'    => 'text-taupe-500 dark:text-taupe-400',
            ]),
            'mauve' => array_fill_keys($v, [
                'wrapper' => 'border border-mauve-200 bg-mauve-100 text-mauve-700 dark:border-mauve-800 dark:bg-mauve-950 dark:text-mauve-300',
                'icon'    => 'text-mauve-500 dark:text-mauve-400',
                'close'   => 'text-mauve-400 hover:text-mauve-600 dark:text-mauve-500 dark:hover:text-mauve-300 transition-colors',
                'desc'    => 'text-mauve-500 dark:text-mauve-400',
            ]),
            'mist' => array_fill_keys($v, [
                'wrapper' => 'border border-mist-200 bg-mist-100 text-mist-700 dark:border-mist-800 dark:bg-mist-950 dark:text-mist-300',
                'icon'    => 'text-mist-500 dark:text-mist-400',
                'close'   => 'text-mist-400 hover:text-mist-600 dark:text-mist-500 dark:hover:text-mist-300 transition-colors',
                'desc'    => 'text-mist-500 dark:text-mist-400',
            ]),
            'olive' => array_fill_keys($v, [
                'wrapper' => 'border border-olive-200 bg-olive-100 text-olive-700 dark:border-olive-800 dark:bg-olive-950 dark:text-olive-300',
                'icon'    => 'text-olive-500 dark:text-olive-400',
                'close'   => 'text-olive-400 hover:text-olive-600 dark:text-olive-500 dark:hover:text-olive-300 transition-colors',
                'desc'    => 'text-olive-500 dark:text-olive-400',
            ]),
        ];
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.toast');
    }
}
