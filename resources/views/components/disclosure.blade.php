<details
    {{ $attributes->class([$classList]) }}
    @if ($open) open @endif
    @if ($persist !== '' || $lazy)
        x-data="{
            key: @js($persist !== '' ? 'fltc-disclosure:'.$persist : ''),
            init() {
                if (this.key) {
                    try { const stored = localStorage.getItem(this.key); if (stored !== null) this.$el.open = stored === '1'; } catch (e) {}
                }
                this.render();
            },
            toggled() {
                if (this.key) {
                    try { localStorage.setItem(this.key, this.$el.open ? '1' : '0'); } catch (e) {}
                }
                this.render();
            },
            render() {
                const lazy = this.$el.open && this.$refs.lazy;
                if (lazy) {
                    lazy.parentNode.appendChild(lazy.content.cloneNode(true));
                    lazy.remove();
                }
            },
        }"
        x-on:toggle="toggled()"
    @endif
>
    <summary class="fltc-disclosure-summary {{ $summaryClasses }}">
        <x-fltc::icon name="caret-right" class="fltc-disclosure-caret shrink-0 transition-transform duration-200 group-open:rotate-90" />
        <span class="min-w-0 flex-1">{{ isset($title) ? $title : $summary }}</span>
        @isset($aside)
            <span class="fltc-disclosure-aside flex shrink-0 items-center gap-2">{{ $aside }}</span>
        @endisset
    </summary>
    <div class="fltc-disclosure-content {{ $contentClasses }}">
        @if ($lazy)
            <template x-ref="lazy">{{ $slot }}</template>
        @else
            {{ $slot }}
        @endif
    </div>
</details>
