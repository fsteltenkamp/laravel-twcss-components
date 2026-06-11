<li {{ $attributes->merge(['class' => 'inline-flex items-center gap-2']) }}>
    @if ($showSeparator)
        <span data-breadcrumb-separator aria-hidden="true" class="{{ $separatorClass }}">
            <i class="ph ph-caret-right"></i>
        </span>
    @endif

    @if ($isLink)
        <a href="{{ $href }}" class="{{ $classList }}">
            @if (filled($icon))
                <i class="{{ $icon }} text-sm" aria-hidden="true"></i>
            @endif
            <span>{{ $slot }}</span>
        </a>
    @else
        <span @if ($isActive) aria-current="page" @endif class="{{ $classList }}">
            @if (filled($icon))
                <i class="{{ $icon }} text-sm" aria-hidden="true"></i>
            @endif
            <span>{{ $slot }}</span>
        </span>
    @endif
</li>
