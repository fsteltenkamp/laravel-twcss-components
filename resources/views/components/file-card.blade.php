<div {{ $attributes->class([$classList]) }}>
    <span class="fltc-file-card-preview {{ $previewClasses }}" aria-hidden="true">
        @isset($preview)
            {{ $preview }}
        @elseif ($previewType === 'image')
            <img src="{{ $src !== '' ? $src : $href }}" alt="" loading="lazy" class="h-full w-full object-cover" />
        @elseif ($previewType === 'text')
            <span class="fltc-file-card-excerpt {{ $excerptClasses }}">{{ \Illuminate\Support\Str::limit($excerpt, 400) }}</span>
        @else
            <x-fltc::icon :name="$fileIcon" class="text-2xl" />
        @endisset
    </span>

    <span class="min-w-0 flex-1">
        @if ($href !== '')
            <a href="{{ $href }}" class="fltc-file-card-name {{ $nameClasses }} hover:underline">{{ $name }}</a>
        @else
            <span class="fltc-file-card-name {{ $nameClasses }}">{{ $name }}</span>
        @endif
        <span class="fltc-file-card-meta {{ $metaClasses }}">{{ collect([$extension, $sizeLabel, $meta])->filter()->implode(' · ') }}</span>
    </span>

    @isset($actions)
        <span class="fltc-file-card-actions flex shrink-0 items-center gap-1">{{ $actions }}</span>
    @endisset
</div>
