<div role="listitem" {{ $attributes->class(['flex items-start gap-3', $own ? 'ml-auto max-w-[85%] flex-row-reverse' : 'mr-auto max-w-[85%]', 'fltc-thread-message-own' => $own]) }}>
    @if ($showAvatar && $author !== '')
        <x-fltc::avatar :name="$author" :src="$avatar" size="sm" :color="$color" class="mt-1" />
    @endif
    <div class="{{ $classList }}">
        @if ($author !== '' || $meta !== '')
            <div class="fltc-thread-message-head {{ $headClasses }}">
                <span class="fltc-thread-message-author font-semibold">{{ $author }}</span>
                @if ($meta !== '')<span class="fltc-thread-message-meta {{ $metaClasses }}">{{ $meta }}</span>@endif
            </div>
        @endif
        <div class="fltc-thread-message-body px-4 py-3 text-sm">{{ $slot }}</div>
        @isset($footer)
            <div class="fltc-thread-message-footer border-t border-current/10 px-4 py-2 text-xs">{{ $footer }}</div>
        @endisset
    </div>
</div>
