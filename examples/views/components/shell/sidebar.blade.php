{{--
    App shell, sidebar variant: a fixed full-height sidebar next to a scrolling
    content column with a slim top bar. Pass `active` to highlight the current
    sidebar link and `title` for the document title. Page body goes in the slot.
--}}
@props([
    'title' => 'App',
    'theme' => 'indigo',
    'active' => 'dashboard',
])

<x-ex::layout :title="$title" :theme="$theme">
    <div class="flex min-h-screen">
        <x-fltc::nav.sidebar :theme="$theme" class="sticky top-0">
            <x-slot:brand>
                <a href="app-sidebar-profile.html" class="flex items-center gap-2 font-semibold tracking-tight">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-{{ $theme }}-500 text-white">
                        <i class="ph ph-cube text-lg" aria-hidden="true"></i>
                    </span>
                    Acme&nbsp;Inc.
                </a>
            </x-slot:brand>

            <x-fltc::nav.sidebar.link href="app-sidebar-profile.html" icon="ph ph-gauge" :active="$active === 'dashboard'">Dashboard</x-fltc::nav.sidebar.link>
            <x-fltc::nav.sidebar.link href="app-sidebar-list.html" icon="ph ph-users" :active="$active === 'customers'">
                Customers
                <x-slot:trailing>
                    <x-fltc::badge :theme="$theme">128</x-fltc::badge>
                </x-slot:trailing>
            </x-fltc::nav.sidebar.link>
            <x-fltc::nav.sidebar.link href="#" icon="ph ph-chart-line">Reports</x-fltc::nav.sidebar.link>

            <x-fltc::nav.sidebar.group label="Settings" icon="ph ph-gear" :open="$active === 'profile'">
                <x-fltc::nav.sidebar.link href="app-sidebar-profile.html" :active="$active === 'profile'">Profile</x-fltc::nav.sidebar.link>
                <x-fltc::nav.sidebar.link href="#">Billing</x-fltc::nav.sidebar.link>
                <x-fltc::nav.sidebar.link href="#">Team</x-fltc::nav.sidebar.link>
            </x-fltc::nav.sidebar.group>

            <x-slot:footer>
                <x-fltc::nav.sidebar.footer>
                    <x-fltc::nav.sidebar.profile name="Jane Doe" email="jane@acme.test">
                        <x-fltc::nav.sidebar.link href="app-sidebar-profile.html" icon="ph ph-user">Your profile</x-fltc::nav.sidebar.link>
                        <x-fltc::nav.sidebar.link href="#" icon="ph ph-sign-out">Sign out</x-fltc::nav.sidebar.link>
                    </x-fltc::nav.sidebar.profile>
                </x-fltc::nav.sidebar.footer>
            </x-slot:footer>
        </x-fltc::nav.sidebar>

        <div class="flex min-w-0 flex-1 flex-col">
            <x-fltc::nav.navbar :theme="$theme" stickyTop containerClass="w-full px-4 sm:px-6 lg:px-8">
                <x-slot:left>
                    <span class="flex items-center text-sm font-medium opacity-70">
                        <i class="ph ph-list mr-2 text-lg" aria-hidden="true"></i>
                        Workspace
                    </span>
                </x-slot:left>
                <x-slot:right>
                    <x-fltc::nav.navbar.onclick onclick="return false" class="hidden items-center gap-2 sm:inline-flex">
                        <i class="ph ph-bell text-lg" aria-hidden="true"></i>
                    </x-fltc::nav.navbar.onclick>
                    <span class="flex items-center"><x-fltc::darkmode.toggle /></span>
                </x-slot:right>
            </x-fltc::nav.navbar>

            <main class="flex-1 px-4 py-8 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</x-ex::layout>
