@if(filled(trim($tooltip)))
	<x-fltc::tooltip :text="$tooltip" :theme="$theme" :class="$width === 'full' ? 'w-full' : ''">
		<a
			href="{{ $disabled ? '#' : $href }}"
			@if($navigate && !$disabled) wire:navigate @endif
			@if($disabled) aria-disabled="true" tabindex="-1" @endif
			{{ $attributes->class([
				$classList
			])->merge(['style' => $heightStyle]) }}
		>{{ $slot }}</a>
	</x-fltc::tooltip>
@else
	<a
		href="{{ $disabled ? '#' : $href }}"
		@if($navigate && !$disabled) wire:navigate @endif
		@if($disabled) aria-disabled="true" tabindex="-1" @endif
		{{ $attributes->class([
			$classList
		])->merge(['style' => $heightStyle]) }}
	>{{ $slot }}</a>
@endif
