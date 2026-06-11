<span
    x-data="{
        open: false,
        tooltipStyle: '',
        showTimer: null,
        hideTimer: null,
        updatePosition() {
            const rect = this.$refs.trigger.getBoundingClientRect();
            const top = Math.max(rect.top - 8, 8);
            const left = rect.left + (rect.width / 2);

            this.tooltipStyle = `top: ${top}px; left: ${left}px;`;
        },
        show(immediate = false) {
            window.clearTimeout(this.hideTimer);

            if (this.open) {
                this.updatePosition();

                return;
            }

            const reveal = () => {
                this.updatePosition();

                this.$nextTick(() => {
                    window.requestAnimationFrame(() => {
                        this.open = true;
                    });
                });
            };

            if (immediate) {
                reveal();

                return;
            }

            this.showTimer = window.setTimeout(reveal, 120);
        },
        hide(immediate = false) {
            window.clearTimeout(this.showTimer);

            const conceal = () => {
                this.open = false;
            };

            if (immediate) {
                conceal();

                return;
            }

            this.hideTimer = window.setTimeout(conceal, 80);
        }
    }"
    x-on:mouseenter="show()"
    x-on:mouseleave="hide()"
    x-on:focusin="show(true)"
    x-on:focusout="hide(true)"
    x-on:resize.window="if (open) updatePosition()"
    x-on:scroll.window.passive="if (open) updatePosition()"
    x-on:keydown.escape.window="hide(true)"
    {{ $attributes->class([$classList]) }}
>
    <span x-ref="trigger" class="flex w-full">
        {{ $slot }}
    </span>

    @if(filled(trim($text)))
        <template x-teleport="body">
            <span
                x-cloak
                x-show="open"
                x-bind:style="tooltipStyle"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="{{ $tooltipClassList }}"
                role="tooltip"
            >{!! $text !!}</span>
        </template>
    @endif
</span>
