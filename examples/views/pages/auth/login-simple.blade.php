{{-- Login — Simple (centered) variant. --}}
@php($theme = 'sky')

<x-ex::layout title="Sign in" theme="slate">
    <div class="relative flex min-h-screen items-center justify-center px-4 py-12">
        <div class="absolute right-4 top-4"><x-fltc::darkmode.toggle /></div>

        <div class="w-full max-w-md">
            <div class="mb-6 flex flex-col items-center text-center">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-{{ $theme }}-500 text-white">
                    <i class="ph ph-cube text-2xl" aria-hidden="true"></i>
                </span>
                <h1 class="mt-4 text-2xl font-bold tracking-tight">Sign in to Acme Inc.</h1>
                <p class="mt-1 text-sm opacity-70">Welcome back — please enter your details.</p>
            </div>

            <x-fltc::form.container.auth.simple :theme="$theme">
                <div class="p-8">
                    <form>
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

                    <div class="my-6 flex items-center gap-3 text-xs uppercase tracking-wider opacity-50">
                        <span class="h-px flex-1 bg-current"></span> or <span class="h-px flex-1 bg-current"></span>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <x-fltc::button theme="slate" variant="outline" width="full">
                            <i class="ph ph-google-logo mr-2" aria-hidden="true"></i> Google
                        </x-fltc::button>
                        <x-fltc::button theme="slate" variant="outline" width="full">
                            <i class="ph ph-github-logo mr-2" aria-hidden="true"></i> GitHub
                        </x-fltc::button>
                    </div>
                </div>
            </x-fltc::form.container.auth.simple>

            <p class="mt-6 text-center text-sm opacity-70">
                Don't have an account?
                <a href="register.html" class="font-medium text-{{ $theme }}-600 hover:underline dark:text-{{ $theme }}-400">Create one</a>
            </p>
        </div>
    </div>
</x-ex::layout>
