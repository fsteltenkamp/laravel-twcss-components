<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Timeline;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * One entry of x-fltc::timeline: a dot (or an icon) on the line, a time, a title
 * (a link with `href`) and the default slot as its content.
 */
class Item extends Component
{
    public string $classList;
    public string $dotClasses;
    public string $timeClasses;
    public string $titleClasses;
    public string $bodyClasses;

    public function __construct(
        public string $time = '',
        public string $datetime = '',
        public string $title = '',
        public string $href = '',
        public string $icon = '',
        public ?string $color = null,
    ) {
        $this->color = $color ?? ViewFacade::shared('fltcTimelineColor') ?? 'base';
        $color = $this->color;

        $ringMap = [
            'slate'     => 'ring-white dark:ring-slate-950',
            'gray'      => 'ring-white dark:ring-gray-950',
            'zinc'      => 'ring-white dark:ring-zinc-950',
            'neutral'   => 'ring-white dark:ring-neutral-950',
            'stone'     => 'ring-white dark:ring-stone-950',
            'red'       => 'ring-white dark:ring-red-950',
            'orange'    => 'ring-white dark:ring-orange-950',
            'amber'     => 'ring-white dark:ring-amber-950',
            'yellow'    => 'ring-white dark:ring-yellow-950',
            'lime'      => 'ring-white dark:ring-lime-950',
            'green'     => 'ring-white dark:ring-green-950',
            'emerald'   => 'ring-white dark:ring-emerald-950',
            'teal'      => 'ring-white dark:ring-teal-950',
            'cyan'      => 'ring-white dark:ring-cyan-950',
            'sky'       => 'ring-white dark:ring-sky-950',
            'blue'      => 'ring-white dark:ring-blue-950',
            'indigo'    => 'ring-white dark:ring-indigo-950',
            'violet'    => 'ring-white dark:ring-violet-950',
            'purple'    => 'ring-white dark:ring-purple-950',
            'fuchsia'   => 'ring-white dark:ring-fuchsia-950',
            'pink'      => 'ring-white dark:ring-pink-950',
            'rose'      => 'ring-white dark:ring-rose-950',
            'taupe'     => 'ring-white dark:ring-taupe-950',
            'mauve'     => 'ring-white dark:ring-mauve-950',
            'mist'      => 'ring-white dark:ring-mist-950',
            'olive'     => 'ring-white dark:ring-olive-950',
            'primary'      => 'ring-white dark:ring-primary-950',
            'secondary'    => 'ring-white dark:ring-secondary-950',
            'accent'       => 'ring-white dark:ring-accent-950',
            'base'         => 'ring-white dark:ring-base-950',
            'info'         => 'ring-white dark:ring-info-950',
            'success'      => 'ring-white dark:ring-success-950',
            'warning'      => 'ring-white dark:ring-warning-950',
            'danger'       => 'ring-white dark:ring-danger-950',
        ];

        // The dot sits on the line: the list is padded by ps-6 and the line is its 2px
        // start border, so the dot centre goes 1.5rem + 1px back from the item.
        $this->dotClasses = trim(implode(' ', [
            'absolute top-0.5 flex items-center justify-center rounded-full ring-4',
            $icon !== '' ? '-start-[calc(1.5rem+0.75rem+1px)] h-6 w-6 text-xs text-white dark:text-black' : '-start-[calc(1.5rem+0.375rem+1px)] h-3 w-3 mt-1',
            Shades::fill($color),
            $ringMap[$color] ?? $ringMap['base'],
        ]));

        $this->classList = 'relative';
        $this->timeClasses = 'block text-xs '.Shades::tertiary($color);
        $this->titleClasses = 'font-semibold '.Shades::primary($color);
        $this->bodyClasses = 'mt-1 text-sm '.Shades::secondary($color);
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.timeline.item');
    }
}
