@php($tag = filled($link) ? 'a' : 'div')
<{{ $tag }}
    @if (filled($link)) href="{{ $link }}" @if ($navigate) wire:navigate @endif @endif
    {{ $attributes->class([$classList]) }}
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
