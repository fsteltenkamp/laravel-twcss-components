@php($tag = filled($link) ? 'a' : 'div')
<{{ $tag }}
    @if (filled($link)) href="{{ $link }}" @if ($navigate) wire:navigate @endif @endif
    {{ $attributes->class([$classList]) }}
>
    <div class="flex items-start justify-between gap-3">
        @if (filled($title))
            <span class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ $title }}</span>
        @endif

        @if (filled($icon))
            <i class="{{ $icon }} text-lg {{ $iconClasses }}" aria-hidden="true"></i>
        @endif
    </div>

    <div class="{{ $counterClasses }}">{{ filled($count) ? $count : $slot }}</div>

    @if (filled($description))
        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $description }}</p>
    @endif
</{{ $tag }}>
