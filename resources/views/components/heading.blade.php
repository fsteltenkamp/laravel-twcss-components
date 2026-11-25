@props([
    'size' => 'base',
    'level' => 2,
    'glitch' => false,
    'color' => null,
    'align' => null,
])
@php
    $sizes = [
        'sm'   => 'text-sm',
        'base' => 'text-base',
        'lg'   => 'text-lg',
        'xl'   => 'text-xl',
        '2xl'  => 'text-2xl',
    ];

    $tag = 'h' . (int) $level;

    // Primary Content role (see README "Color shades") so the heading flips in dark mode.
    // Without a theme it keeps its original neutral zinc/white.
    $colour = $color ? \Fsteltenkamp\TwcssComponents\Support\Shades::primary($color) : 'text-zinc-900 dark:text-white';
    $alignment = ['center' => 'text-center', 'right' => 'text-right'][$align] ?? '';
    $classList = trim(($sizes[$size] ?? $sizes['base']) . ' font-semibold tracking-tight ' . $colour . ' ' . $alignment);
@endphp
{{-- `fltc-heading` is the neutral hook for skin stylesheets. `glitch` opts into a skin's
     glitch effect, which redraws the text from data-text (see skin-effects.css). --}}
<{{ $tag }} {{ $attributes->class(['fltc-heading', 'fltc-color-'.$color => $color, 'fltc-glitch' => $glitch, $classList])->merge($glitch ? ['data-text' => trim(strip_tags($slot))] : []) }}>{{ $slot }}</{{ $tag }}>
