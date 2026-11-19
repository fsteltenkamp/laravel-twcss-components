@aware([
    'stripeClasses' => '',
    'hoverClasses' => '',
    'rowBorderClasses' => '',
    'stackRowClasses' => '',
])

@php
    $useStriped = is_null($striped) ? filled($stripeClasses) : $striped;
    $useHover = is_null($hover) ? filled($hoverClasses) : $hover;
@endphp

<tr {{ $attributes->class([
    'transition-colors duration-150',
    $rowBorderClasses,
    $useStriped ? $stripeClasses : '',
    $useHover ? $hoverClasses : '',
    $stackRowClasses,
]) }}>
    {{ $slot }}
</tr>
