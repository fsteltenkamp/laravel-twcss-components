<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Darkmode;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Toggle extends Component
{
    public readonly string $storageKey;
    public readonly array $options;
    public readonly string $activeClasses;

    /**
     * @param  string  $variant   `default` renders a three-button segmented control
     *                            (light / dark / system); `toggle` renders the pill
     *                            switch built on the form checkbox toggle component.
     * @param  string  $theme     Accent colour: the active segment (default variant) or
     *                            the "on"/dark track (toggle variant). Full palette.
     * @param  string  $themeOff  The "off"/light track colour for the toggle variant.
     * @param  string  $size      Size token forwarded to the toggle variant (sm/md/lg).
     */
    public function __construct(
        public string $variant = 'default',
        public string $theme = 'sky',
        public string $themeOff = 'slate',
        public string $size = 'md',
    ) {
        // Stored preference is one of: light | dark | system. A missing value is
        // treated as `system` so the OS setting is the default.
        $this->storageKey = 'theme';

        $this->options = [
            ['value' => 'light',  'label' => 'Light',  'icon' => 'sun'],
            ['value' => 'dark',   'label' => 'Dark',   'icon' => 'moon'],
            ['value' => 'system', 'label' => 'System', 'icon' => 'desktop'],
        ];

        // Active segment colour for the segmented control. Literal strings so the host
        // app's Tailwind scanner picks them up (dynamic class names are not detected).
        $activeMap = [
            'slate'   => 'bg-slate-600 text-white shadow-sm dark:bg-slate-500',
            'gray'    => 'bg-gray-600 text-white shadow-sm dark:bg-gray-500',
            'zinc'    => 'bg-zinc-600 text-white shadow-sm dark:bg-zinc-500',
            'neutral' => 'bg-neutral-600 text-white shadow-sm dark:bg-neutral-500',
            'stone'   => 'bg-stone-600 text-white shadow-sm dark:bg-stone-500',
            'red'     => 'bg-red-600 text-white shadow-sm dark:bg-red-500',
            'orange'  => 'bg-orange-600 text-white shadow-sm dark:bg-orange-500',
            'amber'   => 'bg-amber-600 text-white shadow-sm dark:bg-amber-500',
            'yellow'  => 'bg-yellow-600 text-white shadow-sm dark:bg-yellow-500',
            'lime'    => 'bg-lime-600 text-white shadow-sm dark:bg-lime-500',
            'green'   => 'bg-green-600 text-white shadow-sm dark:bg-green-500',
            'emerald' => 'bg-emerald-600 text-white shadow-sm dark:bg-emerald-500',
            'teal'    => 'bg-teal-600 text-white shadow-sm dark:bg-teal-500',
            'cyan'    => 'bg-cyan-600 text-white shadow-sm dark:bg-cyan-500',
            'sky'     => 'bg-sky-600 text-white shadow-sm dark:bg-sky-500',
            'blue'    => 'bg-blue-600 text-white shadow-sm dark:bg-blue-500',
            'indigo'  => 'bg-indigo-600 text-white shadow-sm dark:bg-indigo-500',
            'violet'  => 'bg-violet-600 text-white shadow-sm dark:bg-violet-500',
            'purple'  => 'bg-purple-600 text-white shadow-sm dark:bg-purple-500',
            'fuchsia' => 'bg-fuchsia-600 text-white shadow-sm dark:bg-fuchsia-500',
            'pink'    => 'bg-pink-600 text-white shadow-sm dark:bg-pink-500',
            'rose'    => 'bg-rose-600 text-white shadow-sm dark:bg-rose-500',
            'taupe'   => 'bg-taupe-600 text-white shadow-sm dark:bg-taupe-500',
            'mauve'   => 'bg-mauve-600 text-white shadow-sm dark:bg-mauve-500',
            'mist'    => 'bg-mist-600 text-white shadow-sm dark:bg-mist-500',
            'olive'   => 'bg-olive-600 text-white shadow-sm dark:bg-olive-500',
        ];

        $this->activeClasses = $activeMap[$theme] ?? $activeMap['sky'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.darkmode.toggle');
    }
}
