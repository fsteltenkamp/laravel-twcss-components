@props([
    'color' => 'base',
    'variant' => 'default',
])
@php
    use Fsteltenkamp\TwcssComponents\Support\ListTheme;

    // default: a framed box with dividers; inset: dividers only, for inside other
    // components (a message box, a card body); plain: no lines at all.
    $classList = match ($variant) {
        'inset' => 'divide-y '.ListTheme::divider($color),
        'plain' => '',
        default => 'divide-y overflow-hidden rounded-lg border '.ListTheme::surface($color),
    };
@endphp
<ul role="list" {{ $attributes->class(['fltc-list', 'fltc-color-'.$color, 'fltc-list-'.$variant, $classList]) }}>
    {{ $slot }}
</ul>
