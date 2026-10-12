<?php

namespace Fsteltenkamp\TwcssComponents\Support;

/**
 * Tailwind class strings for the Drawer activation tab (the vertical handle
 * that sits in the screen-edge rail).
 *
 * The drawer panel itself reuses the SidebarTheme surface/divider/inactive
 * maps; only the tab needs its own colours. Every value is a **literal**
 * class string per theme so Tailwind's JIT scanner emits all of them. Unknown
 * themes fall back to `slate`, matching the rest of the package.
 */
class DrawerTheme
{
    /**
     * Resting tab: surface background, theme-coloured label and border.
     */
    public static function tab(?string $theme): string
    {
        $map = [
            'slate'   => 'bg-white text-slate-700 border-slate-300 hover:bg-slate-50 dark:bg-slate-900 dark:text-slate-300 dark:border-slate-700 dark:hover:bg-slate-800 focus-visible:ring-slate-400 dark:focus-visible:ring-slate-600',
            'gray'    => 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-800 focus-visible:ring-gray-400 dark:focus-visible:ring-gray-600',
            'zinc'    => 'bg-white text-zinc-700 border-zinc-300 hover:bg-zinc-50 dark:bg-zinc-900 dark:text-zinc-300 dark:border-zinc-700 dark:hover:bg-zinc-800 focus-visible:ring-zinc-400 dark:focus-visible:ring-zinc-600',
            'neutral' => 'bg-white text-neutral-700 border-neutral-300 hover:bg-neutral-50 dark:bg-neutral-900 dark:text-neutral-300 dark:border-neutral-700 dark:hover:bg-neutral-800 focus-visible:ring-neutral-400 dark:focus-visible:ring-neutral-600',
            'stone'   => 'bg-white text-stone-700 border-stone-300 hover:bg-stone-50 dark:bg-stone-900 dark:text-stone-300 dark:border-stone-700 dark:hover:bg-stone-800 focus-visible:ring-stone-400 dark:focus-visible:ring-stone-600',
            'red'     => 'bg-white text-red-700 border-red-300 hover:bg-red-50 dark:bg-red-900 dark:text-red-300 dark:border-red-700 dark:hover:bg-red-800 focus-visible:ring-red-400 dark:focus-visible:ring-red-600',
            'orange'  => 'bg-white text-orange-700 border-orange-300 hover:bg-orange-50 dark:bg-orange-900 dark:text-orange-300 dark:border-orange-700 dark:hover:bg-orange-800 focus-visible:ring-orange-400 dark:focus-visible:ring-orange-600',
            'amber'   => 'bg-white text-amber-700 border-amber-300 hover:bg-amber-50 dark:bg-amber-900 dark:text-amber-300 dark:border-amber-700 dark:hover:bg-amber-800 focus-visible:ring-amber-400 dark:focus-visible:ring-amber-600',
            'yellow'  => 'bg-white text-yellow-700 border-yellow-300 hover:bg-yellow-50 dark:bg-yellow-900 dark:text-yellow-300 dark:border-yellow-700 dark:hover:bg-yellow-800 focus-visible:ring-yellow-400 dark:focus-visible:ring-yellow-600',
            'lime'    => 'bg-white text-lime-700 border-lime-300 hover:bg-lime-50 dark:bg-lime-900 dark:text-lime-300 dark:border-lime-700 dark:hover:bg-lime-800 focus-visible:ring-lime-400 dark:focus-visible:ring-lime-600',
            'green'   => 'bg-white text-green-700 border-green-300 hover:bg-green-50 dark:bg-green-900 dark:text-green-300 dark:border-green-700 dark:hover:bg-green-800 focus-visible:ring-green-400 dark:focus-visible:ring-green-600',
            'emerald' => 'bg-white text-emerald-700 border-emerald-300 hover:bg-emerald-50 dark:bg-emerald-900 dark:text-emerald-300 dark:border-emerald-700 dark:hover:bg-emerald-800 focus-visible:ring-emerald-400 dark:focus-visible:ring-emerald-600',
            'teal'    => 'bg-white text-teal-700 border-teal-300 hover:bg-teal-50 dark:bg-teal-900 dark:text-teal-300 dark:border-teal-700 dark:hover:bg-teal-800 focus-visible:ring-teal-400 dark:focus-visible:ring-teal-600',
            'cyan'    => 'bg-white text-cyan-700 border-cyan-300 hover:bg-cyan-50 dark:bg-cyan-900 dark:text-cyan-300 dark:border-cyan-700 dark:hover:bg-cyan-800 focus-visible:ring-cyan-400 dark:focus-visible:ring-cyan-600',
            'sky'     => 'bg-white text-sky-700 border-sky-300 hover:bg-sky-50 dark:bg-sky-900 dark:text-sky-300 dark:border-sky-700 dark:hover:bg-sky-800 focus-visible:ring-sky-400 dark:focus-visible:ring-sky-600',
            'blue'    => 'bg-white text-blue-700 border-blue-300 hover:bg-blue-50 dark:bg-blue-900 dark:text-blue-300 dark:border-blue-700 dark:hover:bg-blue-800 focus-visible:ring-blue-400 dark:focus-visible:ring-blue-600',
            'indigo'  => 'bg-white text-indigo-700 border-indigo-300 hover:bg-indigo-50 dark:bg-indigo-900 dark:text-indigo-300 dark:border-indigo-700 dark:hover:bg-indigo-800 focus-visible:ring-indigo-400 dark:focus-visible:ring-indigo-600',
            'violet'  => 'bg-white text-violet-700 border-violet-300 hover:bg-violet-50 dark:bg-violet-900 dark:text-violet-300 dark:border-violet-700 dark:hover:bg-violet-800 focus-visible:ring-violet-400 dark:focus-visible:ring-violet-600',
            'purple'  => 'bg-white text-purple-700 border-purple-300 hover:bg-purple-50 dark:bg-purple-900 dark:text-purple-300 dark:border-purple-700 dark:hover:bg-purple-800 focus-visible:ring-purple-400 dark:focus-visible:ring-purple-600',
            'fuchsia' => 'bg-white text-fuchsia-700 border-fuchsia-300 hover:bg-fuchsia-50 dark:bg-fuchsia-900 dark:text-fuchsia-300 dark:border-fuchsia-700 dark:hover:bg-fuchsia-800 focus-visible:ring-fuchsia-400 dark:focus-visible:ring-fuchsia-600',
            'pink'    => 'bg-white text-pink-700 border-pink-300 hover:bg-pink-50 dark:bg-pink-900 dark:text-pink-300 dark:border-pink-700 dark:hover:bg-pink-800 focus-visible:ring-pink-400 dark:focus-visible:ring-pink-600',
            'rose'    => 'bg-white text-rose-700 border-rose-300 hover:bg-rose-50 dark:bg-rose-900 dark:text-rose-300 dark:border-rose-700 dark:hover:bg-rose-800 focus-visible:ring-rose-400 dark:focus-visible:ring-rose-600',
            'taupe'   => 'bg-white text-taupe-700 border-taupe-300 hover:bg-taupe-50 dark:bg-taupe-900 dark:text-taupe-300 dark:border-taupe-700 dark:hover:bg-taupe-800 focus-visible:ring-taupe-400 dark:focus-visible:ring-taupe-600',
            'mauve'   => 'bg-white text-mauve-700 border-mauve-300 hover:bg-mauve-50 dark:bg-mauve-900 dark:text-mauve-300 dark:border-mauve-700 dark:hover:bg-mauve-800 focus-visible:ring-mauve-400 dark:focus-visible:ring-mauve-600',
            'mist'    => 'bg-white text-mist-700 border-mist-300 hover:bg-mist-50 dark:bg-mist-900 dark:text-mist-300 dark:border-mist-700 dark:hover:bg-mist-800 focus-visible:ring-mist-400 dark:focus-visible:ring-mist-600',
            'olive'   => 'bg-white text-olive-700 border-olive-300 hover:bg-olive-50 dark:bg-olive-900 dark:text-olive-300 dark:border-olive-700 dark:hover:bg-olive-800 focus-visible:ring-olive-400 dark:focus-visible:ring-olive-600',
            'skin'    => 'bg-white text-skin-700 border-skin-300 hover:bg-skin-50 dark:bg-skin-900 dark:text-skin-300 dark:border-skin-700 dark:hover:bg-skin-800 focus-visible:ring-skin-400 dark:focus-visible:ring-skin-600',
            'cyberpunk' => 'bg-white text-cyberpunk-700 border-cyberpunk-300 hover:bg-cyberpunk-50 dark:bg-cyberpunk-900 dark:text-cyberpunk-300 dark:border-cyberpunk-700 dark:hover:bg-cyberpunk-800 focus-visible:ring-cyberpunk-400 dark:focus-visible:ring-cyberpunk-600',
            'fantasy' => 'bg-white text-fantasy-700 border-fantasy-300 hover:bg-fantasy-50 dark:bg-fantasy-900 dark:text-fantasy-300 dark:border-fantasy-700 dark:hover:bg-fantasy-800 focus-visible:ring-fantasy-400 dark:focus-visible:ring-fantasy-600',
            'wh40k'   => 'bg-white text-wh40k-700 border-wh40k-300 hover:bg-wh40k-50 dark:bg-wh40k-900 dark:text-wh40k-300 dark:border-wh40k-700 dark:hover:bg-wh40k-800 focus-visible:ring-wh40k-400 dark:focus-visible:ring-wh40k-600',
        ];

        return $map[$theme] ?? $map['slate'];
    }

