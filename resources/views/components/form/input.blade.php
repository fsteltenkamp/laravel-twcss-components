@php
    $hasError = $id !== '' && $errors->has($id);
@endphp

<div {{ $attributes->class(['mb-4']) }}>
    @if ($label !== '')
        <x-fltc::form.label :for="$id" :required="$required">
            {{ $label }}
        </x-fltc::form.label>
    @endif

    {{ $slot }}

    @if ($hasError)
        <p id="{{ $id }}-error" class="{{ $errorClass }}">{{ $errors->first($id) }}</p>
    @endif
</div>
