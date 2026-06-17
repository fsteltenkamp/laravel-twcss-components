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
