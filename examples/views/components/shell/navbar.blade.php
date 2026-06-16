{{--
    App shell, top-navbar variant: a sticky top navigation bar over a centered
    content column. Pass `active` to highlight the current nav item and `title`
    for the document title. Page body goes in the default slot.
--}}
@props([
    'title' => 'App',
    'theme' => 'slate',
    'active' => 'dashboard',
])

@php
    $nav = [
        'dashboard' => ['label' => 'Dashboard', 'href' => 'app-navbar-profile.html', 'icon' => 'ph ph-gauge'],
        'profile'   => ['label' => 'Profile',   'href' => 'app-navbar-profile.html', 'icon' => 'ph ph-user'],
        'customers' => ['label' => 'Customers',  'href' => 'app-navbar-list.html',    'icon' => 'ph ph-users'],
    ];
    $activeLink = 'bg-'.$theme.'-100 font-semibold dark:bg-'.$theme.'-800';
@endphp

<x-ex::layout :title="$title" :theme="$theme">
    <div class="flex min-h-screen flex-col">
        <x-fltc::nav.navbar :theme="$theme" stickyTop>
            <x-slot:left>
                <a href="app-navbar-profile.html" class="flex items-center gap-2 px-2 font-semibold tracking-tight">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-{{ $theme }}-500 text-white">
                        <i class="ph ph-cube text-lg" aria-hidden="true"></i>
                    </span>
                    <span class="hidden sm:inline">Acme&nbsp;Inc.</span>
                </a>

                <span class="mx-1 hidden h-6 w-px self-center bg-{{ $theme }}-200 dark:bg-{{ $theme }}-700 sm:block"></span>

                @foreach ($nav as $key => $item)
                    <x-fltc::nav.navbar.link
                        href="{{ $item['href'] }}"
                        class="hidden items-center gap-2 sm:inline-flex {{ $active === $key ? $activeLink : '' }}"
                    >
                        <i class="{{ $item['icon'] }}" aria-hidden="true"></i>
                        {{ $item['label'] }}
                    </x-fltc::nav.navbar.link>
                @endforeach
            </x-slot:left>

            <x-slot:right>
                <x-fltc::nav.navbar.onclick onclick="return false" class="hidden items-center gap-2 sm:inline-flex">
                    <i class="ph ph-bell text-lg" aria-hidden="true"></i>
                </x-fltc::nav.navbar.onclick>

                <span class="flex items-center"><x-fltc::darkmode.toggle /></span>

                <x-fltc::nav.navbar.dropdown>
                    <x-slot:trigger>
                        <span class="flex items-center gap-2">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-{{ $theme }}-500 text-sm font-semibold text-white">JD</span>
                            <span class="hidden text-sm font-medium md:inline">Jane Doe</span>
                        </span>
                    </x-slot:trigger>

                    <x-fltc::nav.navbar.dropdown.link href="app-navbar-profile.html">
                        <i class="ph ph-user mr-2" aria-hidden="true"></i> Your profile
                    </x-fltc::nav.navbar.dropdown.link>
                    <x-fltc::nav.navbar.dropdown.link href="#">
                        <i class="ph ph-gear mr-2" aria-hidden="true"></i> Settings
                    </x-fltc::nav.navbar.dropdown.link>
                    <x-fltc::nav.navbar.dropdown.postlink action="#">
                        <i class="ph ph-sign-out mr-2" aria-hidden="true"></i> Sign out
                    </x-fltc::nav.navbar.dropdown.postlink>
                </x-fltc::nav.navbar.dropdown>
            </x-slot:right>
        </x-fltc::nav.navbar>

        <main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </div>
</x-ex::layout>
