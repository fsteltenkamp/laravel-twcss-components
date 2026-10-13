<nav aria-label="{{ __('Pagination') }}" {{ $attributes->class(['flex flex-wrap items-center justify-between gap-3']) }}>
    @if ($summary)
        <p class="fltc-nav-pagination-summary {{ $summaryClasses }}">
            {{ __('Showing') }} <span class="font-medium">{{ $summary['first'] }}</span>–<span class="font-medium">{{ $summary['last'] }}</span>
            @if ($summary['total'] !== null)
                {{ __('of') }} <span class="font-medium">{{ $summary['total'] }}</span>
            @endif
        </p>
    @endif

    @if ($links)
        <x-fltc::buttongroup>
            @foreach ($links as $link)
                @php
                    $buttonClass = $link['label'] !== null ? 'min-w-9 px-3 justify-center !font-medium' : 'px-2.5 justify-center';
                    $buttonTheme = $link['current'] ? $accentTheme : $mainTheme;
                    $buttonVariant = $link['current'] ? 'solid' : 'outline';
                @endphp
                @if ($link['url'] !== null)
                    <x-fltc::button.link
                        :href="$link['url']"
                        :theme="$buttonTheme"
                        :variant="$buttonVariant"
                        width="fit"
                        :class="$buttonClass"
                        :aria-label="$link['ariaLabel']"
                        :aria-current="$link['current'] ? 'page' : null"
                    >@if ($link['icon'])<x-fltc::icon :name="$link['icon']" />@else{{ $link['label'] }}@endif</x-fltc::button.link>
                @else
                    <x-fltc::button
                        :wire:key="$link['key']"
                        :wire:click="$livewire && ! $link['disabled'] ? $wireClick($link['page']) : null"
                        :theme="$buttonTheme"
                        :variant="$buttonVariant"
                        width="fit"
                        :disabled="$link['disabled']"
                        :class="$buttonClass"
                        :aria-label="$link['ariaLabel']"
                        :aria-current="$link['current'] ? 'page' : null"
                    >@if ($link['icon'])<x-fltc::icon :name="$link['icon']" />@else{{ $link['label'] }}@endif</x-fltc::button>
                @endif
            @endforeach
        </x-fltc::buttongroup>
    @endif
</nav>
