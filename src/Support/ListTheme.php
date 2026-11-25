<?php

namespace Fsteltenkamp\TwcssComponents\Support;

/**
 * Colour classes for x-fltc::list and x-fltc::list.item (anonymous components: `List`
 * is a reserved word in PHP, so they have no class of their own). Literal strings per
 * colour so Tailwind's scanner emits all of them; unknown colours fall back to base.
 */
class ListTheme
{
    /**
     * Frame, dividers and fill of the list.
     */
    public static function surface(?string $color): string
    {
        $map = [
            'slate'     => 'divide-slate-200 border-slate-200 bg-white dark:divide-slate-700 dark:border-slate-700 dark:bg-slate-900',
            'gray'      => 'divide-gray-200 border-gray-200 bg-white dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-900',
            'zinc'      => 'divide-zinc-200 border-zinc-200 bg-white dark:divide-zinc-700 dark:border-zinc-700 dark:bg-zinc-900',
            'neutral'   => 'divide-neutral-200 border-neutral-200 bg-white dark:divide-neutral-700 dark:border-neutral-700 dark:bg-neutral-900',
            'stone'     => 'divide-stone-200 border-stone-200 bg-white dark:divide-stone-700 dark:border-stone-700 dark:bg-stone-900',
            'red'       => 'divide-red-200 border-red-200 bg-white dark:divide-red-700 dark:border-red-700 dark:bg-red-900',
            'orange'    => 'divide-orange-200 border-orange-200 bg-white dark:divide-orange-700 dark:border-orange-700 dark:bg-orange-900',
            'amber'     => 'divide-amber-200 border-amber-200 bg-white dark:divide-amber-700 dark:border-amber-700 dark:bg-amber-900',
            'yellow'    => 'divide-yellow-200 border-yellow-200 bg-white dark:divide-yellow-700 dark:border-yellow-700 dark:bg-yellow-900',
            'lime'      => 'divide-lime-200 border-lime-200 bg-white dark:divide-lime-700 dark:border-lime-700 dark:bg-lime-900',
            'green'     => 'divide-green-200 border-green-200 bg-white dark:divide-green-700 dark:border-green-700 dark:bg-green-900',
            'emerald'   => 'divide-emerald-200 border-emerald-200 bg-white dark:divide-emerald-700 dark:border-emerald-700 dark:bg-emerald-900',
            'teal'      => 'divide-teal-200 border-teal-200 bg-white dark:divide-teal-700 dark:border-teal-700 dark:bg-teal-900',
            'cyan'      => 'divide-cyan-200 border-cyan-200 bg-white dark:divide-cyan-700 dark:border-cyan-700 dark:bg-cyan-900',
            'sky'       => 'divide-sky-200 border-sky-200 bg-white dark:divide-sky-700 dark:border-sky-700 dark:bg-sky-900',
            'blue'      => 'divide-blue-200 border-blue-200 bg-white dark:divide-blue-700 dark:border-blue-700 dark:bg-blue-900',
            'indigo'    => 'divide-indigo-200 border-indigo-200 bg-white dark:divide-indigo-700 dark:border-indigo-700 dark:bg-indigo-900',
            'violet'    => 'divide-violet-200 border-violet-200 bg-white dark:divide-violet-700 dark:border-violet-700 dark:bg-violet-900',
            'purple'    => 'divide-purple-200 border-purple-200 bg-white dark:divide-purple-700 dark:border-purple-700 dark:bg-purple-900',
            'fuchsia'   => 'divide-fuchsia-200 border-fuchsia-200 bg-white dark:divide-fuchsia-700 dark:border-fuchsia-700 dark:bg-fuchsia-900',
            'pink'      => 'divide-pink-200 border-pink-200 bg-white dark:divide-pink-700 dark:border-pink-700 dark:bg-pink-900',
            'rose'      => 'divide-rose-200 border-rose-200 bg-white dark:divide-rose-700 dark:border-rose-700 dark:bg-rose-900',
            'taupe'     => 'divide-taupe-200 border-taupe-200 bg-white dark:divide-taupe-700 dark:border-taupe-700 dark:bg-taupe-900',
            'mauve'     => 'divide-mauve-200 border-mauve-200 bg-white dark:divide-mauve-700 dark:border-mauve-700 dark:bg-mauve-900',
            'mist'      => 'divide-mist-200 border-mist-200 bg-white dark:divide-mist-700 dark:border-mist-700 dark:bg-mist-900',
            'olive'     => 'divide-olive-200 border-olive-200 bg-white dark:divide-olive-700 dark:border-olive-700 dark:bg-olive-900',
            'primary'   => 'divide-primary-200 border-primary-200 bg-white dark:divide-primary-700 dark:border-primary-700 dark:bg-primary-900',
            'secondary' => 'divide-secondary-200 border-secondary-200 bg-white dark:divide-secondary-700 dark:border-secondary-700 dark:bg-secondary-900',
            'accent'    => 'divide-accent-200 border-accent-200 bg-white dark:divide-accent-700 dark:border-accent-700 dark:bg-accent-900',
            'base'      => 'divide-base-200 border-base-200 bg-white dark:divide-base-700 dark:border-base-700 dark:bg-base-900',
            'info'      => 'divide-info-200 border-info-200 bg-white dark:divide-info-700 dark:border-info-700 dark:bg-info-900',
            'success'   => 'divide-success-200 border-success-200 bg-white dark:divide-success-700 dark:border-success-700 dark:bg-success-900',
            'warning'   => 'divide-warning-200 border-warning-200 bg-white dark:divide-warning-700 dark:border-warning-700 dark:bg-warning-900',
            'danger'    => 'divide-danger-200 border-danger-200 bg-white dark:divide-danger-700 dark:border-danger-700 dark:bg-danger-900',
        ];

        return $map[$color] ?? $map['base'];
    }

