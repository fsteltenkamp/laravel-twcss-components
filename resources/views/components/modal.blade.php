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
        class="fltc-modal-backdrop {{ $backdropClasses }}"
        x-show="open"
        x-transition.opacity
        x-on:click="close()"
    ></div>

    <div
        x-show="open"
        x-transition
        role="dialog"
        aria-modal="true"
        class="fltc-modal-panel {{ $panelClasses }}"
    >
        {{ $slot }}
    </div>
</div>
