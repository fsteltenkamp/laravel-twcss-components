@php($pickerId = 'theme-picker-'.uniqid())
{{--
    Each select writes its attribute on <html>, stores the value under its own key and
    broadcasts it, so several pickers on a page stay in sync. The custom theme's role
    palettes are stored together as JSON under `<themeStorageKey>-custom`.
--}}
<div {{ $attributes->class([$classList]) }}>
    @if (count($skinOptions) > 0)
        <div
            x-data="{
                key: @js($skinStorageKey),
                value: '',
                init() {
                    let stored = null;
                    try { stored = localStorage.getItem(this.key); } catch (e) {}
                    this.value = stored || document.documentElement.dataset.skin || @js($defaultSkin);
                    document.documentElement.dataset.skin = this.value;
                    this.$watch('value', (value) => {
                        document.documentElement.dataset.skin = value;
                        try { localStorage.setItem(this.key, value); } catch (e) {}
                        window.dispatchEvent(new CustomEvent('fltc-skin-change', { detail: value }));
                    });
                },
            }"
            x-on:fltc-skin-change.window="if ($event.detail !== value) value = $event.detail"
        >
            <x-fltc::form.input.select :id="$pickerId.'-skin'" :color="$color" :label="$skinLabel" icon="paint-brush" x-model="value" inline class="fltc-theme-picker-select">
                @foreach ($skinOptions as $value => $optionLabel)
                    <option value="{{ $value }}">{{ $optionLabel }}</option>
                @endforeach
            </x-fltc::form.input.select>
        </div>
    @endif

    @if (count($themeOptions) > 0)
        <div
            class="flex flex-col gap-4"
            x-data="{
                key: @js($themeStorageKey),
                value: '',
                roles: @js(\Fsteltenkamp\TwcssComponents\View\Components\Theme\Picker::DEFAULT_ROLES),
                init() {
                    const root = document.documentElement;
                    let stored = null, custom = null;
                    try { stored = localStorage.getItem(this.key); custom = JSON.parse(localStorage.getItem(this.key + '-custom') || 'null'); } catch (e) {}
                    this.value = stored || root.dataset.theme || @js($defaultTheme);
                    for (const role of Object.keys(this.roles)) {
                        const attr = root.getAttribute('data-theme-' + role);
                        this.roles[role] = (custom && custom[role]) || attr || this.roles[role];
                    }
                    this.apply();
                    this.$watch('value', () => this.save());
                    this.$watch('roles', () => this.save(), { deep: true });
                },
                apply() {
                    const root = document.documentElement;
                    root.dataset.theme = this.value;
                    for (const [role, palette] of Object.entries(this.roles)) root.setAttribute('data-theme-' + role, palette);
                },
                save() {
                    this.apply();
                    try {
                        localStorage.setItem(this.key, this.value);
                        localStorage.setItem(this.key + '-custom', JSON.stringify(this.roles));
                    } catch (e) {}
                    window.dispatchEvent(new CustomEvent('fltc-theme-change', { detail: { theme: this.value, roles: { ...this.roles } } }));
                },
            }"
            x-on:fltc-theme-change.window="if ($event.detail.theme !== value) value = $event.detail.theme; for (const [r, p] of Object.entries($event.detail.roles)) if (roles[r] !== p) roles[r] = p"
        >
            <x-fltc::form.input.select :id="$pickerId.'-theme'" :color="$color" :label="$themeLabel" icon="palette" x-model="value" inline class="fltc-theme-picker-select">
                @foreach ($themeOptions as $value => $optionLabel)
                    <option value="{{ $value }}">{{ $optionLabel }}</option>
                @endforeach
            </x-fltc::form.input.select>

            @if ($hasCustom)
                <div x-show="value === 'custom'" x-cloak class="fltc-theme-picker-roles grid grid-cols-2 gap-3">
                    @foreach (\Fsteltenkamp\TwcssComponents\View\Components\Theme\Picker::ROLES as $role)
                        <x-fltc::form.input.select :id="$pickerId.'-role-'.$role" :color="$role" :label="\Illuminate\Support\Str::headline($role)" x-model="roles.{{ $role }}" inline>
                            @foreach ($paletteOptions as $value => $optionLabel)
                                <option value="{{ $value }}">{{ $optionLabel }}</option>
                            @endforeach
                        </x-fltc::form.input.select>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if ($mode)
        <div>
            <x-fltc::form.label :color="$color">{{ $modeLabel }}</x-fltc::form.label>
            <x-fltc::darkmode.toggle :color="$color" />
        </div>
    @endif
</div>
