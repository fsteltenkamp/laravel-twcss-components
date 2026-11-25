@php
    $fieldName = $name !== '' ? $name : $id;
    $hasError = $error !== '' || $fieldName !== '' && $errors->has($fieldName);
    $describedBy = \Fsteltenkamp\TwcssComponents\View\Components\Form\Field::describedBy($id, $note, $hasError, $fieldName);
@endphp

<x-fltc::form.field :label="$label" :note="$note" :for="$id" :name="$fieldName" :required="$required" :color="$color" :inline="$inline" :class="$wrapperClass" :error="$error" :errorIcon="$errorIcon" :noteToggle="$noteToggle">
    @isset($aside)
        <x-slot:aside>{{ $aside }}</x-slot:aside>
    @endisset
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
        @if ($hasError) aria-invalid="true" @endif
        @if ($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
    >{{ $slot->isNotEmpty() ? $slot : $value }}</textarea>
</x-fltc::form.field>
