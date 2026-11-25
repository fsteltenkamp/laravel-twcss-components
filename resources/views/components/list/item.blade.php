@aware([
    'color' => 'base',
    'variant' => 'default',
])
@props([
    'href' => null,
    'navigate' => false,
    'icon' => null,
    'highlight' => false,
    'muted' => false,
])
@php
    use Fsteltenkamp\TwcssComponents\Support\ListTheme;
    use Fsteltenkamp\TwcssComponents\Support\Shades;

    // highlight: true for the item's colour, or a colour of its own (highlight="warning").
    $highlightColor = $highlight === true || $highlight === '' || $highlight === 'true' ? $color : ($highlight ?: null);
    $padding = $variant === 'inset' ? 'py-2.5' : 'px-4 py-3';
    $rowClasses = trim(implode(' ', [
        'flex items-start gap-3', $padding,
        $highlightColor ? ListTheme::highlight($highlightColor) : '',
        $muted ? 'opacity-60' : '',
    ]));
@endphp
<li {{ $attributes->class(['fltc-list-item', 'fltc-color-'.$color, 'fltc-list-item-highlight' => (bool) $highlightColor, 'fltc-list-item-muted' => $muted]) }}>
    @if ($href)
        <a href="{{ $href }}" @if ($navigate) wire:navigate @endif class="fltc-list-item-link {{ $rowClasses }} transition focus:outline-none {{ ListTheme::hover($color) }}">
    @else
        <div class="{{ $rowClasses }}">
    @endif
        @if ($icon)
            <x-fltc::icon :name="$icon" class="fltc-list-item-icon mt-0.5 shrink-0 {{ Shades::tertiary($color) }}" />
        @endif
        <div class="min-w-0 flex-1">
            <div class="fltc-list-item-title text-sm {{ Shades::primary($color) }}">{{ $slot }}</div>
            @isset($meta)
                <div class="fltc-list-item-meta mt-0.5 text-xs {{ Shades::tertiary($color) }}">{{ $meta }}</div>
            @endisset
        </div>
        @isset($aside)
            <div class="fltc-list-item-aside flex shrink-0 items-center gap-2 text-sm {{ Shades::secondary($color) }}">{{ $aside }}</div>
        @endisset
    @if ($href)
        </a>
    @else
        </div>
    @endif
</li>
