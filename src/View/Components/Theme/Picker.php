<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Theme;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

/**
 * Lets the visitor choose the skin (the look: data-skin on <html>), the colour
 * (data-palette on <html>, which theme="palette" components follow) and the
 * light/dark/system mode (x-fltc::darkmode.toggle, which owns that storage and the
 * OS-following system mode). Each choice is stored under its own key. Pair it with
 * x-fltc::theme.script in <head> so the choices apply before the first paint.
 */
class Picker extends Component
{
    /**
     * @var array<string, string> skin name => label
     */
    public array $skinOptions;

    /**
     * @var array<string, string> palette name => label
     */
    public array $paletteOptions;

    public string $classList;

    /**
     * @param  array<int|string, string>  $skins  skin names, or name => label; empty hides the select
     * @param  array<int|string, string>  $palettes  palette names, or name => label; empty hides the select
     * @param  ?string  $defaultSkin  skin when nothing is stored and <html> has no data-skin
     * @param  ?string  $defaultPalette  palette when nothing is stored and <html> has no data-palette
     */
    public function __construct(
        public array $skins = ['default', 'cyberpunk', 'fantasy', 'wh40k'],
        public array $palettes = ['slate', 'cyberpunk', 'fantasy', 'wh40k'],
        public string $skinStorageKey = 'fltc-skin',
        public string $paletteStorageKey = 'fltc-palette',
        public ?string $defaultSkin = null,
        public ?string $defaultPalette = null,
        public string $theme = 'slate',
        public bool $mode = true,
        public bool $stacked = false,
        public string $skinLabel = '',
        public string $paletteLabel = '',
        public string $modeLabel = '',
    ) {
        $this->skinOptions = self::options($skins);
        $this->paletteOptions = self::options($palettes);

        $this->defaultSkin = $defaultSkin ?? array_key_first($this->skinOptions) ?? 'default';
        $this->defaultPalette = $defaultPalette ?? array_key_first($this->paletteOptions) ?? 'slate';
        $this->skinLabel = $skinLabel !== '' ? $skinLabel : __('Skin');
        $this->paletteLabel = $paletteLabel !== '' ? $paletteLabel : __('Colour');
        $this->modeLabel = $modeLabel !== '' ? $modeLabel : __('Mode');
        $this->classList = $stacked ? 'flex flex-col gap-4' : 'flex flex-wrap items-end gap-4';
    }

    /**
     * @param  array<int|string, string>  $names
     * @return array<string, string>
     */
    private static function options(array $names): array
    {
        return collect($names)
            ->mapWithKeys(fn (string $label, int|string $name) => is_int($name)
                ? [$label => Str::headline($label)]
                : [$name => $label])
            ->all();
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.theme.picker');
    }
}
