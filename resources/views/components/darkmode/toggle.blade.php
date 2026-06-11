<div>
    <button
        type="button"
        class="flex h-8 w-20 items-center rounded-full bg-gray-300 shadow transition duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-400 dark:bg-slate-700 dark:focus-visible:ring-slate-500 cursor-pointer"
        data-darkmode-toggle>
        <div
            class="w-10 h-10 relative rounded-full transition duration-500 transform bg-yellow-500 -translate-x-2 p-1 text-white"
            data-darkmode-knob
            data-light-icon="{{ $lightIcon }}"
            data-dark-icon="{{ $darkIcon }}"
            data-storage-key="{{ $storageKey }}">
            {!! $lightIcon !!}
        </div>
    </button>

    <script>
    (function () {
        if (window.__tailwindDarkmodeToggleInitialized) {
            document.dispatchEvent(new CustomEvent('tailwind-darkmode-sync'));
            return;
        }

        window.__tailwindDarkmodeToggleInitialized = true;

        const lightClasses = ['bg-yellow-500', '-translate-x-2'];
        const darkClasses = ['bg-purple-800', 'translate-x-full'];

        const applyThemeState = (button) => {
            const knob = button.querySelector('[data-darkmode-knob]');

            if (!knob) {
                return;
            }

            const storageKey = knob.dataset.storageKey;
            const darkIcon = knob.dataset.darkIcon;
            const lightIcon = knob.dataset.lightIcon;
            const isDarkmode = localStorage.getItem(storageKey) === 'true';

            knob.classList.remove(...lightClasses, ...darkClasses);
            knob.classList.add(...(isDarkmode ? darkClasses : lightClasses));

            setTimeout(() => {
                knob.innerHTML = isDarkmode ? darkIcon : lightIcon;
            }, 250);

            document.documentElement.classList.toggle('dark', isDarkmode);
            button.setAttribute('aria-pressed', isDarkmode ? 'true' : 'false');
        };

        const syncAllDarkmodeToggles = () => {
            document.querySelectorAll('[data-darkmode-toggle]').forEach((button) => {
                applyThemeState(button);
            });
        };

        document.addEventListener('click', (event) => {
            const button = event.target.closest('[data-darkmode-toggle]');

            if (!button) {
                return;
            }

            const knob = button.querySelector('[data-darkmode-knob]');

            if (!knob) {
                return;
            }

            const storageKey = knob.dataset.storageKey;
            const isDarkmode = !(localStorage.getItem(storageKey) === 'true');

            localStorage.setItem(storageKey, isDarkmode ? 'true' : 'false');
            applyThemeState(button);
        });

        document.addEventListener('tailwind-darkmode-sync', syncAllDarkmodeToggles);
        document.addEventListener('livewire:navigated', syncAllDarkmodeToggles);

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', syncAllDarkmodeToggles);
        } else {
            syncAllDarkmodeToggles();
        }
    })();
    </script>
</div>
