@php(\Illuminate\Support\Facades\View::share('fltcSegmented', null))
<div
    role="group"
    @if ($label !== '') aria-label="{{ $label }}" @endif
    @if ($interactive)
        x-data="{ value: @js($value) }"
        x-modelable="value"
    @endif
    {{ $attributes->class([$classList]) }}
>
    @if ($interactive && $name !== '')
        <input type="hidden" name="{{ $name }}" value="{{ $value }}" x-bind:value="value" />
    @endif
    {{ $slot }}
</div>
