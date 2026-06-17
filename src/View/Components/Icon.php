<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Icon extends Component
{
    public string $classList;

    /**
     * @param  string  $name     Phosphor icon identifier (e.g. "user", "caret-right").
     *                           A full class string ("ph ph-user") is also accepted and
     *                           rendered verbatim so the existing "full icon class" props
     *                           keep working.
     * @param  string  $variant  Phosphor weight: thin, light, regular, bold, fill/solid,
     *                           duotone. Defaults to regular (the base "ph" weight), since
     *                           that is the weight host apps load by default; the other
     *                           weights are opt-in and require the host to load their CSS.
     * @param  string  $color    Theme palette name colouring the glyph; empty inherits the
     *                           surrounding text colour (currentColor).
     * @param  string  $theme    Alias for $color (General Properties theme support).
     * @param  string  $size     Tailwind text-size token (e.g. "sm", "lg", "2xl").
     * @param  string  $before   Logical start margin (space before the icon), e.g. "2".
     * @param  string  $after    Logical end margin (space after the icon), e.g. "2".
     * @param  string  $align    vertical-align token (e.g. "middle", "text-bottom").
     */
    public function __construct(
        public string $name = '',
        public string $variant = 'regular',
        public string $color = '',
        public string $theme = '',
        public string $size = '',
        public string $before = '',
        public string $after = '',
        public string $align = '',
    ) {
        $variantMap = [
            'thin'    => 'ph-thin',
            'light'   => 'ph-light',
            'regular' => 'ph',
            'bold'    => 'ph-bold',
            'fill'    => 'ph-fill',
            'solid'   => 'ph-fill',
            'duotone' => 'ph-duotone',
        ];

        $weightClass = $variantMap[strtolower(trim($variant))] ?? $variantMap['regular'];

        $trimmedName = trim($name);

        // A caller may pass a full class string ("ph ph-user") instead of a bare
        // identifier. Detect that and render it verbatim so the variant/glyph prefix
        // is not doubled up.
        $isRawClass = $trimmedName !== '' && (
            str_contains($trimmedName, ' ')
            || str_starts_with($trimmedName, 'ph-')
            || $trimmedName === 'ph'
        );

        $glyphClasses = $isRawClass
            ? $trimmedName
            : trim($weightClass . ' ph-' . $trimmedName);

        $resolvedColor = $color !== '' ? $color : $theme;

        $this->classList = $this->squish(implode(' ', [
            $glyphClasses,
            $resolvedColor !== '' ? "text-{$resolvedColor}-500 dark:text-{$resolvedColor}-400" : '',
            $size !== '' ? 'text-' . $size : '',
            $before !== '' ? 'ms-' . $before : '',
            $after !== '' ? 'me-' . $after : '',
            $align !== '' ? 'align-' . $align : '',
        ]));
    }

    private function squish(string $value): string
    {
        return trim(preg_replace('/\s+/', ' ', $value));
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.icon');
    }
}
