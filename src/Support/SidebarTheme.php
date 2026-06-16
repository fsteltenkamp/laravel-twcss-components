<?php

namespace Fsteltenkamp\TwcssComponents\Support;

/**
 * Centralised Tailwind class strings for the Sidebar component family
 * (root, link, group, footer, profile).
 *
 * Every value is a **literal** class string for each of the 26 supported
 * themes so Tailwind's JIT scanner emits the utilities for all of them — the
 * sidebar uses fill/border shades (e.g. `bg-{c}-100`, `dark:bg-{c}-800`) that
 * no other component emits, so they cannot be interpolated safely. Unknown
 * themes fall back to `slate`, matching the rest of the package.
 */
class SidebarTheme
{
    /**
     * Root surface: background, border and primary content colour.
     */
    public static function surface(?string $theme): string
    {
        $map = [
            'slate'   => 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100',
            'gray'    => 'bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100',
            'zinc'    => 'bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100',
            'neutral' => 'bg-white dark:bg-neutral-900 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-neutral-100',
            'stone'   => 'bg-white dark:bg-stone-900 border-stone-200 dark:border-stone-700 text-stone-900 dark:text-stone-100',
            'red'     => 'bg-white dark:bg-red-900 border-red-200 dark:border-red-700 text-red-900 dark:text-red-100',
            'orange'  => 'bg-white dark:bg-orange-900 border-orange-200 dark:border-orange-700 text-orange-900 dark:text-orange-100',
            'amber'   => 'bg-white dark:bg-amber-900 border-amber-200 dark:border-amber-700 text-amber-900 dark:text-amber-100',
            'yellow'  => 'bg-white dark:bg-yellow-900 border-yellow-200 dark:border-yellow-700 text-yellow-900 dark:text-yellow-100',
            'lime'    => 'bg-white dark:bg-lime-900 border-lime-200 dark:border-lime-700 text-lime-900 dark:text-lime-100',
            'green'   => 'bg-white dark:bg-green-900 border-green-200 dark:border-green-700 text-green-900 dark:text-green-100',
            'emerald' => 'bg-white dark:bg-emerald-900 border-emerald-200 dark:border-emerald-700 text-emerald-900 dark:text-emerald-100',
            'teal'    => 'bg-white dark:bg-teal-900 border-teal-200 dark:border-teal-700 text-teal-900 dark:text-teal-100',
            'cyan'    => 'bg-white dark:bg-cyan-900 border-cyan-200 dark:border-cyan-700 text-cyan-900 dark:text-cyan-100',
            'sky'     => 'bg-white dark:bg-sky-900 border-sky-200 dark:border-sky-700 text-sky-900 dark:text-sky-100',
            'blue'    => 'bg-white dark:bg-blue-900 border-blue-200 dark:border-blue-700 text-blue-900 dark:text-blue-100',
            'indigo'  => 'bg-white dark:bg-indigo-900 border-indigo-200 dark:border-indigo-700 text-indigo-900 dark:text-indigo-100',
            'violet'  => 'bg-white dark:bg-violet-900 border-violet-200 dark:border-violet-700 text-violet-900 dark:text-violet-100',
            'purple'  => 'bg-white dark:bg-purple-900 border-purple-200 dark:border-purple-700 text-purple-900 dark:text-purple-100',
            'fuchsia' => 'bg-white dark:bg-fuchsia-900 border-fuchsia-200 dark:border-fuchsia-700 text-fuchsia-900 dark:text-fuchsia-100',
            'pink'    => 'bg-white dark:bg-pink-900 border-pink-200 dark:border-pink-700 text-pink-900 dark:text-pink-100',
            'rose'    => 'bg-white dark:bg-rose-900 border-rose-200 dark:border-rose-700 text-rose-900 dark:text-rose-100',
            'taupe'   => 'bg-white dark:bg-taupe-900 border-taupe-200 dark:border-taupe-700 text-taupe-900 dark:text-taupe-100',
            'mauve'   => 'bg-white dark:bg-mauve-900 border-mauve-200 dark:border-mauve-700 text-mauve-900 dark:text-mauve-100',
            'mist'    => 'bg-white dark:bg-mist-900 border-mist-200 dark:border-mist-700 text-mist-900 dark:text-mist-100',
            'olive'   => 'bg-white dark:bg-olive-900 border-olive-200 dark:border-olive-700 text-olive-900 dark:text-olive-100',
        ];

        return $map[$theme] ?? $map['slate'];
    }

