<div {{ $attributes->class([$boxClasses])->merge(['role' => 'alert']) }}>
    @if ($title !== '')
        <div class="fltc-messagebox-title {{ $titleClasses }}">
            @if ($icon !== '')<x-fltc::icon :name="$icon" />@endif
            {{ $title }}
        </div>
    @endif

    <div class="px-4 py-3">
        {{ $slot }}
    </div>

    @isset($details)
        <details class="fltc-messagebox-details {{ $detailsClasses }}">
            <summary class="cursor-pointer select-none text-xs font-medium opacity-80">{{ $details->attributes->get('summary', __('Details')) }}</summary>
            <pre class="mt-2 max-h-64 overflow-auto whitespace-pre-wrap break-words font-mono text-xs opacity-90">{{ $details }}</pre>
        </details>
    @endisset

    @isset($actions)
        <div class="fltc-messagebox-actions flex flex-wrap justify-end gap-2 px-4 pb-3">
            {{ $actions }}
        </div>
    @endisset
</div>
