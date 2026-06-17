<aside
    @if ($collapsible)
        x-data="{
            open: false,
            name: @js($name),
            matches(detail) { return !detail || !detail.name || detail.name === this.name; },
            toggle(detail) { if (this.matches(detail)) this.open = ! this.open; },
            show(detail) { if (this.matches(detail)) this.open = true; },
            hide() { this.open = false; },
        }"
        x-bind:class="open && 'max-lg:!translate-x-0'"
        x-effect="document.body.classList.toggle('overflow-hidden', open && window.matchMedia('(max-width: 1023px)').matches)"
        x-on:fltc-sidebar-toggle.window="toggle($event.detail)"
        x-on:fltc-sidebar-open.window="show($event.detail)"
        x-on:fltc-sidebar-close.window="hide()"
        x-on:keydown.escape.window="hide()"
        x-on:resize.window="if (window.innerWidth >= 1024 && open) open = false"
        x-on:click="$event.target.closest('a') && hide()"
    @endif
    {{ $attributes->class([$classList]) }}
>
    @if ($collapsible)
        {{-- Dimmed backdrop, shown only while the mobile drawer is open. --}}
        <template x-teleport="body">
            <div
                x-show="open"
                x-cloak
                x-transition.opacity.duration.200ms
                x-on:click="$dispatch('fltc-sidebar-close')"
                class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"
                aria-hidden="true"
            ></div>
        </template>
    @endif

    @isset($brand)
        <div class="flex h-16 shrink-0 items-center gap-3 px-4">
            {{ $brand }}
        </div>
    @endisset

    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
        {{ $slot }}
    </nav>

    @isset($footer)
        {{ $footer }}
    @endisset
</aside>