    /**
     * Resting state for links and group triggers (hover + focus ring).
     */
    public static function inactive(?string $theme): string
    {
        $map = [
            'slate'   => 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-slate-100 focus-visible:ring-slate-400 dark:focus-visible:ring-slate-600',
            'gray'    => 'text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-gray-100 focus-visible:ring-gray-400 dark:focus-visible:ring-gray-600',
            'zinc'    => 'text-zinc-700 hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-zinc-100 focus-visible:ring-zinc-400 dark:focus-visible:ring-zinc-600',
            'neutral' => 'text-neutral-700 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:hover:text-neutral-100 focus-visible:ring-neutral-400 dark:focus-visible:ring-neutral-600',
            'stone'   => 'text-stone-700 hover:bg-stone-100 hover:text-stone-900 dark:text-stone-300 dark:hover:bg-stone-800 dark:hover:text-stone-100 focus-visible:ring-stone-400 dark:focus-visible:ring-stone-600',
            'red'     => 'text-red-700 hover:bg-red-100 hover:text-red-900 dark:text-red-300 dark:hover:bg-red-800 dark:hover:text-red-100 focus-visible:ring-red-400 dark:focus-visible:ring-red-600',
            'orange'  => 'text-orange-700 hover:bg-orange-100 hover:text-orange-900 dark:text-orange-300 dark:hover:bg-orange-800 dark:hover:text-orange-100 focus-visible:ring-orange-400 dark:focus-visible:ring-orange-600',
            'amber'   => 'text-amber-700 hover:bg-amber-100 hover:text-amber-900 dark:text-amber-300 dark:hover:bg-amber-800 dark:hover:text-amber-100 focus-visible:ring-amber-400 dark:focus-visible:ring-amber-600',
            'yellow'  => 'text-yellow-700 hover:bg-yellow-100 hover:text-yellow-900 dark:text-yellow-300 dark:hover:bg-yellow-800 dark:hover:text-yellow-100 focus-visible:ring-yellow-400 dark:focus-visible:ring-yellow-600',
            'lime'    => 'text-lime-700 hover:bg-lime-100 hover:text-lime-900 dark:text-lime-300 dark:hover:bg-lime-800 dark:hover:text-lime-100 focus-visible:ring-lime-400 dark:focus-visible:ring-lime-600',
            'green'   => 'text-green-700 hover:bg-green-100 hover:text-green-900 dark:text-green-300 dark:hover:bg-green-800 dark:hover:text-green-100 focus-visible:ring-green-400 dark:focus-visible:ring-green-600',
            'emerald' => 'text-emerald-700 hover:bg-emerald-100 hover:text-emerald-900 dark:text-emerald-300 dark:hover:bg-emerald-800 dark:hover:text-emerald-100 focus-visible:ring-emerald-400 dark:focus-visible:ring-emerald-600',
            'teal'    => 'text-teal-700 hover:bg-teal-100 hover:text-teal-900 dark:text-teal-300 dark:hover:bg-teal-800 dark:hover:text-teal-100 focus-visible:ring-teal-400 dark:focus-visible:ring-teal-600',
            'cyan'    => 'text-cyan-700 hover:bg-cyan-100 hover:text-cyan-900 dark:text-cyan-300 dark:hover:bg-cyan-800 dark:hover:text-cyan-100 focus-visible:ring-cyan-400 dark:focus-visible:ring-cyan-600',
            'sky'     => 'text-sky-700 hover:bg-sky-100 hover:text-sky-900 dark:text-sky-300 dark:hover:bg-sky-800 dark:hover:text-sky-100 focus-visible:ring-sky-400 dark:focus-visible:ring-sky-600',
            'blue'    => 'text-blue-700 hover:bg-blue-100 hover:text-blue-900 dark:text-blue-300 dark:hover:bg-blue-800 dark:hover:text-blue-100 focus-visible:ring-blue-400 dark:focus-visible:ring-blue-600',
            'indigo'  => 'text-indigo-700 hover:bg-indigo-100 hover:text-indigo-900 dark:text-indigo-300 dark:hover:bg-indigo-800 dark:hover:text-indigo-100 focus-visible:ring-indigo-400 dark:focus-visible:ring-indigo-600',
            'violet'  => 'text-violet-700 hover:bg-violet-100 hover:text-violet-900 dark:text-violet-300 dark:hover:bg-violet-800 dark:hover:text-violet-100 focus-visible:ring-violet-400 dark:focus-visible:ring-violet-600',
            'purple'  => 'text-purple-700 hover:bg-purple-100 hover:text-purple-900 dark:text-purple-300 dark:hover:bg-purple-800 dark:hover:text-purple-100 focus-visible:ring-purple-400 dark:focus-visible:ring-purple-600',
            'fuchsia' => 'text-fuchsia-700 hover:bg-fuchsia-100 hover:text-fuchsia-900 dark:text-fuchsia-300 dark:hover:bg-fuchsia-800 dark:hover:text-fuchsia-100 focus-visible:ring-fuchsia-400 dark:focus-visible:ring-fuchsia-600',
            'pink'    => 'text-pink-700 hover:bg-pink-100 hover:text-pink-900 dark:text-pink-300 dark:hover:bg-pink-800 dark:hover:text-pink-100 focus-visible:ring-pink-400 dark:focus-visible:ring-pink-600',
            'rose'    => 'text-rose-700 hover:bg-rose-100 hover:text-rose-900 dark:text-rose-300 dark:hover:bg-rose-800 dark:hover:text-rose-100 focus-visible:ring-rose-400 dark:focus-visible:ring-rose-600',
            'taupe'   => 'text-taupe-700 hover:bg-taupe-100 hover:text-taupe-900 dark:text-taupe-300 dark:hover:bg-taupe-800 dark:hover:text-taupe-100 focus-visible:ring-taupe-400 dark:focus-visible:ring-taupe-600',
            'mauve'   => 'text-mauve-700 hover:bg-mauve-100 hover:text-mauve-900 dark:text-mauve-300 dark:hover:bg-mauve-800 dark:hover:text-mauve-100 focus-visible:ring-mauve-400 dark:focus-visible:ring-mauve-600',
            'mist'    => 'text-mist-700 hover:bg-mist-100 hover:text-mist-900 dark:text-mist-300 dark:hover:bg-mist-800 dark:hover:text-mist-100 focus-visible:ring-mist-400 dark:focus-visible:ring-mist-600',
            'olive'   => 'text-olive-700 hover:bg-olive-100 hover:text-olive-900 dark:text-olive-300 dark:hover:bg-olive-800 dark:hover:text-olive-100 focus-visible:ring-olive-400 dark:focus-visible:ring-olive-600',
        ];

        return $map[$theme] ?? $map['slate'];
    }

