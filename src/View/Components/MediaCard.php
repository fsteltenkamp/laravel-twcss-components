<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * A card for a book, story or other media item, with slots for cover, title, meta,
 * badges, footer and actions. `layout` is card / compact / list; it is rendered as
 * data-layout and every region styles itself per layout through group-data variants,
 * so the layout can also switch on the client: x-bind:data-layout="layout" (e.g.
 * from an x-fltc::segmented control) re-lays the cards without a re-render.
 */
class MediaCard extends Component
{
    public const LAYOUTS = ['card', 'compact', 'list'];

    public string $classList;
    public string $coverClasses;
    public string $bodyClasses;
    public string $titleClasses;
    public string $metaClasses;
    public string $badgesClasses;
    public string $footerClasses;
    public string $actionsClasses;

    public function __construct(
        public string $layout = 'card',
        public string $href = '',
        public string $color = 'base',
    ) {
        $this->layout = in_array($layout, static::LAYOUTS, true) ? $layout : 'card';

            $surfaceMap = [
                'slate'     => 'border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900',
                'gray'      => 'border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900',
                'zinc'      => 'border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900',
                'neutral'   => 'border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900',
                'stone'     => 'border-stone-200 bg-white dark:border-stone-700 dark:bg-stone-900',
                'red'       => 'border-red-200 bg-white dark:border-red-700 dark:bg-red-900',
                'orange'    => 'border-orange-200 bg-white dark:border-orange-700 dark:bg-orange-900',
                'amber'     => 'border-amber-200 bg-white dark:border-amber-700 dark:bg-amber-900',
                'yellow'    => 'border-yellow-200 bg-white dark:border-yellow-700 dark:bg-yellow-900',
                'lime'      => 'border-lime-200 bg-white dark:border-lime-700 dark:bg-lime-900',
                'green'     => 'border-green-200 bg-white dark:border-green-700 dark:bg-green-900',
                'emerald'   => 'border-emerald-200 bg-white dark:border-emerald-700 dark:bg-emerald-900',
                'teal'      => 'border-teal-200 bg-white dark:border-teal-700 dark:bg-teal-900',
                'cyan'      => 'border-cyan-200 bg-white dark:border-cyan-700 dark:bg-cyan-900',
                'sky'       => 'border-sky-200 bg-white dark:border-sky-700 dark:bg-sky-900',
                'blue'      => 'border-blue-200 bg-white dark:border-blue-700 dark:bg-blue-900',
                'indigo'    => 'border-indigo-200 bg-white dark:border-indigo-700 dark:bg-indigo-900',
                'violet'    => 'border-violet-200 bg-white dark:border-violet-700 dark:bg-violet-900',
                'purple'    => 'border-purple-200 bg-white dark:border-purple-700 dark:bg-purple-900',
                'fuchsia'   => 'border-fuchsia-200 bg-white dark:border-fuchsia-700 dark:bg-fuchsia-900',
                'pink'      => 'border-pink-200 bg-white dark:border-pink-700 dark:bg-pink-900',
                'rose'      => 'border-rose-200 bg-white dark:border-rose-700 dark:bg-rose-900',
                'taupe'     => 'border-taupe-200 bg-white dark:border-taupe-700 dark:bg-taupe-900',
                'mauve'     => 'border-mauve-200 bg-white dark:border-mauve-700 dark:bg-mauve-900',
                'mist'      => 'border-mist-200 bg-white dark:border-mist-700 dark:bg-mist-900',
                'olive'     => 'border-olive-200 bg-white dark:border-olive-700 dark:bg-olive-900',
                'primary'      => 'border-primary-200 bg-white dark:border-primary-700 dark:bg-primary-900',
                'secondary'    => 'border-secondary-200 bg-white dark:border-secondary-700 dark:bg-secondary-900',
                'accent'       => 'border-accent-200 bg-white dark:border-accent-700 dark:bg-accent-900',
                'base'         => 'border-base-200 bg-white dark:border-base-700 dark:bg-base-900',
                'info'         => 'border-info-200 bg-white dark:border-info-700 dark:bg-info-900',
                'success'      => 'border-success-200 bg-white dark:border-success-700 dark:bg-success-900',
                'warning'      => 'border-warning-200 bg-white dark:border-warning-700 dark:bg-warning-900',
                'danger'       => 'border-danger-200 bg-white dark:border-danger-700 dark:bg-danger-900',
            ];

            $hoverMap = [
                'slate'     => 'hover:border-slate-300 hover:shadow-md dark:hover:border-slate-600',
                'gray'      => 'hover:border-gray-300 hover:shadow-md dark:hover:border-gray-600',
                'zinc'      => 'hover:border-zinc-300 hover:shadow-md dark:hover:border-zinc-600',
                'neutral'   => 'hover:border-neutral-300 hover:shadow-md dark:hover:border-neutral-600',
                'stone'     => 'hover:border-stone-300 hover:shadow-md dark:hover:border-stone-600',
                'red'       => 'hover:border-red-300 hover:shadow-md dark:hover:border-red-600',
                'orange'    => 'hover:border-orange-300 hover:shadow-md dark:hover:border-orange-600',
                'amber'     => 'hover:border-amber-300 hover:shadow-md dark:hover:border-amber-600',
                'yellow'    => 'hover:border-yellow-300 hover:shadow-md dark:hover:border-yellow-600',
                'lime'      => 'hover:border-lime-300 hover:shadow-md dark:hover:border-lime-600',
                'green'     => 'hover:border-green-300 hover:shadow-md dark:hover:border-green-600',
                'emerald'   => 'hover:border-emerald-300 hover:shadow-md dark:hover:border-emerald-600',
                'teal'      => 'hover:border-teal-300 hover:shadow-md dark:hover:border-teal-600',
                'cyan'      => 'hover:border-cyan-300 hover:shadow-md dark:hover:border-cyan-600',
                'sky'       => 'hover:border-sky-300 hover:shadow-md dark:hover:border-sky-600',
                'blue'      => 'hover:border-blue-300 hover:shadow-md dark:hover:border-blue-600',
                'indigo'    => 'hover:border-indigo-300 hover:shadow-md dark:hover:border-indigo-600',
                'violet'    => 'hover:border-violet-300 hover:shadow-md dark:hover:border-violet-600',
                'purple'    => 'hover:border-purple-300 hover:shadow-md dark:hover:border-purple-600',
                'fuchsia'   => 'hover:border-fuchsia-300 hover:shadow-md dark:hover:border-fuchsia-600',
                'pink'      => 'hover:border-pink-300 hover:shadow-md dark:hover:border-pink-600',
                'rose'      => 'hover:border-rose-300 hover:shadow-md dark:hover:border-rose-600',
                'taupe'     => 'hover:border-taupe-300 hover:shadow-md dark:hover:border-taupe-600',
                'mauve'     => 'hover:border-mauve-300 hover:shadow-md dark:hover:border-mauve-600',
                'mist'      => 'hover:border-mist-300 hover:shadow-md dark:hover:border-mist-600',
                'olive'     => 'hover:border-olive-300 hover:shadow-md dark:hover:border-olive-600',
                'primary'      => 'hover:border-primary-300 hover:shadow-md dark:hover:border-primary-600',
                'secondary'    => 'hover:border-secondary-300 hover:shadow-md dark:hover:border-secondary-600',
                'accent'       => 'hover:border-accent-300 hover:shadow-md dark:hover:border-accent-600',
                'base'         => 'hover:border-base-300 hover:shadow-md dark:hover:border-base-600',
                'info'         => 'hover:border-info-300 hover:shadow-md dark:hover:border-info-600',
                'success'      => 'hover:border-success-300 hover:shadow-md dark:hover:border-success-600',
                'warning'      => 'hover:border-warning-300 hover:shadow-md dark:hover:border-warning-600',
                'danger'       => 'hover:border-danger-300 hover:shadow-md dark:hover:border-danger-600',
            ];

        $this->classList = trim(implode(' ', [
            'group/media relative flex overflow-hidden rounded-xl border shadow-sm transition',
            'data-[layout=card]:flex-col',
            'data-[layout=compact]:items-center data-[layout=compact]:gap-3 data-[layout=compact]:p-2',
            'data-[layout=list]:gap-4 data-[layout=list]:p-3',
            $surfaceMap[$color] ?? $surfaceMap['base'],
            $href !== '' ? ($hoverMap[$color] ?? $hoverMap['base']) : '',
        ]));

        $this->coverClasses = 'shrink-0 group-data-[layout=card]/media:w-full group-data-[layout=card]/media:[&_.fltc-cover]:rounded-none group-data-[layout=compact]/media:w-12 group-data-[layout=list]/media:w-20 sm:group-data-[layout=list]/media:w-24';
        $this->bodyClasses = 'flex min-w-0 flex-1 flex-col gap-1 group-data-[layout=card]/media:p-4';
        $this->titleClasses = 'font-semibold leading-snug '.Shades::primary($color).' group-data-[layout=compact]/media:truncate group-data-[layout=compact]/media:text-sm';
        $this->metaClasses = 'text-xs '.Shades::tertiary($color).' group-data-[layout=compact]/media:truncate';
        $this->badgesClasses = 'mt-1 flex flex-wrap gap-1 group-data-[layout=compact]/media:hidden';
        $this->footerClasses = 'mt-auto pt-2 text-sm '.Shades::secondary($color).' group-data-[layout=compact]/media:hidden';
        $this->actionsClasses = 'relative z-10 flex shrink-0 items-center gap-1 group-data-[layout=card]/media:absolute group-data-[layout=card]/media:right-2 group-data-[layout=card]/media:top-2';
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.media-card');
    }
}
