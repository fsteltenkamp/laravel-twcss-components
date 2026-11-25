@if ($pinnable)
    {{--
        Pinned or hidden from lg up, per browser: data-sidebar="pinned|collapsed" on <html>,
        set before the sidebar paints. wire:navigate swaps the <html> attributes for the
        server's and drops data-sidebar; the observer puts it back before the next paint.
        window.fltcSidebar.pin() / .collapse() switch it (the buttons in the brand row).
    --}}
    <script>
    (function (key) {
        var root = document.documentElement;
        function apply() {
            var state = 'pinned';
            try { state = localStorage.getItem(key) === 'collapsed' ? 'collapsed' : 'pinned'; } catch (e) {}
            if (root.getAttribute('data-sidebar') !== state) root.setAttribute('data-sidebar', state);
        }
        function set(state) {
            try { localStorage.setItem(key, state); } catch (e) {}
            apply();
        }
        window.fltcSidebar = {
            pin: function () { set('pinned'); },
            collapse: function () { set('collapsed'); },
            state: function () { return root.getAttribute('data-sidebar'); },
        };
        apply();
        if (! window.__fltcSidebarObserver) {
            window.__fltcSidebarObserver = new MutationObserver(function () { apply(); });
            window.__fltcSidebarObserver.observe(root, { attributes: true, attributeFilter: ['data-sidebar'] });
        }
    })(@js($persist));
    </script>
@endif
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
        x-bind:class="open && @js($openClasses)"
        x-effect="document.body.classList.toggle('overflow-hidden', open && window.matchMedia('(max-width: 1023px)').matches)"
        x-on:fltc-sidebar-toggle.window="toggle($event.detail)"
        x-on:fltc-sidebar-open.window="show($event.detail)"
        x-on:fltc-sidebar-close.window="hide()"
        x-on:keydown.escape.window="hide()"
        x-on:resize.window="if (window.innerWidth >= 1024 && open && document.documentElement.getAttribute('data-sidebar') !== 'collapsed') open = false"
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
                class="fixed inset-0 z-40 bg-slate-900/50 {{ $backdropClasses }}"
                aria-hidden="true"
            ></div>
        </template>
    @endif

    @if (isset($brand) || $pinnable)
        <div class="fltc-nav-sidebar-brand flex {{ $headerClass }} shrink-0 items-center gap-3 px-4">
            {{ $brand ?? '' }}
            @if ($pinnable)
                <span class="ml-auto hidden lg:[[data-sidebar=pinned]_&]:inline-flex">
                    <x-fltc::button variant="ghost" square height="xs" :color="$color" icon="sidebar-simple" class="fltc-nav-sidebar-pin" x-on:click="window.fltcSidebar.collapse()" :title="__('Hide sidebar')" :aria-label="__('Hide sidebar')" />
                </span>
                <span class="ml-auto hidden lg:[[data-sidebar=collapsed]_&]:inline-flex">
                    <x-fltc::button variant="ghost" square height="xs" :color="$color" icon="push-pin" class="fltc-nav-sidebar-pin" x-on:click="window.fltcSidebar.pin(); open = false" :title="__('Pin sidebar')" :aria-label="__('Pin sidebar')" />
                </span>
            @endif
        </div>
    @endif

    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
        {{ $slot }}
    </nav>

    @isset($footer)
        {{ $footer }}
    @endisset
</aside>
