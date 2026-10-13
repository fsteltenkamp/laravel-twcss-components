@php(\Illuminate\Support\Facades\View::share('fltcTimelineColor', null))
<ol {{ $attributes->class([$classList]) }}>
    {{ $slot }}
</ol>
