@props(['hover' => false])

<div {{ $attributes->merge(['class' => 'relative h-full', 'data-navbar-dropdown' => '', 'data-navbar-dropdown-hover' => $hover ? 'true' : 'false']) }}>
    <button
        type="button"
        class="{{ $buttonClass }}"
        aria-haspopup="true"
        aria-expanded="false"
        data-dropdown-trigger
    >
        {{ $trigger }}
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.51a.75.75 0 01-1.08 0l-4.25-4.51a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
        </svg>
    </button>

    <div class="{{ $menuClass }}" data-dropdown-menu>
        <div class="p-1.5">
            {{ $slot }}
        </div>
    </div>
</div>

@once
    <script>
        if (!window.__navbarDropdownInitialized) {
            window.__navbarDropdownInitialized = true;

            const dropdownSelector = '[data-navbar-dropdown]';

            const closeDropdown = (dropdown) => {
                const trigger = dropdown.querySelector('[data-dropdown-trigger]');
                const menu = dropdown.querySelector('[data-dropdown-menu]');

                if (!trigger || !menu) {
                    return;
                }

                menu.classList.add('hidden');
                trigger.setAttribute('aria-expanded', 'false');
            };

            const openDropdown = (dropdown) => {
                const trigger = dropdown.querySelector('[data-dropdown-trigger]');
                const menu = dropdown.querySelector('[data-dropdown-menu]');

                if (!trigger || !menu) {
                    return;
                }

                menu.classList.remove('hidden');
                trigger.setAttribute('aria-expanded', 'true');
            };

            const closeAllDropdowns = () => {
                document.querySelectorAll(dropdownSelector).forEach((dropdown) => closeDropdown(dropdown));
            };

            document.addEventListener('click', (event) => {
                const trigger = event.target.closest('[data-dropdown-trigger]');

                if (trigger) {
                    event.preventDefault();

                    const dropdown = trigger.closest(dropdownSelector);

                    if (!dropdown) {
                        return;
                    }

                    const isOpen = trigger.getAttribute('aria-expanded') === 'true';
                    closeAllDropdowns();

                    if (!isOpen) {
                        openDropdown(dropdown);
                    }

                    return;
                }

                document.querySelectorAll(dropdownSelector).forEach((dropdown) => {
                    if (!dropdown.contains(event.target)) {
                        closeDropdown(dropdown);
                    }
                });
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeAllDropdowns();
                }
            });

            // Handle hover for dropdowns with hover enabled
            const setupHoverListeners = () => {
                document.querySelectorAll(dropdownSelector).forEach((dropdown) => {
                    if (dropdown.getAttribute('data-navbar-dropdown-hover') === 'true' && !dropdown.__hoverSetup) {
                        dropdown.__hoverSetup = true;
                        let hoverTimeout;

                        dropdown.addEventListener('mouseenter', () => {
                            clearTimeout(hoverTimeout);
                            openDropdown(dropdown);
                        });

                        dropdown.addEventListener('mouseleave', () => {
                            hoverTimeout = setTimeout(() => {
                                closeDropdown(dropdown);
                            }, 150);
                        });
                    }
                });
            };

            // Setup hover listeners immediately and after DOM changes
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', setupHoverListeners);
            } else {
                setupHoverListeners();
            }
        }
    </script>
@endonce
