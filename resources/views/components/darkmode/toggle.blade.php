<div {{ $attributes }}>
    @if ($variant === 'toggle')
        <span data-darkmode-switch data-storage-key="{{ $storageKey }}">
            <x-fltc::form.checkbox
                variant="toggle"
                :theme="$theme"
                :themeOff="$themeOff"
                :size="$size"
                iconChecked="moon"
                iconUnchecked="sun"
                aria-label="Toggle dark mode"
            />
        </span>
    @else
        <div
            role="group"
            aria-label="Color theme"
            data-darkmode-group
            data-storage-key="{{ $storageKey }}"
            data-active-class="{{ $activeClasses }}"
            class="inline-flex items-center gap-1 rounded-lg bg-slate-100 p-1 dark:bg-slate-800"
        >
            @foreach ($options as $option)
                <button
                    type="button"
                    data-theme-option
                    data-theme-value="{{ $option['value'] }}"
                    aria-pressed="false"
                    class="inline-flex items-center gap-1.5 rounded-md px-3 py-1.5 text-sm font-medium transition-colors cursor-pointer text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-100"
                >
                    <x-fltc::icon :name="$option['icon']" class="leading-none" />
                    <span>{{ $option['label'] }}</span>
                </button>
            @endforeach
        </div>
    @endif

    <script>
    (function () {
        if (window.__fltcDarkmodeInitialized) {
            document.dispatchEvent(new CustomEvent('fltc-darkmode-sync'));
            return;
        }

        window.__fltcDarkmodeInitialized = true;

        const DEFAULT = 'system';
        const INACTIVE = ['text-slate-600', 'hover:text-slate-900', 'dark:text-slate-400', 'dark:hover:text-slate-100'];
        const media = window.matchMedia('(prefers-color-scheme: dark)');

        const getKey = () => {
            const el = document.querySelector('[data-darkmode-group], [data-darkmode-switch]');
            return el && el.dataset.storageKey ? el.dataset.storageKey : 'theme';
        };

        const getPref = () => localStorage.getItem(getKey()) || DEFAULT;

        const resolveDark = (pref) => pref === 'dark' ? true : pref === 'light' ? false : media.matches;

        const sync = () => {
            const pref = getPref();
            const isDark = resolveDark(pref);

            document.documentElement.classList.toggle('dark', isDark);

            document.querySelectorAll('[data-darkmode-group]').forEach((group) => {
                const active = (group.dataset.activeClass || '').split(' ').filter(Boolean);

                group.querySelectorAll('[data-theme-option]').forEach((button) => {
                    const isActive = button.dataset.themeValue === pref;

                    button.setAttribute('aria-pressed', isActive ? 'true' : 'false');

                    if (isActive) {
                        if (active.length) button.classList.add(...active);
                        button.classList.remove(...INACTIVE);
                    } else {
                        if (active.length) button.classList.remove(...active);
                        button.classList.add(...INACTIVE);
                    }
                });
            });

            document.querySelectorAll('[data-darkmode-switch]').forEach((toggle) => {
                const input = toggle.querySelector('input[type="checkbox"]');

                if (input) {
                    input.checked = isDark;
                }
            });
        };

        const setPref = (value) => {
            localStorage.setItem(getKey(), value);
            sync();
        };

        document.addEventListener('click', (event) => {
            const button = event.target.closest('[data-theme-option]');

            if (button) {
                setPref(button.dataset.themeValue);
            }
        });

        document.addEventListener('change', (event) => {
            const toggle = event.target.closest('[data-darkmode-switch]');

            if (!toggle) {
                return;
            }

            const input = toggle.querySelector('input[type="checkbox"]');

            setPref(input && input.checked ? 'dark' : 'light');
        });

        media.addEventListener('change', () => {
            if (getPref() === 'system') {
                sync();
            }
        });

        document.addEventListener('fltc-darkmode-sync', sync);
        document.addEventListener('livewire:navigated', sync);

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', sync);
        } else {
            sync();
        }
    })();
    </script>
</div>
