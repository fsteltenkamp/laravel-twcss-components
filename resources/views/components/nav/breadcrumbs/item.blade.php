<li {{ $attributes->merge(['class' => 'inline-flex items-center gap-2']) }}>
    @if ($showSeparator)
        <span data-breadcrumb-separator aria-hidden="true" class="fltc-nav-breadcrumbs-separator {{ $separatorClass }}">
            <x-fltc::icon name="caret-right" />
        </span>
    @endif

    @if ($isLink)
        <a href="{{ $href }}" class="fltc-nav-breadcrumbs-crumb {{ $classList }}">
            @if (filled($icon))
                <x-fltc::icon :name="$icon" class="text-sm" />
            @endif
            <span>{{ $slot }}</span>
        </a>
    @else
        <span @if ($isActive) aria-current="page" @endif class="fltc-nav-breadcrumbs-crumb {{ $classList }}">
            @if (filled($icon))
                <x-fltc::icon :name="$icon" class="text-sm" />
            @endif
            <span>{{ $slot }}</span>
        </span>
    @endif
</li>
