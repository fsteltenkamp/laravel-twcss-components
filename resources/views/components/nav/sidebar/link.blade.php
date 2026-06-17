<a
    href="{{ $href }}"
    {{ $attributes->class([$classList])->merge($isActive ? ['aria-current' => 'page', 'data-sidebar-active' => ''] : []) }}
>
    @if ($icon)
        <x-fltc::icon :name="$icon" class="shrink-0 text-base" />
    @endif

    <span class="min-w-0 flex-1 truncate">{{ $slot }}</span>

    @isset($trailing)
        <span class="ml-auto shrink-0">{{ $trailing }}</span>
    @endisset
</a>
