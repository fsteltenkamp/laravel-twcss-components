@if(filled(trim($tooltip)))
    <x-fltc::tooltip :text="$tooltip" :theme="$theme" :class="$width === 'full' ? 'w-full' : ''">
        <button
            @disabled($disabled)
            {{ $attributes->class([
                $classList
            ])->merge([
                'type' => 'button',
                'style' => $heightStyle,
            ]) }}
        >{{ $slot }}</button>
    </x-fltc::tooltip>
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
