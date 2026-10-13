@php(\Illuminate\Support\Facades\View::share('fltcBadgeColor', null))
<div {{ $attributes->class([$classList]) }} @if ($label !== '') role="group" aria-label="{{ $label }}" @endif>
    {{ $slot }}
</div>
