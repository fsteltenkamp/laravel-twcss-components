@props([
    'vertical' => false,
    'variant' => 'default',
])
@php
    $borderClasses = $variant === 'subtle'
        ? 'border-zinc-100 dark:border-zinc-800'
        : 'border-zinc-200 dark:border-zinc-700';

    $orientation = $vertical ? 'h-full border-l' : 'w-full border-t';
@endphp
<div
    role="separator"
    aria-orientation="{{ $vertical ? 'vertical' : 'horizontal' }}"
    {{ $attributes->class(['fltc-separator', $orientation, $borderClasses]) }}
></div>
