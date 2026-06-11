<div data-card-rows {{ $attributes->class([$classList]) }}>
    <x-twcss::table
        :theme="$theme"
        :striped="$striped"
        :hover="$hover"
        :bordered="$bordered"
        :compact="$compact"
        :responsive="$responsive"
        radius="0"
    >
        @isset($head)
            <x-twcss::table.head>
                {{ $head }}
            </x-twcss::table.head>
        @endisset

        <tbody id="{{ $bodyId }}">
            {{ $slot }}
        </tbody>

        @isset($foot)
            <x-twcss::table.foot>
                {{ $foot }}
            </x-twcss::table.foot>
        @endisset
    </x-twcss::table>
</div>
