<div
    {{ $attributes->merge([
        'data-sidebar-group' => '',
        'data-sidebar-group-key' => $key,
        'data-sidebar-group-open' => $isOpen ? 'true' : 'false',
    ]) }}
>
    <button
        type="button"
        class="{{ $triggerClass }}"
        data-sidebar-group-trigger
        aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
    >
        @if ($icon)
            <x-fltc::icon :name="$icon" class="shrink-0 text-base" />
        @endif

        <span class="min-w-0 flex-1 truncate text-left">{{ $label }}</span>

        <x-fltc::icon
            name="caret-down"
            class="ml-auto shrink-0 text-sm transition-transform duration-200 {{ $isOpen ? 'rotate-180' : '' }}"
            data-sidebar-group-chevron
        />
    </button>

    <div data-sidebar-group-content @unless ($isOpen) hidden @endunless>
        <div class="ml-4 mt-1 space-y-1 border-l {{ $guideClass }} pl-3">
            {{ $slot }}
        </div>
    </div>
</div>

@once
    <script>
        if (!window.__fltcSidebarGroupInitialized) {
            window.__fltcSidebarGroupInitialized = true;

            const STORAGE_PREFIX = 'fltc.sidebar.group.';
            const groupSelector = '[data-sidebar-group]';

            const setOpen = (group, open, persist) => {
                const content = group.querySelector('[data-sidebar-group-content]');
                const trigger = group.querySelector('[data-sidebar-group-trigger]');
                const chevron = group.querySelector('[data-sidebar-group-chevron]');

                if (!content || !trigger) {
                    return;
                }

                content.hidden = !open;
                trigger.setAttribute('aria-expanded', open ? 'true' : 'false');

                if (chevron) {
                    chevron.classList.toggle('rotate-180', open);
                }

                if (persist) {
                    const key = group.getAttribute('data-sidebar-group-key');

                    if (key) {
                        try {
                            localStorage.setItem(STORAGE_PREFIX + key, open ? 'open' : 'closed');
                        } catch (e) {}
                    }
                }
            };

            const initGroups = () => {
                document.querySelectorAll(groupSelector).forEach((group) => {
                    if (group.__fltcInitialized) {
                        return;
                    }
                    group.__fltcInitialized = true;

                    const key = group.getAttribute('data-sidebar-group-key');
                    const hasActiveChild = !!group.querySelector('[data-sidebar-active]');

                    // Start from the server-rendered state, then let a remembered
                    // choice override it, and finally force open when the current
                    // URL lives on one of the group's sub-items.
                    let open = group.getAttribute('data-sidebar-group-open') === 'true';

                    if (key) {
                        try {
                            const stored = localStorage.getItem(STORAGE_PREFIX + key);
                            if (stored === 'open') open = true;
                            else if (stored === 'closed') open = false;
                        } catch (e) {}
                    }

                    if (hasActiveChild) {
                        open = true;
                    }

                    setOpen(group, open, false);

                    const trigger = group.querySelector('[data-sidebar-group-trigger]');

                    if (trigger && !trigger.__fltcBound) {
                        trigger.__fltcBound = true;
                        trigger.addEventListener('click', (event) => {
                            event.preventDefault();
                            const isOpen = trigger.getAttribute('aria-expanded') === 'true';
                            setOpen(group, !isOpen, true);
                        });
                    }
                });
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initGroups);
            } else {
                initGroups();
            }

            // Re-run after Livewire/wire:navigate SPA navigations.
            document.addEventListener('livewire:navigated', initGroups);
        }
    </script>
@endonce
