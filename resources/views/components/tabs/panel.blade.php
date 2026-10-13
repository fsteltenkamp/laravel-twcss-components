<div
    {{ $attributes->class([$classList]) }}
    role="tabpanel"
    id="{{ $tabsId }}-panel-{{ $name }}"
    aria-labelledby="{{ $tabsId }}-tab-{{ $name }}"
    tabindex="0"
    x-show="active === @js($name)"
    @if ($cloak) x-cloak @endif
    @if ($hidden) style="display: none;" @endif
>
    {{ $slot }}
</div>
