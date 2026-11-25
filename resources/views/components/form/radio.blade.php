@if ($variant === 'cards')
<label for="{{ $id }}" @class(['fltc-form-radio-control fltc-form-radio-card', $cardClasses, $disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer', $class])>
    <input
        {{ $attributes->class([$classList, 'mt-0.5']) }}
        type="radio"
        id="{{ $id }}"
        @if ($name !== '') name="{{ $name }}" @endif
        value="{{ $value }}"
        @if ($model !== '')
            @if ($live)
                wire:model.live="{{ $model }}"
            @else
                wire:model="{{ $model }}"
            @endif
        @endif
        @checked($checked)
        @required($required)
        @disabled($disabled)
    />

    <span class="min-w-0 flex-1">
        <span class="fltc-form-radio-label block font-medium {{ $labelClasses }}">{{ $label !== '' ? $label : $slot }}</span>
        @if ($description !== '' || ($label !== '' && $slot->isNotEmpty()))
            <span class="fltc-form-radio-description {{ $descriptionClasses }}">{{ $description }}@if ($label !== ''){{ $slot }}@endif</span>
        @endif
    </span>
</label>
@else
<label
    for="{{ $id }}"
    @class([
        'fltc-form-radio-control inline-flex items-center gap-2',
        $disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
        $class,
    ])
>
    <input
        {{ $attributes->class([$classList]) }}
        type="radio"
        id="{{ $id }}"
        @if ($name !== '') name="{{ $name }}" @endif
        value="{{ $value }}"
        @if ($model !== '')
            @if ($live)
                wire:model.live="{{ $model }}"
            @else
                wire:model="{{ $model }}"
            @endif
        @endif
        @checked($checked)
        @required($required)
        @disabled($disabled)
    />

    @if ($label !== '' || $slot->isNotEmpty())
        <span class="fltc-form-radio-label {{ $labelClasses }}">{{ $label !== '' ? $label : $slot }}</span>
    @endif
</label>
@endif
