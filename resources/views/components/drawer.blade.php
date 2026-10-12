@php
    $panelId = $attributes->get('id', 'fltc-drawer-'.$name);
@endphp
<aside
    x-data="fltcDrawer(@js([
        'name' => $name,
        'side' => $side,
        'open' => $open,
        'pinnable' => $pinnable,
        'width' => $panelWidth,
        'offset' => $offset,
    ]))"
    x-bind:class="open ? '!translate-x-0' : @js($closedClass)"
    x-bind:inert="! open"
    x-on:fltc-drawer-open.window="matches($event.detail) && show()"
    x-on:fltc-drawer-close.window="matches($event.detail) && hide()"
    x-on:fltc-drawer-toggle.window="matches($event.detail) && toggle()"
    x-on:keydown.escape.window="open && ! pinned && hide()"
    x-on:pointerdown.window="closeOnOutside($event)"
    @unless ($open) inert @endunless
    aria-label="{{ $title !== '' ? $title : ($label ?? $name) }}"
    {{ $attributes->class([$classList, $closedClass => ! $open])->merge([
        'id' => $panelId,
        'style' => 'top: '.$offset.'; width: '.$panelWidth.';',
        'data-fltc-drawer' => $name,
        'data-fltc-drawer-side' => $side,
    ]) }}
>
    @if ($hasTab)
        <template x-teleport="[data-fltc-drawer-rail='{{ $side }}']">
            <button
                type="button"
                class="{{ $tabClasses }}"
                style="order: {{ $order }}"
                x-bind:class="open ? @js($tabActiveClasses) : @js($tabRestingClasses)"
                x-bind:aria-expanded="open ? 'true' : 'false'"
                x-on:click="toggle()"
                aria-controls="{{ $panelId }}"
                title="{{ $title !== '' ? $title : $label }}"
                data-fltc-drawer-tab="{{ $name }}"
            >
                @if (filled($icon))
                    <x-fltc::icon :name="$icon" @class(['text-base leading-none [text-orientation:upright]', 'rotate-180' => $side === 'right']) />
                @endif
                @if (filled($label))
                    <span>{{ $label }}</span>
                @endif
            </button>
        </template>
    @endif

    <div class="{{ $headerClasses }}">
        <span class="{{ $titleClasses }}">{{ $title }}</span>

        <div class="flex shrink-0 items-center gap-1">
            @isset($actions)
                {{ $actions }}
            @endisset

            @if ($pinnable)
                <button
                    type="button"
                    class="{{ $pinClasses }}"
                    x-bind:class="pinned ? @js($pinActiveClasses) : @js($pinRestingClasses)"
                    x-bind:aria-pressed="pinned ? 'true' : 'false'"
                    x-bind:title="pinned ? 'Unpin drawer' : 'Pin drawer'"
                    x-on:click="togglePin()"
                    aria-pressed="false"
                    title="Pin drawer"
                    data-fltc-drawer-pin
                >
                    <x-fltc::icon name="push-pin" />
                </button>
            @endif

            <button
                type="button"
                class="{{ $buttonClasses }}"
                x-on:click="hide()"
                title="Close drawer"
                aria-label="Close drawer"
                data-fltc-drawer-close
            >
                <x-fltc::icon name="x" />
            </button>
        </div>
    </div>

    <div class="{{ $bodyClasses }}">
        {{ $slot }}
    </div>
</aside>

