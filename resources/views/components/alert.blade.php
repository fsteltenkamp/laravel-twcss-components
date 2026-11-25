<div {{ $attributes->class(['rounded-md border p-4', $alertClasses]) }}>
    <div class="flex items-start gap-3">
        @if ($icon !== '')
            <x-fltc::icon :name="$icon" class="fltc-alert-icon mt-0.5 shrink-0 text-lg" aria-hidden="true" />
        @endif
        <div class="min-w-0 flex-1 text-sm">
            {{ $slot }}
        </div>
    </div>
</div>
