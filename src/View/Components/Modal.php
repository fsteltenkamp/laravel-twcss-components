<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\SidebarTheme;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * Alpine dialog with a dimmed backdrop. Open state comes from wire:model, the
 * open-modal / close-modal events (by `name`) or the initial `open` prop; the view
 * reads wire:model off the attribute bag.
 */
class Modal extends Component
{
    public string $panelClasses;
    public string $backdropClasses;

    public function __construct(
        public ?string $name = null,
        public bool $open = false,
        public string $maxWidth = 'lg',
        public bool $closeable = true,
        public string $theme = 'slate',
    ) {
        $widthMap = [
            'sm'   => 'max-w-sm',
            'md'   => 'max-w-md',
            'lg'   => 'max-w-lg',
            'xl'   => 'max-w-xl',
            '2xl'  => 'max-w-2xl',
            '3xl'  => 'max-w-3xl',
            '4xl'  => 'max-w-4xl',
            '5xl'  => 'max-w-5xl',
            '6xl'  => 'max-w-6xl',
            '7xl'  => 'max-w-7xl',
            'full' => 'max-w-full',
        ];

        $backdropMap = [
            'slate'     => 'bg-slate-950/50',
            'gray'      => 'bg-gray-950/50',
            'zinc'      => 'bg-zinc-950/50',
            'neutral'   => 'bg-neutral-950/50',
            'stone'     => 'bg-stone-950/50',
            'red'       => 'bg-red-950/50',
            'orange'    => 'bg-orange-950/50',
            'amber'     => 'bg-amber-950/50',
            'yellow'    => 'bg-yellow-950/50',
            'lime'      => 'bg-lime-950/50',
            'green'     => 'bg-green-950/50',
            'emerald'   => 'bg-emerald-950/50',
            'teal'      => 'bg-teal-950/50',
            'cyan'      => 'bg-cyan-950/50',
            'sky'       => 'bg-sky-950/50',
            'blue'      => 'bg-blue-950/50',
            'indigo'    => 'bg-indigo-950/50',
            'violet'    => 'bg-violet-950/50',
            'purple'    => 'bg-purple-950/50',
            'fuchsia'   => 'bg-fuchsia-950/50',
            'pink'      => 'bg-pink-950/50',
            'rose'      => 'bg-rose-950/50',
            'taupe'     => 'bg-taupe-950/50',
            'mauve'     => 'bg-mauve-950/50',
            'mist'      => 'bg-mist-950/50',
            'olive'     => 'bg-olive-950/50',
            'skin'      => 'bg-skin-950/50',
            'cyberpunk' => 'bg-cyberpunk-950/50',
            'fantasy'   => 'bg-fantasy-950/50',
            'wh40k'     => 'bg-wh40k-950/50',
        ];

        // Panel: the floating-surface shades the sidebar and dropdown menus use.
        $this->panelClasses = trim(implode(' ', [
            'relative max-h-[90vh] w-full overflow-y-auto rounded-xl border p-6 shadow-xl',
            $widthMap[$maxWidth] ?? $widthMap['lg'],
            SidebarTheme::surface($theme),
        ]));

        $this->backdropClasses = 'fixed inset-0 backdrop-blur-sm '.($backdropMap[$theme] ?? $backdropMap['slate']);
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.modal');
    }
}
