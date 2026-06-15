<div data-card-rows {{ $attributes->class([$classList]) }}>
    <x-fltc::table
        :theme="$theme"
        :striped="$striped"
        :hover="$hover"
        :bordered="$bordered"
        :compact="$compact"
        :responsive="$responsive"
        :floating="$floating"
        radius="0"
    >
        @isset($head)
            <x-fltc::table.head>
                {{ $head }}
            </x-fltc::table.head>
        @endisset

        <tbody id="{{ $bodyId }}">
            {{ $slot }}
        </tbody>

        @isset($foot)
            <x-fltc::table.foot>
                {{ $foot }}
            </x-fltc::table.foot>
        @endisset
    </x-fltc::table>
</div>
