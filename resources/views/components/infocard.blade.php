<span
    x-data="{ open: false, peek: false, canHover: window.matchMedia('(hover: hover)').matches }"
    x-on:keydown.escape="open = false; peek = false"
    {{ $attributes->class([$classList]) }}
>
    <button
        type="button"
        class="fltc-infocard-trigger {{ $triggerClasses }}"
        aria-expanded="false"
        x-bind:aria-expanded="open"
        x-on:click="open = ! open; peek = false"
        @if ($preview)
            x-on:mouseenter="if (canHover && ! open) peek = true"
            x-on:mouseleave="peek = false"
        @endif
    >{{ $trigger }}</button>

    @foreach ($preview ? ['preview', 'card'] : ['card'] as $mode)
        <span
            @if ($mode === 'preview')
                class="fltc-infocard-preview {{ $previewClasses }}"
                role="tooltip"
                x-show="peek"
            @else
                class="fltc-infocard-card {{ $cardClasses }}"
                x-show="open"
            @endif
            x-transition.opacity
            x-cloak
            style="display: none;"
        >
            @if ($image !== '')
                <img src="{{ $image }}" alt="" loading="lazy" @class(['fltc-infocard-image block w-full object-cover', 'h-24' => $mode === 'preview', 'h-40' => $mode === 'card']) />
            @endif
            <span class="block space-y-2 p-3">
                @if ($title !== '' || $icon !== '')
                    <span class="fltc-infocard-title {{ $titleClasses }}">
                        @if ($icon !== '')<x-fltc::icon :name="$icon" aria-hidden="true" />@endif
                        <span class="flex-1">{{ $title }}</span>
                        @if ($mode === 'card')
                            <button type="button" class="fltc-infocard-close opacity-60 hover:opacity-100" aria-label="{{ __('Close') }}" x-on:click="open = false"><x-fltc::icon name="x" /></button>
                        @endif
                    </span>
                @endif
                @if ($slot->isNotEmpty())
                    <span @class(['fltc-infocard-body', $bodyClasses, 'line-clamp-3' => $mode === 'preview'])>{{ $slot }}</span>
                @endif
                @if ($mode === 'card' && ($href !== '' || isset($actions)))
                    <span class="flex flex-wrap items-center justify-between gap-2 pt-1">
                        @if ($href !== '')
                            <a href="{{ $href }}" class="fltc-infocard-link {{ $linkClasses }}">{{ $linkLabel }} <x-fltc::icon name="arrow-right" aria-hidden="true" /></a>
                        @endif
                        @isset($actions)
                            <span class="fltc-infocard-actions flex flex-wrap gap-2">{{ $actions }}</span>
                        @endisset
                    </span>
                @endif
            </span>
        </span>
    @endforeach
</span>
