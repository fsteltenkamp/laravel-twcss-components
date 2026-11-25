<header {{ $attributes->class([$classList]) }}>
    <div class="fltc-page-header-text min-w-0">
        @if ($title !== '')
            <x-fltc::heading :level="$level" :size="$size" :color="$color">{{ $title }}</x-fltc::heading>
        @endif
        @if ($description !== '')
            <x-fltc::subheading :color="$color" class="mt-1">{{ $description }}</x-fltc::subheading>
        @endif
        @if ($slot->isNotEmpty())
            <div class="mt-2">{{ $slot }}</div>
        @endif
    </div>
    @isset($actions)
        <div class="fltc-page-header-actions flex flex-wrap items-center gap-2">{{ $actions }}</div>
    @endisset
</header>
