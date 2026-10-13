<li {{ $attributes->class([$classList]) }}>
    <span class="fltc-timeline-dot {{ $dotClasses }}" aria-hidden="true">
        @if ($icon !== '')<x-fltc::icon :name="$icon" />@endif
    </span>
    @if ($time !== '')
        <time class="fltc-timeline-time {{ $timeClasses }}" @if ($datetime !== '') datetime="{{ $datetime }}" @endif>{{ $time }}</time>
    @endif
    @if ($title !== '')
        <p class="fltc-timeline-title {{ $titleClasses }}">
            @if ($href !== '')<a href="{{ $href }}" class="hover:underline">{{ $title }}</a>@else{{ $title }}@endif
        </p>
    @endif
    @if ($slot->isNotEmpty())
        <div class="fltc-timeline-body {{ $bodyClasses }}">{{ $slot }}</div>
    @endif
</li>
