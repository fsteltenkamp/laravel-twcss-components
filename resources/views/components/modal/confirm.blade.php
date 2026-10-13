@props([
    'name' => null,
    'title',
    'description' => null,
    'maxWidth' => 'md',
    'color' => 'base',
    'cancelColor' => null,
    'cancelLabel' => null,
    'teleport' => true,
])

<x-fltc::modal :name="$name" :maxWidth="$maxWidth" :color="$color" :teleport="$teleport" {{ $attributes->except(['name', 'maxWidth', 'color'])->class('fltc-modal-confirm') }}>
    <div class="space-y-6">
        <div class="space-y-2">
            <x-fltc::heading level="2" size="lg" :color="$color">{{ $title }}</x-fltc::heading>
            @if ($description)
                <x-fltc::subheading :color="$color">{{ $description }}</x-fltc::subheading>
            @endif
        </div>
        <div class="flex justify-end gap-2">
            <x-fltc::button variant="outline" :color="$cancelColor ?? $color" x-on:click="close()">{{ $cancelLabel ?? __('Cancel') }}</x-fltc::button>
            {{ $slot }}
        </div>
    </div>
</x-fltc::modal>
