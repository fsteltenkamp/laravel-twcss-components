<span {{ $attributes->class([$classList])->merge($name !== '' ? ['title' => $name] : []) }}>
    <span class="fltc-avatar-face {{ $faceClasses }}">
        @if ($src !== '')
            <img src="{{ $src }}" alt="{{ $name }}" class="h-full w-full object-cover" />
        @elseif ($icon !== '')
            <x-fltc::icon :name="$icon" aria-hidden="true" />
        @elseif ($initials !== '')
            <span aria-hidden="true">{{ $initials }}</span>
        @else
            <x-fltc::icon name="user" aria-hidden="true" />
        @endif
    </span>
    @if ($name !== '' && $src === '')
        <span class="sr-only">{{ $name }}</span>
    @endif
    @if ($statusClasses !== '')
        <span class="fltc-avatar-status {{ $statusClasses }}" data-status="{{ $status }}" role="img" aria-label="{{ $statusLabel }}"></span>
    @endif
</span>
