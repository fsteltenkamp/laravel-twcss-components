@php
    $fieldName = $name !== '' ? $name : $id;
    $errorKey = rtrim($fieldName, '[]');
    $hasError = $errorKey !== '' && ($errors->has($errorKey) || $errors->has($errorKey.'.*'));
    $describedBy = \Fsteltenkamp\TwcssComponents\View\Components\Form\Field::describedBy($id, $note, $hasError, $errorKey);
@endphp
<x-fltc::form.field :label="$label" :note="$note" :for="$id" :name="$fieldName" :required="$required" :theme="$theme" :inline="$inline" :class="$wrapperClass">
    <div
        x-data="{
            dragging: false,
            files: [],
            sync() { this.files = [...this.$refs.input.files].map((file) => file.name); },
            drop(event) {
                this.dragging = false;
                if (@js($disabled) || ! event.dataTransfer?.files?.length) return;
                const transfer = new DataTransfer();
                [...event.dataTransfer.files].slice(0, @js($multiple) ? undefined : 1).forEach((file) => transfer.items.add(file));
                this.$refs.input.files = transfer.files;
                this.$refs.input.dispatchEvent(new Event('change', { bubbles: true }));
            },
        }"
        {{ $attributes->only(['class', 'id'])->class(['fltc-form-upload']) }}
    >
        <label
            for="{{ $id }}"
            class="fltc-form-upload-zone {{ $zoneClasses }} {{ $idleClasses }}"
            x-bind:class="{ [@js($idleClasses)]: ! dragging, [@js($dragClasses)]: dragging }"
            x-bind:data-dragging="dragging"
            x-on:dragover.prevent="dragging = ! @js($disabled)"
            x-on:dragenter.prevent="dragging = ! @js($disabled)"
            x-on:dragleave.prevent="if (! $el.contains($event.relatedTarget)) dragging = false"
            x-on:drop.prevent="drop($event)"
        >
            <input
                {{ $attributes->except(['class', 'id']) }}
                x-ref="input"
                x-on:change="sync()"
                type="file"
                id="{{ $id }}"
                name="{{ $fieldName }}"
                class="sr-only"
                @if ($accept !== '') accept="{{ $accept }}" @endif
                @if ($multiple) multiple @endif
                @if ($model !== '')
                    @if ($live) wire:model.live="{{ $model }}" @else wire:model="{{ $model }}" @endif
                @endif
                @required($required)
                @disabled($disabled)
                @if ($hasError) aria-invalid="true" @endif
                @if ($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
            />
            @if ($icon !== '')<x-fltc::icon :name="$icon" class="fltc-form-upload-icon text-3xl" aria-hidden="true" />@endif
            <span class="fltc-form-upload-prompt text-sm font-medium">{{ $prompt }}</span>
            @if ($accept !== '')
                <span class="fltc-form-upload-hint {{ $hintClasses }}">{{ $accept }}</span>
            @endif
        </label>

        <ul class="fltc-form-upload-files {{ $listClasses }}" x-show="files.length" x-cloak style="display: none;" aria-live="polite">
            <template x-for="file in files" :key="file">
                <li class="flex items-center gap-2 truncate"><x-fltc::icon name="file" aria-hidden="true" /><span class="truncate" x-text="file"></span></li>
            </template>
        </ul>
    </div>
</x-fltc::form.field>
