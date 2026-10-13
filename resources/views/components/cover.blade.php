<span {{ $attributes->class([$classList])->merge(['style' => $ratioStyle]) }}>
    @if ($src !== '')
        <img
            src="{{ $src }}"
            alt="{{ $alt }}"
            loading="lazy"
            class="fltc-cover-image absolute inset-0 h-full w-full object-cover"
            onerror="this.hidden = true; this.nextElementSibling.hidden = false;"
        />
    @endif
    <span class="fltc-cover-fallback {{ $fallbackClasses }}" @if ($src !== '') hidden @endif @if ($alt !== '') role="img" aria-label="{{ $alt }}" @endif>
        @if ($fallbackIcon !== '')<x-fltc::icon :name="$fallbackIcon" class="text-2xl" aria-hidden="true" />@endif
        @if ($fallback !== '')<span class="text-[0.65rem] font-semibold uppercase tracking-widest">{{ $fallback }}</span>@endif
    </span>
</span>
