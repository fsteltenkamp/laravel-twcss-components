<div role="region" @if ($title !== '') aria-label="{{ $title }}" @endif {{ $attributes->class([$classList])->merge(['style' => $style]) }}>
    <div class="flex min-w-0 flex-1 items-center gap-3">
        @if ($icon !== '')<x-fltc::icon :name="$icon" class="fltc-action-bar-icon text-lg" aria-hidden="true" />@endif
        <div class="min-w-0">
            @if ($title !== '')<p class="fltc-action-bar-title font-semibold">{{ $title }}</p>@endif
            @if ($slot->isNotEmpty())<div class="fltc-action-bar-text opacity-80">{{ $slot }}</div>@endif
        </div>
    </div>
    @isset($actions)
        <div class="fltc-action-bar-actions flex flex-wrap items-center gap-2">{{ $actions }}</div>
    @endisset
</div>
