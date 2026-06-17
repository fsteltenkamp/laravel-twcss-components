@props([
    'size' => 'base',
    'level' => 2,
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
    $classList = trim(($sizes[$size] ?? $sizes['base']) . ' font-semibold tracking-tight text-zinc-900 dark:text-white');
@endphp
<{{ $tag }} {{ $attributes->class($classList) }}>{{ $slot }}</{{ $tag }}>
