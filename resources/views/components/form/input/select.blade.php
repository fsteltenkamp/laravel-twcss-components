@php
    $fieldName = $name !== '' ? $name : $id;
    $errorKey = rtrim($fieldName, '[]');
    $hasError = $errorKey !== '' && ($errors->has($errorKey) || $errors->has($errorKey.'.*'));
    $describedBy = \Fsteltenkamp\TwcssComponents\View\Components\Form\Field::describedBy($id, $note, $hasError, $errorKey);
@endphp

<x-fltc::form.field :label="$label" :note="$note" :for="$id" :name="$fieldName" :required="$required" :theme="$theme" :inline="$inline" :class="$wrapperClass">
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
            @if ($hasError) aria-invalid="true" @endif
            @if ($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
        >
            @if ($placeholder !== '')
                <option value="" disabled selected>{{ $placeholder }}</option>
            @endif
            {{ $slot }}
        </select>
        @if ($icon !== '')
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 {{ $iconClasses() }}">
                <x-fltc::icon :name="$icon" :variant="$iconVariant" />
            </span>
        @endif
    </div>
</x-fltc::form.field>
