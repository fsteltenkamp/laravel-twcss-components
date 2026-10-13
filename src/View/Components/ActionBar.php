<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * A banner with title, text and actions, e.g. a draft bar: "Unpublished draft —
 * Publish / Discard". `sticky` keeps it at the top of the scroll area (`offset` below
 * a sticky header); `quiet` is a lighter, dashed variant.
 */
class ActionBar extends Component
{
    public string $classList;
    public string $style = '';

    public function __construct(
        public string $title = '',
        public string $icon = '',
        public bool $sticky = false,
        public string $offset = '0px',
        public bool $quiet = false,
        public string $theme = 'slate',
    ) {
            $loudMap = [
                'slate'     => 'border-slate-300 bg-slate-100 text-slate-900 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100',
                'gray'      => 'border-gray-300 bg-gray-100 text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100',
                'zinc'      => 'border-zinc-300 bg-zinc-100 text-zinc-900 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100',
                'neutral'   => 'border-neutral-300 bg-neutral-100 text-neutral-900 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100',
                'stone'     => 'border-stone-300 bg-stone-100 text-stone-900 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100',
                'red'       => 'border-red-300 bg-red-100 text-red-900 dark:border-red-700 dark:bg-red-900 dark:text-red-100',
                'orange'    => 'border-orange-300 bg-orange-100 text-orange-900 dark:border-orange-700 dark:bg-orange-900 dark:text-orange-100',
                'amber'     => 'border-amber-300 bg-amber-100 text-amber-900 dark:border-amber-700 dark:bg-amber-900 dark:text-amber-100',
                'yellow'    => 'border-yellow-300 bg-yellow-100 text-yellow-900 dark:border-yellow-700 dark:bg-yellow-900 dark:text-yellow-100',
                'lime'      => 'border-lime-300 bg-lime-100 text-lime-900 dark:border-lime-700 dark:bg-lime-900 dark:text-lime-100',
                'green'     => 'border-green-300 bg-green-100 text-green-900 dark:border-green-700 dark:bg-green-900 dark:text-green-100',
                'emerald'   => 'border-emerald-300 bg-emerald-100 text-emerald-900 dark:border-emerald-700 dark:bg-emerald-900 dark:text-emerald-100',
                'teal'      => 'border-teal-300 bg-teal-100 text-teal-900 dark:border-teal-700 dark:bg-teal-900 dark:text-teal-100',
                'cyan'      => 'border-cyan-300 bg-cyan-100 text-cyan-900 dark:border-cyan-700 dark:bg-cyan-900 dark:text-cyan-100',
                'sky'       => 'border-sky-300 bg-sky-100 text-sky-900 dark:border-sky-700 dark:bg-sky-900 dark:text-sky-100',
                'blue'      => 'border-blue-300 bg-blue-100 text-blue-900 dark:border-blue-700 dark:bg-blue-900 dark:text-blue-100',
                'indigo'    => 'border-indigo-300 bg-indigo-100 text-indigo-900 dark:border-indigo-700 dark:bg-indigo-900 dark:text-indigo-100',
                'violet'    => 'border-violet-300 bg-violet-100 text-violet-900 dark:border-violet-700 dark:bg-violet-900 dark:text-violet-100',
                'purple'    => 'border-purple-300 bg-purple-100 text-purple-900 dark:border-purple-700 dark:bg-purple-900 dark:text-purple-100',
                'fuchsia'   => 'border-fuchsia-300 bg-fuchsia-100 text-fuchsia-900 dark:border-fuchsia-700 dark:bg-fuchsia-900 dark:text-fuchsia-100',
                'pink'      => 'border-pink-300 bg-pink-100 text-pink-900 dark:border-pink-700 dark:bg-pink-900 dark:text-pink-100',
                'rose'      => 'border-rose-300 bg-rose-100 text-rose-900 dark:border-rose-700 dark:bg-rose-900 dark:text-rose-100',
                'taupe'     => 'border-taupe-300 bg-taupe-100 text-taupe-900 dark:border-taupe-700 dark:bg-taupe-900 dark:text-taupe-100',
                'mauve'     => 'border-mauve-300 bg-mauve-100 text-mauve-900 dark:border-mauve-700 dark:bg-mauve-900 dark:text-mauve-100',
                'mist'      => 'border-mist-300 bg-mist-100 text-mist-900 dark:border-mist-700 dark:bg-mist-900 dark:text-mist-100',
                'olive'     => 'border-olive-300 bg-olive-100 text-olive-900 dark:border-olive-700 dark:bg-olive-900 dark:text-olive-100',
                'palette'      => 'border-palette-300 bg-palette-100 text-palette-900 dark:border-palette-700 dark:bg-palette-900 dark:text-palette-100',
                'cyberpunk' => 'border-cyberpunk-300 bg-cyberpunk-100 text-cyberpunk-900 dark:border-cyberpunk-700 dark:bg-cyberpunk-900 dark:text-cyberpunk-100',
                'fantasy'   => 'border-fantasy-300 bg-fantasy-100 text-fantasy-900 dark:border-fantasy-700 dark:bg-fantasy-900 dark:text-fantasy-100',
                'wh40k'     => 'border-wh40k-300 bg-wh40k-100 text-wh40k-900 dark:border-wh40k-700 dark:bg-wh40k-900 dark:text-wh40k-100',
            ];

            $quietMap = [
                'slate'     => 'border-dashed border-slate-300 bg-white/70 text-slate-700 dark:border-slate-600 dark:bg-slate-950/70 dark:text-slate-300',
                'gray'      => 'border-dashed border-gray-300 bg-white/70 text-gray-700 dark:border-gray-600 dark:bg-gray-950/70 dark:text-gray-300',
                'zinc'      => 'border-dashed border-zinc-300 bg-white/70 text-zinc-700 dark:border-zinc-600 dark:bg-zinc-950/70 dark:text-zinc-300',
                'neutral'   => 'border-dashed border-neutral-300 bg-white/70 text-neutral-700 dark:border-neutral-600 dark:bg-neutral-950/70 dark:text-neutral-300',
                'stone'     => 'border-dashed border-stone-300 bg-white/70 text-stone-700 dark:border-stone-600 dark:bg-stone-950/70 dark:text-stone-300',
                'red'       => 'border-dashed border-red-300 bg-white/70 text-red-700 dark:border-red-600 dark:bg-red-950/70 dark:text-red-300',
                'orange'    => 'border-dashed border-orange-300 bg-white/70 text-orange-700 dark:border-orange-600 dark:bg-orange-950/70 dark:text-orange-300',
                'amber'     => 'border-dashed border-amber-300 bg-white/70 text-amber-700 dark:border-amber-600 dark:bg-amber-950/70 dark:text-amber-300',
                'yellow'    => 'border-dashed border-yellow-300 bg-white/70 text-yellow-700 dark:border-yellow-600 dark:bg-yellow-950/70 dark:text-yellow-300',
                'lime'      => 'border-dashed border-lime-300 bg-white/70 text-lime-700 dark:border-lime-600 dark:bg-lime-950/70 dark:text-lime-300',
                'green'     => 'border-dashed border-green-300 bg-white/70 text-green-700 dark:border-green-600 dark:bg-green-950/70 dark:text-green-300',
                'emerald'   => 'border-dashed border-emerald-300 bg-white/70 text-emerald-700 dark:border-emerald-600 dark:bg-emerald-950/70 dark:text-emerald-300',
                'teal'      => 'border-dashed border-teal-300 bg-white/70 text-teal-700 dark:border-teal-600 dark:bg-teal-950/70 dark:text-teal-300',
                'cyan'      => 'border-dashed border-cyan-300 bg-white/70 text-cyan-700 dark:border-cyan-600 dark:bg-cyan-950/70 dark:text-cyan-300',
                'sky'       => 'border-dashed border-sky-300 bg-white/70 text-sky-700 dark:border-sky-600 dark:bg-sky-950/70 dark:text-sky-300',
                'blue'      => 'border-dashed border-blue-300 bg-white/70 text-blue-700 dark:border-blue-600 dark:bg-blue-950/70 dark:text-blue-300',
                'indigo'    => 'border-dashed border-indigo-300 bg-white/70 text-indigo-700 dark:border-indigo-600 dark:bg-indigo-950/70 dark:text-indigo-300',
                'violet'    => 'border-dashed border-violet-300 bg-white/70 text-violet-700 dark:border-violet-600 dark:bg-violet-950/70 dark:text-violet-300',
                'purple'    => 'border-dashed border-purple-300 bg-white/70 text-purple-700 dark:border-purple-600 dark:bg-purple-950/70 dark:text-purple-300',
                'fuchsia'   => 'border-dashed border-fuchsia-300 bg-white/70 text-fuchsia-700 dark:border-fuchsia-600 dark:bg-fuchsia-950/70 dark:text-fuchsia-300',
                'pink'      => 'border-dashed border-pink-300 bg-white/70 text-pink-700 dark:border-pink-600 dark:bg-pink-950/70 dark:text-pink-300',
                'rose'      => 'border-dashed border-rose-300 bg-white/70 text-rose-700 dark:border-rose-600 dark:bg-rose-950/70 dark:text-rose-300',
                'taupe'     => 'border-dashed border-taupe-300 bg-white/70 text-taupe-700 dark:border-taupe-600 dark:bg-taupe-950/70 dark:text-taupe-300',
                'mauve'     => 'border-dashed border-mauve-300 bg-white/70 text-mauve-700 dark:border-mauve-600 dark:bg-mauve-950/70 dark:text-mauve-300',
                'mist'      => 'border-dashed border-mist-300 bg-white/70 text-mist-700 dark:border-mist-600 dark:bg-mist-950/70 dark:text-mist-300',
                'olive'     => 'border-dashed border-olive-300 bg-white/70 text-olive-700 dark:border-olive-600 dark:bg-olive-950/70 dark:text-olive-300',
                'palette'      => 'border-dashed border-palette-300 bg-white/70 text-palette-700 dark:border-palette-600 dark:bg-palette-950/70 dark:text-palette-300',
                'cyberpunk' => 'border-dashed border-cyberpunk-300 bg-white/70 text-cyberpunk-700 dark:border-cyberpunk-600 dark:bg-cyberpunk-950/70 dark:text-cyberpunk-300',
                'fantasy'   => 'border-dashed border-fantasy-300 bg-white/70 text-fantasy-700 dark:border-fantasy-600 dark:bg-fantasy-950/70 dark:text-fantasy-300',
                'wh40k'     => 'border-dashed border-wh40k-300 bg-white/70 text-wh40k-700 dark:border-wh40k-600 dark:bg-wh40k-950/70 dark:text-wh40k-300',
            ];

        $this->classList = trim(implode(' ', [
            'flex flex-wrap items-center gap-x-4 gap-y-2 rounded-lg border px-4 py-3 text-sm',
            $sticky ? 'sticky z-30 shadow-sm backdrop-blur' : '',
            $quiet ? ($quietMap[$theme] ?? $quietMap['slate']) : ($loudMap[$theme] ?? $loudMap['slate']),
        ]));

        if ($sticky) {
            $this->style = 'top: '.$offset.';';
        }
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.action-bar');
    }
}
