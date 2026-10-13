@php
    $fieldName = $name !== '' ? $name : $id;
    // A multiple upload posts as name[]: its errors are keyed name / name.0, name.1, …
    $errorKey = rtrim($fieldName, '[]');
    $hasError = $errorKey !== '' && ($errors->has($errorKey) || $errors->has($errorKey.'.*'));
    $describedBy = \Fsteltenkamp\TwcssComponents\View\Components\Form\Field::describedBy($id, $note, $hasError, $errorKey);
@endphp

<x-fltc::form.field :label="$label" :note="$note" :for="$id" :name="$fieldName" :required="$required" :theme="$theme" :inline="$inline" :class="$wrapperClass">
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
        @if ($hasError) aria-invalid="true" @endif
        @if ($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
    />
</x-fltc::form.field>
