<label
	for="{{ $for }}"
	{{ $attributes->class([$classList]) }}
>
	{{ $slot }}
	@if ($required)
		<span class="ml-1 text-red-500 dark:text-red-400">*</span>
	@endif
</label>
