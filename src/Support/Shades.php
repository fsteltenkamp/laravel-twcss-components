<?php

namespace Fsteltenkamp\TwcssComponents\Support;

/**
 * Tailwind class strings for the shared colour roles (README "Color shades"),
 * for components whose markup needs a role colour outside their own theme map.
 *
 * Every value is a **literal** class string per theme so Tailwind's JIT scanner
 * emits all of them. Unknown themes fall back to `slate`.
 */
class Shades
{
    /**
     * Primary Content: headings and body copy.
     */
    public static function primary(?string $theme): string
    {
        $map = [
            'slate'     => 'text-slate-900 dark:text-slate-100',
            'gray'      => 'text-gray-900 dark:text-gray-100',
            'zinc'      => 'text-zinc-900 dark:text-zinc-100',
            'neutral'   => 'text-neutral-900 dark:text-neutral-100',
            'stone'     => 'text-stone-900 dark:text-stone-100',
            'red'       => 'text-red-900 dark:text-red-100',
            'orange'    => 'text-orange-900 dark:text-orange-100',
            'amber'     => 'text-amber-900 dark:text-amber-100',
            'yellow'    => 'text-yellow-900 dark:text-yellow-100',
            'lime'      => 'text-lime-900 dark:text-lime-100',
            'green'     => 'text-green-900 dark:text-green-100',
            'emerald'   => 'text-emerald-900 dark:text-emerald-100',
            'teal'      => 'text-teal-900 dark:text-teal-100',
            'cyan'      => 'text-cyan-900 dark:text-cyan-100',
            'sky'       => 'text-sky-900 dark:text-sky-100',
            'blue'      => 'text-blue-900 dark:text-blue-100',
            'indigo'    => 'text-indigo-900 dark:text-indigo-100',
            'violet'    => 'text-violet-900 dark:text-violet-100',
            'purple'    => 'text-purple-900 dark:text-purple-100',
            'fuchsia'   => 'text-fuchsia-900 dark:text-fuchsia-100',
            'pink'      => 'text-pink-900 dark:text-pink-100',
            'rose'      => 'text-rose-900 dark:text-rose-100',
            'taupe'     => 'text-taupe-900 dark:text-taupe-100',
            'mauve'     => 'text-mauve-900 dark:text-mauve-100',
            'mist'      => 'text-mist-900 dark:text-mist-100',
            'olive'     => 'text-olive-900 dark:text-olive-100',
            'skin'      => 'text-skin-900 dark:text-skin-100',
            'cyberpunk' => 'text-cyberpunk-900 dark:text-cyberpunk-100',
            'fantasy'   => 'text-fantasy-900 dark:text-fantasy-100',
            'wh40k'     => 'text-wh40k-900 dark:text-wh40k-100',
        ];

        return $map[$theme] ?? $map['slate'];
    }

    /**
     * Secondary Content: supporting text, labels, sub-headings.
     */
    public static function secondary(?string $theme): string
    {
        $map = [
            'slate'     => 'text-slate-700 dark:text-slate-300',
            'gray'      => 'text-gray-700 dark:text-gray-300',
            'zinc'      => 'text-zinc-700 dark:text-zinc-300',
            'neutral'   => 'text-neutral-700 dark:text-neutral-300',
            'stone'     => 'text-stone-700 dark:text-stone-300',
            'red'       => 'text-red-700 dark:text-red-300',
            'orange'    => 'text-orange-700 dark:text-orange-300',
            'amber'     => 'text-amber-700 dark:text-amber-300',
            'yellow'    => 'text-yellow-700 dark:text-yellow-300',
            'lime'      => 'text-lime-700 dark:text-lime-300',
            'green'     => 'text-green-700 dark:text-green-300',
            'emerald'   => 'text-emerald-700 dark:text-emerald-300',
            'teal'      => 'text-teal-700 dark:text-teal-300',
            'cyan'      => 'text-cyan-700 dark:text-cyan-300',
            'sky'       => 'text-sky-700 dark:text-sky-300',
            'blue'      => 'text-blue-700 dark:text-blue-300',
            'indigo'    => 'text-indigo-700 dark:text-indigo-300',
            'violet'    => 'text-violet-700 dark:text-violet-300',
            'purple'    => 'text-purple-700 dark:text-purple-300',
            'fuchsia'   => 'text-fuchsia-700 dark:text-fuchsia-300',
            'pink'      => 'text-pink-700 dark:text-pink-300',
            'rose'      => 'text-rose-700 dark:text-rose-300',
            'taupe'     => 'text-taupe-700 dark:text-taupe-300',
            'mauve'     => 'text-mauve-700 dark:text-mauve-300',
            'mist'      => 'text-mist-700 dark:text-mist-300',
            'olive'     => 'text-olive-700 dark:text-olive-300',
            'skin'      => 'text-skin-700 dark:text-skin-300',
            'cyberpunk' => 'text-cyberpunk-700 dark:text-cyberpunk-300',
            'fantasy'   => 'text-fantasy-700 dark:text-fantasy-300',
            'wh40k'     => 'text-wh40k-700 dark:text-wh40k-300',
        ];

        return $map[$theme] ?? $map['slate'];
    }

