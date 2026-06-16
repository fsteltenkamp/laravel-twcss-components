{{-- Login — Split variant: a marketing panel beside the form (panel hides on mobile). --}}
@php($theme = 'indigo')

<x-ex::layout title="Sign in" theme="slate">
    <div class="relative flex min-h-screen items-center justify-center px-4 py-12">
        <div class="absolute right-4 top-4"><x-fltc::darkmode.toggle /></div>

        <div class="w-full max-w-4xl">
            <x-fltc::form.container.auth.two-col-right :theme="$theme">
                {{-- Decorative / marketing side (left) --}}
                <x-slot:side>
                    <div class="flex h-full flex-col">
                        <a href="#" class="flex items-center gap-2 font-semibold tracking-tight">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-{{ $theme }}-500 text-white">
                                <i class="ph ph-cube text-lg" aria-hidden="true"></i>
                            </span>
                            Acme Inc.
                        </a>

                        <div class="mt-auto">
                            <blockquote class="text-lg font-medium leading-relaxed">
                                “This component library cut our build time in half. Everything just composes.”
                            </blockquote>
                            <div class="mt-4 flex items-center gap-3">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-{{ $theme }}-500 text-xs font-semibold text-white">AL</span>
                                <span class="text-sm">
                                    <span class="block font-semibold">Ada Lovelace</span>
                                    <span class="block opacity-70">Lead Engineer, Initech</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </x-slot:side>

                {{-- Form side (right) --}}
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Welcome back</h1>
                    <p class="mt-1 text-sm opacity-70">Sign in to continue to your dashboard.</p>

                    <form class="mt-6">
                        <x-fltc::form.input.email id="email" label="Email address" placeholder="you@example.com"
                            icon="envelope" autocomplete="email" :theme="$theme" required autofocus />

                        <x-fltc::form.input.password id="password" label="Password" placeholder="••••••••"
                            icon="lock" autocomplete="current-password" :theme="$theme" required />

                        <div class="mb-4 flex items-center justify-between">
                            <x-fltc::form.checkbox id="remember" label="Remember me" :theme="$theme" :bordered="false" class="!px-0" />
                            <a href="#" class="text-sm font-medium text-{{ $theme }}-600 hover:underline dark:text-{{ $theme }}-400">Forgot password?</a>
                        </div>

                        <x-fltc::button :theme="$theme" width="full" type="submit">Sign in</x-fltc::button>
                    </form>

                    <p class="mt-6 text-sm opacity-70">
                        Don't have an account?
                        <a href="register.html" class="font-medium text-{{ $theme }}-600 hover:underline dark:text-{{ $theme }}-400">Create one</a>
                    </p>
                </div>
            </x-fltc::form.container.auth.two-col-right>
        </div>
    </div>
</x-ex::layout>
