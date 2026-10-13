@php
    // `fc` is a raw CSS colour; without it the text takes the colour's Primary Content
    // shades (see README "Color shades") so it flips automatically in dark mode
    // instead of staying locked to whatever it inherited.
    $fontColor = $attributes->get('fc');
@endphp
<span
    {{ $attributes->except(['ff', 'fs', 'fw', 'fc', 'ta', 'lh', 'ls'])->class([$classList => blank($fontColor)]) }}
    style="
        font-family:{{$attributes->get('ff') ?? 'inherit'}};
        font-size:{{$attributes->get('fs') ?? 'inherit'}}pt;
        font-weight:{{$attributes->get('fw') ?? 'inherit'}};
        @if(filled($fontColor))color:{{$fontColor}};@endif
        text-align:{{$attributes->get('ta') ?? 'inherit'}};
        line-height:{{$attributes->get('lh') ?? 'inherit'}};
        letter-spacing:{{$attributes->get('ls') ?? 'inherit'}};
    "
>
{{$slot}}
</span>
