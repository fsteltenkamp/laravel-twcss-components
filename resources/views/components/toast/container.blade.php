{{--
    Dynamic toast container. Listens for `fltc:toast` (and `flux:toast` for Flux compat)
    window events and renders toasts with auto-dismiss, variant-specific layouts, and
    full theme support.

    Usage:
        @persist('fltc-toasts')
            <x-fltc::toast.container position="bottom-right" />
        @endpersist

    Dispatching (Alpine):   $dispatch('fltc:toast', { title: '…', theme: 'green', variant: 'card' })
    Dispatching (Livewire): $this->dispatch('fltc:toast', title: '…', theme: 'green')
    Dispatching (JS):       window.dispatchEvent(new CustomEvent('fltc:toast', { detail: { title: '…' } }))
--}}
<div
    x-data="{
        toasts: [],
        nextId: 0,

        defaultTheme:   @js($theme),
        defaultVariant: @js($variant),
        defaultDuration: @js($duration),

        themeMap: @js($themeMap),

        _toastHandler: null,
        _fluxHandler: null,

        init() {
            this._toastHandler = (e) => {
                this.add(e.detail || {});
            };

            this._fluxHandler = (e) => {
                const fluxMap = { success: 'green', warning: 'amber', danger: 'red', info: 'blue', default: 'gray' };
                const d = e.detail || {};
                this.add({ ...d, theme: fluxMap[d.variant] ?? this.defaultTheme });
            };

            window.addEventListener('fltc:toast', this._toastHandler);
            window.addEventListener('flux:toast',  this._fluxHandler);
        },

        destroy() {
            window.removeEventListener('fltc:toast', this._toastHandler);
            window.removeEventListener('flux:toast',  this._fluxHandler);
        },

        add(options) {
            const id = ++this.nextId;
            const toast = {
                id,
                title:   options.title   ?? '',
                message: options.message ?? null,
                icon:    options.icon    ?? null,
                theme:   options.theme   ?? this.defaultTheme,
                variant: options.variant ?? this.defaultVariant,
                duration: options.duration ?? this.defaultDuration,
                visible: true,
            };
            this.toasts.push(toast);
            if (toast.duration > 0) {
                setTimeout(() => this.dismiss(id), toast.duration);
            }
        },

        dismiss(id) {
            const t = this.toasts.find(t => t.id === id);
            if (t) t.visible = false;
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }, 200);
        },

        wrapperClasses(toast) {
            return (this.themeMap[toast.theme]?.[toast.variant] ?? this.themeMap.gray?.toast)?.wrapper ?? '';
        },

        iconClasses(toast) {
            return (this.themeMap[toast.theme]?.[toast.variant] ?? this.themeMap.gray?.toast)?.icon ?? '';
        },

        closeClasses(toast) {
            return (this.themeMap[toast.theme]?.[toast.variant] ?? this.themeMap.gray?.toast)?.close ?? '';
        },

        descClasses(toast) {
            return (this.themeMap[toast.theme]?.[toast.variant] ?? this.themeMap.gray?.toast)?.desc ?? '';
        },
    }"
    {{ $attributes->class([$classList]) }}
    aria-live="polite"
    aria-label="{{ __('Notifications') }}"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="toast.visible"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
            class="pointer-events-auto w-full"
            role="alert"
        >
            {{-- Card variant: header with title + body with message --}}
            <template x-if="toast.variant === 'card'">
                <div
                    :class="[wrapperClasses(toast), 'rounded-xl overflow-hidden']"
                >
                    <div class="flex items-center gap-2.5 px-4 py-2.5 border-b border-current/10">
                        <template x-if="toast.icon">
                            <i :class="[toast.icon, iconClasses(toast), 'shrink-0']" aria-hidden="true"></i>
                        </template>
                        <p class="flex-1 text-sm font-semibold leading-snug" x-text="toast.title"></p>
                        <button
                            :class="[closeClasses(toast), '-mr-0.5 rounded p-0.5 focus:outline-none focus:ring-2 focus:ring-current']"
                            x-on:click="dismiss(toast.id)"
                            aria-label="{{ __('Dismiss') }}"
                        >
                            <i class="ph ph-x text-sm" aria-hidden="true"></i>
                        </button>
                    </div>
                    <p
                        x-show="toast.message"
                        :class="[descClasses(toast), 'px-4 py-3 text-sm leading-relaxed']"
                        x-text="toast.message"
                    ></p>
                </div>
            </template>

            {{-- Baguette variant: centered ~80% wide solid-fill banner --}}
            <template x-if="toast.variant === 'baguette'">
                <div
                    :class="[wrapperClasses(toast), 'mx-auto flex w-4/5 items-center gap-4 rounded-xl px-6 py-3.5 text-sm']"
                >
                    <template x-if="toast.icon">
                        <i :class="[toast.icon, iconClasses(toast), 'text-lg shrink-0']" aria-hidden="true"></i>
                    </template>
                    <div class="flex min-w-0 flex-1 items-baseline gap-2">
                        <span class="font-medium" x-text="toast.title"></span>
                        <span
                            x-show="toast.message"
                            :class="[descClasses(toast), 'truncate text-xs']"
                            x-text="toast.message"
                        ></span>
                    </div>
                    <button
                        :class="[closeClasses(toast), 'shrink-0 rounded p-0.5 focus:outline-none focus:ring-2 focus:ring-white/50']"
                        x-on:click="dismiss(toast.id)"
                        aria-label="{{ __('Dismiss') }}"
                    >
                        <i class="ph ph-x text-sm" aria-hidden="true"></i>
                    </button>
                </div>
            </template>

            {{-- Toast variant (default): compact solid-fill horizontal bar --}}
            <template x-if="toast.variant === 'toast'">
                <div
                    :class="[wrapperClasses(toast), 'flex items-center gap-4 rounded-lg px-4 py-3 text-sm']"
                >
                    <template x-if="toast.icon">
                        <i :class="[toast.icon, iconClasses(toast), 'text-lg shrink-0']" aria-hidden="true"></i>
                    </template>
                    <div class="flex min-w-0 flex-1 items-baseline gap-2">
                        <span class="font-medium" x-text="toast.title"></span>
                        <span
                            x-show="toast.message"
                            :class="[descClasses(toast), 'truncate text-xs']"
                            x-text="toast.message"
                        ></span>
                    </div>
                    <button
                        :class="[closeClasses(toast), 'shrink-0 rounded p-0.5 focus:outline-none focus:ring-2 focus:ring-white/50']"
                        x-on:click="dismiss(toast.id)"
                        aria-label="{{ __('Dismiss') }}"
                    >
                        <i class="ph ph-x text-sm" aria-hidden="true"></i>
                    </button>
                </div>
            </template>

            {{-- Pill variant: lightweight bordered pill --}}
            <template x-if="toast.variant === 'pill'">
                <div
                    :class="[wrapperClasses(toast), 'flex items-center gap-2.5 rounded-full px-4 py-2 text-sm']"
                >
                    <template x-if="toast.icon">
                        <i :class="[toast.icon, iconClasses(toast), 'shrink-0']" aria-hidden="true"></i>
                    </template>
                    <span class="min-w-0 flex-1 font-medium leading-snug" x-text="toast.title"></span>
                    <span
                        x-show="toast.message"
                        :class="[descClasses(toast), 'shrink-0 text-xs']"
                        x-text="toast.message"
                    ></span>
                    <button
                        :class="[closeClasses(toast), 'shrink-0 rounded-full p-0.5 focus:outline-none focus:ring-2 focus:ring-current']"
                        x-on:click="dismiss(toast.id)"
                        aria-label="{{ __('Dismiss') }}"
                    >
                        <i class="ph ph-x text-sm" aria-hidden="true"></i>
                    </button>
                </div>
            </template>
        </div>
    </template>
</div>
