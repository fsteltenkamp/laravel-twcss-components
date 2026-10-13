<span data-state="{{ $state }}" role="status" aria-live="polite" {{ $attributes->class([$classList]) }}>
    @foreach ($states as $key => $part)
        <span data-status="{{ $key }}" class="fltc-status-{{ $key }} fltc-color-{{ $part['color'] }} {{ $part['classes'] }}">
            @if ($key === 'saving' && $part['icon'] === '')
                <x-fltc::spinner color="current" size="xs" label="" aria-hidden="true" />
            @elseif ($part['icon'] !== '')
                <x-fltc::icon :name="$part['icon']" />
            @endif
            {{ $part['label'] }}
        </span>
    @endforeach
</span>
