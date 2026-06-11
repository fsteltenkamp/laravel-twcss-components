@php
    $fieldName = $name !== '' ? $name : $id;
    $hasError = $fieldName !== '' && $errors->has($fieldName);
@endphp

<div class="mb-4">
    @if ($label !== '')
        <x-twcss::form.label :for="$id" :required="$required">
            {{ $label }}
        </x-twcss::form.label>
    @endif

    <textarea
        {{ $attributes->class($classList) }}
        id="{{ $id }}"
        name="{{ $fieldName }}"
        @if ($model !== '')
            @if ($live)
                wire:model.live="{{ $model }}"
            @else
                wire:model="{{ $model }}"
            @endif
        @endif
        @disabled($disabled)
        @readonly($readonly)
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        @if ($hasError) aria-invalid="true" aria-describedby="{{ $fieldName }}-error" @endif
    >{{ $slot->isNotEmpty() ? $slot : $value }}</textarea>

    @if ($hasError)
        <p id="{{ $fieldName }}-error" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $errors->first($fieldName) }}</p>
    @endif
</div>
