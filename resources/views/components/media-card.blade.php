<article data-layout="{{ $layout }}" {{ $attributes->class([$classList]) }}>
    @isset($cover)
        <div class="fltc-media-card-cover {{ $coverClasses }}">{{ $cover }}</div>
    @endisset

    <div class="fltc-media-card-body {{ $bodyClasses }}">
        @isset($title)
            <h3 class="fltc-media-card-title {{ $titleClasses }}">
                @if ($href !== '')
                    {{-- Stretched link: the whole card is clickable, the actions sit above it. --}}
                    <a href="{{ $href }}" class="after:absolute after:inset-0 focus:outline-none focus-visible:underline">{{ $title }}</a>
                @else
                    {{ $title }}
                @endif
            </h3>
        @endisset
        @isset($meta)
            <div class="fltc-media-card-meta {{ $metaClasses }}">{{ $meta }}</div>
        @endisset
        @isset($badges)
            <div class="fltc-media-card-badges {{ $badgesClasses }}">{{ $badges }}</div>
        @endisset
        {{ $slot }}
        @isset($footer)
            <div class="fltc-media-card-footer {{ $footerClasses }}">{{ $footer }}</div>
        @endisset
    </div>

    @isset($actions)
        <div class="fltc-media-card-actions {{ $actionsClasses }}">{{ $actions }}</div>
    @endisset
</article>
