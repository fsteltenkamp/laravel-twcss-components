@if ($variant === 'toggle')
<label
    for="{{ $id }}"
    class="fltc-form-checkbox-control group/toggle inline-flex items-center gap-3 select-none {{ $disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }} {{ $class }}"
>
    <input
        {{ $attributes->class(['peer sr-only']) }}
        type="checkbox"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @if ($model !== '')
            @if ($live)
                wire:model.live="{{ $model }}"
            @else
                wire:model="{{ $model }}"
            @endif
        @endif
        @checked($checked)
        @disabled($disabled)
    />

    @if ($labelOff !== '' || $iconOff !== '')
        <span class="fltc-form-checkbox-off {{ $sideClasses }} group-has-[:checked]/toggle:opacity-40" aria-hidden="true">@if ($iconOff !== '')<x-fltc::icon :name="$iconOff" />@endif{{ $labelOff }}</span>
    @endif

    <span class="fltc-form-checkbox-track relative inline-flex flex-shrink-0 items-center rounded-full transition-colors duration-300 {{ $trackSize }} {{ $trackOff }} {{ $trackOn }}">
        <span class="fltc-form-checkbox-knob absolute left-0.5 top-0.5 inline-flex items-center justify-center rounded-full bg-white shadow transform transition-transform duration-300 {{ $knobSize }} {{ $knobTranslate }}">
            @if ($iconUnchecked)
                <x-fltc::icon :name="$iconUnchecked" class="leading-none {{ $knobIconSize }} {{ $iconColorOff }} group-has-[:checked]/toggle:hidden" />
            @endif
            @if ($iconChecked)
                <x-fltc::icon :name="$iconChecked" class="leading-none hidden {{ $knobIconSize }} {{ $iconColorOn }} group-has-[:checked]/toggle:inline-flex" />
            @endif
        </span>
    </span>

    @if ($labelOn !== '' || $iconOn !== '')
        <span class="fltc-form-checkbox-on {{ $sideClasses }} opacity-40 group-has-[:checked]/toggle:opacity-100" aria-hidden="true">@if ($iconOn !== '')<x-fltc::icon :name="$iconOn" />@endif{{ $labelOn }}</span>
    @endif

    @if ($label)
        <span class="{{ $labelClasses }}">{{ $label }}</span>
    @endif
</label>
@else
<label
    for="{{ $id }}"
    class="fltc-form-checkbox-control inline-flex items-center gap-3 px-4 py-2.5 transition-colors {{ $disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }}
        @if ($bordered) border {{ $containerBorder }} rounded-lg {{ $rowBg }} {{ $rowBgCheckedHas }} @endif
        {{ $class }}"
>
    <input
        {{ $attributes->class(['peer sr-only']) }}
        type="checkbox"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @if ($model !== '')
            @if ($live)
                wire:model.live="{{ $model }}"
            @else
                wire:model="{{ $model }}"
            @endif
        @endif
        @checked($checked)
        @disabled($disabled)
    />

    <x-fltc::icon :name="$iconUnchecked" class="text-lg leading-none flex-shrink-0 transition-colors {{ $iconColorUnchecked }} peer-checked:hidden" />
    <x-fltc::icon :name="$iconChecked" class="text-lg leading-none flex-shrink-0 transition-colors {{ $iconColorChecked }} hidden peer-checked:inline" />

    @if ($label)
        <span class="{{ $labelClasses }}">{{ $label }}</span>
    @endif
</label>
@endif
