<span {{ $attributes->class([$classList]) }} role="img" aria-label="{{ $label }}">
    @foreach ($stars as $star)
        <span class="fltc-rating-star {{ $starClasses }}" data-star="{{ $star }}" aria-hidden="true">
            <svg class="absolute inset-0 h-full w-full {{ $emptyClasses }}" viewBox="0 0 24 24" fill="currentColor"><path d="{{ \Fsteltenkamp\TwcssComponents\View\Components\Rating::STAR_PATH }}" /></svg>
            @if ($star !== 'empty')
                <svg class="fltc-rating-fill absolute inset-0 h-full w-full {{ $filledClasses }}" viewBox="0 0 24 24" fill="currentColor" @if ($star === 'half') style="clip-path: inset(0 50% 0 0)" @endif><path d="{{ \Fsteltenkamp\TwcssComponents\View\Components\Rating::STAR_PATH }}" /></svg>
            @endif
        </span>
    @endforeach
    @if ($showValue)
        <span class="fltc-rating-value {{ $valueClasses }}">{{ rtrim(rtrim(number_format($rounded, 1), '0'), '.') }}</span>
    @endif
</span>