    /**
     * Active/current item: filled background and primary content colour.
     */
    public static function active(?string $theme): string
    {
        $map = [
            'slate'   => 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-slate-100 focus-visible:ring-slate-400 dark:focus-visible:ring-slate-600',
            'gray'    => 'bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-gray-100 focus-visible:ring-gray-400 dark:focus-visible:ring-gray-600',
            'zinc'    => 'bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-zinc-100 focus-visible:ring-zinc-400 dark:focus-visible:ring-zinc-600',
            'neutral' => 'bg-neutral-100 text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100 focus-visible:ring-neutral-400 dark:focus-visible:ring-neutral-600',
            'stone'   => 'bg-stone-100 text-stone-900 dark:bg-stone-800 dark:text-stone-100 focus-visible:ring-stone-400 dark:focus-visible:ring-stone-600',
            'red'     => 'bg-red-100 text-red-900 dark:bg-red-800 dark:text-red-100 focus-visible:ring-red-400 dark:focus-visible:ring-red-600',
            'orange'  => 'bg-orange-100 text-orange-900 dark:bg-orange-800 dark:text-orange-100 focus-visible:ring-orange-400 dark:focus-visible:ring-orange-600',
            'amber'   => 'bg-amber-100 text-amber-900 dark:bg-amber-800 dark:text-amber-100 focus-visible:ring-amber-400 dark:focus-visible:ring-amber-600',
            'yellow'  => 'bg-yellow-100 text-yellow-900 dark:bg-yellow-800 dark:text-yellow-100 focus-visible:ring-yellow-400 dark:focus-visible:ring-yellow-600',
            'lime'    => 'bg-lime-100 text-lime-900 dark:bg-lime-800 dark:text-lime-100 focus-visible:ring-lime-400 dark:focus-visible:ring-lime-600',
            'green'   => 'bg-green-100 text-green-900 dark:bg-green-800 dark:text-green-100 focus-visible:ring-green-400 dark:focus-visible:ring-green-600',
            'emerald' => 'bg-emerald-100 text-emerald-900 dark:bg-emerald-800 dark:text-emerald-100 focus-visible:ring-emerald-400 dark:focus-visible:ring-emerald-600',
            'teal'    => 'bg-teal-100 text-teal-900 dark:bg-teal-800 dark:text-teal-100 focus-visible:ring-teal-400 dark:focus-visible:ring-teal-600',
            'cyan'    => 'bg-cyan-100 text-cyan-900 dark:bg-cyan-800 dark:text-cyan-100 focus-visible:ring-cyan-400 dark:focus-visible:ring-cyan-600',
            'sky'     => 'bg-sky-100 text-sky-900 dark:bg-sky-800 dark:text-sky-100 focus-visible:ring-sky-400 dark:focus-visible:ring-sky-600',
            'blue'    => 'bg-blue-100 text-blue-900 dark:bg-blue-800 dark:text-blue-100 focus-visible:ring-blue-400 dark:focus-visible:ring-blue-600',
            'indigo'  => 'bg-indigo-100 text-indigo-900 dark:bg-indigo-800 dark:text-indigo-100 focus-visible:ring-indigo-400 dark:focus-visible:ring-indigo-600',
            'violet'  => 'bg-violet-100 text-violet-900 dark:bg-violet-800 dark:text-violet-100 focus-visible:ring-violet-400 dark:focus-visible:ring-violet-600',
            'purple'  => 'bg-purple-100 text-purple-900 dark:bg-purple-800 dark:text-purple-100 focus-visible:ring-purple-400 dark:focus-visible:ring-purple-600',
            'fuchsia' => 'bg-fuchsia-100 text-fuchsia-900 dark:bg-fuchsia-800 dark:text-fuchsia-100 focus-visible:ring-fuchsia-400 dark:focus-visible:ring-fuchsia-600',
            'pink'    => 'bg-pink-100 text-pink-900 dark:bg-pink-800 dark:text-pink-100 focus-visible:ring-pink-400 dark:focus-visible:ring-pink-600',
            'rose'    => 'bg-rose-100 text-rose-900 dark:bg-rose-800 dark:text-rose-100 focus-visible:ring-rose-400 dark:focus-visible:ring-rose-600',
            'taupe'   => 'bg-taupe-100 text-taupe-900 dark:bg-taupe-800 dark:text-taupe-100 focus-visible:ring-taupe-400 dark:focus-visible:ring-taupe-600',
            'mauve'   => 'bg-mauve-100 text-mauve-900 dark:bg-mauve-800 dark:text-mauve-100 focus-visible:ring-mauve-400 dark:focus-visible:ring-mauve-600',
            'mist'    => 'bg-mist-100 text-mist-900 dark:bg-mist-800 dark:text-mist-100 focus-visible:ring-mist-400 dark:focus-visible:ring-mist-600',
            'olive'   => 'bg-olive-100 text-olive-900 dark:bg-olive-800 dark:text-olive-100 focus-visible:ring-olive-400 dark:focus-visible:ring-olive-600',
        ];

        return $map[$theme] ?? $map['slate'];
    }

