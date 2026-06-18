@if ($variant === 'toggle')
<label
    for="{{ $id }}"
    class="group/toggle inline-flex items-center gap-3 select-none {{ $disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }} {{ $class }}"
>
    <input
        {{ $attributes }}
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
        class="peer sr-only"
    />

    <span class="relative inline-flex flex-shrink-0 items-center rounded-full transition-colors duration-300 {{ $trackSize }} {{ $trackOff }} {{ $trackOn }}">
        <span class="absolute left-0.5 top-0.5 inline-flex items-center justify-center rounded-full bg-white shadow transform transition-transform duration-300 {{ $knobSize }} {{ $knobTranslate }}">
            @if ($iconUnchecked)
                <x-fltc::icon :name="$iconUnchecked" class="leading-none {{ $knobIconSize }} {{ $iconColorOff }} group-has-[:checked]/toggle:hidden" />
            @endif
            @if ($iconChecked)
                <x-fltc::icon :name="$iconChecked" class="leading-none hidden {{ $knobIconSize }} {{ $iconColorOn }} group-has-[:checked]/toggle:inline-flex" />
            @endif
        </span>
    </span>

    @if ($label)
        <span class="{{ $labelClasses }}">{{ $label }}</span>
    @endif
</label>
@else
<label
    for="{{ $id }}"
    class="inline-flex items-center gap-3 px-4 py-2.5 transition-colors {{ $disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }}
        @if ($bordered) border {{ $containerBorder }} rounded-lg {{ $rowBg }} {{ $rowBgCheckedHas }} @endif
        {{ $class }}"
>
    <input
        {{ $attributes }}
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
        class="peer sr-only"
    />

    <x-fltc::icon :name="$iconUnchecked" class="text-lg leading-none flex-shrink-0 transition-colors {{ $iconColorUnchecked }} peer-checked:hidden" />
    <x-fltc::icon :name="$iconChecked" class="text-lg leading-none flex-shrink-0 transition-colors {{ $iconColorChecked }} hidden peer-checked:inline" />

    @if ($label)
        <span class="{{ $labelClasses }}">{{ $label }}</span>
    @endif
</label>
@endif
