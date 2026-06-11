<label
	for="{{ $for }}"
	{{ $attributes->class(['mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300']) }}
>
	{{ $slot }}
	@if ($required)
		<span class="ml-1 text-red-500 dark:text-red-400">*</span>
	@endif
</label>
