<div {{ $attributes->class([$classList]) }}>
    {{ $slot }}

    @if ($links !== [])
        {{-- Small links in a row, e.g. "Documentation · Imprint": label => href, or [label, href, external]. --}}
        <div class="{{ $linksClasses }}">
            @foreach ($links as $label => $link)
                @php
                    [$text, $href, $external] = is_array($link) ? [$link[0], $link[1], $link[2] ?? false] : [$label, $link, false];
                @endphp
                @if (! $loop->first)<span aria-hidden="true">·</span>@endif
                <a href="{{ $href }}" class="hover:underline" @if ($external) target="_blank" rel="noopener noreferrer" @endif>{{ $text }}</a>
            @endforeach
        </div>
    @endif
</div>
