<x-fltc::buttongroup>
    <x-fltc::button
        wire:click="gotoPage(1)"
        theme="{{$mainTheme}}"
        width="fit"
        class="px-2.5 justify-center"
    ><x-icon i="skip-back"/></x-fltc::button>

    <x-fltc::button
        wire:click="gotoPage({{$currentPage - 1}})"
        theme="{{$mainTheme}}"
        width="fit"
        class="px-2.5 justify-center"
    ><x-icon i="rewind"/></x-fltc::button>

    @for ($i = $start; $i <= $end; $i++)
        <x-fltc::button
            wire:key="page_link_{{$i}}"
            wire:click="gotoPage({{$i}})"
            theme="{{ $i == $currentPage ? $accentTheme : $mainTheme }}"
            width="fit"
            class="min-w-9 px-3 justify-center !font-medium"
        >{{ $i }}</x-fltc::button>
    @endfor

    <x-fltc::button
        wire:click="gotoPage({{$currentPage + 1}})"
        theme="{{$mainTheme}}"
        width="fit"
        class="px-2.5 justify-center"
    ><x-icon i="fast-forward"/></x-fltc::button>

    <x-fltc::button
        wire:click="gotoPage({{$totalPages}})"
        theme="{{$mainTheme}}"
        width="fit"
        class="px-2.5 justify-center"
    ><x-icon i="skip-forward"/></x-fltc::button>
</x-fltc::buttongroup>
