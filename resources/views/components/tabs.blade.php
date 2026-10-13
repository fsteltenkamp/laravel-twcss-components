<div
    x-data="{
        active: @js($active),
        init() {
            if (this.active === '' || this.active === null) {
                this.active = this.$refs.list.querySelector('[role=tab][data-tab]:not([disabled])')?.dataset.tab ?? '';
            }
        },
        focusTab(step) {
            const tabs = [...this.$refs.list.querySelectorAll('[role=tab]:not([disabled]):not([aria-disabled=true])')];
            const index = tabs.indexOf(document.activeElement);
            const next = tabs[(index + step + tabs.length) % tabs.length];
            next?.focus();
            if (next?.dataset.tab) this.active = next.dataset.tab;
        },
    }"
    x-modelable="active"
    id="{{ $tabsId }}"
    {{ $attributes->except('id')->class([$classList]) }}
>
    <div
        x-ref="list"
        role="tablist"
        x-on:keydown.arrow-right.prevent="focusTab(1)"
        x-on:keydown.arrow-left.prevent="focusTab(-1)"
        class="fltc-tabs-list {{ $listClasses }}"
    >
        {{ $list ?? '' }}
    </div>

    {{ $slot }}
</div>