    /**
     * Tertiary Content: muted text, placeholders, icons.
     */
    public static function tertiary(?string $theme): string
    {
        $map = [
            'slate'     => 'text-slate-500 dark:text-slate-400',
            'gray'      => 'text-gray-500 dark:text-gray-400',
            'zinc'      => 'text-zinc-500 dark:text-zinc-400',
            'neutral'   => 'text-neutral-500 dark:text-neutral-400',
            'stone'     => 'text-stone-500 dark:text-stone-400',
            'red'       => 'text-red-500 dark:text-red-400',
            'orange'    => 'text-orange-500 dark:text-orange-400',
            'amber'     => 'text-amber-500 dark:text-amber-400',
            'yellow'    => 'text-yellow-500 dark:text-yellow-400',
            'lime'      => 'text-lime-500 dark:text-lime-400',
            'green'     => 'text-green-500 dark:text-green-400',
            'emerald'   => 'text-emerald-500 dark:text-emerald-400',
            'teal'      => 'text-teal-500 dark:text-teal-400',
            'cyan'      => 'text-cyan-500 dark:text-cyan-400',
            'sky'       => 'text-sky-500 dark:text-sky-400',
            'blue'      => 'text-blue-500 dark:text-blue-400',
            'indigo'    => 'text-indigo-500 dark:text-indigo-400',
            'violet'    => 'text-violet-500 dark:text-violet-400',
            'purple'    => 'text-purple-500 dark:text-purple-400',
            'fuchsia'   => 'text-fuchsia-500 dark:text-fuchsia-400',
            'pink'      => 'text-pink-500 dark:text-pink-400',
            'rose'      => 'text-rose-500 dark:text-rose-400',
            'taupe'     => 'text-taupe-500 dark:text-taupe-400',
            'mauve'     => 'text-mauve-500 dark:text-mauve-400',
            'mist'      => 'text-mist-500 dark:text-mist-400',
            'olive'     => 'text-olive-500 dark:text-olive-400',
            'skin'      => 'text-skin-500 dark:text-skin-400',
            'cyberpunk' => 'text-cyberpunk-500 dark:text-cyberpunk-400',
            'fantasy'   => 'text-fantasy-500 dark:text-fantasy-400',
            'wh40k'     => 'text-wh40k-500 dark:text-wh40k-400',
        ];

        return $map[$theme] ?? $map['slate'];
    }

    /**
     * Unfilled track behind a progress fill.
     */
    public static function track(?string $theme): string
    {
        $map = [
            'slate'     => 'bg-slate-200 dark:bg-slate-700',
            'gray'      => 'bg-gray-200 dark:bg-gray-700',
            'zinc'      => 'bg-zinc-200 dark:bg-zinc-700',
            'neutral'   => 'bg-neutral-200 dark:bg-neutral-700',
            'stone'     => 'bg-stone-200 dark:bg-stone-700',
            'red'       => 'bg-red-200 dark:bg-red-700',
            'orange'    => 'bg-orange-200 dark:bg-orange-700',
            'amber'     => 'bg-amber-200 dark:bg-amber-700',
            'yellow'    => 'bg-yellow-200 dark:bg-yellow-700',
            'lime'      => 'bg-lime-200 dark:bg-lime-700',
            'green'     => 'bg-green-200 dark:bg-green-700',
            'emerald'   => 'bg-emerald-200 dark:bg-emerald-700',
            'teal'      => 'bg-teal-200 dark:bg-teal-700',
            'cyan'      => 'bg-cyan-200 dark:bg-cyan-700',
            'sky'       => 'bg-sky-200 dark:bg-sky-700',
            'blue'      => 'bg-blue-200 dark:bg-blue-700',
            'indigo'    => 'bg-indigo-200 dark:bg-indigo-700',
            'violet'    => 'bg-violet-200 dark:bg-violet-700',
            'purple'    => 'bg-purple-200 dark:bg-purple-700',
            'fuchsia'   => 'bg-fuchsia-200 dark:bg-fuchsia-700',
            'pink'      => 'bg-pink-200 dark:bg-pink-700',
            'rose'      => 'bg-rose-200 dark:bg-rose-700',
            'taupe'     => 'bg-taupe-200 dark:bg-taupe-700',
            'mauve'     => 'bg-mauve-200 dark:bg-mauve-700',
            'mist'      => 'bg-mist-200 dark:bg-mist-700',
            'olive'     => 'bg-olive-200 dark:bg-olive-700',
            'skin'      => 'bg-skin-200 dark:bg-skin-700',
            'cyberpunk' => 'bg-cyberpunk-200 dark:bg-cyberpunk-700',
            'fantasy'   => 'bg-fantasy-200 dark:bg-fantasy-700',
            'wh40k'     => 'bg-wh40k-200 dark:bg-wh40k-700',
        ];

        return $map[$theme] ?? $map['slate'];
    }
}
