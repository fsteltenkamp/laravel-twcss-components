@php(\Illuminate\Support\Facades\View::share('fltcTimelineTheme', null))
<ol {{ $attributes->class([$classList]) }}>
    {{ $slot }}
</ol>
