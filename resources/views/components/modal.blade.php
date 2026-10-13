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
{{--
    The wrapper stays where the modal is written and holds the Alpine state and the
    host's attributes (wire:*, x-on:close, id), so events dispatched by close() reach
    them. The overlay is teleported to <body>, out of any transformed or clipped
    ancestor, and carries the classes (host classes and fltc-* hooks) and the
    data-skin, data-theme and data-theme-* of the regions the modal was written in
    (copied on every open, so changes to the region are picked up).
--}}
<div
    @if ($wireModel)
        x-data="{ open: @entangle($wireModel), close() { if (! {{ $closeable ? 'true' : 'false' }}) return; this.open = false; this.$dispatch('close'); }, syncRegion(el) { for (const attr of ['data-skin', 'data-theme']) { const r = this.$root.closest('[' + attr + ']'); const from = r && r !== document.documentElement ? r : null; for (const a of [...el.attributes]) if (a.name === attr || (attr === 'data-theme' && a.name.startsWith('data-theme-'))) el.removeAttribute(a.name); if (from) for (const a of [...from.attributes]) if (a.name === attr || (attr === 'data-theme' && a.name.startsWith('data-theme-'))) el.setAttribute(a.name, a.value); } } }"
    @else
        x-data="{ open: @js((bool) $open), close() { if (! {{ $closeable ? 'true' : 'false' }}) return; this.open = false; this.$dispatch('close'); }, syncRegion(el) { for (const attr of ['data-skin', 'data-theme']) { const r = this.$root.closest('[' + attr + ']'); const from = r && r !== document.documentElement ? r : null; for (const a of [...el.attributes]) if (a.name === attr || (attr === 'data-theme' && a.name.startsWith('data-theme-'))) el.removeAttribute(a.name); if (from) for (const a of [...from.attributes]) if (a.name === attr || (attr === 'data-theme' && a.name.startsWith('data-theme-'))) el.setAttribute(a.name, a.value); } } }"
    @endif
    @if ($name)
        x-on:open-modal.window="if ([$event.detail, $event.detail?.name].includes('{{ $name }}')) open = true"
        x-on:close-modal.window="if ([$event.detail, $event.detail?.name].includes('{{ $name }}')) close()"
    @endif
    x-on:keydown.escape.window="if (open) close()"
    {{ $attributes->whereDoesntStartWith('wire:model')->except('class') }}
>
    @if ($teleport)<template x-teleport="body">@endif
    <div
        x-show="open"
        x-cloak
        style="display: none;"
        x-effect="open && syncRegion($el)"
        class="{{ $attributes->get('class') }} fixed inset-0 z-50 flex items-center justify-center p-4"
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
    @if ($teleport)</template>@endif
</div>
