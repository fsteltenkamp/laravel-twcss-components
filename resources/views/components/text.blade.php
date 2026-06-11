<span
    style="
        font-family:{{$attributes->get('ff') ?? 'inherit'}};
        font-size:{{$attributes->get('fs') ?? 'inherit'}}pt;
        font-weight:{{$attributes->get('fw') ?? 'inherit'}};
        color:{{$attributes->get('color') ?? 'inherit'}};
        text-align:{{$attributes->get('ta') ?? 'inherit'}};
        line-height:{{$attributes->get('lh') ?? 'inherit'}};
        letter-spacing:{{$attributes->get('ls') ?? 'inherit'}};
    "
>
{{$slot}}
</span>