    /**
     * Dividers only, for a list inside another component (variant inset).
     */
    public static function divider(?string $color): string
    {
        $map = [
            'slate'     => 'divide-slate-200 dark:divide-slate-700',
            'gray'      => 'divide-gray-200 dark:divide-gray-700',
            'zinc'      => 'divide-zinc-200 dark:divide-zinc-700',
            'neutral'   => 'divide-neutral-200 dark:divide-neutral-700',
            'stone'     => 'divide-stone-200 dark:divide-stone-700',
            'red'       => 'divide-red-200 dark:divide-red-700',
            'orange'    => 'divide-orange-200 dark:divide-orange-700',
            'amber'     => 'divide-amber-200 dark:divide-amber-700',
            'yellow'    => 'divide-yellow-200 dark:divide-yellow-700',
            'lime'      => 'divide-lime-200 dark:divide-lime-700',
            'green'     => 'divide-green-200 dark:divide-green-700',
            'emerald'   => 'divide-emerald-200 dark:divide-emerald-700',
            'teal'      => 'divide-teal-200 dark:divide-teal-700',
            'cyan'      => 'divide-cyan-200 dark:divide-cyan-700',
            'sky'       => 'divide-sky-200 dark:divide-sky-700',
            'blue'      => 'divide-blue-200 dark:divide-blue-700',
            'indigo'    => 'divide-indigo-200 dark:divide-indigo-700',
            'violet'    => 'divide-violet-200 dark:divide-violet-700',
            'purple'    => 'divide-purple-200 dark:divide-purple-700',
            'fuchsia'   => 'divide-fuchsia-200 dark:divide-fuchsia-700',
            'pink'      => 'divide-pink-200 dark:divide-pink-700',
            'rose'      => 'divide-rose-200 dark:divide-rose-700',
            'taupe'     => 'divide-taupe-200 dark:divide-taupe-700',
            'mauve'     => 'divide-mauve-200 dark:divide-mauve-700',
            'mist'      => 'divide-mist-200 dark:divide-mist-700',
            'olive'     => 'divide-olive-200 dark:divide-olive-700',
            'primary'   => 'divide-primary-200 dark:divide-primary-700',
            'secondary' => 'divide-secondary-200 dark:divide-secondary-700',
            'accent'    => 'divide-accent-200 dark:divide-accent-700',
            'base'      => 'divide-base-200 dark:divide-base-700',
            'info'      => 'divide-info-200 dark:divide-info-700',
            'success'   => 'divide-success-200 dark:divide-success-700',
            'warning'   => 'divide-warning-200 dark:divide-warning-700',
            'danger'    => 'divide-danger-200 dark:divide-danger-700',
        ];

        return $map[$color] ?? $map['base'];
    }

