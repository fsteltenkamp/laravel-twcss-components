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
     */
    public static function themeMap(): array
    {
        // Solid-fill variants (toast & baguette) share non-wrapper classes.
        $bi = 'text-white/80 shrink-0';
        $bc = 'text-white/60 hover:text-white transition-colors';
        $bd = 'text-white/75';

        return [
            // ── Neutral scales ────────────────────────────────────────────────────────
            'slate' => [
                'pill' => [
                    'wrapper' => 'border border-slate-200 bg-slate-50 text-slate-700 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300',
                    'icon'    => 'text-slate-500 dark:text-slate-400',
                    'close'   => 'text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 transition-colors',
                    'desc'    => 'text-slate-500 dark:text-slate-400',
                ],
                'card' => [
                    'wrapper' => 'border border-slate-200 bg-white text-slate-900 shadow-lg dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100',
                    'icon'    => 'text-slate-500 dark:text-slate-400',
                    'close'   => 'text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 transition-colors',
                    'desc'    => 'text-slate-500 dark:text-slate-400',
                ],
                'toast'    => ['wrapper' => 'bg-slate-700 text-white shadow-lg dark:bg-slate-800', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-slate-700 text-white shadow-lg dark:bg-slate-800', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'gray' => [
                'pill' => [
                    'wrapper' => 'border border-gray-200 bg-gray-50 text-gray-700 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300',
                    'icon'    => 'text-gray-500 dark:text-gray-400',
                    'close'   => 'text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors',
                    'desc'    => 'text-gray-500 dark:text-gray-400',
                ],
                'card' => [
                    'wrapper' => 'border border-gray-200 bg-white text-gray-900 shadow-lg dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100',
                    'icon'    => 'text-gray-500 dark:text-gray-400',
                    'close'   => 'text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors',
                    'desc'    => 'text-gray-500 dark:text-gray-400',
                ],
                'toast'    => ['wrapper' => 'bg-gray-700 text-white shadow-lg dark:bg-gray-800', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-gray-700 text-white shadow-lg dark:bg-gray-800', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'zinc' => [
                'pill' => [
                    'wrapper' => 'border border-zinc-200 bg-zinc-50 text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300',
                    'icon'    => 'text-zinc-500 dark:text-zinc-400',
                    'close'   => 'text-zinc-400 hover:text-zinc-600 dark:text-zinc-500 dark:hover:text-zinc-300 transition-colors',
                    'desc'    => 'text-zinc-500 dark:text-zinc-400',
                ],
                'card' => [
                    'wrapper' => 'border border-zinc-200 bg-white text-zinc-900 shadow-lg dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100',
                    'icon'    => 'text-zinc-500 dark:text-zinc-400',
                    'close'   => 'text-zinc-400 hover:text-zinc-600 dark:text-zinc-500 dark:hover:text-zinc-300 transition-colors',
                    'desc'    => 'text-zinc-500 dark:text-zinc-400',
                ],
                'toast'    => ['wrapper' => 'bg-zinc-700 text-white shadow-lg dark:bg-zinc-800', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-zinc-700 text-white shadow-lg dark:bg-zinc-800', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'neutral' => [
                'pill' => [
                    'wrapper' => 'border border-neutral-200 bg-neutral-50 text-neutral-700 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300',
                    'icon'    => 'text-neutral-500 dark:text-neutral-400',
                    'close'   => 'text-neutral-400 hover:text-neutral-600 dark:text-neutral-500 dark:hover:text-neutral-300 transition-colors',
                    'desc'    => 'text-neutral-500 dark:text-neutral-400',
                ],
                'card' => [
                    'wrapper' => 'border border-neutral-200 bg-white text-neutral-900 shadow-lg dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100',
                    'icon'    => 'text-neutral-500 dark:text-neutral-400',
                    'close'   => 'text-neutral-400 hover:text-neutral-600 dark:text-neutral-500 dark:hover:text-neutral-300 transition-colors',
                    'desc'    => 'text-neutral-500 dark:text-neutral-400',
                ],
                'toast'    => ['wrapper' => 'bg-neutral-700 text-white shadow-lg dark:bg-neutral-800', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-neutral-700 text-white shadow-lg dark:bg-neutral-800', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'stone' => [
                'pill' => [
                    'wrapper' => 'border border-stone-200 bg-stone-50 text-stone-700 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-300',
                    'icon'    => 'text-stone-500 dark:text-stone-400',
                    'close'   => 'text-stone-400 hover:text-stone-600 dark:text-stone-500 dark:hover:text-stone-300 transition-colors',
                    'desc'    => 'text-stone-500 dark:text-stone-400',
                ],
                'card' => [
                    'wrapper' => 'border border-stone-200 bg-white text-stone-900 shadow-lg dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100',
                    'icon'    => 'text-stone-500 dark:text-stone-400',
                    'close'   => 'text-stone-400 hover:text-stone-600 dark:text-stone-500 dark:hover:text-stone-300 transition-colors',
                    'desc'    => 'text-stone-500 dark:text-stone-400',
                ],
                'toast'    => ['wrapper' => 'bg-stone-700 text-white shadow-lg dark:bg-stone-800', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-stone-700 text-white shadow-lg dark:bg-stone-800', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],

            // ── Accent scales ─────────────────────────────────────────────────────────
            'red' => [
                'pill' => [
                    'wrapper' => 'border border-red-200 bg-red-50 text-red-700 dark:border-red-800 dark:bg-red-950 dark:text-red-300',
                    'icon'    => 'text-red-500 dark:text-red-400',
                    'close'   => 'text-red-400 hover:text-red-600 dark:text-red-500 dark:hover:text-red-300 transition-colors',
                    'desc'    => 'text-red-500 dark:text-red-400',
                ],
                'card' => [
                    'wrapper' => 'border border-red-200 bg-white text-red-900 shadow-lg dark:border-red-800 dark:bg-zinc-900 dark:text-red-100',
                    'icon'    => 'text-red-500 dark:text-red-400',
                    'close'   => 'text-red-400 hover:text-red-600 dark:text-red-500 dark:hover:text-red-300 transition-colors',
                    'desc'    => 'text-red-500 dark:text-red-400',
                ],
                'toast'    => ['wrapper' => 'bg-red-600 text-white shadow-lg dark:bg-red-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-red-600 text-white shadow-lg dark:bg-red-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'orange' => [
                'pill' => [
                    'wrapper' => 'border border-orange-200 bg-orange-50 text-orange-700 dark:border-orange-800 dark:bg-orange-950 dark:text-orange-300',
                    'icon'    => 'text-orange-500 dark:text-orange-400',
                    'close'   => 'text-orange-400 hover:text-orange-600 dark:text-orange-500 dark:hover:text-orange-300 transition-colors',
                    'desc'    => 'text-orange-500 dark:text-orange-400',
                ],
                'card' => [
                    'wrapper' => 'border border-orange-200 bg-white text-orange-900 shadow-lg dark:border-orange-800 dark:bg-zinc-900 dark:text-orange-100',
                    'icon'    => 'text-orange-500 dark:text-orange-400',
                    'close'   => 'text-orange-400 hover:text-orange-600 dark:text-orange-500 dark:hover:text-orange-300 transition-colors',
                    'desc'    => 'text-orange-500 dark:text-orange-400',
                ],
                'toast'    => ['wrapper' => 'bg-orange-600 text-white shadow-lg dark:bg-orange-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-orange-600 text-white shadow-lg dark:bg-orange-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'amber' => [
                'pill' => [
                    'wrapper' => 'border border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-800 dark:bg-amber-950 dark:text-amber-300',
                    'icon'    => 'text-amber-500 dark:text-amber-400',
                    'close'   => 'text-amber-400 hover:text-amber-600 dark:text-amber-500 dark:hover:text-amber-300 transition-colors',
                    'desc'    => 'text-amber-500 dark:text-amber-400',
                ],
                'card' => [
                    'wrapper' => 'border border-amber-200 bg-white text-amber-900 shadow-lg dark:border-amber-800 dark:bg-zinc-900 dark:text-amber-100',
                    'icon'    => 'text-amber-500 dark:text-amber-400',
                    'close'   => 'text-amber-400 hover:text-amber-600 dark:text-amber-500 dark:hover:text-amber-300 transition-colors',
                    'desc'    => 'text-amber-500 dark:text-amber-400',
                ],
                'toast'    => ['wrapper' => 'bg-amber-600 text-white shadow-lg dark:bg-amber-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-amber-600 text-white shadow-lg dark:bg-amber-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'yellow' => [
                'pill' => [
                    'wrapper' => 'border border-yellow-200 bg-yellow-50 text-yellow-700 dark:border-yellow-800 dark:bg-yellow-950 dark:text-yellow-300',
                    'icon'    => 'text-yellow-500 dark:text-yellow-400',
                    'close'   => 'text-yellow-400 hover:text-yellow-600 dark:text-yellow-500 dark:hover:text-yellow-300 transition-colors',
                    'desc'    => 'text-yellow-500 dark:text-yellow-400',
                ],
                'card' => [
                    'wrapper' => 'border border-yellow-200 bg-white text-yellow-900 shadow-lg dark:border-yellow-800 dark:bg-zinc-900 dark:text-yellow-100',
                    'icon'    => 'text-yellow-500 dark:text-yellow-400',
                    'close'   => 'text-yellow-400 hover:text-yellow-600 dark:text-yellow-500 dark:hover:text-yellow-300 transition-colors',
                    'desc'    => 'text-yellow-500 dark:text-yellow-400',
                ],
                'toast'    => ['wrapper' => 'bg-yellow-500 text-white shadow-lg dark:bg-yellow-600', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-yellow-500 text-white shadow-lg dark:bg-yellow-600', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'lime' => [
                'pill' => [
                    'wrapper' => 'border border-lime-200 bg-lime-50 text-lime-700 dark:border-lime-800 dark:bg-lime-950 dark:text-lime-300',
                    'icon'    => 'text-lime-500 dark:text-lime-400',
                    'close'   => 'text-lime-400 hover:text-lime-600 dark:text-lime-500 dark:hover:text-lime-300 transition-colors',
                    'desc'    => 'text-lime-500 dark:text-lime-400',
                ],
                'card' => [
                    'wrapper' => 'border border-lime-200 bg-white text-lime-900 shadow-lg dark:border-lime-800 dark:bg-zinc-900 dark:text-lime-100',
                    'icon'    => 'text-lime-500 dark:text-lime-400',
                    'close'   => 'text-lime-400 hover:text-lime-600 dark:text-lime-500 dark:hover:text-lime-300 transition-colors',
                    'desc'    => 'text-lime-500 dark:text-lime-400',
                ],
                'toast'    => ['wrapper' => 'bg-lime-600 text-white shadow-lg dark:bg-lime-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-lime-600 text-white shadow-lg dark:bg-lime-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'green' => [
                'pill' => [
                    'wrapper' => 'border border-green-200 bg-green-50 text-green-700 dark:border-green-800 dark:bg-green-950 dark:text-green-300',
                    'icon'    => 'text-green-500 dark:text-green-400',
                    'close'   => 'text-green-400 hover:text-green-600 dark:text-green-500 dark:hover:text-green-300 transition-colors',
                    'desc'    => 'text-green-500 dark:text-green-400',
                ],
                'card' => [
                    'wrapper' => 'border border-green-200 bg-white text-green-900 shadow-lg dark:border-green-800 dark:bg-zinc-900 dark:text-green-100',
                    'icon'    => 'text-green-500 dark:text-green-400',
                    'close'   => 'text-green-400 hover:text-green-600 dark:text-green-500 dark:hover:text-green-300 transition-colors',
                    'desc'    => 'text-green-500 dark:text-green-400',
                ],
                'toast'    => ['wrapper' => 'bg-green-600 text-white shadow-lg dark:bg-green-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-green-600 text-white shadow-lg dark:bg-green-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'emerald' => [
                'pill' => [
                    'wrapper' => 'border border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-300',
                    'icon'    => 'text-emerald-500 dark:text-emerald-400',
                    'close'   => 'text-emerald-400 hover:text-emerald-600 dark:text-emerald-500 dark:hover:text-emerald-300 transition-colors',
                    'desc'    => 'text-emerald-500 dark:text-emerald-400',
                ],
                'card' => [
                    'wrapper' => 'border border-emerald-200 bg-white text-emerald-900 shadow-lg dark:border-emerald-800 dark:bg-zinc-900 dark:text-emerald-100',
                    'icon'    => 'text-emerald-500 dark:text-emerald-400',
                    'close'   => 'text-emerald-400 hover:text-emerald-600 dark:text-emerald-500 dark:hover:text-emerald-300 transition-colors',
                    'desc'    => 'text-emerald-500 dark:text-emerald-400',
                ],
                'toast'    => ['wrapper' => 'bg-emerald-600 text-white shadow-lg dark:bg-emerald-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-emerald-600 text-white shadow-lg dark:bg-emerald-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'teal' => [
                'pill' => [
                    'wrapper' => 'border border-teal-200 bg-teal-50 text-teal-700 dark:border-teal-800 dark:bg-teal-950 dark:text-teal-300',
                    'icon'    => 'text-teal-500 dark:text-teal-400',
                    'close'   => 'text-teal-400 hover:text-teal-600 dark:text-teal-500 dark:hover:text-teal-300 transition-colors',
                    'desc'    => 'text-teal-500 dark:text-teal-400',
                ],
                'card' => [
                    'wrapper' => 'border border-teal-200 bg-white text-teal-900 shadow-lg dark:border-teal-800 dark:bg-zinc-900 dark:text-teal-100',
                    'icon'    => 'text-teal-500 dark:text-teal-400',
                    'close'   => 'text-teal-400 hover:text-teal-600 dark:text-teal-500 dark:hover:text-teal-300 transition-colors',
                    'desc'    => 'text-teal-500 dark:text-teal-400',
                ],
                'toast'    => ['wrapper' => 'bg-teal-600 text-white shadow-lg dark:bg-teal-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-teal-600 text-white shadow-lg dark:bg-teal-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'cyan' => [
                'pill' => [
                    'wrapper' => 'border border-cyan-200 bg-cyan-50 text-cyan-700 dark:border-cyan-800 dark:bg-cyan-950 dark:text-cyan-300',
                    'icon'    => 'text-cyan-500 dark:text-cyan-400',
                    'close'   => 'text-cyan-400 hover:text-cyan-600 dark:text-cyan-500 dark:hover:text-cyan-300 transition-colors',
                    'desc'    => 'text-cyan-500 dark:text-cyan-400',
                ],
                'card' => [
                    'wrapper' => 'border border-cyan-200 bg-white text-cyan-900 shadow-lg dark:border-cyan-800 dark:bg-zinc-900 dark:text-cyan-100',
                    'icon'    => 'text-cyan-500 dark:text-cyan-400',
                    'close'   => 'text-cyan-400 hover:text-cyan-600 dark:text-cyan-500 dark:hover:text-cyan-300 transition-colors',
                    'desc'    => 'text-cyan-500 dark:text-cyan-400',
                ],
                'toast'    => ['wrapper' => 'bg-cyan-600 text-white shadow-lg dark:bg-cyan-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-cyan-600 text-white shadow-lg dark:bg-cyan-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'sky' => [
                'pill' => [
                    'wrapper' => 'border border-sky-200 bg-sky-50 text-sky-700 dark:border-sky-800 dark:bg-sky-950 dark:text-sky-300',
                    'icon'    => 'text-sky-500 dark:text-sky-400',
                    'close'   => 'text-sky-400 hover:text-sky-600 dark:text-sky-500 dark:hover:text-sky-300 transition-colors',
                    'desc'    => 'text-sky-500 dark:text-sky-400',
                ],
                'card' => [
                    'wrapper' => 'border border-sky-200 bg-white text-sky-900 shadow-lg dark:border-sky-800 dark:bg-zinc-900 dark:text-sky-100',
                    'icon'    => 'text-sky-500 dark:text-sky-400',
                    'close'   => 'text-sky-400 hover:text-sky-600 dark:text-sky-500 dark:hover:text-sky-300 transition-colors',
                    'desc'    => 'text-sky-500 dark:text-sky-400',
                ],
                'toast'    => ['wrapper' => 'bg-sky-600 text-white shadow-lg dark:bg-sky-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-sky-600 text-white shadow-lg dark:bg-sky-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'blue' => [
                'pill' => [
                    'wrapper' => 'border border-blue-200 bg-blue-50 text-blue-700 dark:border-blue-800 dark:bg-blue-950 dark:text-blue-300',
                    'icon'    => 'text-blue-500 dark:text-blue-400',
                    'close'   => 'text-blue-400 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-300 transition-colors',
                    'desc'    => 'text-blue-500 dark:text-blue-400',
                ],
                'card' => [
                    'wrapper' => 'border border-blue-200 bg-white text-blue-900 shadow-lg dark:border-blue-800 dark:bg-zinc-900 dark:text-blue-100',
                    'icon'    => 'text-blue-500 dark:text-blue-400',
                    'close'   => 'text-blue-400 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-300 transition-colors',
                    'desc'    => 'text-blue-500 dark:text-blue-400',
                ],
                'toast'    => ['wrapper' => 'bg-blue-600 text-white shadow-lg dark:bg-blue-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-blue-600 text-white shadow-lg dark:bg-blue-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'indigo' => [
                'pill' => [
                    'wrapper' => 'border border-indigo-200 bg-indigo-50 text-indigo-700 dark:border-indigo-800 dark:bg-indigo-950 dark:text-indigo-300',
                    'icon'    => 'text-indigo-500 dark:text-indigo-400',
                    'close'   => 'text-indigo-400 hover:text-indigo-600 dark:text-indigo-500 dark:hover:text-indigo-300 transition-colors',
                    'desc'    => 'text-indigo-500 dark:text-indigo-400',
                ],
                'card' => [
                    'wrapper' => 'border border-indigo-200 bg-white text-indigo-900 shadow-lg dark:border-indigo-800 dark:bg-zinc-900 dark:text-indigo-100',
                    'icon'    => 'text-indigo-500 dark:text-indigo-400',
                    'close'   => 'text-indigo-400 hover:text-indigo-600 dark:text-indigo-500 dark:hover:text-indigo-300 transition-colors',
                    'desc'    => 'text-indigo-500 dark:text-indigo-400',
                ],
                'toast'    => ['wrapper' => 'bg-indigo-600 text-white shadow-lg dark:bg-indigo-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-indigo-600 text-white shadow-lg dark:bg-indigo-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'violet' => [
                'pill' => [
                    'wrapper' => 'border border-violet-200 bg-violet-50 text-violet-700 dark:border-violet-800 dark:bg-violet-950 dark:text-violet-300',
                    'icon'    => 'text-violet-500 dark:text-violet-400',
                    'close'   => 'text-violet-400 hover:text-violet-600 dark:text-violet-500 dark:hover:text-violet-300 transition-colors',
                    'desc'    => 'text-violet-500 dark:text-violet-400',
                ],
                'card' => [
                    'wrapper' => 'border border-violet-200 bg-white text-violet-900 shadow-lg dark:border-violet-800 dark:bg-zinc-900 dark:text-violet-100',
                    'icon'    => 'text-violet-500 dark:text-violet-400',
                    'close'   => 'text-violet-400 hover:text-violet-600 dark:text-violet-500 dark:hover:text-violet-300 transition-colors',
                    'desc'    => 'text-violet-500 dark:text-violet-400',
                ],
                'toast'    => ['wrapper' => 'bg-violet-600 text-white shadow-lg dark:bg-violet-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-violet-600 text-white shadow-lg dark:bg-violet-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'purple' => [
                'pill' => [
                    'wrapper' => 'border border-purple-200 bg-purple-50 text-purple-700 dark:border-purple-800 dark:bg-purple-950 dark:text-purple-300',
                    'icon'    => 'text-purple-500 dark:text-purple-400',
                    'close'   => 'text-purple-400 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-300 transition-colors',
                    'desc'    => 'text-purple-500 dark:text-purple-400',
                ],
                'card' => [
                    'wrapper' => 'border border-purple-200 bg-white text-purple-900 shadow-lg dark:border-purple-800 dark:bg-zinc-900 dark:text-purple-100',
                    'icon'    => 'text-purple-500 dark:text-purple-400',
                    'close'   => 'text-purple-400 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-300 transition-colors',
                    'desc'    => 'text-purple-500 dark:text-purple-400',
                ],
                'toast'    => ['wrapper' => 'bg-purple-600 text-white shadow-lg dark:bg-purple-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-purple-600 text-white shadow-lg dark:bg-purple-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'fuchsia' => [
                'pill' => [
                    'wrapper' => 'border border-fuchsia-200 bg-fuchsia-50 text-fuchsia-700 dark:border-fuchsia-800 dark:bg-fuchsia-950 dark:text-fuchsia-300',
                    'icon'    => 'text-fuchsia-500 dark:text-fuchsia-400',
                    'close'   => 'text-fuchsia-400 hover:text-fuchsia-600 dark:text-fuchsia-500 dark:hover:text-fuchsia-300 transition-colors',
                    'desc'    => 'text-fuchsia-500 dark:text-fuchsia-400',
                ],
                'card' => [
                    'wrapper' => 'border border-fuchsia-200 bg-white text-fuchsia-900 shadow-lg dark:border-fuchsia-800 dark:bg-zinc-900 dark:text-fuchsia-100',
                    'icon'    => 'text-fuchsia-500 dark:text-fuchsia-400',
                    'close'   => 'text-fuchsia-400 hover:text-fuchsia-600 dark:text-fuchsia-500 dark:hover:text-fuchsia-300 transition-colors',
                    'desc'    => 'text-fuchsia-500 dark:text-fuchsia-400',
                ],
                'toast'    => ['wrapper' => 'bg-fuchsia-600 text-white shadow-lg dark:bg-fuchsia-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-fuchsia-600 text-white shadow-lg dark:bg-fuchsia-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'pink' => [
                'pill' => [
                    'wrapper' => 'border border-pink-200 bg-pink-50 text-pink-700 dark:border-pink-800 dark:bg-pink-950 dark:text-pink-300',
                    'icon'    => 'text-pink-500 dark:text-pink-400',
                    'close'   => 'text-pink-400 hover:text-pink-600 dark:text-pink-500 dark:hover:text-pink-300 transition-colors',
                    'desc'    => 'text-pink-500 dark:text-pink-400',
                ],
                'card' => [
                    'wrapper' => 'border border-pink-200 bg-white text-pink-900 shadow-lg dark:border-pink-800 dark:bg-zinc-900 dark:text-pink-100',
                    'icon'    => 'text-pink-500 dark:text-pink-400',
                    'close'   => 'text-pink-400 hover:text-pink-600 dark:text-pink-500 dark:hover:text-pink-300 transition-colors',
                    'desc'    => 'text-pink-500 dark:text-pink-400',
                ],
                'toast'    => ['wrapper' => 'bg-pink-600 text-white shadow-lg dark:bg-pink-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-pink-600 text-white shadow-lg dark:bg-pink-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'rose' => [
                'pill' => [
                    'wrapper' => 'border border-rose-200 bg-rose-50 text-rose-700 dark:border-rose-800 dark:bg-rose-950 dark:text-rose-300',
                    'icon'    => 'text-rose-500 dark:text-rose-400',
                    'close'   => 'text-rose-400 hover:text-rose-600 dark:text-rose-500 dark:hover:text-rose-300 transition-colors',
                    'desc'    => 'text-rose-500 dark:text-rose-400',
                ],
                'card' => [
                    'wrapper' => 'border border-rose-200 bg-white text-rose-900 shadow-lg dark:border-rose-800 dark:bg-zinc-900 dark:text-rose-100',
                    'icon'    => 'text-rose-500 dark:text-rose-400',
                    'close'   => 'text-rose-400 hover:text-rose-600 dark:text-rose-500 dark:hover:text-rose-300 transition-colors',
                    'desc'    => 'text-rose-500 dark:text-rose-400',
                ],
                'toast'    => ['wrapper' => 'bg-rose-600 text-white shadow-lg dark:bg-rose-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-rose-600 text-white shadow-lg dark:bg-rose-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],

            // ── Extended neutrals ─────────────────────────────────────────────────────
            'taupe' => [
                'pill' => [
                    'wrapper' => 'border border-taupe-200 bg-taupe-50 text-taupe-700 dark:border-taupe-800 dark:bg-taupe-950 dark:text-taupe-300',
                    'icon'    => 'text-taupe-500 dark:text-taupe-400',
                    'close'   => 'text-taupe-400 hover:text-taupe-600 dark:text-taupe-500 dark:hover:text-taupe-300 transition-colors',
                    'desc'    => 'text-taupe-500 dark:text-taupe-400',
                ],
                'card' => [
                    'wrapper' => 'border border-taupe-200 bg-white text-taupe-900 shadow-lg dark:border-taupe-800 dark:bg-zinc-900 dark:text-taupe-100',
                    'icon'    => 'text-taupe-500 dark:text-taupe-400',
                    'close'   => 'text-taupe-400 hover:text-taupe-600 dark:text-taupe-500 dark:hover:text-taupe-300 transition-colors',
                    'desc'    => 'text-taupe-500 dark:text-taupe-400',
                ],
                'toast'    => ['wrapper' => 'bg-taupe-600 text-white shadow-lg dark:bg-taupe-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-taupe-600 text-white shadow-lg dark:bg-taupe-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'mauve' => [
                'pill' => [
                    'wrapper' => 'border border-mauve-200 bg-mauve-50 text-mauve-700 dark:border-mauve-800 dark:bg-mauve-950 dark:text-mauve-300',
                    'icon'    => 'text-mauve-500 dark:text-mauve-400',
                    'close'   => 'text-mauve-400 hover:text-mauve-600 dark:text-mauve-500 dark:hover:text-mauve-300 transition-colors',
                    'desc'    => 'text-mauve-500 dark:text-mauve-400',
                ],
                'card' => [
                    'wrapper' => 'border border-mauve-200 bg-white text-mauve-900 shadow-lg dark:border-mauve-800 dark:bg-zinc-900 dark:text-mauve-100',
                    'icon'    => 'text-mauve-500 dark:text-mauve-400',
                    'close'   => 'text-mauve-400 hover:text-mauve-600 dark:text-mauve-500 dark:hover:text-mauve-300 transition-colors',
                    'desc'    => 'text-mauve-500 dark:text-mauve-400',
                ],
                'toast'    => ['wrapper' => 'bg-mauve-600 text-white shadow-lg dark:bg-mauve-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-mauve-600 text-white shadow-lg dark:bg-mauve-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'mist' => [
                'pill' => [
                    'wrapper' => 'border border-mist-200 bg-mist-50 text-mist-700 dark:border-mist-800 dark:bg-mist-950 dark:text-mist-300',
                    'icon'    => 'text-mist-500 dark:text-mist-400',
                    'close'   => 'text-mist-400 hover:text-mist-600 dark:text-mist-500 dark:hover:text-mist-300 transition-colors',
                    'desc'    => 'text-mist-500 dark:text-mist-400',
                ],
                'card' => [
                    'wrapper' => 'border border-mist-200 bg-white text-mist-900 shadow-lg dark:border-mist-800 dark:bg-zinc-900 dark:text-mist-100',
                    'icon'    => 'text-mist-500 dark:text-mist-400',
                    'close'   => 'text-mist-400 hover:text-mist-600 dark:text-mist-500 dark:hover:text-mist-300 transition-colors',
                    'desc'    => 'text-mist-500 dark:text-mist-400',
                ],
                'toast'    => ['wrapper' => 'bg-mist-600 text-white shadow-lg dark:bg-mist-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-mist-600 text-white shadow-lg dark:bg-mist-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
            'olive' => [
                'pill' => [
                    'wrapper' => 'border border-olive-200 bg-olive-50 text-olive-700 dark:border-olive-800 dark:bg-olive-950 dark:text-olive-300',
                    'icon'    => 'text-olive-500 dark:text-olive-400',
                    'close'   => 'text-olive-400 hover:text-olive-600 dark:text-olive-500 dark:hover:text-olive-300 transition-colors',
                    'desc'    => 'text-olive-500 dark:text-olive-400',
                ],
                'card' => [
                    'wrapper' => 'border border-olive-200 bg-white text-olive-900 shadow-lg dark:border-olive-800 dark:bg-zinc-900 dark:text-olive-100',
                    'icon'    => 'text-olive-500 dark:text-olive-400',
                    'close'   => 'text-olive-400 hover:text-olive-600 dark:text-olive-500 dark:hover:text-olive-300 transition-colors',
                    'desc'    => 'text-olive-500 dark:text-olive-400',
                ],
                'toast'    => ['wrapper' => 'bg-olive-600 text-white shadow-lg dark:bg-olive-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
                'baguette' => ['wrapper' => 'bg-olive-600 text-white shadow-lg dark:bg-olive-500', 'icon' => $bi, 'close' => $bc, 'desc' => $bd],
            ],
        ];
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.toast');
    }
}
