@props([
    'size' => 'sm',
    'color' => null,
    'align' => null,
])
@php
    $sizes = [
        'xs'   => 'text-xs',
        'sm'   => 'text-sm',
        'base' => 'text-base',
        'lg'   => 'text-lg',
    ];

    // Tertiary Content role (see README "Color shades") — muted supporting copy.
    // Without a theme it keeps its original neutral zinc.
    $colour = $color ? \Fsteltenkamp\TwcssComponents\Support\Shades::tertiary($color) : 'text-zinc-500 dark:text-zinc-400';
    $alignment = ['center' => 'text-center', 'right' => 'text-right'][$align] ?? '';
    $classList = trim(($sizes[$size] ?? $sizes['sm']) . ' ' . $colour . ' ' . $alignment);
@endphp
<p {{ $attributes->class(['fltc-subheading', 'fltc-color-'.$color => $color, $classList]) }}>{{ $slot }}</p>
