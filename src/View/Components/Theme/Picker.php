<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Theme;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

/**
 * Lets the visitor choose the runtime theme (data-skin on <html>, stored under
 * `storageKey`) and the light/dark/system mode (x-fltc::darkmode.toggle, which owns
 * that storage and the OS-following system mode). Pair it with
 * x-fltc::theme.script in <head> so the choice applies before the first paint.
 */
class Picker extends Component
{
    /**
     * @var array<string, string> theme name => label
     */
    public array $options;

    public string $classList;

    /**
     * @param  array<int|string, string>  $themes  theme names, or name => label
     * @param  ?string  $default  theme when nothing is stored and <html> has no data-skin
     */
    public function __construct(
        public array $themes = ['slate', 'cyberpunk', 'fantasy', 'wh40k'],
        public string $storageKey = 'fltc-skin',
        public ?string $default = null,
        public string $theme = 'slate',
        public bool $mode = true,
        public bool $stacked = false,
        public string $label = '',
        public string $modeLabel = '',
    ) {
        $this->options = collect($themes)
            ->mapWithKeys(fn (string $label, int|string $name) => is_int($name)
                ? [$label => Str::headline($label)]
                : [$name => $label])
            ->all();

        $this->default = $default ?? array_key_first($this->options) ?? 'slate';
        $this->label = $label !== '' ? $label : __('Theme');
        $this->modeLabel = $modeLabel !== '' ? $modeLabel : __('Mode');
        $this->classList = $stacked ? 'flex flex-col gap-4' : 'flex flex-wrap items-end gap-4';
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.theme.picker');
    }
}