    /**
     * Floating surface used by the profile menu popover.
     */
    public static function menu(?string $theme): string
    {
        $map = [
            'slate'   => 'border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900 shadow-lg shadow-slate-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'gray'    => 'border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900 shadow-lg shadow-gray-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'zinc'    => 'border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 shadow-lg shadow-zinc-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'neutral' => 'border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900 shadow-lg shadow-neutral-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'stone'   => 'border-stone-200 bg-white dark:border-stone-700 dark:bg-stone-900 shadow-lg shadow-stone-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'red'     => 'border-red-200 bg-white dark:border-red-700 dark:bg-red-900 shadow-lg shadow-red-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'orange'  => 'border-orange-200 bg-white dark:border-orange-700 dark:bg-orange-900 shadow-lg shadow-orange-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'amber'   => 'border-amber-200 bg-white dark:border-amber-700 dark:bg-amber-900 shadow-lg shadow-amber-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'yellow'  => 'border-yellow-200 bg-white dark:border-yellow-700 dark:bg-yellow-900 shadow-lg shadow-yellow-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'lime'    => 'border-lime-200 bg-white dark:border-lime-700 dark:bg-lime-900 shadow-lg shadow-lime-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'green'   => 'border-green-200 bg-white dark:border-green-700 dark:bg-green-900 shadow-lg shadow-green-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'emerald' => 'border-emerald-200 bg-white dark:border-emerald-700 dark:bg-emerald-900 shadow-lg shadow-emerald-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'teal'    => 'border-teal-200 bg-white dark:border-teal-700 dark:bg-teal-900 shadow-lg shadow-teal-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'cyan'    => 'border-cyan-200 bg-white dark:border-cyan-700 dark:bg-cyan-900 shadow-lg shadow-cyan-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'sky'     => 'border-sky-200 bg-white dark:border-sky-700 dark:bg-sky-900 shadow-lg shadow-sky-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'blue'    => 'border-blue-200 bg-white dark:border-blue-700 dark:bg-blue-900 shadow-lg shadow-blue-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'indigo'  => 'border-indigo-200 bg-white dark:border-indigo-700 dark:bg-indigo-900 shadow-lg shadow-indigo-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'violet'  => 'border-violet-200 bg-white dark:border-violet-700 dark:bg-violet-900 shadow-lg shadow-violet-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'purple'  => 'border-purple-200 bg-white dark:border-purple-700 dark:bg-purple-900 shadow-lg shadow-purple-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'fuchsia' => 'border-fuchsia-200 bg-white dark:border-fuchsia-700 dark:bg-fuchsia-900 shadow-lg shadow-fuchsia-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'pink'    => 'border-pink-200 bg-white dark:border-pink-700 dark:bg-pink-900 shadow-lg shadow-pink-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'rose'    => 'border-rose-200 bg-white dark:border-rose-700 dark:bg-rose-900 shadow-lg shadow-rose-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'taupe'   => 'border-taupe-200 bg-white dark:border-taupe-700 dark:bg-taupe-900 shadow-lg shadow-taupe-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'mauve'   => 'border-mauve-200 bg-white dark:border-mauve-700 dark:bg-mauve-900 shadow-lg shadow-mauve-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'mist'    => 'border-mist-200 bg-white dark:border-mist-700 dark:bg-mist-900 shadow-lg shadow-mist-900/5 ring-1 ring-black/5 dark:ring-white/10',
            'olive'   => 'border-olive-200 bg-white dark:border-olive-700 dark:bg-olive-900 shadow-lg shadow-olive-900/5 ring-1 ring-black/5 dark:ring-white/10',
        ];

        return $map[$theme] ?? $map['slate'];
    }

