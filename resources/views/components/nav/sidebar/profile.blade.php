@php
    $hasMenu = isset($slot) && trim($slot) !== '';
    $identity = ['avatar' => $avatar, 'avatarClass' => $avatarClass, 'initials' => $initials, 'name' => $name, 'email' => $email];
@endphp

@if ($hasMenu)
    <div {{ $attributes->class(['relative'])->merge(['data-sidebar-profile' => '']) }}>
        <button
            type="button"
            class="{{ $triggerClass }}"
            data-sidebar-profile-trigger
            aria-haspopup="true"
            aria-expanded="false"
        >
            @include('fltc::components.nav.sidebar.profile.identity', $identity)
            <i class="ph ph-dots-three-vertical ml-auto shrink-0 text-base" aria-hidden="true"></i>
        </button>

        <div class="{{ $menuClass }}" data-sidebar-profile-menu>
            <div class="p-1.5">
                {{ $slot }}
            </div>
        </div>
    </div>

    @once
        <script>
            if (!window.__fltcSidebarProfileInitialized) {
                window.__fltcSidebarProfileInitialized = true;

                const profileSelector = '[data-sidebar-profile]';

                const closeProfile = (profile) => {
                    const menu = profile.querySelector('[data-sidebar-profile-menu]');
                    const trigger = profile.querySelector('[data-sidebar-profile-trigger]');
                    if (menu) menu.classList.add('hidden');
                    if (trigger) trigger.setAttribute('aria-expanded', 'false');
                };

                const openProfile = (profile) => {
                    const menu = profile.querySelector('[data-sidebar-profile-menu]');
                    const trigger = profile.querySelector('[data-sidebar-profile-trigger]');
                    if (menu) menu.classList.remove('hidden');
                    if (trigger) trigger.setAttribute('aria-expanded', 'true');
                };

                document.addEventListener('click', (event) => {
                    const trigger = event.target.closest('[data-sidebar-profile-trigger]');

                    if (trigger) {
                        event.preventDefault();
                        const profile = trigger.closest(profileSelector);
                        const isOpen = trigger.getAttribute('aria-expanded') === 'true';
                        document.querySelectorAll(profileSelector).forEach(closeProfile);
                        if (!isOpen && profile) openProfile(profile);
                        return;
                    }

                    document.querySelectorAll(profileSelector).forEach((profile) => {
                        if (!profile.contains(event.target)) {
                            closeProfile(profile);
                        }
                    });
                });

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape') {
                        document.querySelectorAll(profileSelector).forEach(closeProfile);
                    }
                });
            }
        </script>
    @endonce
@elseif ($href)
    <a href="{{ $href }}" {{ $attributes->class([$triggerClass]) }}>
        @include('fltc::components.nav.sidebar.profile.identity', $identity)
    </a>
@else
    <div {{ $attributes->class([$triggerClass]) }}>
        @include('fltc::components.nav.sidebar.profile.identity', $identity)
    </div>
@endif
