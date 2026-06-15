@php
    // When no explicit `color` is given we fall back to the neutral Primary Content
    // shades (see README "Color shades") so the text flips automatically in dark mode
    // instead of staying locked to whatever it inherited.
    $color = $attributes->get('color');
@endphp
<span
    @class(['text-slate-900 dark:text-slate-100' => blank($color)])
    style="
        font-family:{{$attributes->get('ff') ?? 'inherit'}};
        font-size:{{$attributes->get('fs') ?? 'inherit'}}pt;
        font-weight:{{$attributes->get('fw') ?? 'inherit'}};
        @if(filled($color))color:{{$color}};@endif
        text-align:{{$attributes->get('ta') ?? 'inherit'}};
        line-height:{{$attributes->get('lh') ?? 'inherit'}};
        letter-spacing:{{$attributes->get('ls') ?? 'inherit'}};
    "
>
{{$slot}}
</span>
