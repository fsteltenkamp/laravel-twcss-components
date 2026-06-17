@props([
    'name' => null,
    'open' => false,
    'maxWidth' => 'lg',
    'closeable' => true,
])
@php
    // Open state can be driven three ways:
    //   1. wire:model="prop"      — entangled with a Livewire boolean
    //   2. name + open-modal event — dispatch `open-modal` with the modal name
    //   3. open                   — initial open state (e.g. when validation fails)
    // Read wire:model straight off the bag so the component does not depend on
    // Livewire's `wire()` attribute macro being registered (e.g. in package tests).
    $wireModel = null;
    foreach ($attributes->getAttributes() as $attrKey => $attrValue) {
        if (str_starts_with($attrKey, 'wire:model')) {
            $wireModel = $attrValue;
            break;
        }
    }

    $widthMap = [
        'sm'  => 'max-w-sm',
        'md'  => 'max-w-md',
        'lg'  => 'max-w-lg',
        'xl'  => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
    ];
    $panelWidth = $widthMap[$maxWidth] ?? $widthMap['lg'];
@endphp
<div
    @if ($wireModel)
        x-data="{ open: @entangle($wireModel), close() { if (! {{ $closeable ? 'true' : 'false' }}) return; this.open = false; this.$dispatch('close'); } }"
    @else
        x-data="{ open: @js((bool) $open), close() { if (! {{ $closeable ? 'true' : 'false' }}) return; this.open = false; this.$dispatch('close'); } }"
    @endif
    @if ($name)
        x-on:open-modal.window="if ([$event.detail, $event.detail?.name].includes('{{ $name }}')) open = true"
        x-on:close-modal.window="if ([$event.detail, $event.detail?.name].includes('{{ $name }}')) close()"
    @endif
    x-on:keydown.escape.window="if (open) close()"
    x-show="open"
    x-cloak
    style="display: none;"
    {{ $attributes->whereDoesntStartWith('wire:model')->class('fixed inset-0 z-50 flex items-center justify-center p-4') }}
>
    <div
        class="fixed inset-0 bg-zinc-900/50 backdrop-blur-sm"
        x-show="open"
        x-transition.opacity
        x-on:click="close()"
    ></div>

    <div
        x-show="open"
        x-transition
        role="dialog"
        aria-modal="true"
        class="relative max-h-[90vh] w-full {{ $panelWidth }} overflow-y-auto rounded-xl border border-zinc-200 bg-white p-6 shadow-xl dark:border-zinc-700 dark:bg-zinc-900"
    >
        {{ $slot }}
    </div>
</div>
