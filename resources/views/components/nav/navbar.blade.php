<nav {{ $attributes->merge(['class' => $classList]) }}>
	<div class="{{ $containerClass }}">
		<div class="flex h-16 items-center gap-4">
			@isset($logo)
			<div class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden">
				{{ $logo }}
			</div>
			@endisset

			<div class="flex h-full min-w-0 items-stretch gap-1">
				@isset($left)
					{{ $left }}
				@else
					{{ $slot }}
				@endisset
			</div>

			<div class="ml-auto flex h-full min-w-0 items-stretch justify-end gap-1">
				@isset($right)
					{{ $right }}
				@endisset
			</div>
		</div>
	</div>
</nav>
