<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * Compact label / chip. Plain by default; with `href` a link, with
 * `variant="toggle"` an on/off chip backed by a checkbox (`name` / `value` post with
 * a form), with `removable` a ✕ button that dispatches `badge-remove`. Inside
 * x-fltc::badge.cloud it takes the cloud's theme.
 */
class Badge extends Component
{
    public string $classList = '';
    public string $countClasses;
    public string $removeClasses;
    public string $tag;

    public function __construct(
        public ?string $theme = null,
        public string $href = '',
        public string $icon = '',
        public string $iconVariant = 'regular',
        public string $variant = 'default',
        public string $name = '',
        public string $value = '',
        public bool $checked = false,
        public bool $removable = false,
        public string $removeLabel = '',
        public int|string|null $count = null,
    ) {
        $this->theme = $theme ?? ViewFacade::shared('fltcBadgeTheme') ?? 'slate';
        $theme = $this->theme;

        $linkMap = [
            'slate'     => 'hover:bg-slate-100 focus-visible:ring-slate-400 dark:hover:bg-slate-800 dark:focus-visible:ring-slate-600',
            'gray'      => 'hover:bg-gray-100 focus-visible:ring-gray-400 dark:hover:bg-gray-800 dark:focus-visible:ring-gray-600',
            'zinc'      => 'hover:bg-zinc-100 focus-visible:ring-zinc-400 dark:hover:bg-zinc-800 dark:focus-visible:ring-zinc-600',
            'neutral'   => 'hover:bg-neutral-100 focus-visible:ring-neutral-400 dark:hover:bg-neutral-800 dark:focus-visible:ring-neutral-600',
            'stone'     => 'hover:bg-stone-100 focus-visible:ring-stone-400 dark:hover:bg-stone-800 dark:focus-visible:ring-stone-600',
            'red'       => 'hover:bg-red-100 focus-visible:ring-red-400 dark:hover:bg-red-800 dark:focus-visible:ring-red-600',
            'orange'    => 'hover:bg-orange-100 focus-visible:ring-orange-400 dark:hover:bg-orange-800 dark:focus-visible:ring-orange-600',
            'amber'     => 'hover:bg-amber-100 focus-visible:ring-amber-400 dark:hover:bg-amber-800 dark:focus-visible:ring-amber-600',
            'yellow'    => 'hover:bg-yellow-100 focus-visible:ring-yellow-400 dark:hover:bg-yellow-800 dark:focus-visible:ring-yellow-600',
            'lime'      => 'hover:bg-lime-100 focus-visible:ring-lime-400 dark:hover:bg-lime-800 dark:focus-visible:ring-lime-600',
            'green'     => 'hover:bg-green-100 focus-visible:ring-green-400 dark:hover:bg-green-800 dark:focus-visible:ring-green-600',
            'emerald'   => 'hover:bg-emerald-100 focus-visible:ring-emerald-400 dark:hover:bg-emerald-800 dark:focus-visible:ring-emerald-600',
            'teal'      => 'hover:bg-teal-100 focus-visible:ring-teal-400 dark:hover:bg-teal-800 dark:focus-visible:ring-teal-600',
            'cyan'      => 'hover:bg-cyan-100 focus-visible:ring-cyan-400 dark:hover:bg-cyan-800 dark:focus-visible:ring-cyan-600',
            'sky'       => 'hover:bg-sky-100 focus-visible:ring-sky-400 dark:hover:bg-sky-800 dark:focus-visible:ring-sky-600',
            'blue'      => 'hover:bg-blue-100 focus-visible:ring-blue-400 dark:hover:bg-blue-800 dark:focus-visible:ring-blue-600',
            'indigo'    => 'hover:bg-indigo-100 focus-visible:ring-indigo-400 dark:hover:bg-indigo-800 dark:focus-visible:ring-indigo-600',
            'violet'    => 'hover:bg-violet-100 focus-visible:ring-violet-400 dark:hover:bg-violet-800 dark:focus-visible:ring-violet-600',
            'purple'    => 'hover:bg-purple-100 focus-visible:ring-purple-400 dark:hover:bg-purple-800 dark:focus-visible:ring-purple-600',
            'fuchsia'   => 'hover:bg-fuchsia-100 focus-visible:ring-fuchsia-400 dark:hover:bg-fuchsia-800 dark:focus-visible:ring-fuchsia-600',
            'pink'      => 'hover:bg-pink-100 focus-visible:ring-pink-400 dark:hover:bg-pink-800 dark:focus-visible:ring-pink-600',
            'rose'      => 'hover:bg-rose-100 focus-visible:ring-rose-400 dark:hover:bg-rose-800 dark:focus-visible:ring-rose-600',
            'taupe'     => 'hover:bg-taupe-100 focus-visible:ring-taupe-400 dark:hover:bg-taupe-800 dark:focus-visible:ring-taupe-600',
            'mauve'     => 'hover:bg-mauve-100 focus-visible:ring-mauve-400 dark:hover:bg-mauve-800 dark:focus-visible:ring-mauve-600',
            'mist'      => 'hover:bg-mist-100 focus-visible:ring-mist-400 dark:hover:bg-mist-800 dark:focus-visible:ring-mist-600',
            'olive'     => 'hover:bg-olive-100 focus-visible:ring-olive-400 dark:hover:bg-olive-800 dark:focus-visible:ring-olive-600',
            'skin'      => 'hover:bg-skin-100 focus-visible:ring-skin-400 dark:hover:bg-skin-800 dark:focus-visible:ring-skin-600',
            'cyberpunk' => 'hover:bg-cyberpunk-100 focus-visible:ring-cyberpunk-400 dark:hover:bg-cyberpunk-800 dark:focus-visible:ring-cyberpunk-600',
            'fantasy'   => 'hover:bg-fantasy-100 focus-visible:ring-fantasy-400 dark:hover:bg-fantasy-800 dark:focus-visible:ring-fantasy-600',
            'wh40k'     => 'hover:bg-wh40k-100 focus-visible:ring-wh40k-400 dark:hover:bg-wh40k-800 dark:focus-visible:ring-wh40k-600',
        ];

        $onMap = [
            'slate'     => 'has-[:checked]:border-slate-600 has-[:checked]:bg-slate-600 has-[:checked]:text-white has-[:focus-visible]:ring-slate-400 dark:has-[:checked]:border-slate-400 dark:has-[:checked]:bg-slate-400 dark:has-[:checked]:text-slate-950 dark:has-[:focus-visible]:ring-slate-600',
            'gray'      => 'has-[:checked]:border-gray-600 has-[:checked]:bg-gray-600 has-[:checked]:text-white has-[:focus-visible]:ring-gray-400 dark:has-[:checked]:border-gray-400 dark:has-[:checked]:bg-gray-400 dark:has-[:checked]:text-gray-950 dark:has-[:focus-visible]:ring-gray-600',
            'zinc'      => 'has-[:checked]:border-zinc-600 has-[:checked]:bg-zinc-600 has-[:checked]:text-white has-[:focus-visible]:ring-zinc-400 dark:has-[:checked]:border-zinc-400 dark:has-[:checked]:bg-zinc-400 dark:has-[:checked]:text-zinc-950 dark:has-[:focus-visible]:ring-zinc-600',
            'neutral'   => 'has-[:checked]:border-neutral-600 has-[:checked]:bg-neutral-600 has-[:checked]:text-white has-[:focus-visible]:ring-neutral-400 dark:has-[:checked]:border-neutral-400 dark:has-[:checked]:bg-neutral-400 dark:has-[:checked]:text-neutral-950 dark:has-[:focus-visible]:ring-neutral-600',
            'stone'     => 'has-[:checked]:border-stone-600 has-[:checked]:bg-stone-600 has-[:checked]:text-white has-[:focus-visible]:ring-stone-400 dark:has-[:checked]:border-stone-400 dark:has-[:checked]:bg-stone-400 dark:has-[:checked]:text-stone-950 dark:has-[:focus-visible]:ring-stone-600',
            'red'       => 'has-[:checked]:border-red-600 has-[:checked]:bg-red-600 has-[:checked]:text-white has-[:focus-visible]:ring-red-400 dark:has-[:checked]:border-red-400 dark:has-[:checked]:bg-red-400 dark:has-[:checked]:text-red-950 dark:has-[:focus-visible]:ring-red-600',
            'orange'    => 'has-[:checked]:border-orange-600 has-[:checked]:bg-orange-600 has-[:checked]:text-white has-[:focus-visible]:ring-orange-400 dark:has-[:checked]:border-orange-400 dark:has-[:checked]:bg-orange-400 dark:has-[:checked]:text-orange-950 dark:has-[:focus-visible]:ring-orange-600',
            'amber'     => 'has-[:checked]:border-amber-600 has-[:checked]:bg-amber-600 has-[:checked]:text-white has-[:focus-visible]:ring-amber-400 dark:has-[:checked]:border-amber-400 dark:has-[:checked]:bg-amber-400 dark:has-[:checked]:text-amber-950 dark:has-[:focus-visible]:ring-amber-600',
            'yellow'    => 'has-[:checked]:border-yellow-600 has-[:checked]:bg-yellow-600 has-[:checked]:text-white has-[:focus-visible]:ring-yellow-400 dark:has-[:checked]:border-yellow-400 dark:has-[:checked]:bg-yellow-400 dark:has-[:checked]:text-yellow-950 dark:has-[:focus-visible]:ring-yellow-600',
            'lime'      => 'has-[:checked]:border-lime-600 has-[:checked]:bg-lime-600 has-[:checked]:text-white has-[:focus-visible]:ring-lime-400 dark:has-[:checked]:border-lime-400 dark:has-[:checked]:bg-lime-400 dark:has-[:checked]:text-lime-950 dark:has-[:focus-visible]:ring-lime-600',
            'green'     => 'has-[:checked]:border-green-600 has-[:checked]:bg-green-600 has-[:checked]:text-white has-[:focus-visible]:ring-green-400 dark:has-[:checked]:border-green-400 dark:has-[:checked]:bg-green-400 dark:has-[:checked]:text-green-950 dark:has-[:focus-visible]:ring-green-600',
            'emerald'   => 'has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-600 has-[:checked]:text-white has-[:focus-visible]:ring-emerald-400 dark:has-[:checked]:border-emerald-400 dark:has-[:checked]:bg-emerald-400 dark:has-[:checked]:text-emerald-950 dark:has-[:focus-visible]:ring-emerald-600',
            'teal'      => 'has-[:checked]:border-teal-600 has-[:checked]:bg-teal-600 has-[:checked]:text-white has-[:focus-visible]:ring-teal-400 dark:has-[:checked]:border-teal-400 dark:has-[:checked]:bg-teal-400 dark:has-[:checked]:text-teal-950 dark:has-[:focus-visible]:ring-teal-600',
            'cyan'      => 'has-[:checked]:border-cyan-600 has-[:checked]:bg-cyan-600 has-[:checked]:text-white has-[:focus-visible]:ring-cyan-400 dark:has-[:checked]:border-cyan-400 dark:has-[:checked]:bg-cyan-400 dark:has-[:checked]:text-cyan-950 dark:has-[:focus-visible]:ring-cyan-600',
            'sky'       => 'has-[:checked]:border-sky-600 has-[:checked]:bg-sky-600 has-[:checked]:text-white has-[:focus-visible]:ring-sky-400 dark:has-[:checked]:border-sky-400 dark:has-[:checked]:bg-sky-400 dark:has-[:checked]:text-sky-950 dark:has-[:focus-visible]:ring-sky-600',
            'blue'      => 'has-[:checked]:border-blue-600 has-[:checked]:bg-blue-600 has-[:checked]:text-white has-[:focus-visible]:ring-blue-400 dark:has-[:checked]:border-blue-400 dark:has-[:checked]:bg-blue-400 dark:has-[:checked]:text-blue-950 dark:has-[:focus-visible]:ring-blue-600',
            'indigo'    => 'has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-600 has-[:checked]:text-white has-[:focus-visible]:ring-indigo-400 dark:has-[:checked]:border-indigo-400 dark:has-[:checked]:bg-indigo-400 dark:has-[:checked]:text-indigo-950 dark:has-[:focus-visible]:ring-indigo-600',
            'violet'    => 'has-[:checked]:border-violet-600 has-[:checked]:bg-violet-600 has-[:checked]:text-white has-[:focus-visible]:ring-violet-400 dark:has-[:checked]:border-violet-400 dark:has-[:checked]:bg-violet-400 dark:has-[:checked]:text-violet-950 dark:has-[:focus-visible]:ring-violet-600',
            'purple'    => 'has-[:checked]:border-purple-600 has-[:checked]:bg-purple-600 has-[:checked]:text-white has-[:focus-visible]:ring-purple-400 dark:has-[:checked]:border-purple-400 dark:has-[:checked]:bg-purple-400 dark:has-[:checked]:text-purple-950 dark:has-[:focus-visible]:ring-purple-600',
            'fuchsia'   => 'has-[:checked]:border-fuchsia-600 has-[:checked]:bg-fuchsia-600 has-[:checked]:text-white has-[:focus-visible]:ring-fuchsia-400 dark:has-[:checked]:border-fuchsia-400 dark:has-[:checked]:bg-fuchsia-400 dark:has-[:checked]:text-fuchsia-950 dark:has-[:focus-visible]:ring-fuchsia-600',
            'pink'      => 'has-[:checked]:border-pink-600 has-[:checked]:bg-pink-600 has-[:checked]:text-white has-[:focus-visible]:ring-pink-400 dark:has-[:checked]:border-pink-400 dark:has-[:checked]:bg-pink-400 dark:has-[:checked]:text-pink-950 dark:has-[:focus-visible]:ring-pink-600',
            'rose'      => 'has-[:checked]:border-rose-600 has-[:checked]:bg-rose-600 has-[:checked]:text-white has-[:focus-visible]:ring-rose-400 dark:has-[:checked]:border-rose-400 dark:has-[:checked]:bg-rose-400 dark:has-[:checked]:text-rose-950 dark:has-[:focus-visible]:ring-rose-600',
            'taupe'     => 'has-[:checked]:border-taupe-600 has-[:checked]:bg-taupe-600 has-[:checked]:text-white has-[:focus-visible]:ring-taupe-400 dark:has-[:checked]:border-taupe-400 dark:has-[:checked]:bg-taupe-400 dark:has-[:checked]:text-taupe-950 dark:has-[:focus-visible]:ring-taupe-600',
            'mauve'     => 'has-[:checked]:border-mauve-600 has-[:checked]:bg-mauve-600 has-[:checked]:text-white has-[:focus-visible]:ring-mauve-400 dark:has-[:checked]:border-mauve-400 dark:has-[:checked]:bg-mauve-400 dark:has-[:checked]:text-mauve-950 dark:has-[:focus-visible]:ring-mauve-600',
            'mist'      => 'has-[:checked]:border-mist-600 has-[:checked]:bg-mist-600 has-[:checked]:text-white has-[:focus-visible]:ring-mist-400 dark:has-[:checked]:border-mist-400 dark:has-[:checked]:bg-mist-400 dark:has-[:checked]:text-mist-950 dark:has-[:focus-visible]:ring-mist-600',
            'olive'     => 'has-[:checked]:border-olive-600 has-[:checked]:bg-olive-600 has-[:checked]:text-white has-[:focus-visible]:ring-olive-400 dark:has-[:checked]:border-olive-400 dark:has-[:checked]:bg-olive-400 dark:has-[:checked]:text-olive-950 dark:has-[:focus-visible]:ring-olive-600',
            'skin'      => 'has-[:checked]:border-skin-600 has-[:checked]:bg-skin-600 has-[:checked]:text-white has-[:focus-visible]:ring-skin-400 dark:has-[:checked]:border-skin-400 dark:has-[:checked]:bg-skin-400 dark:has-[:checked]:text-skin-950 dark:has-[:focus-visible]:ring-skin-600',
            'cyberpunk' => 'has-[:checked]:border-cyberpunk-600 has-[:checked]:bg-cyberpunk-600 has-[:checked]:text-white has-[:focus-visible]:ring-cyberpunk-400 dark:has-[:checked]:border-cyberpunk-400 dark:has-[:checked]:bg-cyberpunk-400 dark:has-[:checked]:text-cyberpunk-950 dark:has-[:focus-visible]:ring-cyberpunk-600',
            'fantasy'   => 'has-[:checked]:border-fantasy-600 has-[:checked]:bg-fantasy-600 has-[:checked]:text-white has-[:focus-visible]:ring-fantasy-400 dark:has-[:checked]:border-fantasy-400 dark:has-[:checked]:bg-fantasy-400 dark:has-[:checked]:text-fantasy-950 dark:has-[:focus-visible]:ring-fantasy-600',
            'wh40k'     => 'has-[:checked]:border-wh40k-600 has-[:checked]:bg-wh40k-600 has-[:checked]:text-white has-[:focus-visible]:ring-wh40k-400 dark:has-[:checked]:border-wh40k-400 dark:has-[:checked]:bg-wh40k-400 dark:has-[:checked]:text-wh40k-950 dark:has-[:focus-visible]:ring-wh40k-600',
        ];

        $countMap = [
            'slate'     => 'bg-slate-200 text-slate-800 dark:bg-slate-800 dark:text-slate-200',
            'gray'      => 'bg-gray-200 text-gray-800 dark:bg-gray-800 dark:text-gray-200',
            'zinc'      => 'bg-zinc-200 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-200',
            'neutral'   => 'bg-neutral-200 text-neutral-800 dark:bg-neutral-800 dark:text-neutral-200',
            'stone'     => 'bg-stone-200 text-stone-800 dark:bg-stone-800 dark:text-stone-200',
            'red'       => 'bg-red-200 text-red-800 dark:bg-red-800 dark:text-red-200',
            'orange'    => 'bg-orange-200 text-orange-800 dark:bg-orange-800 dark:text-orange-200',
            'amber'     => 'bg-amber-200 text-amber-800 dark:bg-amber-800 dark:text-amber-200',
            'yellow'    => 'bg-yellow-200 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-200',
            'lime'      => 'bg-lime-200 text-lime-800 dark:bg-lime-800 dark:text-lime-200',
            'green'     => 'bg-green-200 text-green-800 dark:bg-green-800 dark:text-green-200',
            'emerald'   => 'bg-emerald-200 text-emerald-800 dark:bg-emerald-800 dark:text-emerald-200',
            'teal'      => 'bg-teal-200 text-teal-800 dark:bg-teal-800 dark:text-teal-200',
            'cyan'      => 'bg-cyan-200 text-cyan-800 dark:bg-cyan-800 dark:text-cyan-200',
            'sky'       => 'bg-sky-200 text-sky-800 dark:bg-sky-800 dark:text-sky-200',
            'blue'      => 'bg-blue-200 text-blue-800 dark:bg-blue-800 dark:text-blue-200',
            'indigo'    => 'bg-indigo-200 text-indigo-800 dark:bg-indigo-800 dark:text-indigo-200',
            'violet'    => 'bg-violet-200 text-violet-800 dark:bg-violet-800 dark:text-violet-200',
            'purple'    => 'bg-purple-200 text-purple-800 dark:bg-purple-800 dark:text-purple-200',
            'fuchsia'   => 'bg-fuchsia-200 text-fuchsia-800 dark:bg-fuchsia-800 dark:text-fuchsia-200',
            'pink'      => 'bg-pink-200 text-pink-800 dark:bg-pink-800 dark:text-pink-200',
            'rose'      => 'bg-rose-200 text-rose-800 dark:bg-rose-800 dark:text-rose-200',
            'taupe'     => 'bg-taupe-200 text-taupe-800 dark:bg-taupe-800 dark:text-taupe-200',
            'mauve'     => 'bg-mauve-200 text-mauve-800 dark:bg-mauve-800 dark:text-mauve-200',
            'mist'      => 'bg-mist-200 text-mist-800 dark:bg-mist-800 dark:text-mist-200',
            'olive'     => 'bg-olive-200 text-olive-800 dark:bg-olive-800 dark:text-olive-200',
            'skin'      => 'bg-skin-200 text-skin-800 dark:bg-skin-800 dark:text-skin-200',
            'cyberpunk' => 'bg-cyberpunk-200 text-cyberpunk-800 dark:bg-cyberpunk-800 dark:text-cyberpunk-200',
            'fantasy'   => 'bg-fantasy-200 text-fantasy-800 dark:bg-fantasy-800 dark:text-fantasy-200',
            'wh40k'     => 'bg-wh40k-200 text-wh40k-800 dark:bg-wh40k-800 dark:text-wh40k-200',
        ];

        $removeMap = [
            'slate'     => 'hover:bg-slate-200 focus-visible:ring-slate-400 dark:hover:bg-slate-700 dark:focus-visible:ring-slate-600',
            'gray'      => 'hover:bg-gray-200 focus-visible:ring-gray-400 dark:hover:bg-gray-700 dark:focus-visible:ring-gray-600',
            'zinc'      => 'hover:bg-zinc-200 focus-visible:ring-zinc-400 dark:hover:bg-zinc-700 dark:focus-visible:ring-zinc-600',
            'neutral'   => 'hover:bg-neutral-200 focus-visible:ring-neutral-400 dark:hover:bg-neutral-700 dark:focus-visible:ring-neutral-600',
            'stone'     => 'hover:bg-stone-200 focus-visible:ring-stone-400 dark:hover:bg-stone-700 dark:focus-visible:ring-stone-600',
            'red'       => 'hover:bg-red-200 focus-visible:ring-red-400 dark:hover:bg-red-700 dark:focus-visible:ring-red-600',
            'orange'    => 'hover:bg-orange-200 focus-visible:ring-orange-400 dark:hover:bg-orange-700 dark:focus-visible:ring-orange-600',
            'amber'     => 'hover:bg-amber-200 focus-visible:ring-amber-400 dark:hover:bg-amber-700 dark:focus-visible:ring-amber-600',
            'yellow'    => 'hover:bg-yellow-200 focus-visible:ring-yellow-400 dark:hover:bg-yellow-700 dark:focus-visible:ring-yellow-600',
            'lime'      => 'hover:bg-lime-200 focus-visible:ring-lime-400 dark:hover:bg-lime-700 dark:focus-visible:ring-lime-600',
            'green'     => 'hover:bg-green-200 focus-visible:ring-green-400 dark:hover:bg-green-700 dark:focus-visible:ring-green-600',
            'emerald'   => 'hover:bg-emerald-200 focus-visible:ring-emerald-400 dark:hover:bg-emerald-700 dark:focus-visible:ring-emerald-600',
            'teal'      => 'hover:bg-teal-200 focus-visible:ring-teal-400 dark:hover:bg-teal-700 dark:focus-visible:ring-teal-600',
            'cyan'      => 'hover:bg-cyan-200 focus-visible:ring-cyan-400 dark:hover:bg-cyan-700 dark:focus-visible:ring-cyan-600',
            'sky'       => 'hover:bg-sky-200 focus-visible:ring-sky-400 dark:hover:bg-sky-700 dark:focus-visible:ring-sky-600',
            'blue'      => 'hover:bg-blue-200 focus-visible:ring-blue-400 dark:hover:bg-blue-700 dark:focus-visible:ring-blue-600',
            'indigo'    => 'hover:bg-indigo-200 focus-visible:ring-indigo-400 dark:hover:bg-indigo-700 dark:focus-visible:ring-indigo-600',
            'violet'    => 'hover:bg-violet-200 focus-visible:ring-violet-400 dark:hover:bg-violet-700 dark:focus-visible:ring-violet-600',
            'purple'    => 'hover:bg-purple-200 focus-visible:ring-purple-400 dark:hover:bg-purple-700 dark:focus-visible:ring-purple-600',
            'fuchsia'   => 'hover:bg-fuchsia-200 focus-visible:ring-fuchsia-400 dark:hover:bg-fuchsia-700 dark:focus-visible:ring-fuchsia-600',
            'pink'      => 'hover:bg-pink-200 focus-visible:ring-pink-400 dark:hover:bg-pink-700 dark:focus-visible:ring-pink-600',
            'rose'      => 'hover:bg-rose-200 focus-visible:ring-rose-400 dark:hover:bg-rose-700 dark:focus-visible:ring-rose-600',
            'taupe'     => 'hover:bg-taupe-200 focus-visible:ring-taupe-400 dark:hover:bg-taupe-700 dark:focus-visible:ring-taupe-600',
            'mauve'     => 'hover:bg-mauve-200 focus-visible:ring-mauve-400 dark:hover:bg-mauve-700 dark:focus-visible:ring-mauve-600',
            'mist'      => 'hover:bg-mist-200 focus-visible:ring-mist-400 dark:hover:bg-mist-700 dark:focus-visible:ring-mist-600',
            'olive'     => 'hover:bg-olive-200 focus-visible:ring-olive-400 dark:hover:bg-olive-700 dark:focus-visible:ring-olive-600',
            'skin'      => 'hover:bg-skin-200 focus-visible:ring-skin-400 dark:hover:bg-skin-700 dark:focus-visible:ring-skin-600',
            'cyberpunk' => 'hover:bg-cyberpunk-200 focus-visible:ring-cyberpunk-400 dark:hover:bg-cyberpunk-700 dark:focus-visible:ring-cyberpunk-600',
            'fantasy'   => 'hover:bg-fantasy-200 focus-visible:ring-fantasy-400 dark:hover:bg-fantasy-700 dark:focus-visible:ring-fantasy-600',
            'wh40k'     => 'hover:bg-wh40k-200 focus-visible:ring-wh40k-400 dark:hover:bg-wh40k-700 dark:focus-visible:ring-wh40k-600',
        ];

        $this->tag = match (true) {
            $variant === 'toggle' => 'label',
            $href !== '' => 'a',
            default => 'span',
        };

        $this->classList = trim(implode(' ', [
            'inline-flex items-center gap-1 rounded-md border px-2.5 py-1 text-xs font-medium',
            static::surface($theme),
            match ($this->tag) {
                'a' => 'cursor-pointer transition focus:outline-none focus-visible:ring-2 '.($linkMap[$theme] ?? $linkMap['slate']),
                'label' => 'cursor-pointer select-none transition has-[:focus-visible]:ring-2 '.($linkMap[$theme] ?? $linkMap['slate']).' '.($onMap[$theme] ?? $onMap['slate']),
                default => '',
            },
        ]));

        $this->countClasses = 'ml-0.5 rounded-full px-1.5 text-[0.7rem] leading-4 tabular-nums '.($countMap[$theme] ?? $countMap['slate']);
        $this->removeClasses = '-mr-1 ml-0.5 inline-flex h-4 w-4 cursor-pointer items-center justify-center rounded transition focus:outline-none focus-visible:ring-2 '.($removeMap[$theme] ?? $removeMap['slate']);

        if ($this->removeLabel === '') {
            $this->removeLabel = __('Remove');
        }
    }