    /**
     * Hover fill of a linked row.
     */
    public static function hover(?string $color): string
    {
        $map = [
            'slate'     => 'hover:bg-slate-50 focus-visible:bg-slate-50 dark:hover:bg-slate-800/60 dark:focus-visible:bg-slate-800/60',
            'gray'      => 'hover:bg-gray-50 focus-visible:bg-gray-50 dark:hover:bg-gray-800/60 dark:focus-visible:bg-gray-800/60',
            'zinc'      => 'hover:bg-zinc-50 focus-visible:bg-zinc-50 dark:hover:bg-zinc-800/60 dark:focus-visible:bg-zinc-800/60',
            'neutral'   => 'hover:bg-neutral-50 focus-visible:bg-neutral-50 dark:hover:bg-neutral-800/60 dark:focus-visible:bg-neutral-800/60',
            'stone'     => 'hover:bg-stone-50 focus-visible:bg-stone-50 dark:hover:bg-stone-800/60 dark:focus-visible:bg-stone-800/60',
            'red'       => 'hover:bg-red-50 focus-visible:bg-red-50 dark:hover:bg-red-800/60 dark:focus-visible:bg-red-800/60',
            'orange'    => 'hover:bg-orange-50 focus-visible:bg-orange-50 dark:hover:bg-orange-800/60 dark:focus-visible:bg-orange-800/60',
            'amber'     => 'hover:bg-amber-50 focus-visible:bg-amber-50 dark:hover:bg-amber-800/60 dark:focus-visible:bg-amber-800/60',
            'yellow'    => 'hover:bg-yellow-50 focus-visible:bg-yellow-50 dark:hover:bg-yellow-800/60 dark:focus-visible:bg-yellow-800/60',
            'lime'      => 'hover:bg-lime-50 focus-visible:bg-lime-50 dark:hover:bg-lime-800/60 dark:focus-visible:bg-lime-800/60',
            'green'     => 'hover:bg-green-50 focus-visible:bg-green-50 dark:hover:bg-green-800/60 dark:focus-visible:bg-green-800/60',
            'emerald'   => 'hover:bg-emerald-50 focus-visible:bg-emerald-50 dark:hover:bg-emerald-800/60 dark:focus-visible:bg-emerald-800/60',
            'teal'      => 'hover:bg-teal-50 focus-visible:bg-teal-50 dark:hover:bg-teal-800/60 dark:focus-visible:bg-teal-800/60',
            'cyan'      => 'hover:bg-cyan-50 focus-visible:bg-cyan-50 dark:hover:bg-cyan-800/60 dark:focus-visible:bg-cyan-800/60',
            'sky'       => 'hover:bg-sky-50 focus-visible:bg-sky-50 dark:hover:bg-sky-800/60 dark:focus-visible:bg-sky-800/60',
            'blue'      => 'hover:bg-blue-50 focus-visible:bg-blue-50 dark:hover:bg-blue-800/60 dark:focus-visible:bg-blue-800/60',
            'indigo'    => 'hover:bg-indigo-50 focus-visible:bg-indigo-50 dark:hover:bg-indigo-800/60 dark:focus-visible:bg-indigo-800/60',
            'violet'    => 'hover:bg-violet-50 focus-visible:bg-violet-50 dark:hover:bg-violet-800/60 dark:focus-visible:bg-violet-800/60',
            'purple'    => 'hover:bg-purple-50 focus-visible:bg-purple-50 dark:hover:bg-purple-800/60 dark:focus-visible:bg-purple-800/60',
            'fuchsia'   => 'hover:bg-fuchsia-50 focus-visible:bg-fuchsia-50 dark:hover:bg-fuchsia-800/60 dark:focus-visible:bg-fuchsia-800/60',
            'pink'      => 'hover:bg-pink-50 focus-visible:bg-pink-50 dark:hover:bg-pink-800/60 dark:focus-visible:bg-pink-800/60',
            'rose'      => 'hover:bg-rose-50 focus-visible:bg-rose-50 dark:hover:bg-rose-800/60 dark:focus-visible:bg-rose-800/60',
            'taupe'     => 'hover:bg-taupe-50 focus-visible:bg-taupe-50 dark:hover:bg-taupe-800/60 dark:focus-visible:bg-taupe-800/60',
            'mauve'     => 'hover:bg-mauve-50 focus-visible:bg-mauve-50 dark:hover:bg-mauve-800/60 dark:focus-visible:bg-mauve-800/60',
            'mist'      => 'hover:bg-mist-50 focus-visible:bg-mist-50 dark:hover:bg-mist-800/60 dark:focus-visible:bg-mist-800/60',
            'olive'     => 'hover:bg-olive-50 focus-visible:bg-olive-50 dark:hover:bg-olive-800/60 dark:focus-visible:bg-olive-800/60',
            'primary'   => 'hover:bg-primary-50 focus-visible:bg-primary-50 dark:hover:bg-primary-800/60 dark:focus-visible:bg-primary-800/60',
            'secondary' => 'hover:bg-secondary-50 focus-visible:bg-secondary-50 dark:hover:bg-secondary-800/60 dark:focus-visible:bg-secondary-800/60',
            'accent'    => 'hover:bg-accent-50 focus-visible:bg-accent-50 dark:hover:bg-accent-800/60 dark:focus-visible:bg-accent-800/60',
            'base'      => 'hover:bg-base-50 focus-visible:bg-base-50 dark:hover:bg-base-800/60 dark:focus-visible:bg-base-800/60',
            'info'      => 'hover:bg-info-50 focus-visible:bg-info-50 dark:hover:bg-info-800/60 dark:focus-visible:bg-info-800/60',
            'success'   => 'hover:bg-success-50 focus-visible:bg-success-50 dark:hover:bg-success-800/60 dark:focus-visible:bg-success-800/60',
            'warning'   => 'hover:bg-warning-50 focus-visible:bg-warning-50 dark:hover:bg-warning-800/60 dark:focus-visible:bg-warning-800/60',
            'danger'    => 'hover:bg-danger-50 focus-visible:bg-danger-50 dark:hover:bg-danger-800/60 dark:focus-visible:bg-danger-800/60',
        ];

        return $map[$color] ?? $map['base'];
    }

