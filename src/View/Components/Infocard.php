<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\Support\SidebarTheme;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * Context for a term in running text (a character, a place). Hovering the trigger
 * on a pointer device shows a small floating preview; clicking or tapping unfolds the
 * full card inline below it. The card has a title, icon, image, the default slot as
 * body, a link and an `actions` slot.
 */
class Infocard extends Component
{
    public string $classList;
    public string $triggerClasses;
    public string $previewClasses;
    public string $cardClasses;
    public string $titleClasses;
    public string $bodyClasses;
    public string $linkClasses;

    public function __construct(
        public string $title = '',
        public string $icon = '',
        public string $image = '',
        public string $href = '',
        public string $linkLabel = '',
        public bool $preview = true,
        public string $color = 'base',
    ) {
        $triggerMap = [
            'slate'     => 'decoration-slate-400 hover:decoration-slate-600 focus-visible:ring-slate-400 dark:decoration-slate-500 dark:hover:decoration-slate-300 dark:focus-visible:ring-slate-600',
            'gray'      => 'decoration-gray-400 hover:decoration-gray-600 focus-visible:ring-gray-400 dark:decoration-gray-500 dark:hover:decoration-gray-300 dark:focus-visible:ring-gray-600',
            'zinc'      => 'decoration-zinc-400 hover:decoration-zinc-600 focus-visible:ring-zinc-400 dark:decoration-zinc-500 dark:hover:decoration-zinc-300 dark:focus-visible:ring-zinc-600',
            'neutral'   => 'decoration-neutral-400 hover:decoration-neutral-600 focus-visible:ring-neutral-400 dark:decoration-neutral-500 dark:hover:decoration-neutral-300 dark:focus-visible:ring-neutral-600',
            'stone'     => 'decoration-stone-400 hover:decoration-stone-600 focus-visible:ring-stone-400 dark:decoration-stone-500 dark:hover:decoration-stone-300 dark:focus-visible:ring-stone-600',
            'red'       => 'decoration-red-400 hover:decoration-red-600 focus-visible:ring-red-400 dark:decoration-red-500 dark:hover:decoration-red-300 dark:focus-visible:ring-red-600',
            'orange'    => 'decoration-orange-400 hover:decoration-orange-600 focus-visible:ring-orange-400 dark:decoration-orange-500 dark:hover:decoration-orange-300 dark:focus-visible:ring-orange-600',
            'amber'     => 'decoration-amber-400 hover:decoration-amber-600 focus-visible:ring-amber-400 dark:decoration-amber-500 dark:hover:decoration-amber-300 dark:focus-visible:ring-amber-600',
            'yellow'    => 'decoration-yellow-400 hover:decoration-yellow-600 focus-visible:ring-yellow-400 dark:decoration-yellow-500 dark:hover:decoration-yellow-300 dark:focus-visible:ring-yellow-600',
            'lime'      => 'decoration-lime-400 hover:decoration-lime-600 focus-visible:ring-lime-400 dark:decoration-lime-500 dark:hover:decoration-lime-300 dark:focus-visible:ring-lime-600',
            'green'     => 'decoration-green-400 hover:decoration-green-600 focus-visible:ring-green-400 dark:decoration-green-500 dark:hover:decoration-green-300 dark:focus-visible:ring-green-600',
            'emerald'   => 'decoration-emerald-400 hover:decoration-emerald-600 focus-visible:ring-emerald-400 dark:decoration-emerald-500 dark:hover:decoration-emerald-300 dark:focus-visible:ring-emerald-600',
            'teal'      => 'decoration-teal-400 hover:decoration-teal-600 focus-visible:ring-teal-400 dark:decoration-teal-500 dark:hover:decoration-teal-300 dark:focus-visible:ring-teal-600',
            'cyan'      => 'decoration-cyan-400 hover:decoration-cyan-600 focus-visible:ring-cyan-400 dark:decoration-cyan-500 dark:hover:decoration-cyan-300 dark:focus-visible:ring-cyan-600',
            'sky'       => 'decoration-sky-400 hover:decoration-sky-600 focus-visible:ring-sky-400 dark:decoration-sky-500 dark:hover:decoration-sky-300 dark:focus-visible:ring-sky-600',
            'blue'      => 'decoration-blue-400 hover:decoration-blue-600 focus-visible:ring-blue-400 dark:decoration-blue-500 dark:hover:decoration-blue-300 dark:focus-visible:ring-blue-600',
            'indigo'    => 'decoration-indigo-400 hover:decoration-indigo-600 focus-visible:ring-indigo-400 dark:decoration-indigo-500 dark:hover:decoration-indigo-300 dark:focus-visible:ring-indigo-600',
            'violet'    => 'decoration-violet-400 hover:decoration-violet-600 focus-visible:ring-violet-400 dark:decoration-violet-500 dark:hover:decoration-violet-300 dark:focus-visible:ring-violet-600',
            'purple'    => 'decoration-purple-400 hover:decoration-purple-600 focus-visible:ring-purple-400 dark:decoration-purple-500 dark:hover:decoration-purple-300 dark:focus-visible:ring-purple-600',
            'fuchsia'   => 'decoration-fuchsia-400 hover:decoration-fuchsia-600 focus-visible:ring-fuchsia-400 dark:decoration-fuchsia-500 dark:hover:decoration-fuchsia-300 dark:focus-visible:ring-fuchsia-600',
            'pink'      => 'decoration-pink-400 hover:decoration-pink-600 focus-visible:ring-pink-400 dark:decoration-pink-500 dark:hover:decoration-pink-300 dark:focus-visible:ring-pink-600',
            'rose'      => 'decoration-rose-400 hover:decoration-rose-600 focus-visible:ring-rose-400 dark:decoration-rose-500 dark:hover:decoration-rose-300 dark:focus-visible:ring-rose-600',
            'taupe'     => 'decoration-taupe-400 hover:decoration-taupe-600 focus-visible:ring-taupe-400 dark:decoration-taupe-500 dark:hover:decoration-taupe-300 dark:focus-visible:ring-taupe-600',
            'mauve'     => 'decoration-mauve-400 hover:decoration-mauve-600 focus-visible:ring-mauve-400 dark:decoration-mauve-500 dark:hover:decoration-mauve-300 dark:focus-visible:ring-mauve-600',
            'mist'      => 'decoration-mist-400 hover:decoration-mist-600 focus-visible:ring-mist-400 dark:decoration-mist-500 dark:hover:decoration-mist-300 dark:focus-visible:ring-mist-600',
            'olive'     => 'decoration-olive-400 hover:decoration-olive-600 focus-visible:ring-olive-400 dark:decoration-olive-500 dark:hover:decoration-olive-300 dark:focus-visible:ring-olive-600',
            'primary'      => 'decoration-primary-400 hover:decoration-primary-600 focus-visible:ring-primary-400 dark:decoration-primary-500 dark:hover:decoration-primary-300 dark:focus-visible:ring-primary-600',
            'secondary'    => 'decoration-secondary-400 hover:decoration-secondary-600 focus-visible:ring-secondary-400 dark:decoration-secondary-500 dark:hover:decoration-secondary-300 dark:focus-visible:ring-secondary-600',
            'accent'       => 'decoration-accent-400 hover:decoration-accent-600 focus-visible:ring-accent-400 dark:decoration-accent-500 dark:hover:decoration-accent-300 dark:focus-visible:ring-accent-600',
            'base'         => 'decoration-base-400 hover:decoration-base-600 focus-visible:ring-base-400 dark:decoration-base-500 dark:hover:decoration-base-300 dark:focus-visible:ring-base-600',
            'info'         => 'decoration-info-400 hover:decoration-info-600 focus-visible:ring-info-400 dark:decoration-info-500 dark:hover:decoration-info-300 dark:focus-visible:ring-info-600',
            'success'      => 'decoration-success-400 hover:decoration-success-600 focus-visible:ring-success-400 dark:decoration-success-500 dark:hover:decoration-success-300 dark:focus-visible:ring-success-600',
            'warning'      => 'decoration-warning-400 hover:decoration-warning-600 focus-visible:ring-warning-400 dark:decoration-warning-500 dark:hover:decoration-warning-300 dark:focus-visible:ring-warning-600',
            'danger'       => 'decoration-danger-400 hover:decoration-danger-600 focus-visible:ring-danger-400 dark:decoration-danger-500 dark:hover:decoration-danger-300 dark:focus-visible:ring-danger-600',
        ];

        $linkMap = [
            'slate'     => 'text-slate-700 hover:text-slate-900 dark:text-slate-300 dark:hover:text-slate-100',
            'gray'      => 'text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100',
            'zinc'      => 'text-zinc-700 hover:text-zinc-900 dark:text-zinc-300 dark:hover:text-zinc-100',
            'neutral'   => 'text-neutral-700 hover:text-neutral-900 dark:text-neutral-300 dark:hover:text-neutral-100',
            'stone'     => 'text-stone-700 hover:text-stone-900 dark:text-stone-300 dark:hover:text-stone-100',
            'red'       => 'text-red-700 hover:text-red-900 dark:text-red-300 dark:hover:text-red-100',
            'orange'    => 'text-orange-700 hover:text-orange-900 dark:text-orange-300 dark:hover:text-orange-100',
            'amber'     => 'text-amber-700 hover:text-amber-900 dark:text-amber-300 dark:hover:text-amber-100',
            'yellow'    => 'text-yellow-700 hover:text-yellow-900 dark:text-yellow-300 dark:hover:text-yellow-100',
            'lime'      => 'text-lime-700 hover:text-lime-900 dark:text-lime-300 dark:hover:text-lime-100',
            'green'     => 'text-green-700 hover:text-green-900 dark:text-green-300 dark:hover:text-green-100',
            'emerald'   => 'text-emerald-700 hover:text-emerald-900 dark:text-emerald-300 dark:hover:text-emerald-100',
            'teal'      => 'text-teal-700 hover:text-teal-900 dark:text-teal-300 dark:hover:text-teal-100',
            'cyan'      => 'text-cyan-700 hover:text-cyan-900 dark:text-cyan-300 dark:hover:text-cyan-100',
            'sky'       => 'text-sky-700 hover:text-sky-900 dark:text-sky-300 dark:hover:text-sky-100',
            'blue'      => 'text-blue-700 hover:text-blue-900 dark:text-blue-300 dark:hover:text-blue-100',
            'indigo'    => 'text-indigo-700 hover:text-indigo-900 dark:text-indigo-300 dark:hover:text-indigo-100',
            'violet'    => 'text-violet-700 hover:text-violet-900 dark:text-violet-300 dark:hover:text-violet-100',
            'purple'    => 'text-purple-700 hover:text-purple-900 dark:text-purple-300 dark:hover:text-purple-100',
            'fuchsia'   => 'text-fuchsia-700 hover:text-fuchsia-900 dark:text-fuchsia-300 dark:hover:text-fuchsia-100',
            'pink'      => 'text-pink-700 hover:text-pink-900 dark:text-pink-300 dark:hover:text-pink-100',
            'rose'      => 'text-rose-700 hover:text-rose-900 dark:text-rose-300 dark:hover:text-rose-100',
            'taupe'     => 'text-taupe-700 hover:text-taupe-900 dark:text-taupe-300 dark:hover:text-taupe-100',
            'mauve'     => 'text-mauve-700 hover:text-mauve-900 dark:text-mauve-300 dark:hover:text-mauve-100',
            'mist'      => 'text-mist-700 hover:text-mist-900 dark:text-mist-300 dark:hover:text-mist-100',
            'olive'     => 'text-olive-700 hover:text-olive-900 dark:text-olive-300 dark:hover:text-olive-100',
            'primary'      => 'text-primary-700 hover:text-primary-900 dark:text-primary-300 dark:hover:text-primary-100',
            'secondary'    => 'text-secondary-700 hover:text-secondary-900 dark:text-secondary-300 dark:hover:text-secondary-100',
            'accent'       => 'text-accent-700 hover:text-accent-900 dark:text-accent-300 dark:hover:text-accent-100',
            'base'         => 'text-base-700 hover:text-base-900 dark:text-base-300 dark:hover:text-base-100',
            'info'         => 'text-info-700 hover:text-info-900 dark:text-info-300 dark:hover:text-info-100',
            'success'      => 'text-success-700 hover:text-success-900 dark:text-success-300 dark:hover:text-success-100',
            'warning'      => 'text-warning-700 hover:text-warning-900 dark:text-warning-300 dark:hover:text-warning-100',
            'danger'       => 'text-danger-700 hover:text-danger-900 dark:text-danger-300 dark:hover:text-danger-100',
        ];

        $this->classList = 'relative';
        $this->triggerClasses = 'cursor-pointer rounded-sm underline decoration-dotted decoration-2 underline-offset-4 transition focus:outline-none focus-visible:ring-2 '.($triggerMap[$color] ?? $triggerMap['base']);
        $this->previewClasses = 'pointer-events-none absolute left-0 top-full z-30 mt-1 block w-64 overflow-hidden rounded-lg border text-left '.SidebarTheme::menu($color);
        $this->cardClasses = 'my-2 block w-full max-w-md overflow-hidden rounded-lg border text-left shadow-sm '.SidebarTheme::surface($color);
        $this->titleClasses = 'flex items-center gap-2 font-semibold '.Shades::primary($color);
        $this->bodyClasses = 'block text-sm '.Shades::secondary($color);
        $this->linkClasses = 'inline-flex items-center gap-1 text-sm font-medium underline-offset-2 hover:underline '.($linkMap[$color] ?? $linkMap['base']);

        if ($this->linkLabel === '') {
            $this->linkLabel = __('Read more');
        }
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.infocard');
    }
}
