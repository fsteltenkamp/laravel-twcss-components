@props([
    'name' => null,
    'title',
    'description' => null,
    'maxWidth' => 'md',
    'theme' => 'slate',
    'cancelTheme' => null,
    'cancelLabel' => null,
    'teleport' => true,
])

<x-fltc::modal :name="$name" :maxWidth="$maxWidth" :theme="$theme" :teleport="$teleport" {{ $attributes->except(['name', 'maxWidth', 'theme'])->class('fltc-modal-confirm') }}>
    <div class="space-y-6">
        <div class="space-y-2">
            <x-fltc::heading level="2" size="lg" :theme="$theme">{{ $title }}</x-fltc::heading>
            @if ($description)
                <x-fltc::subheading :theme="$theme">{{ $description }}</x-fltc::subheading>
            @endif
        </div>
        <div class="flex justify-end gap-2">
            <x-fltc::button variant="outline" :theme="$cancelTheme ?? $theme" x-on:click="close()">{{ $cancelLabel ?? __('Cancel') }}</x-fltc::button>
            {{ $slot }}
        </div>
    </div>
</x-fltc::modal>
