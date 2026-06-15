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
        <select
            {{ $attributes->class(trim($hasError ? $errorClasses : $normalClasses)) }}
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
            @if ($hasError) aria-invalid="true" aria-describedby="{{ $fieldName }}-error" @endif
        >
            @if ($placeholder !== '')
                <option value="" disabled selected>{{ $placeholder }}</option>
            @endif
            <option>----- Bitte Wählen -----</option>
            {{ $slot }}
        </select>
        @if ($icon !== '')
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 dark:text-slate-500">
                <i class="ph ph-{{ $icon }}" aria-hidden="true"></i>
            </span>
        @endif
    </div>

    @if ($hasError)
        <p id="{{ $fieldName }}-error" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->first($fieldName) }}</p>
    @endif
</div>
