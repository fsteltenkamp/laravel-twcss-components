@php
    \Illuminate\Support\Facades\View::share('fltcProgress', null);
    $split = $slot->isNotEmpty();
    $parts = $segments();
    $total = $split ? array_sum(array_column($parts, 'value')) : $value;
@endphp
<div {{ $attributes->class([$classList]) }}>
    @if ($variant === 'meter' || $label !== '' || $showValue)
        <div class="mb-1.5 flex items-baseline justify-between gap-3">
            <span class="fltc-progress-label {{ $labelClasses }}">{{ $label }}</span>
            @if ($variant === 'meter')
                <span class="fltc-progress-value {{ $valueClasses }}">{{ $formatValue($total) }} / {{ $formatValue($max) }}</span>
            @elseif ($showValue)
                <span class="fltc-progress-value {{ $valueClasses }}">{{ round($split ? $percentOf($total, $max) : $percent) }}%</span>
            @endif
        </div>
    @endif

    <div
        class="fltc-progress-track {{ $trackClasses }}"
        role="progressbar"
        aria-valuemin="0"
        aria-valuemax="{{ $max }}"
        aria-valuenow="{{ $total }}"
        @if ($label !== '') aria-label="{{ $label }}" @endif
    >
        @if ($split)
            {{ $slot }}
        @else
            <div class="fltc-progress-fill {{ $fillClasses }}" style="width: {{ $percent }}%"></div>
        @endif
    </div>

    @if ($legend && $parts)
        <ul class="fltc-progress-legend {{ $legendClasses }}">
            @foreach ($parts as $segment)
                <li class="inline-flex items-center gap-1.5">
                    <span class="{{ $segment['swatchClasses'] }}"></span>
                    {{ $segment['label'] }}
                    <span class="tabular-nums opacity-75">{{ $formatValue($segment['value']) }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
