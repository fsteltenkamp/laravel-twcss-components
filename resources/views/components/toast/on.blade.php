<span
    hidden
    x-data="{
        handler: null,
        init() {
            const payload = @js($payload());
            this.handler = (event) => window.dispatchEvent(new CustomEvent('fltc:toast', { detail: { ...payload, ...(event.detail?.toast ?? {}) } }));
            window.addEventListener(@js($event), this.handler);
        },
        destroy() { window.removeEventListener(@js($event), this.handler); },
    }"
    {{ $attributes }}
></span>
