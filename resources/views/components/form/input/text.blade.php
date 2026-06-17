@php
    $fieldName = $name !== '' ? $name : $id;
    $hasError = $fieldName !== '' && $errors->has($fieldName);
@endphp

<div class="mb-4">
    @if ($label !== '')
        <x-fltc::form.label :for="$id" :required="$required">
            {{ $label }}
        </x-fltc::form.label>
    @endif

    <div class="relative">
        <input
            {{ $attributes->class(trim($hasError ? $errorClasses : $normalClasses)) }}
            type="text"
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
            placeholder="{{ $placeholder }}"
            @if ($autocomplete !== '') autocomplete="{{ $autocomplete }}" @endif
            @required($required)
            @disabled($disabled)
            @if ($autofocus) autofocus @endif
            @if ($hasError) aria-invalid="true" aria-describedby="{{ $fieldName }}-error" @endif
        />
        @if ($icon !== '')
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 dark:text-slate-500">
                <x-fltc::icon :name="$icon" :variant="$iconVariant" />
            </span>
        @endif
    </div>

    @if ($hasError)
        <p id="{{ $fieldName }}-error" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->first($fieldName) }}</p>
    @endif
</div>
