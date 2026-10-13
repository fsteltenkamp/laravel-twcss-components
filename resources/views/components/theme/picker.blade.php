@php($pickerId = 'theme-picker-'.uniqid())
{{--
    One Alpine scope per choice: each select writes its attribute on <html>, stores the
    value under its own key and broadcasts it, so several pickers on a page stay in sync.
--}}
<div {{ $attributes->class([$classList]) }}>
    @foreach ([
        ['options' => $skinOptions, 'attr' => 'skin', 'key' => $skinStorageKey, 'default' => $defaultSkin, 'label' => $skinLabel, 'icon' => 'paint-brush'],
        ['options' => $paletteOptions, 'attr' => 'palette', 'key' => $paletteStorageKey, 'default' => $defaultPalette, 'label' => $paletteLabel, 'icon' => 'palette'],
    ] as $choice)
        @if (count($choice['options']) > 0)
            <div
                x-data="{
                    key: @js($choice['key']),
                    attr: @js($choice['attr']),
                    value: '',
                    init() {
                        let stored = null;
                        try { stored = localStorage.getItem(this.key); } catch (e) {}
                        this.value = stored || document.documentElement.dataset[this.attr] || @js($choice['default']);
                        document.documentElement.dataset[this.attr] = this.value;
                        this.$watch('value', (value) => {
                            document.documentElement.dataset[this.attr] = value;
                            try { localStorage.setItem(this.key, value); } catch (e) {}
                            window.dispatchEvent(new CustomEvent('fltc-' + this.attr + '-change', { detail: value }));
                        });
                    },
                }"
                x-on:fltc-{{ $choice['attr'] }}-change.window="if ($event.detail !== value) value = $event.detail"
            >
                <x-fltc::form.input.select :id="$pickerId.'-'.$choice['attr']" :theme="$theme" :label="$choice['label']" :icon="$choice['icon']" x-model="value" inline class="fltc-theme-picker-select">
                    @foreach ($choice['options'] as $value => $optionLabel)
                        <option value="{{ $value }}">{{ $optionLabel }}</option>
                    @endforeach
                </x-fltc::form.input.select>
            </div>
        @endif
    @endforeach

    @if ($mode)
        <div>
            <x-fltc::form.label :theme="$theme">{{ $modeLabel }}</x-fltc::form.label>
            <x-fltc::darkmode.toggle :theme="$theme" />
        </div>
    @endif
</div>
