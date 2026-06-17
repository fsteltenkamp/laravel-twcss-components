@php($hasIcon = filled(trim($icon)))
@php($hasLabel = filled(trim($slot)))
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
        >@if($hasIcon && $iconPosition !== 'after')<x-fltc::icon :name="$icon" :variant="$iconVariant" :after="$hasLabel ? '2' : ''" />@endif{{ $slot }}@if($hasIcon && $iconPosition === 'after')<x-fltc::icon :name="$icon" :variant="$iconVariant" :before="$hasLabel ? '2' : ''" />@endif</button>
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
    >@if($hasIcon && $iconPosition !== 'after')<x-fltc::icon :name="$icon" :variant="$iconVariant" :after="$hasLabel ? '2' : ''" />@endif{{ $slot }}@if($hasIcon && $iconPosition === 'after')<x-fltc::icon :name="$icon" :variant="$iconVariant" :before="$hasLabel ? '2' : ''" />@endif</button>
@endif
