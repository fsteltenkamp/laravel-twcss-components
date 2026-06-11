<x-twcss::buttongroup>
    <x-twcss::button
        wire:click="gotoPage(1)"
        theme="{{$mainTheme}}"
        width="fit"
        class="px-2.5 justify-center"
    ><x-icon i="skip-back"/></x-twcss::button>

    <x-twcss::button
        wire:click="gotoPage({{$currentPage - 1}})"
        theme="{{$mainTheme}}"
        width="fit"
        class="px-2.5 justify-center"
    ><x-icon i="rewind"/></x-twcss::button>

    @for ($i = $start; $i <= $end; $i++)
        <x-twcss::button
            wire:key="page_link_{{$i}}"
            wire:click="gotoPage({{$i}})"
            theme="{{ $i == $currentPage ? $accentTheme : $mainTheme }}"
            width="fit"
            class="min-w-9 px-3 justify-center !font-medium"
        >{{ $i }}</x-twcss::button>
    @endfor

    <x-twcss::button
        wire:click="gotoPage({{$currentPage + 1}})"
        theme="{{$mainTheme}}"
        width="fit"
        class="px-2.5 justify-center"
    ><x-icon i="fast-forward"/></x-twcss::button>

    <x-twcss::button
        wire:click="gotoPage({{$totalPages}})"
        theme="{{$mainTheme}}"
        width="fit"
        class="px-2.5 justify-center"
    ><x-icon i="skip-forward"/></x-twcss::button>
</x-twcss::buttongroup>
