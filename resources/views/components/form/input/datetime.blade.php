@php
    $fieldName = $name !== '' ? $name : $id;
    $hasError  = $fieldName !== '' && $errors->has($fieldName);
@endphp

<div class="mb-4">
    @if ($label !== '')
        <x-twcss::form.label :for="$id" :required="$required">
            {{ $label }}
        </x-twcss::form.label>
    @endif

    <div class="relative">
        <input
            {{ $attributes->class(trim($hasError ? $errorClasses : $normalClasses)) }}
            type="datetime-local"
            id="{{ $id }}"
            name="{{ $fieldName }}"
            @if ($model !== '')
                @if ($live)
                    wire:model.live="{{ $model }}"
                @else
                    wire:model="{{ $model }}"
                @endif
            @else
                value="{{ old($fieldName, $value) }}"
            @endif
            @required($required)
            @disabled($disabled)
            @if ($hasError) aria-invalid="true" aria-describedby="{{ $fieldName }}-error" @endif
        />
    </div>

    @if ($hasError)
        <p id="{{ $fieldName }}-error" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->first($fieldName) }}</p>
    @endif
</div>