@assets
    <script>
        if (! window.fltcDrawers) {
            // Shared coordinator for every fltc drawer. Each drawer keeps
            // its own open/pinned state in Alpine (so it survives Livewire
            // morphs); this object only tracks the mounted drawers to enforce
            // "one open drawer per side" (per screen on mobile), lay out the
            // tab rails and publish the pinned widths as CSS variables.
            const PIN_PREFIX = 'fltc-drawer-pinned:';
            // Keep in sync with Tailwind's `sm` breakpoint: below it the panel
            // is near full-width, so only one drawer can be open at all.
            const mobile = window.matchMedia('(max-width: 639px)');
            // Matches the panel's transition-transform duration-200.
            const TRANSITION_MS = 200;
            // Keyed by a per-instance id: Alpine hands each method call a fresh
            // proxy as `this`, so object identity can't be used to compare.
            const drawers = new Map();
            let sequence = 0;

            const storage = {
                get: (name) => { try { return localStorage.getItem(PIN_PREFIX + name) === '1'; } catch (e) { return false; } },
                set: (name, pinned) => {
                    try {
                        pinned ? localStorage.setItem(PIN_PREFIX + name, '1') : localStorage.removeItem(PIN_PREFIX + name);
                    } catch (e) {}
                },
            };

            const api = window.fltcDrawers = {
                // The fixed column at the screen edge holding all tabs of one
                // side. Re-created on demand because wire:navigate swaps <body>.
                rail(side, offset) {
                    let rail = document.querySelector(`[data-fltc-drawer-rail='${side}']`);
                    if (! rail) {
                        rail = document.createElement('div');
                        rail.setAttribute('data-fltc-drawer-rail', side);
                        rail.className = side === 'left'
                            ? 'pointer-events-none fixed left-0 z-40 flex flex-col items-start gap-2 transition-transform duration-200 ease-out'
                            : 'pointer-events-none fixed right-0 z-40 flex flex-col items-end gap-2 transition-transform duration-200 ease-out';
                        document.body.appendChild(rail);
                    }
                    rail.style.top = `calc(${offset} + 1rem)`;
                    return rail;
                },

                // Slide each rail out beside its side's open panel and expose
                // pinned widths as --fltc-drawer-pin-left/right on <html>.
                layout() {
                    const root = document.documentElement;
                    const openOn = (side) => [...drawers.values()].find((d) => d.side === side && d.open);
                    let anyPinned = false;
                    for (const side of ['left', 'right']) {
                        const open = openOn(side);
                        const rail = document.querySelector(`[data-fltc-drawer-rail='${side}']`);
                        if (rail) {
                            rail.style.transform = ! open ? ''
                                : side === 'left' ? `translateX(${open.width})` : `translateX(calc(-1 * ${open.width}))`;
                            // On mobile the open panel spans the screen and its
                            // rail lands on the opposite edge — hide that edge's rail.
                            rail.style.visibility = mobile.matches && openOn(side === 'left' ? 'right' : 'left') ? 'hidden' : '';
                        }
                        const pinned = open && open.pinned ? open.width : '0px';
                        anyPinned = anyPinned || pinned !== '0px';
                        root.style.setProperty(`--fltc-drawer-pin-${side}`, pinned);
                    }
                    root.toggleAttribute('data-fltc-drawer-pinned', anyPinned);
                },

                // Close every drawer that would collide with `drawer`; returns
                // whether anything was closed so the caller can wait for it.
                closeOthers(drawer) {
                    let closed = false;
                    for (const d of drawers.values()) {
                        if (d.uid !== drawer.uid && d.open && (mobile.matches || d.side === drawer.side)) {
                            d.hide();
                            closed = true;
                        }
                    }
                    return closed;
                },

                open: (name) => window.dispatchEvent(new CustomEvent('fltc-drawer-open', { detail: name })),
                close: (name) => window.dispatchEvent(new CustomEvent('fltc-drawer-close', { detail: name })),
                toggle: (name) => window.dispatchEvent(new CustomEvent('fltc-drawer-toggle', { detail: name })),
            };

            const register = (Alpine) => Alpine.data('fltcDrawer', (config) => ({
                name: config.name,
                side: config.side,
                width: config.width,
                pinnable: config.pinnable,
                open: config.open,
                pinned: false,
                pending: null,
                uid: null,

                init() {
                    this.uid = ++sequence;
                    drawers.set(this.uid, this);
                    // Must exist before the tab's x-teleport (a child) initialises.
                    api.rail(this.side, config.offset);
                    this.$watch('open', () => api.layout());
                    this.$watch('pinned', () => api.layout());

                    if (this.pinnable && storage.get(this.name)) {
                        this.open = false;
                        this.setPinned(true);
                    } else if (this.open) {
                        api.closeOthers(this);
                    }
                    this.$nextTick(() => api.layout());
                },

                destroy() {
                    clearTimeout(this.pending);
                    drawers.delete(this.uid);
                    api.layout();
                },

                matches(detail) {
                    return [detail, detail?.name].includes(this.name);
                },

                // The active drawer is closed first; the new one slides in once
                // that close transition has finished.
                show() {
                    if (this.open || this.pending) return;
                    if (api.closeOthers(this)) {
                        this.pending = setTimeout(() => { this.pending = null; this.open = true; }, TRANSITION_MS);
                    } else {
                        this.open = true;
                    }
                },

                hide() {
                    clearTimeout(this.pending);
                    this.pending = null;
                    this.open = false;
                    this.setPinned(false);
                },

                toggle() {
                    this.open || this.pending ? this.hide() : this.show();
                },

                togglePin() {
                    this.setPinned(! this.pinned);
                },

                setPinned(pinned) {
                    if (! this.pinnable || this.pinned === pinned) return;
                    this.pinned = pinned;
                    storage.set(this.name, pinned);
                    if (pinned) this.show();
                },

                // Clicks outside every drawer panel, tab and trigger close the
                // unpinned drawers. Another drawer's tab is excluded so opening
                // it only swaps out the drawer on its own side.
                closeOnOutside(event) {
                    if (! this.open || this.pinned) return;
                    if (event.target.closest?.('[data-fltc-drawer], [data-fltc-drawer-tab], [data-fltc-drawer-trigger]')) return;
                    this.hide();
                },
            }));

            mobile.addEventListener('change', () => api.layout());

            if (window.Alpine) {
                register(window.Alpine);
            } else {
                document.addEventListener('alpine:init', () => register(window.Alpine));
            }
        }
    </script>
@endassets
