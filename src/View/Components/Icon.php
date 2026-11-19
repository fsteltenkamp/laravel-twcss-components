<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Fsteltenkamp\TwcssComponents\View\Component;

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
     * @param  string  $color    Colour role or palette colouring the glyph; empty inherits
     *                           the surrounding text colour (currentColor).
     * @param  string  $size     Tailwind text-size token (e.g. "sm", "lg", "2xl").
     * @param  string  $before   Logical start margin (space before the icon), e.g. "2".
     * @param  string  $after    Logical end margin (space after the icon), e.g. "2".
     * @param  string  $align    vertical-align token (e.g. "middle", "text-bottom").
     */
    public function __construct(
        public string $name = '',
        public string $variant = 'regular',
        public string $color = '',
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

        $resolvedColor = $color;

        $this->classList = $this->squish(implode(' ', [
            $glyphClasses,
            $resolvedColor !== '' ? "text-{$resolvedColor}-500 dark:text-{$resolvedColor}-400" : '',
            $size !== '' ? 'text-' . $size : '',
            $before !== '' ? (self::MARGIN_START[$before] ?? 'ms-' . $before) : '',
            $after !== '' ? (self::MARGIN_END[$after] ?? 'me-' . $after) : '',
            $align !== '' ? 'align-' . $align : '',
        ]));
    }

    /**
     * Literal class strings so Tailwind's scanner generates them; a built `'ms-'.$before`
     * is invisible to it. Other values still fall back to the built class.
     */
    private const MARGIN_START = [
        '0.5' => 'ms-0.5', '1' => 'ms-1', '1.5' => 'ms-1.5', '2' => 'ms-2', '2.5' => 'ms-2.5',
        '3' => 'ms-3', '4' => 'ms-4', '5' => 'ms-5', '6' => 'ms-6', '8' => 'ms-8',
    ];

    private const MARGIN_END = [
        '0.5' => 'me-0.5', '1' => 'me-1', '1.5' => 'me-1.5', '2' => 'me-2', '2.5' => 'me-2.5',
        '3' => 'me-3', '4' => 'me-4', '5' => 'me-5', '6' => 'me-6', '8' => 'me-8',
    ];

    private function squish(string $value): string
    {
        return trim(preg_replace('/\s+/', ' ', $value));
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.icon');
    }
}
