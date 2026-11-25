@if ($collapsible)
    {{-- The header toggles the card; `persist` keeps the choice in localStorage. --}}
    <div
        x-data="{
            open: @js($open),
            init() {
                const key = @js($persist !== '' ? 'fltc-card:'.$persist : '');
                if (! key) return;
                try { const stored = localStorage.getItem(key); if (stored !== null) this.open = stored === '1'; } catch (e) {}
                this.$watch('open', (value) => { try { localStorage.setItem(key, value ? '1' : '0'); } catch (e) {} });
            },
        }"
        x-bind:data-collapsed="(! open).toString()"
        data-collapsed="{{ $open ? 'false' : 'true' }}"
        {{ $attributes->class([$classList]) }}
    >
        {{ $slot }}
    </div>
@else
    <div {{ $attributes->class([$classList]) }}>
        {{ $slot }}
    </div>
@endif
