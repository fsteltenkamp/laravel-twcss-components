@php
    $errorKey = rtrim($name, '[]');
    $hasError = $error !== '' || ($errorKey !== '' && $errors->has($errorKey));
    $describedBy = \Fsteltenkamp\TwcssComponents\View\Components\Form\Field::describedBy($id, $note, $hasError, $errorKey);
@endphp
<x-fltc::form.field :label="$label" :note="$note" :for="$id" :name="$name" :required="$required" :color="$color" :inline="$inline" :class="$wrapperClass" :error="$error" :errorIcon="$errorIcon" :noteToggle="$noteToggle">
    @isset($aside)
        <x-slot:aside>{{ $aside }}</x-slot:aside>
    @endisset
    <div
        x-data="{
            mode: 'write',
            html: '',
            loading: false,
            get input() { return this.$refs.input; },
            changed() {
                this.input.dispatchEvent(new Event('input', { bubbles: true }));
                this.input.focus();
            },
            wrap(before, after, placeholder) {
                const el = this.input, start = el.selectionStart, end = el.selectionEnd;
                const text = el.value.slice(start, end) || placeholder;
                el.setRangeText(before + text + after, start, end, 'end');
                el.setSelectionRange(start + before.length, start + before.length + text.length);
                this.changed();
            },
            prefix(marker) {
                const el = this.input, start = el.value.lastIndexOf('\n', el.selectionStart - 1) + 1, end = el.selectionEnd;
                const lines = el.value.slice(start, end).split('\n');
                el.setRangeText(lines.map((line, i) => (marker === '1.' ? (i + 1) + '. ' : marker + ' ') + line).join('\n'), start, end, 'select');
                this.changed();
            },
            insert(text) {
                const el = this.input;
                el.setRangeText(text, el.selectionStart, el.selectionEnd, 'end');
                this.changed();
            },
            apply(action) {
                const el = this.input, multiline = el.value.slice(el.selectionStart, el.selectionEnd).includes('\n');
                ({
                    bold: () => this.wrap('**', '**', @js(__('bold text'))),
                    italic: () => this.wrap('_', '_', @js(__('italic text'))),
                    heading: () => this.prefix('##'),
                    code: () => multiline ? this.wrap('```\n', '\n```', '') : this.wrap('`', '`', 'code'),
                    link: () => this.wrap('[', '](https://)', @js(__('link text'))),
                    ul: () => this.prefix('-'),
                    ol: () => this.prefix('1.'),
                    quote: () => this.prefix('>'),
                })[action]?.();
            },
            async showPreview() {
                this.mode = 'preview';
                this.loading = true;
                const text = this.input.value;
                @if ($previewMethod !== '')
                    this.html = await this.$wire.call(@js($previewMethod), text);
                    this.loading = false;
                @else
                    window.dispatchEvent(new CustomEvent('fltc-markdown-preview', { detail: { id: @js($id), name: @js($name), value: text, render: (html) => { this.html = html; this.loading = false; } } }));
                @endif
            },
        }"
        {{ $attributes->only(['class'])->class([$frameClasses]) }}
    >
        <div class="fltc-form-markdown-bar flex flex-wrap items-center justify-between gap-1 border-b border-current/10 p-1">
            <div class="flex flex-wrap items-center gap-0.5" role="toolbar" aria-label="{{ __('Formatting') }}" x-show="mode === 'write'">
                @foreach ($toolbar as $action => $button)
                    <x-fltc::toolbar.button :icon="$button['icon']" :label="$button['label']" :color="$color" x-on:click="apply(@js($action))" :disabled="$disabled" />
                @endforeach
                @isset($controls)
                    <span class="fltc-toolbar-separator mx-1 h-5 w-px self-center bg-current opacity-20" aria-hidden="true"></span>
                    {{ $controls }}
                @endisset
            </div>
            @if ($preview)
                <div class="ml-auto flex items-center gap-0.5">
                    <x-fltc::toolbar.button :color="$color" x-on:click="mode = 'write'; $nextTick(() => input.focus())" x-bind:aria-pressed="(mode === 'write').toString()">{{ __('Write') }}</x-fltc::toolbar.button>
                    <x-fltc::toolbar.button :color="$color" x-on:click="showPreview()" x-bind:aria-pressed="(mode === 'preview').toString()">{{ __('Preview') }}</x-fltc::toolbar.button>
                </div>
            @endif
        </div>
        <textarea
            {{ $attributes->except(['class']) }}
            x-ref="input"
            x-show="mode === 'write'"
            id="{{ $id }}"
            name="{{ $name }}"
            rows="{{ $rows }}"
            class="fltc-form-markdown-input {{ $inputClasses }}"
            x-on:keydown.ctrl.b.prevent="apply('bold')"
            x-on:keydown.meta.b.prevent="apply('bold')"
            x-on:keydown.ctrl.i.prevent="apply('italic')"
            x-on:keydown.meta.i.prevent="apply('italic')"
            x-on:keydown.ctrl.k.prevent="apply('link')"
            x-on:keydown.meta.k.prevent="apply('link')"
            @if ($model !== '')
                @if ($live) wire:model.live="{{ $model }}" @else wire:model="{{ $model }}" @endif
            @endif
            @if ($placeholder !== '') placeholder="{{ $placeholder }}" @endif
            @required($required)
            @disabled($disabled)
            @if ($hasError) aria-invalid="true" @endif
            @if ($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
        >{{ $model === '' ? old($name, $value) : '' }}</textarea>
        @if ($preview)
            <div class="fltc-form-markdown-preview min-h-32 px-3 py-2" x-show="mode === 'preview'" x-cloak style="display: none;">
                <x-fltc::spinner :color="$color" size="sm" :text="__('Rendering preview…')" x-show="loading" />
                <x-fltc::prose :color="$color" x-show="! loading" x-html="html" />
            </div>
        @endif
    </div>
</x-fltc::form.field>
