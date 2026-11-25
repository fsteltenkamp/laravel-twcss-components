<?php

namespace Fsteltenkamp\TwcssComponents\Support;

/**
 * Tailwind class strings for the shared colour roles (README "Color shades"),
 * for components whose markup needs a role colour outside their own theme map.
 *
 * Every value is a **literal** class string per theme so Tailwind's JIT scanner
 * emits all of them. Unknown colours fall back to `base`.
 */
class Shades
{
    /**
     * Primary Content: headings and body copy.
     */
    public static function primary(?string $color): string
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
            'primary'      => 'text-primary-900 dark:text-primary-100',
            'secondary'    => 'text-secondary-900 dark:text-secondary-100',
            'accent'       => 'text-accent-900 dark:text-accent-100',
            'base'         => 'text-base-900 dark:text-base-100',
            'info'         => 'text-info-900 dark:text-info-100',
            'success'      => 'text-success-900 dark:text-success-100',
            'warning'      => 'text-warning-900 dark:text-warning-100',
            'danger'       => 'text-danger-900 dark:text-danger-100',
        ];

        return $map[$color] ?? $map['base'];
    }

    /**
     * Secondary Content: supporting text, labels, sub-headings.
     */
    public static function secondary(?string $color): string
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
            'primary'      => 'text-primary-700 dark:text-primary-300',
            'secondary'    => 'text-secondary-700 dark:text-secondary-300',
            'accent'       => 'text-accent-700 dark:text-accent-300',
            'base'         => 'text-base-700 dark:text-base-300',
            'info'         => 'text-info-700 dark:text-info-300',
            'success'      => 'text-success-700 dark:text-success-300',
            'warning'      => 'text-warning-700 dark:text-warning-300',
            'danger'       => 'text-danger-700 dark:text-danger-300',
        ];

        return $map[$color] ?? $map['base'];
    }

    /**
     * Tertiary Content: muted text, placeholders, icons.
     */
    public static function tertiary(?string $color): string
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
            'primary'      => 'text-primary-500 dark:text-primary-400',
            'secondary'    => 'text-secondary-500 dark:text-secondary-400',
            'accent'       => 'text-accent-500 dark:text-accent-400',
            'base'         => 'text-base-500 dark:text-base-400',
            'info'         => 'text-info-500 dark:text-info-400',
            'success'      => 'text-success-500 dark:text-success-400',
            'warning'      => 'text-warning-500 dark:text-warning-400',
            'danger'       => 'text-danger-500 dark:text-danger-400',
        ];

        return $map[$color] ?? $map['base'];
    }

    /**
     * Unfilled track behind a progress fill.
     */
    public static function track(?string $color): string
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
            'primary'      => 'bg-primary-200 dark:bg-primary-700',
            'secondary'    => 'bg-secondary-200 dark:bg-secondary-700',
            'accent'       => 'bg-accent-200 dark:bg-accent-700',
            'base'         => 'bg-base-200 dark:bg-base-700',
            'info'         => 'bg-info-200 dark:bg-info-700',
            'success'      => 'bg-success-200 dark:bg-success-700',
            'warning'      => 'bg-warning-200 dark:bg-warning-700',
            'danger'       => 'bg-danger-200 dark:bg-danger-700',
        ];

        return $map[$color] ?? $map['base'];
    }

    /**
     * Filled part of a progress bar or meter, filled rating stars.
     */
    public static function fill(?string $color): string
    {
        $map = [
            'slate'     => 'bg-slate-500 dark:bg-slate-400',
            'gray'      => 'bg-gray-500 dark:bg-gray-400',
            'zinc'      => 'bg-zinc-500 dark:bg-zinc-400',
            'neutral'   => 'bg-neutral-500 dark:bg-neutral-400',
            'stone'     => 'bg-stone-500 dark:bg-stone-400',
            'red'       => 'bg-red-500 dark:bg-red-400',
            'orange'    => 'bg-orange-500 dark:bg-orange-400',
            'amber'     => 'bg-amber-500 dark:bg-amber-400',
            'yellow'    => 'bg-yellow-500 dark:bg-yellow-400',
            'lime'      => 'bg-lime-500 dark:bg-lime-400',
            'green'     => 'bg-green-500 dark:bg-green-400',
            'emerald'   => 'bg-emerald-500 dark:bg-emerald-400',
            'teal'      => 'bg-teal-500 dark:bg-teal-400',
            'cyan'      => 'bg-cyan-500 dark:bg-cyan-400',
            'sky'       => 'bg-sky-500 dark:bg-sky-400',
            'blue'      => 'bg-blue-500 dark:bg-blue-400',
            'indigo'    => 'bg-indigo-500 dark:bg-indigo-400',
            'violet'    => 'bg-violet-500 dark:bg-violet-400',
            'purple'    => 'bg-purple-500 dark:bg-purple-400',
            'fuchsia'   => 'bg-fuchsia-500 dark:bg-fuchsia-400',
            'pink'      => 'bg-pink-500 dark:bg-pink-400',
            'rose'      => 'bg-rose-500 dark:bg-rose-400',
            'taupe'     => 'bg-taupe-500 dark:bg-taupe-400',
            'mauve'     => 'bg-mauve-500 dark:bg-mauve-400',
            'mist'      => 'bg-mist-500 dark:bg-mist-400',
            'olive'     => 'bg-olive-500 dark:bg-olive-400',
            'primary'      => 'bg-primary-500 dark:bg-primary-400',
            'secondary'    => 'bg-secondary-500 dark:bg-secondary-400',
            'accent'       => 'bg-accent-500 dark:bg-accent-400',
            'base'         => 'bg-base-500 dark:bg-base-400',
            'info'         => 'bg-info-500 dark:bg-info-400',
            'success'      => 'bg-success-500 dark:bg-success-400',
            'warning'      => 'bg-warning-500 dark:bg-warning-400',
            'danger'       => 'bg-danger-500 dark:bg-danger-400',
        ];

        return $map[$color] ?? $map['base'];
    }

    /**
     * Faint marks on a surface: empty rating stars, placeholder glyphs.
     */
    public static function faint(?string $color): string
    {
        $map = [
            'slate'     => 'text-slate-300 dark:text-slate-600',
            'gray'      => 'text-gray-300 dark:text-gray-600',
            'zinc'      => 'text-zinc-300 dark:text-zinc-600',
            'neutral'   => 'text-neutral-300 dark:text-neutral-600',
            'stone'     => 'text-stone-300 dark:text-stone-600',
            'red'       => 'text-red-300 dark:text-red-600',
            'orange'    => 'text-orange-300 dark:text-orange-600',
            'amber'     => 'text-amber-300 dark:text-amber-600',
            'yellow'    => 'text-yellow-300 dark:text-yellow-600',
            'lime'      => 'text-lime-300 dark:text-lime-600',
            'green'     => 'text-green-300 dark:text-green-600',
            'emerald'   => 'text-emerald-300 dark:text-emerald-600',
            'teal'      => 'text-teal-300 dark:text-teal-600',
            'cyan'      => 'text-cyan-300 dark:text-cyan-600',
            'sky'       => 'text-sky-300 dark:text-sky-600',
            'blue'      => 'text-blue-300 dark:text-blue-600',
            'indigo'    => 'text-indigo-300 dark:text-indigo-600',
            'violet'    => 'text-violet-300 dark:text-violet-600',
            'purple'    => 'text-purple-300 dark:text-purple-600',
            'fuchsia'   => 'text-fuchsia-300 dark:text-fuchsia-600',
            'pink'      => 'text-pink-300 dark:text-pink-600',
            'rose'      => 'text-rose-300 dark:text-rose-600',
            'taupe'     => 'text-taupe-300 dark:text-taupe-600',
            'mauve'     => 'text-mauve-300 dark:text-mauve-600',
            'mist'      => 'text-mist-300 dark:text-mist-600',
            'olive'     => 'text-olive-300 dark:text-olive-600',
            'primary'      => 'text-primary-300 dark:text-primary-600',
            'secondary'    => 'text-secondary-300 dark:text-secondary-600',
            'accent'       => 'text-accent-300 dark:text-accent-600',
            'base'         => 'text-base-300 dark:text-base-600',
            'info'         => 'text-info-300 dark:text-info-600',
            'success'      => 'text-success-300 dark:text-success-600',
            'warning'      => 'text-warning-300 dark:text-warning-600',
            'danger'       => 'text-danger-300 dark:text-danger-600',
        ];

        return $map[$color] ?? $map['base'];
    }

    /**
     * A text control on the page: frame, fill, text and focus ring (the one-time-code boxes).
     */
    public static function control(?string $color): string
    {
        $map = [
            'slate'     => 'border-slate-300 bg-white text-slate-900 focus:border-slate-500 focus:ring-slate-500 dark:border-slate-600 dark:bg-slate-950 dark:text-slate-100 dark:focus:border-slate-400 dark:focus:ring-slate-400',
            'gray'      => 'border-gray-300 bg-white text-gray-900 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600 dark:bg-gray-950 dark:text-gray-100 dark:focus:border-gray-400 dark:focus:ring-gray-400',
            'zinc'      => 'border-zinc-300 bg-white text-zinc-900 focus:border-zinc-500 focus:ring-zinc-500 dark:border-zinc-600 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-zinc-400 dark:focus:ring-zinc-400',
            'neutral'   => 'border-neutral-300 bg-white text-neutral-900 focus:border-neutral-500 focus:ring-neutral-500 dark:border-neutral-600 dark:bg-neutral-950 dark:text-neutral-100 dark:focus:border-neutral-400 dark:focus:ring-neutral-400',
            'stone'     => 'border-stone-300 bg-white text-stone-900 focus:border-stone-500 focus:ring-stone-500 dark:border-stone-600 dark:bg-stone-950 dark:text-stone-100 dark:focus:border-stone-400 dark:focus:ring-stone-400',
            'red'       => 'border-red-300 bg-white text-red-900 focus:border-red-500 focus:ring-red-500 dark:border-red-600 dark:bg-red-950 dark:text-red-100 dark:focus:border-red-400 dark:focus:ring-red-400',
            'orange'    => 'border-orange-300 bg-white text-orange-900 focus:border-orange-500 focus:ring-orange-500 dark:border-orange-600 dark:bg-orange-950 dark:text-orange-100 dark:focus:border-orange-400 dark:focus:ring-orange-400',
            'amber'     => 'border-amber-300 bg-white text-amber-900 focus:border-amber-500 focus:ring-amber-500 dark:border-amber-600 dark:bg-amber-950 dark:text-amber-100 dark:focus:border-amber-400 dark:focus:ring-amber-400',
            'yellow'    => 'border-yellow-300 bg-white text-yellow-900 focus:border-yellow-500 focus:ring-yellow-500 dark:border-yellow-600 dark:bg-yellow-950 dark:text-yellow-100 dark:focus:border-yellow-400 dark:focus:ring-yellow-400',
            'lime'      => 'border-lime-300 bg-white text-lime-900 focus:border-lime-500 focus:ring-lime-500 dark:border-lime-600 dark:bg-lime-950 dark:text-lime-100 dark:focus:border-lime-400 dark:focus:ring-lime-400',
            'green'     => 'border-green-300 bg-white text-green-900 focus:border-green-500 focus:ring-green-500 dark:border-green-600 dark:bg-green-950 dark:text-green-100 dark:focus:border-green-400 dark:focus:ring-green-400',
            'emerald'   => 'border-emerald-300 bg-white text-emerald-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-emerald-600 dark:bg-emerald-950 dark:text-emerald-100 dark:focus:border-emerald-400 dark:focus:ring-emerald-400',
            'teal'      => 'border-teal-300 bg-white text-teal-900 focus:border-teal-500 focus:ring-teal-500 dark:border-teal-600 dark:bg-teal-950 dark:text-teal-100 dark:focus:border-teal-400 dark:focus:ring-teal-400',
            'cyan'      => 'border-cyan-300 bg-white text-cyan-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-cyan-600 dark:bg-cyan-950 dark:text-cyan-100 dark:focus:border-cyan-400 dark:focus:ring-cyan-400',
            'sky'       => 'border-sky-300 bg-white text-sky-900 focus:border-sky-500 focus:ring-sky-500 dark:border-sky-600 dark:bg-sky-950 dark:text-sky-100 dark:focus:border-sky-400 dark:focus:ring-sky-400',
            'blue'      => 'border-blue-300 bg-white text-blue-900 focus:border-blue-500 focus:ring-blue-500 dark:border-blue-600 dark:bg-blue-950 dark:text-blue-100 dark:focus:border-blue-400 dark:focus:ring-blue-400',
            'indigo'    => 'border-indigo-300 bg-white text-indigo-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-indigo-600 dark:bg-indigo-950 dark:text-indigo-100 dark:focus:border-indigo-400 dark:focus:ring-indigo-400',
            'violet'    => 'border-violet-300 bg-white text-violet-900 focus:border-violet-500 focus:ring-violet-500 dark:border-violet-600 dark:bg-violet-950 dark:text-violet-100 dark:focus:border-violet-400 dark:focus:ring-violet-400',
            'purple'    => 'border-purple-300 bg-white text-purple-900 focus:border-purple-500 focus:ring-purple-500 dark:border-purple-600 dark:bg-purple-950 dark:text-purple-100 dark:focus:border-purple-400 dark:focus:ring-purple-400',
            'fuchsia'   => 'border-fuchsia-300 bg-white text-fuchsia-900 focus:border-fuchsia-500 focus:ring-fuchsia-500 dark:border-fuchsia-600 dark:bg-fuchsia-950 dark:text-fuchsia-100 dark:focus:border-fuchsia-400 dark:focus:ring-fuchsia-400',
            'pink'      => 'border-pink-300 bg-white text-pink-900 focus:border-pink-500 focus:ring-pink-500 dark:border-pink-600 dark:bg-pink-950 dark:text-pink-100 dark:focus:border-pink-400 dark:focus:ring-pink-400',
            'rose'      => 'border-rose-300 bg-white text-rose-900 focus:border-rose-500 focus:ring-rose-500 dark:border-rose-600 dark:bg-rose-950 dark:text-rose-100 dark:focus:border-rose-400 dark:focus:ring-rose-400',
            'taupe'     => 'border-taupe-300 bg-white text-taupe-900 focus:border-taupe-500 focus:ring-taupe-500 dark:border-taupe-600 dark:bg-taupe-950 dark:text-taupe-100 dark:focus:border-taupe-400 dark:focus:ring-taupe-400',
            'mauve'     => 'border-mauve-300 bg-white text-mauve-900 focus:border-mauve-500 focus:ring-mauve-500 dark:border-mauve-600 dark:bg-mauve-950 dark:text-mauve-100 dark:focus:border-mauve-400 dark:focus:ring-mauve-400',
            'mist'      => 'border-mist-300 bg-white text-mist-900 focus:border-mist-500 focus:ring-mist-500 dark:border-mist-600 dark:bg-mist-950 dark:text-mist-100 dark:focus:border-mist-400 dark:focus:ring-mist-400',
            'olive'     => 'border-olive-300 bg-white text-olive-900 focus:border-olive-500 focus:ring-olive-500 dark:border-olive-600 dark:bg-olive-950 dark:text-olive-100 dark:focus:border-olive-400 dark:focus:ring-olive-400',
            'primary'   => 'border-primary-300 bg-white text-primary-900 focus:border-primary-500 focus:ring-primary-500 dark:border-primary-600 dark:bg-primary-950 dark:text-primary-100 dark:focus:border-primary-400 dark:focus:ring-primary-400',
            'secondary' => 'border-secondary-300 bg-white text-secondary-900 focus:border-secondary-500 focus:ring-secondary-500 dark:border-secondary-600 dark:bg-secondary-950 dark:text-secondary-100 dark:focus:border-secondary-400 dark:focus:ring-secondary-400',
            'accent'    => 'border-accent-300 bg-white text-accent-900 focus:border-accent-500 focus:ring-accent-500 dark:border-accent-600 dark:bg-accent-950 dark:text-accent-100 dark:focus:border-accent-400 dark:focus:ring-accent-400',
            'base'      => 'border-base-300 bg-white text-base-900 focus:border-base-500 focus:ring-base-500 dark:border-base-600 dark:bg-base-950 dark:text-base-100 dark:focus:border-base-400 dark:focus:ring-base-400',
            'info'      => 'border-info-300 bg-white text-info-900 focus:border-info-500 focus:ring-info-500 dark:border-info-600 dark:bg-info-950 dark:text-info-100 dark:focus:border-info-400 dark:focus:ring-info-400',
            'success'   => 'border-success-300 bg-white text-success-900 focus:border-success-500 focus:ring-success-500 dark:border-success-600 dark:bg-success-950 dark:text-success-100 dark:focus:border-success-400 dark:focus:ring-success-400',
            'warning'   => 'border-warning-300 bg-white text-warning-900 focus:border-warning-500 focus:ring-warning-500 dark:border-warning-600 dark:bg-warning-950 dark:text-warning-100 dark:focus:border-warning-400 dark:focus:ring-warning-400',
            'danger'    => 'border-danger-300 bg-white text-danger-900 focus:border-danger-500 focus:ring-danger-500 dark:border-danger-600 dark:bg-danger-950 dark:text-danger-100 dark:focus:border-danger-400 dark:focus:ring-danger-400',
        ];

        return $map[$color] ?? $map['base'];
    }
}
