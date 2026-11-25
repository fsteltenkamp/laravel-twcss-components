<label
	for="{{ $for }}"
	{{ $attributes->class([$classList]) }}
>
	{{ $slot }}
	@if ($required)
		<span class="ml-1 text-danger-500 dark:text-danger-400">*</span>
	@endif
</label>
