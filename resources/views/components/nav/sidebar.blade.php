<aside {{ $attributes->class([$classList]) }}>
    @isset($brand)
        <div class="flex h-16 shrink-0 items-center gap-3 px-4">
            {{ $brand }}
        </div>
    @endisset

    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
        {{ $slot }}
    </nav>

    @isset($footer)
        {{ $footer }}
    @endisset
</aside>
