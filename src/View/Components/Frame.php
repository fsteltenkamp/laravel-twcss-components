<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * An embedded page or document (<iframe>) in a frame, with a spinner until it has
 * loaded: a PDF or mail preview, a signature, an editor preview.
 */
class Frame extends Component
{
    public string $classList;
    public string $heightStyle;

    /**
     * @param  string  $srcDark  another source for dark mode (a dark rendering of the document)
     * @param  string  $height  CSS height, e.g. 24rem (default), 60vh, 400px
     * @param  bool  $resizable  the visitor can drag the frame taller
     * @param  string|null  $sandbox  the iframe's sandbox tokens ('' for the strictest); none by default
     */
    public function __construct(
        public string $src = '',
        public string $srcdoc = '',
        public string $srcDark = '',
        public string $title = '',
        public string $height = '24rem',
        public bool $resizable = false,
        public ?string $sandbox = null,
        public string $color = 'base',
    ) {
        $frameMap = [
            'slate'     => 'border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-950',
            'gray'      => 'border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-950',
            'zinc'      => 'border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-950',
            'neutral'   => 'border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-950',
            'stone'     => 'border-stone-200 bg-white dark:border-stone-700 dark:bg-stone-950',
            'red'       => 'border-red-200 bg-white dark:border-red-700 dark:bg-red-950',
            'orange'    => 'border-orange-200 bg-white dark:border-orange-700 dark:bg-orange-950',
            'amber'     => 'border-amber-200 bg-white dark:border-amber-700 dark:bg-amber-950',
            'yellow'    => 'border-yellow-200 bg-white dark:border-yellow-700 dark:bg-yellow-950',
            'lime'      => 'border-lime-200 bg-white dark:border-lime-700 dark:bg-lime-950',
            'green'     => 'border-green-200 bg-white dark:border-green-700 dark:bg-green-950',
            'emerald'   => 'border-emerald-200 bg-white dark:border-emerald-700 dark:bg-emerald-950',
            'teal'      => 'border-teal-200 bg-white dark:border-teal-700 dark:bg-teal-950',
            'cyan'      => 'border-cyan-200 bg-white dark:border-cyan-700 dark:bg-cyan-950',
            'sky'       => 'border-sky-200 bg-white dark:border-sky-700 dark:bg-sky-950',
            'blue'      => 'border-blue-200 bg-white dark:border-blue-700 dark:bg-blue-950',
            'indigo'    => 'border-indigo-200 bg-white dark:border-indigo-700 dark:bg-indigo-950',
            'violet'    => 'border-violet-200 bg-white dark:border-violet-700 dark:bg-violet-950',
            'purple'    => 'border-purple-200 bg-white dark:border-purple-700 dark:bg-purple-950',
            'fuchsia'   => 'border-fuchsia-200 bg-white dark:border-fuchsia-700 dark:bg-fuchsia-950',
            'pink'      => 'border-pink-200 bg-white dark:border-pink-700 dark:bg-pink-950',
            'rose'      => 'border-rose-200 bg-white dark:border-rose-700 dark:bg-rose-950',
            'taupe'     => 'border-taupe-200 bg-white dark:border-taupe-700 dark:bg-taupe-950',
            'mauve'     => 'border-mauve-200 bg-white dark:border-mauve-700 dark:bg-mauve-950',
            'mist'      => 'border-mist-200 bg-white dark:border-mist-700 dark:bg-mist-950',
            'olive'     => 'border-olive-200 bg-white dark:border-olive-700 dark:bg-olive-950',
            'primary'   => 'border-primary-200 bg-white dark:border-primary-700 dark:bg-primary-950',
            'secondary' => 'border-secondary-200 bg-white dark:border-secondary-700 dark:bg-secondary-950',
            'accent'    => 'border-accent-200 bg-white dark:border-accent-700 dark:bg-accent-950',
            'base'      => 'border-base-200 bg-white dark:border-base-700 dark:bg-base-950',
            'info'      => 'border-info-200 bg-white dark:border-info-700 dark:bg-info-950',
            'success'   => 'border-success-200 bg-white dark:border-success-700 dark:bg-success-950',
            'warning'   => 'border-warning-200 bg-white dark:border-warning-700 dark:bg-warning-950',
            'danger'    => 'border-danger-200 bg-white dark:border-danger-700 dark:bg-danger-950',
        ];

        $this->classList = trim(implode(' ', [
            'relative w-full overflow-hidden rounded-lg border',
            $resizable ? 'resize-y' : '',
            $frameMap[$color] ?? $frameMap['base'],
        ]));
        $this->heightStyle = 'height: '.$height.';';
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.frame');
    }
}
