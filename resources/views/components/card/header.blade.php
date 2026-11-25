<div data-card-header {{ $attributes->class([$classList]) }}>
    @if ($collapsible)
        <button type="button" class="fltc-card-toggle -my-1 flex w-full cursor-pointer items-center justify-between gap-3 py-1 text-left focus:outline-none focus-visible:underline" x-on:click="open = ! open" x-bind:aria-expanded="open.toString()">
            <span class="min-w-0 flex-1">{{ $slot }}</span>
            <x-fltc::icon name="caret-down" class="shrink-0 transition-transform duration-200" x-bind:class="open || '-rotate-90'" />
        </button>
    @else
        {{ $slot }}
    @endif
</div>
