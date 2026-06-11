@aware([
    'stripeClasses' => '',
    'hoverClasses' => '',
    'rowBorderClasses' => '',
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
]) }}>
    {{ $slot }}
</tr>
