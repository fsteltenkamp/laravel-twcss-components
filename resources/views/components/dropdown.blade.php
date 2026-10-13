<div
    x-data="{
        open: false,
        toggle() { this.open ? this.close() : this.show() },
        show() { this.open = true },
        close(focusTrigger = false) {
            if (! this.open) return;
            this.open = false;
            if (focusTrigger) this.$refs.trigger.querySelector('button, a, [tabindex]')?.focus();
        },
        focusItem(step) {
            const items = [...this.$refs.menu.querySelectorAll('[role=menuitem]:not([disabled]):not([aria-disabled=true])')];
            if (! items.length) return;
            const index = items.indexOf(document.activeElement);
            items[(index + step + items.length) % items.length].focus();
        },
    }"
    x-on:keydown.escape.window="close(true)"
    x-on:click.outside="close()"
    {{ $attributes->class([$classList]) }}
>
    <div
        x-ref="trigger"
        class="fltc-dropdown-trigger"
        x-on:click="toggle()"
        x-on:keydown.arrow-down.prevent="show(); $nextTick(() => focusItem(1))"
        aria-haspopup="menu"
        x-bind:aria-expanded="open"
    >
        {{ $trigger }}
    </div>

    <div
        x-ref="menu"
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        x-on:keydown.arrow-down.prevent="focusItem(1)"
        x-on:keydown.arrow-up.prevent="focusItem(-1)"
        x-on:click="if ($event.target.closest('[role=menuitem]')) close()"
        role="menu"
        style="display: none;"
        class="fltc-dropdown-menu {{ $menuClasses }}"
    >
        {{ $slot }}
    </div>
</div>
