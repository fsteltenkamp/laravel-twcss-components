@props([
    'name' => null,
    'title',
    'description' => null,
    'maxWidth' => 'md',
])

<x-fltc::modal :name="$name" :maxWidth="$maxWidth" {{ $attributes->except(['name', 'maxWidth']) }}>
    <div class="space-y-6">
        <div class="space-y-2">
            <x-fltc::heading level="2" size="lg">{{ $title }}</x-fltc::heading>
            @if ($description)
                <x-fltc::subheading>{{ $description }}</x-fltc::subheading>
            @endif
        </div>
        <div class="flex justify-end gap-2">
            <x-fltc::button variant="outline" theme="zinc" x-on:click="close()">{{ __('Cancel') }}</x-fltc::button>
            {{ $slot }}
        </div>
    </div>
</x-fltc::modal>
