<{{ $tag }}
    @if (filled($link)) href="{{ $link }}" @if ($navigate) wire:navigate @endif @endif
    {{ $attributes->class([$classList])->merge($tag === 'button' ? ['type' => 'button'] + ($active !== null ? ['aria-pressed' => $active ? 'true' : 'false'] : []) : []) }}
>
    <div class="flex items-start justify-between gap-3">
        @if (filled($title))
            <span class="{{ $titleClasses }}">{{ $title }}</span>
        @endif

        @if (filled($icon))
            <x-fltc::icon :name="$icon" :color="$iconColor" class="text-lg" />
        @endif
    </div>

    <div class="{{ $counterClasses }}">{{ filled($count) ? $count : $slot }}</div>

    @if (filled($description))
        <p class="{{ $descriptionClasses }}">{{ $description }}</p>
    @endif
</{{ $tag }}>
