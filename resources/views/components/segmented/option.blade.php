<button
    {{ $attributes->class([$classList, $initiallyActive ? $activeClasses : $inactiveClasses]) }}
    type="button"
    data-value="{{ $value }}"
    aria-pressed="{{ $initiallyActive ? 'true' : 'false' }}"
    @if ($interactive)
        x-on:click="value = @js($value)"
        x-bind:aria-pressed="value === @js($value)"
        x-bind:class="{ [@js($activeClasses)]: value === @js($value), [@js($inactiveClasses)]: value !== @js($value) }"
    @endif
    @disabled($disabled)
>
    @if ($icon !== '')<x-fltc::icon :name="$icon" :variant="$iconVariant" class="leading-none" />@endif
    @if ($label !== '' || $slot->isNotEmpty())<span>{{ $label !== '' ? $label : $slot }}</span>@endif
</button>
