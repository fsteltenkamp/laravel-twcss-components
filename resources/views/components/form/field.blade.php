@php
    $errorMessage = $errorKey !== '' ? ($errors->first($errorKey) ?: $errors->first($errorKey.'.*')) : '';
@endphp
<div {{ $attributes->class([$classList]) }}>
    @if ($label !== '')
        <x-fltc::form.label :for="$for" :required="$required" :theme="$theme">
            {{ $label }}
        </x-fltc::form.label>
    @endif

    {{ $slot }}

    @if ($note !== '')
        <p id="{{ $for }}-note" class="fltc-form-field-note {{ $noteClasses }}">{{ $note }}</p>
    @endif

    @if ($errorMessage !== '')
        <p id="{{ $errorKey }}-error" class="fltc-form-field-error mt-2 text-sm text-red-600 dark:text-red-400">{{ $errorMessage }}</p>
    @endif
</div>
