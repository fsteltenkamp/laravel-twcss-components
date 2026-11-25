<div role="listitem" {{ $attributes->class([$classList]) }}>
    @if ($icon !== '')<x-fltc::icon :name="$icon" />@endif
    <span>{{ $slot }}</span>
    @if ($meta !== '')<span class="fltc-thread-event-meta opacity-75">· {{ $meta }}</span>@endif
</div>
