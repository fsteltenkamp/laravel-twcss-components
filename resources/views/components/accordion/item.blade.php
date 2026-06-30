<div
    {{ $attributes->class([
        $classList,
    ])->merge([
        'data-accordion-item' => '',
        'data-accordion-item-draggable' => $isDraggable ? 'true' : 'false',
    ]) }}
>
    <button type="button" class="{{ $buttonClass }}" data-accordion-trigger aria-expanded="false">
        <span class="flex min-w-0 flex-1 items-start gap-3">
            @if ($isDraggable)
                <span
                    class="{{ $handleClass }}"
                    data-accordion-drag-handle
                    role="button"
                    tabindex="0"
                    title="Drag item"
                    aria-label="Drag item"
                >
                    <x-fltc::icon name="dots-six-vertical" />
                </span>
            @endif

            @isset($leading)
                {{ $leading }}
            @endisset

            <span class="min-w-0 flex-1">
                <span class="{{ $titleClass }}">{{ $title }}</span>

                @if (filled($subtext))
                    <span class="{{ $subtextClass }}">{{ $subtext }}</span>
                @endif
            </span>
        </span>

        <x-fltc::icon :name="$chevronClass" data-accordion-chevron />
    </button>

    <div class="{{ $contentClass }}" data-accordion-content hidden>
        {{ $slot }}
    </div>
</div>
