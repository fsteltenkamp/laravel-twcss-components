@php
    // A toggle chip is a <label> around a hidden checkbox: model bindings belong on
    // the checkbox, everything else (class, id, hooks) on the chip.
    $inputAttributes = $tag === 'label' ? $attributes->whereStartsWith(['wire:model', 'x-model']) : null;
    $chipAttributes = $tag === 'label' ? $attributes->whereDoesntStartWith(['wire:model', 'x-model']) : $attributes;
@endphp
<{{ $tag }} {{ $chipAttributes->class([$classList]) }} @if ($tag === 'a') href="{{ $href }}" @endif>
    @if ($tag === 'label')
        <input {{ $inputAttributes }} type="checkbox" class="peer sr-only" @if ($name !== '') name="{{ $name }}" @endif value="{{ $value !== '' ? $value : '1' }}" @checked($checked) />
    @endif
    @if ($icon !== '')<x-fltc::icon :name="$icon" :variant="$iconVariant" />@endif
    {{ $slot }}
    @if ($count !== null && $count !== '')
        <span class="fltc-badge-count {{ $countClasses }}">{{ $count }}</span>
    @endif
    @if ($removable)
        <button
            type="button"
            class="fltc-badge-remove {{ $removeClasses }}"
            aria-label="{{ $removeLabel }}"
            x-data
            x-on:click.prevent.stop="$dispatch('badge-remove', @js($value !== '' ? $value : trim(strip_tags($slot))))"
        ><x-fltc::icon name="x" /></button>
    @endif
</{{ $tag }}>