    /**
     * Border colour used for footers and the group's sub-item guide line.
     */
    public static function divider(?string $theme): string
    {
        $map = [
            'slate'   => 'border-slate-200 dark:border-slate-700',
            'gray'    => 'border-gray-200 dark:border-gray-700',
            'zinc'    => 'border-zinc-200 dark:border-zinc-700',
            'neutral' => 'border-neutral-200 dark:border-neutral-700',
            'stone'   => 'border-stone-200 dark:border-stone-700',
            'red'     => 'border-red-200 dark:border-red-700',
            'orange'  => 'border-orange-200 dark:border-orange-700',
            'amber'   => 'border-amber-200 dark:border-amber-700',
            'yellow'  => 'border-yellow-200 dark:border-yellow-700',
            'lime'    => 'border-lime-200 dark:border-lime-700',
            'green'   => 'border-green-200 dark:border-green-700',
            'emerald' => 'border-emerald-200 dark:border-emerald-700',
            'teal'    => 'border-teal-200 dark:border-teal-700',
            'cyan'    => 'border-cyan-200 dark:border-cyan-700',
            'sky'     => 'border-sky-200 dark:border-sky-700',
            'blue'    => 'border-blue-200 dark:border-blue-700',
            'indigo'  => 'border-indigo-200 dark:border-indigo-700',
            'violet'  => 'border-violet-200 dark:border-violet-700',
            'purple'  => 'border-purple-200 dark:border-purple-700',
            'fuchsia' => 'border-fuchsia-200 dark:border-fuchsia-700',
            'pink'    => 'border-pink-200 dark:border-pink-700',
            'rose'    => 'border-rose-200 dark:border-rose-700',
            'taupe'   => 'border-taupe-200 dark:border-taupe-700',
            'mauve'   => 'border-mauve-200 dark:border-mauve-700',
            'mist'    => 'border-mist-200 dark:border-mist-700',
            'olive'   => 'border-olive-200 dark:border-olive-700',
        ];

        return $map[$theme] ?? $map['slate'];
    }
}