    /**
     * The badge surface: border, tinted fill and text. Shared with x-fltc::status.
     */
    public static function surface(string $theme): string
    {
        $themeMap = [
            'slate'   => 'border-slate-200 bg-slate-50 text-slate-700 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300',
            'gray'    => 'border-gray-200 bg-gray-50 text-gray-700 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300',
            'zinc'    => 'border-zinc-200 bg-zinc-50 text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300',
            'neutral' => 'border-neutral-200 bg-neutral-50 text-neutral-700 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300',
            'stone'   => 'border-stone-200 bg-stone-50 text-stone-700 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-300',
            'red'     => 'border-red-200 bg-red-50 text-red-700 dark:border-red-800 dark:bg-red-950 dark:text-red-300',
            'orange'  => 'border-orange-200 bg-orange-50 text-orange-700 dark:border-orange-800 dark:bg-orange-950 dark:text-orange-300',
            'amber'   => 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-800 dark:bg-amber-950 dark:text-amber-300',
            'yellow'  => 'border-yellow-200 bg-yellow-50 text-yellow-700 dark:border-yellow-800 dark:bg-yellow-950 dark:text-yellow-300',
            'lime'    => 'border-lime-200 bg-lime-50 text-lime-700 dark:border-lime-800 dark:bg-lime-950 dark:text-lime-300',
            'green'   => 'border-green-200 bg-green-50 text-green-700 dark:border-green-800 dark:bg-green-950 dark:text-green-300',
            'emerald' => 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-300',
            'teal'    => 'border-teal-200 bg-teal-50 text-teal-700 dark:border-teal-800 dark:bg-teal-950 dark:text-teal-300',
            'cyan'    => 'border-cyan-200 bg-cyan-50 text-cyan-700 dark:border-cyan-800 dark:bg-cyan-950 dark:text-cyan-300',
            'sky'     => 'border-sky-200 bg-sky-50 text-sky-700 dark:border-sky-800 dark:bg-sky-950 dark:text-sky-300',
            'blue'    => 'border-blue-200 bg-blue-50 text-blue-700 dark:border-blue-800 dark:bg-blue-950 dark:text-blue-300',
            'indigo'  => 'border-indigo-200 bg-indigo-50 text-indigo-700 dark:border-indigo-800 dark:bg-indigo-950 dark:text-indigo-300',
            'violet'  => 'border-violet-200 bg-violet-50 text-violet-700 dark:border-violet-800 dark:bg-violet-950 dark:text-violet-300',
            'purple'  => 'border-purple-200 bg-purple-50 text-purple-700 dark:border-purple-800 dark:bg-purple-950 dark:text-purple-300',
            'fuchsia' => 'border-fuchsia-200 bg-fuchsia-50 text-fuchsia-700 dark:border-fuchsia-800 dark:bg-fuchsia-950 dark:text-fuchsia-300',
            'pink'    => 'border-pink-200 bg-pink-50 text-pink-700 dark:border-pink-800 dark:bg-pink-950 dark:text-pink-300',
            'rose'    => 'border-rose-200 bg-rose-50 text-rose-700 dark:border-rose-800 dark:bg-rose-950 dark:text-rose-300',
            'taupe'   => 'border-taupe-200 bg-taupe-50 text-taupe-700 dark:border-taupe-800 dark:bg-taupe-950 dark:text-taupe-300',
            'mauve'   => 'border-mauve-200 bg-mauve-50 text-mauve-700 dark:border-mauve-800 dark:bg-mauve-950 dark:text-mauve-300',
            'mist'    => 'border-mist-200 bg-mist-50 text-mist-700 dark:border-mist-800 dark:bg-mist-950 dark:text-mist-300',
            'olive'   => 'border-olive-200 bg-olive-50 text-olive-700 dark:border-olive-800 dark:bg-olive-950 dark:text-olive-300',
            'skin'    => 'border-skin-200 bg-skin-50 text-skin-700 dark:border-skin-800 dark:bg-skin-950 dark:text-skin-300',
            'cyberpunk' => 'border-cyberpunk-200 bg-cyberpunk-50 text-cyberpunk-700 dark:border-cyberpunk-800 dark:bg-cyberpunk-950 dark:text-cyberpunk-300',
            'fantasy' => 'border-fantasy-200 bg-fantasy-50 text-fantasy-700 dark:border-fantasy-800 dark:bg-fantasy-950 dark:text-fantasy-300',
            'wh40k'   => 'border-wh40k-200 bg-wh40k-50 text-wh40k-700 dark:border-wh40k-800 dark:bg-wh40k-950 dark:text-wh40k-300',
        ];

        return $themeMap[$theme] ?? $themeMap['slate'];
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.badge');
    }
}
