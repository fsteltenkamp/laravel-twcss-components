{{-- Register — Simple (centered) variant. --}}
@php($theme = 'emerald')

<x-ex::layout title="Create account" theme="slate">
    <div class="relative flex min-h-screen items-center justify-center px-4 py-12">
        <div class="absolute right-4 top-4"><x-fltc::darkmode.toggle /></div>

        <div class="w-full max-w-md">
            <div class="mb-6 flex flex-col items-center text-center">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-{{ $theme }}-500 text-white">
                    <i class="ph ph-cube text-2xl" aria-hidden="true"></i>
                </span>
                <h1 class="mt-4 text-2xl font-bold tracking-tight">Create your account</h1>
                <p class="mt-1 text-sm opacity-70">Start your free 14-day trial. No card required.</p>
            </div>

            <x-fltc::form.container.auth.simple :theme="$theme">
                <div class="p-8">
                    <form>
                        <div class="grid grid-cols-1 gap-x-4 sm:grid-cols-2">
                            <x-fltc::form.input.text id="first_name" label="First name" placeholder="Jane" :theme="$theme" required autofocus />
                            <x-fltc::form.input.text id="last_name" label="Last name" placeholder="Doe" :theme="$theme" required />
                        </div>

                        <x-fltc::form.input.email id="email" label="Email address" placeholder="you@example.com"
                            icon="envelope" autocomplete="email" :theme="$theme" required />

                        <x-fltc::form.input.password id="password" label="Password" placeholder="At least 8 characters"
                            icon="lock" autocomplete="new-password" :theme="$theme" required />

                        <x-fltc::form.input.password id="password_confirmation" label="Confirm password" placeholder="Repeat your password"
                            icon="lock-key" autocomplete="new-password" :theme="$theme" required />

                        <div class="mb-4">
                            <x-fltc::form.checkbox id="terms" label="I agree to the Terms of Service and Privacy Policy." :theme="$theme" />
                        </div>

                        <x-fltc::button :theme="$theme" width="full" type="submit">Create account</x-fltc::button>
                    </form>
                </div>
            </x-fltc::form.container.auth.simple>

            <p class="mt-6 text-center text-sm opacity-70">
                Already have an account?
                <a href="login-simple.html" class="font-medium text-{{ $theme }}-600 hover:underline dark:text-{{ $theme }}-400">Sign in</a>
            </p>
        </div>
    </div>
</x-ex::layout>
