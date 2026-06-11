@if(filled(trim($tooltip)))
    <x-twcss::tooltip :text="$tooltip" :theme="$theme" :class="$width === 'full' ? 'w-full' : ''">
        <button
            @disabled($disabled)
            {{ $attributes->class([
                $classList
            ])->merge([
                'type' => 'button',
                'style' => $heightStyle,
            ]) }}
        >{{ $slot }}</button>
    </x-twcss::tooltip>
@else
    <button
        @disabled($disabled)
        {{ $attributes->class([
            $classList
        ])->merge([
            'type' => 'button',
            'style' => $heightStyle,
        ]) }}
    >{{ $slot }}</button>
@endif
