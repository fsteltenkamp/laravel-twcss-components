@props([
    'size' => 'sm',
])
@php
    $sizes = [
        'xs'   => 'text-xs',
        'sm'   => 'text-sm',
        'base' => 'text-base',
        'lg'   => 'text-lg',
    ];

    // Tertiary Content role (see README "Color shades") — muted supporting copy.
    $classList = trim(($sizes[$size] ?? $sizes['sm']) . ' text-zinc-500 dark:text-zinc-400');
@endphp
<p {{ $attributes->class($classList) }}>{{ $slot }}</p>
