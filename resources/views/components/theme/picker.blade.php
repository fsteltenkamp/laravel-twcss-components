@php($selectId = 'theme-picker-'.uniqid())
<div
    x-data="{
        key: @js($storageKey),
        skin: '',
        init() {
            let stored = null;
            try { stored = localStorage.getItem(this.key); } catch (e) {}
            this.skin = stored || document.documentElement.dataset.skin || @js($default);
            document.documentElement.dataset.skin = this.skin;
            this.$watch('skin', (value) => {
                document.documentElement.dataset.skin = value;
                try { localStorage.setItem(this.key, value); } catch (e) {}
                window.dispatchEvent(new CustomEvent('fltc-skin-change', { detail: value }));
            });
        },
    }"
    x-on:fltc-skin-change.window="if ($event.detail !== skin) skin = $event.detail"
    {{ $attributes->class([$classList]) }}
>
    <x-fltc::form.input.select :id="$selectId" :theme="$theme" :label="$label" icon="palette" x-model="skin" inline class="fltc-theme-picker-select">
        @foreach ($options as $value => $optionLabel)
            <option value="{{ $value }}">{{ $optionLabel }}</option>
        @endforeach
    </x-fltc::form.input.select>

    @if ($mode)
        <div>
            <x-fltc::form.label :theme="$theme">{{ $modeLabel }}</x-fltc::form.label>
            <x-fltc::darkmode.toggle :theme="$theme" />
        </div>
    @endif
</div>
