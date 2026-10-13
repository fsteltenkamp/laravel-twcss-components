@php(\Illuminate\Support\Facades\View::share('fltcBadgeTheme', null))
<div {{ $attributes->class([$classList]) }} @if ($label !== '') role="group" aria-label="{{ $label }}" @endif>
    {{ $slot }}
</div>