    /**
     * Leading bar and tint of a highlighted row.
     */
    public static function highlight(?string $color): string
    {
        $map = [
            'slate'     => 'shadow-[inset_3px_0_0] shadow-slate-500 bg-slate-50/60 dark:shadow-slate-400 dark:bg-slate-900/40',
            'gray'      => 'shadow-[inset_3px_0_0] shadow-gray-500 bg-gray-50/60 dark:shadow-gray-400 dark:bg-gray-900/40',
            'zinc'      => 'shadow-[inset_3px_0_0] shadow-zinc-500 bg-zinc-50/60 dark:shadow-zinc-400 dark:bg-zinc-900/40',
            'neutral'   => 'shadow-[inset_3px_0_0] shadow-neutral-500 bg-neutral-50/60 dark:shadow-neutral-400 dark:bg-neutral-900/40',
            'stone'     => 'shadow-[inset_3px_0_0] shadow-stone-500 bg-stone-50/60 dark:shadow-stone-400 dark:bg-stone-900/40',
            'red'       => 'shadow-[inset_3px_0_0] shadow-red-500 bg-red-50/60 dark:shadow-red-400 dark:bg-red-900/40',
            'orange'    => 'shadow-[inset_3px_0_0] shadow-orange-500 bg-orange-50/60 dark:shadow-orange-400 dark:bg-orange-900/40',
            'amber'     => 'shadow-[inset_3px_0_0] shadow-amber-500 bg-amber-50/60 dark:shadow-amber-400 dark:bg-amber-900/40',
            'yellow'    => 'shadow-[inset_3px_0_0] shadow-yellow-500 bg-yellow-50/60 dark:shadow-yellow-400 dark:bg-yellow-900/40',
            'lime'      => 'shadow-[inset_3px_0_0] shadow-lime-500 bg-lime-50/60 dark:shadow-lime-400 dark:bg-lime-900/40',
            'green'     => 'shadow-[inset_3px_0_0] shadow-green-500 bg-green-50/60 dark:shadow-green-400 dark:bg-green-900/40',
            'emerald'   => 'shadow-[inset_3px_0_0] shadow-emerald-500 bg-emerald-50/60 dark:shadow-emerald-400 dark:bg-emerald-900/40',
            'teal'      => 'shadow-[inset_3px_0_0] shadow-teal-500 bg-teal-50/60 dark:shadow-teal-400 dark:bg-teal-900/40',
            'cyan'      => 'shadow-[inset_3px_0_0] shadow-cyan-500 bg-cyan-50/60 dark:shadow-cyan-400 dark:bg-cyan-900/40',
            'sky'       => 'shadow-[inset_3px_0_0] shadow-sky-500 bg-sky-50/60 dark:shadow-sky-400 dark:bg-sky-900/40',
            'blue'      => 'shadow-[inset_3px_0_0] shadow-blue-500 bg-blue-50/60 dark:shadow-blue-400 dark:bg-blue-900/40',
            'indigo'    => 'shadow-[inset_3px_0_0] shadow-indigo-500 bg-indigo-50/60 dark:shadow-indigo-400 dark:bg-indigo-900/40',
            'violet'    => 'shadow-[inset_3px_0_0] shadow-violet-500 bg-violet-50/60 dark:shadow-violet-400 dark:bg-violet-900/40',
            'purple'    => 'shadow-[inset_3px_0_0] shadow-purple-500 bg-purple-50/60 dark:shadow-purple-400 dark:bg-purple-900/40',
            'fuchsia'   => 'shadow-[inset_3px_0_0] shadow-fuchsia-500 bg-fuchsia-50/60 dark:shadow-fuchsia-400 dark:bg-fuchsia-900/40',
            'pink'      => 'shadow-[inset_3px_0_0] shadow-pink-500 bg-pink-50/60 dark:shadow-pink-400 dark:bg-pink-900/40',
            'rose'      => 'shadow-[inset_3px_0_0] shadow-rose-500 bg-rose-50/60 dark:shadow-rose-400 dark:bg-rose-900/40',
            'taupe'     => 'shadow-[inset_3px_0_0] shadow-taupe-500 bg-taupe-50/60 dark:shadow-taupe-400 dark:bg-taupe-900/40',
            'mauve'     => 'shadow-[inset_3px_0_0] shadow-mauve-500 bg-mauve-50/60 dark:shadow-mauve-400 dark:bg-mauve-900/40',
            'mist'      => 'shadow-[inset_3px_0_0] shadow-mist-500 bg-mist-50/60 dark:shadow-mist-400 dark:bg-mist-900/40',
            'olive'     => 'shadow-[inset_3px_0_0] shadow-olive-500 bg-olive-50/60 dark:shadow-olive-400 dark:bg-olive-900/40',
            'primary'   => 'shadow-[inset_3px_0_0] shadow-primary-500 bg-primary-50/60 dark:shadow-primary-400 dark:bg-primary-900/40',
            'secondary' => 'shadow-[inset_3px_0_0] shadow-secondary-500 bg-secondary-50/60 dark:shadow-secondary-400 dark:bg-secondary-900/40',
            'accent'    => 'shadow-[inset_3px_0_0] shadow-accent-500 bg-accent-50/60 dark:shadow-accent-400 dark:bg-accent-900/40',
            'base'      => 'shadow-[inset_3px_0_0] shadow-base-500 bg-base-50/60 dark:shadow-base-400 dark:bg-base-900/40',
            'info'      => 'shadow-[inset_3px_0_0] shadow-info-500 bg-info-50/60 dark:shadow-info-400 dark:bg-info-900/40',
            'success'   => 'shadow-[inset_3px_0_0] shadow-success-500 bg-success-50/60 dark:shadow-success-400 dark:bg-success-900/40',
            'warning'   => 'shadow-[inset_3px_0_0] shadow-warning-500 bg-warning-50/60 dark:shadow-warning-400 dark:bg-warning-900/40',
            'danger'    => 'shadow-[inset_3px_0_0] shadow-danger-500 bg-danger-50/60 dark:shadow-danger-400 dark:bg-danger-900/40',
        ];

        return $map[$color] ?? $map['base'];
    }
}
