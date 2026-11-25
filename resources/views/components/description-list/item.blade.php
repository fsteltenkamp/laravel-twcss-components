@php
    $wrapper = match ($layout) {
        'stacked' => 'flex flex-col gap-0.5',
        'inline' => 'flex items-baseline gap-1.5',
        default => 'contents',
    };
@endphp
<div {{ $attributes->class([$wrapper, 'fltc-description-list-total' => $total]) }}>
    <dt class="fltc-description-list-term {{ $termClasses }}">@if ($icon !== '')<x-fltc::icon :name="$icon" />@endif{{ $label }}@if ($layout === 'inline'):@endif</dt>
    <dd class="fltc-description-list-value {{ $valueClasses }}">{{ $slot }}</dd>
</div>
