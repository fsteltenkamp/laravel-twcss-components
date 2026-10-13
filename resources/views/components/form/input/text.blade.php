@php
    $fieldName = $name !== '' ? $name : $id;
    $errorKey = rtrim($fieldName, '[]');
    $hasError = $errorKey !== '' && ($errors->has($errorKey) || $errors->has($errorKey.'.*'));
    $describedBy = \Fsteltenkamp\TwcssComponents\View\Components\Form\Field::describedBy($id, $note, $hasError, $errorKey);
@endphp

<x-fltc::form.field :label="$label" :note="$note" :for="$id" :name="$fieldName" :required="$required" :color="$color" :inline="$inline" :class="$wrapperClass">
    <div class="relative">
        <input
            {{ $attributes->class(trim($hasError ? $errorClasses : $normalClasses)) }}
            type="{{ $type }}"
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
            @if ($placeholder !== '') placeholder="{{ $placeholder }}" @endif
            @if ($autocomplete !== '') autocomplete="{{ $autocomplete }}" @endif
            @required($required)
            @disabled($disabled)
            @if ($autofocus) autofocus @endif
            @if ($hasError) aria-invalid="true" @endif
            @if ($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
        />
        @if ($icon !== '')
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 {{ $iconClasses() }}">
                <x-fltc::icon :name="$icon" :variant="$iconVariant" />
            </span>
        @endif
    </div>
</x-fltc::form.field>
