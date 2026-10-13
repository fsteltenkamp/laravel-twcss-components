@props([
    'size' => 'sm',
    'theme' => null,
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
    $colour = $theme ? \Fsteltenkamp\TwcssComponents\Support\Shades::tertiary($theme) : 'text-zinc-500 dark:text-zinc-400';
    $classList = trim(($sizes[$size] ?? $sizes['sm']) . ' ' . $colour);
@endphp
<p {{ $attributes->class(['fltc-subheading', 'fltc-theme-'.$theme => $theme, $classList]) }}>{{ $slot }}</p>
