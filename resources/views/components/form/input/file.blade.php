@php
    $fieldName = $name !== '' ? $name : $id;
    // A multiple upload posts as name[]: its errors are keyed name / name.0, name.1, …
    $errorKey = rtrim($fieldName, '[]');
    $hasError = $errorKey !== '' && ($errors->has($errorKey) || $errors->has($errorKey.'.*'));
    $errorMessage = $errors->first($errorKey) ?: $errors->first($errorKey.'.*');
@endphp

<div @class([$wrapperClasses])>
    @if ($label !== '')
        <x-fltc::form.label :for="$id" :required="$required" :theme="$theme">
            {{ $label }}
        </x-fltc::form.label>
    @endif

    <input
        {{ $attributes->class(trim($hasError ? $errorClasses : $normalClasses)) }}
        type="file"
        id="{{ $id }}"
        name="{{ $fieldName }}"
        @if ($model !== '')
            @if ($live)
                wire:model.live="{{ $model }}"
            @else
                wire:model="{{ $model }}"
            @endif
        @endif
        @required($required)
        @disabled($disabled)
        @if ($hasError) aria-invalid="true" aria-describedby="{{ $errorKey }}-error" @endif
    />

    @if ($hasError)
        <p id="{{ $errorKey }}-error" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errorMessage }}</p>
    @endif
</div>