    /**
     * Tab of the open drawer: filled with the theme colour.
     */
    public static function tabActive(?string $theme): string
    {
        $map = [
            'slate'   => 'bg-slate-600 text-white border-slate-600 dark:bg-slate-500 dark:text-white dark:border-slate-500 focus-visible:ring-slate-400 dark:focus-visible:ring-slate-600',
            'gray'    => 'bg-gray-600 text-white border-gray-600 dark:bg-gray-500 dark:text-white dark:border-gray-500 focus-visible:ring-gray-400 dark:focus-visible:ring-gray-600',
            'zinc'    => 'bg-zinc-600 text-white border-zinc-600 dark:bg-zinc-500 dark:text-white dark:border-zinc-500 focus-visible:ring-zinc-400 dark:focus-visible:ring-zinc-600',
            'neutral' => 'bg-neutral-600 text-white border-neutral-600 dark:bg-neutral-500 dark:text-white dark:border-neutral-500 focus-visible:ring-neutral-400 dark:focus-visible:ring-neutral-600',
            'stone'   => 'bg-stone-600 text-white border-stone-600 dark:bg-stone-500 dark:text-white dark:border-stone-500 focus-visible:ring-stone-400 dark:focus-visible:ring-stone-600',
            'red'     => 'bg-red-600 text-white border-red-600 dark:bg-red-500 dark:text-white dark:border-red-500 focus-visible:ring-red-400 dark:focus-visible:ring-red-600',
            'orange'  => 'bg-orange-600 text-white border-orange-600 dark:bg-orange-500 dark:text-white dark:border-orange-500 focus-visible:ring-orange-400 dark:focus-visible:ring-orange-600',
            'amber'   => 'bg-amber-600 text-white border-amber-600 dark:bg-amber-500 dark:text-white dark:border-amber-500 focus-visible:ring-amber-400 dark:focus-visible:ring-amber-600',
            'yellow'  => 'bg-yellow-600 text-white border-yellow-600 dark:bg-yellow-500 dark:text-white dark:border-yellow-500 focus-visible:ring-yellow-400 dark:focus-visible:ring-yellow-600',
            'lime'    => 'bg-lime-600 text-white border-lime-600 dark:bg-lime-500 dark:text-white dark:border-lime-500 focus-visible:ring-lime-400 dark:focus-visible:ring-lime-600',
            'green'   => 'bg-green-600 text-white border-green-600 dark:bg-green-500 dark:text-white dark:border-green-500 focus-visible:ring-green-400 dark:focus-visible:ring-green-600',
            'emerald' => 'bg-emerald-600 text-white border-emerald-600 dark:bg-emerald-500 dark:text-white dark:border-emerald-500 focus-visible:ring-emerald-400 dark:focus-visible:ring-emerald-600',
            'teal'    => 'bg-teal-600 text-white border-teal-600 dark:bg-teal-500 dark:text-white dark:border-teal-500 focus-visible:ring-teal-400 dark:focus-visible:ring-teal-600',
            'cyan'    => 'bg-cyan-600 text-white border-cyan-600 dark:bg-cyan-500 dark:text-white dark:border-cyan-500 focus-visible:ring-cyan-400 dark:focus-visible:ring-cyan-600',
            'sky'     => 'bg-sky-600 text-white border-sky-600 dark:bg-sky-500 dark:text-white dark:border-sky-500 focus-visible:ring-sky-400 dark:focus-visible:ring-sky-600',
            'blue'    => 'bg-blue-600 text-white border-blue-600 dark:bg-blue-500 dark:text-white dark:border-blue-500 focus-visible:ring-blue-400 dark:focus-visible:ring-blue-600',
            'indigo'  => 'bg-indigo-600 text-white border-indigo-600 dark:bg-indigo-500 dark:text-white dark:border-indigo-500 focus-visible:ring-indigo-400 dark:focus-visible:ring-indigo-600',
            'violet'  => 'bg-violet-600 text-white border-violet-600 dark:bg-violet-500 dark:text-white dark:border-violet-500 focus-visible:ring-violet-400 dark:focus-visible:ring-violet-600',
            'purple'  => 'bg-purple-600 text-white border-purple-600 dark:bg-purple-500 dark:text-white dark:border-purple-500 focus-visible:ring-purple-400 dark:focus-visible:ring-purple-600',
            'fuchsia' => 'bg-fuchsia-600 text-white border-fuchsia-600 dark:bg-fuchsia-500 dark:text-white dark:border-fuchsia-500 focus-visible:ring-fuchsia-400 dark:focus-visible:ring-fuchsia-600',
            'pink'    => 'bg-pink-600 text-white border-pink-600 dark:bg-pink-500 dark:text-white dark:border-pink-500 focus-visible:ring-pink-400 dark:focus-visible:ring-pink-600',
            'rose'    => 'bg-rose-600 text-white border-rose-600 dark:bg-rose-500 dark:text-white dark:border-rose-500 focus-visible:ring-rose-400 dark:focus-visible:ring-rose-600',
            'taupe'   => 'bg-taupe-600 text-white border-taupe-600 dark:bg-taupe-500 dark:text-white dark:border-taupe-500 focus-visible:ring-taupe-400 dark:focus-visible:ring-taupe-600',
            'mauve'   => 'bg-mauve-600 text-white border-mauve-600 dark:bg-mauve-500 dark:text-white dark:border-mauve-500 focus-visible:ring-mauve-400 dark:focus-visible:ring-mauve-600',
            'mist'    => 'bg-mist-600 text-white border-mist-600 dark:bg-mist-500 dark:text-white dark:border-mist-500 focus-visible:ring-mist-400 dark:focus-visible:ring-mist-600',
            'olive'   => 'bg-olive-600 text-white border-olive-600 dark:bg-olive-500 dark:text-white dark:border-olive-500 focus-visible:ring-olive-400 dark:focus-visible:ring-olive-600',
            'skin'    => 'bg-skin-600 text-white border-skin-600 dark:bg-skin-500 dark:text-white dark:border-skin-500 focus-visible:ring-skin-400 dark:focus-visible:ring-skin-600',
            'cyberpunk' => 'bg-cyberpunk-600 text-white border-cyberpunk-600 dark:bg-cyberpunk-500 dark:text-white dark:border-cyberpunk-500 focus-visible:ring-cyberpunk-400 dark:focus-visible:ring-cyberpunk-600',
            'fantasy' => 'bg-fantasy-600 text-white border-fantasy-600 dark:bg-fantasy-500 dark:text-white dark:border-fantasy-500 focus-visible:ring-fantasy-400 dark:focus-visible:ring-fantasy-600',
            'wh40k'   => 'bg-wh40k-600 text-white border-wh40k-600 dark:bg-wh40k-500 dark:text-white dark:border-wh40k-500 focus-visible:ring-wh40k-400 dark:focus-visible:ring-wh40k-600',
        ];

        return $map[$theme] ?? $map['slate'];
    }
}
