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
    ($useHover || $href !== '') ? $hoverClasses : '',
    $stackRowClasses,
    'fltc-table-row-link cursor-pointer focus:outline-none focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-current' => $href !== '',
])->merge($href !== '' ? ['tabindex' => '0', 'data-href' => $href] : []) }}
    @if ($href !== '')
        x-data="{
            follow(event, newTab = false) {
                if (event.target.closest('a, button, input, select, textarea, label, summary, [data-row-ignore]')) return;
                if (window.getSelection && String(window.getSelection()).length) return;
                const href = this.$el.dataset.href;
                if (newTab || event.ctrlKey || event.metaKey || event.shiftKey) return window.open(href, '_blank');
                @if ($navigate) if (window.Livewire?.navigate) return window.Livewire.navigate(href); @endif
                window.location.href = href;
            },
        }"
        x-on:click="follow($event)"
        x-on:auxclick="$event.button === 1 && follow($event, true)"
        x-on:keydown.enter.self="follow($event)"
    @endif
>
    {{ $slot }}
</tr>
