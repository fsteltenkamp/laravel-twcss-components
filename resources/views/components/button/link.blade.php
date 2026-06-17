@php($hasIcon = filled(trim($icon)))
@php($hasLabel = filled(trim($slot)))
@if(filled(trim($tooltip)))
	<x-fltc::tooltip :text="$tooltip" :theme="$theme" :class="$width === 'full' ? 'w-full' : ''">
		<a
			href="{{ $disabled ? '#' : $href }}"
			@if($navigate && !$disabled) wire:navigate @endif
			@if($disabled) aria-disabled="true" tabindex="-1" @endif
			{{ $attributes->class([
				$classList
			])->merge(['style' => $heightStyle]) }}
		>@if($hasIcon && $iconPosition !== 'after')<x-fltc::icon :name="$icon" :variant="$iconVariant" :after="$hasLabel ? '2' : ''" />@endif{{ $slot }}@if($hasIcon && $iconPosition === 'after')<x-fltc::icon :name="$icon" :variant="$iconVariant" :before="$hasLabel ? '2' : ''" />@endif</a>
	</x-fltc::tooltip>
@else
	<a
		href="{{ $disabled ? '#' : $href }}"
		@if($navigate && !$disabled) wire:navigate @endif
		@if($disabled) aria-disabled="true" tabindex="-1" @endif
		{{ $attributes->class([
			$classList
		])->merge(['style' => $heightStyle]) }}
	>@if($hasIcon && $iconPosition !== 'after')<x-fltc::icon :name="$icon" :variant="$iconVariant" :after="$hasLabel ? '2' : ''" />@endif{{ $slot }}@if($hasIcon && $iconPosition === 'after')<x-fltc::icon :name="$icon" :variant="$iconVariant" :before="$hasLabel ? '2' : ''" />@endif</a>
@endif
