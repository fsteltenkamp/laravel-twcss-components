@once
    <style>
        [data-breadcrumb-list] > li:first-child [data-breadcrumb-separator] {
            display: none;
        }
    </style>
@endonce

<nav
    aria-label="Breadcrumb"
    {{ $attributes->merge(['class' => $classList]) }}
>
    <div class="{{ $containerClass }}">
        <ol data-breadcrumb-list class="{{ $listClass }}">
            @if ($items !== [])
                @foreach ($items as $item)
                    <x-fltc::nav.breadcrumbs.item
                        :href="$item['href']"
                        :icon="$item['icon']"
                        :is-active="$item['isActive']"
                        :show-separator="$item['showSeparator']"
                        :theme="$theme"
                    >{{ $item['label'] }}</x-fltc::nav.breadcrumbs.item>
                @endforeach
            @else
                {{ $slot }}
            @endif
        </ol>
    </div>
</nav>
