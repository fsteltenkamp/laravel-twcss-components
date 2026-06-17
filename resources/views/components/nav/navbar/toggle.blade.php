<button
    type="button"
    x-data
    x-on:click="$dispatch('fltc-sidebar-toggle', @js($detail))"
    aria-label="{{ $label }}"
    aria-haspopup="true"
    {{ $attributes->merge(['class' => $classList]) }}
>
    @if (trim($slot) === '')
        <x-fltc::icon name="list" />
    @else
        {{ $slot }}
    @endif
</button>
