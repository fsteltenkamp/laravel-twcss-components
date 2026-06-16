{{--
    Shared "Profile" page body, reused by both the navbar and sidebar app shells.
    Pure composition of <x-fltc::*> components: page header, stat counters, an
    identity card and an account-details form.
--}}
@props(['theme' => 'slate'])

<x-ex::page-header
    title="Profile"
    subtitle="Manage your personal information and account preferences."
    :crumbs="[
        ['label' => 'Home', 'href' => '#', 'icon' => 'ph ph-house'],
        ['label' => 'Settings', 'href' => '#'],
        ['label' => 'Profile'],
    ]"
>
    <x-slot:actions>
        <x-fltc::button theme="slate" variant="outline">Cancel</x-fltc::button>
        <x-fltc::button :theme="$theme">
            <i class="ph ph-floppy-disk mr-2" aria-hidden="true"></i> Save changes
        </x-fltc::button>
    </x-slot:actions>
</x-ex::page-header>

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <x-fltc::counter :theme="$theme" title="Projects" count="24" description="3 active this week" icon="ph ph-folder" />
    <x-fltc::counter :theme="$theme" title="Tasks done" count="312" description="+18 since Monday" icon="ph ph-check-circle" />
    <x-fltc::counter :theme="$theme" title="Teams" count="5" description="2 you own" icon="ph ph-users-three" />
    <x-fltc::counter :theme="$theme" title="Storage" count="48%" description="9.6 GB of 20 GB" icon="ph ph-database" />
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
    {{-- Identity --}}
    <x-fltc::card :theme="$theme" class="lg:col-span-4">
        <x-fltc::card.body>
            <div class="flex flex-col items-center text-center">
                <span class="flex h-20 w-20 items-center justify-center rounded-full bg-{{ $theme }}-500 text-2xl font-semibold text-white">JD</span>
                <h2 class="mt-4 text-lg font-semibold">Jane Doe</h2>
                <p class="text-sm opacity-70">jane@acme.test</p>
                <div class="mt-3 flex flex-wrap justify-center gap-2">
                    <x-fltc::badge theme="green">Active</x-fltc::badge>
                    <x-fltc::badge :theme="$theme">Admin</x-fltc::badge>
                    <x-fltc::badge theme="amber">Pro plan</x-fltc::badge>
                </div>
            </div>
        </x-fltc::card.body>

        <x-fltc::card.rows :theme="$theme">
            <x-fltc::table.row>
                <x-fltc::table.cell class="font-medium">Role</x-fltc::table.cell>
                <x-fltc::table.cell numeric>Administrator</x-fltc::table.cell>
            </x-fltc::table.row>
            <x-fltc::table.row>
                <x-fltc::table.cell class="font-medium">Location</x-fltc::table.cell>
                <x-fltc::table.cell numeric>Berlin, DE</x-fltc::table.cell>
            </x-fltc::table.row>
            <x-fltc::table.row>
                <x-fltc::table.cell class="font-medium">Phone</x-fltc::table.cell>
                <x-fltc::table.cell numeric>+49 30 123456</x-fltc::table.cell>
            </x-fltc::table.row>
        </x-fltc::card.rows>

        <x-fltc::card.footer :theme="$theme">
            <span class="text-xs opacity-70">Member since March 2021</span>
        </x-fltc::card.footer>
    </x-fltc::card>

    {{-- Edit form --}}
    <x-fltc::card :theme="$theme" class="lg:col-span-8">
        <x-fltc::card.header :theme="$theme">
            <h2 class="text-base font-semibold">Account details</h2>
        </x-fltc::card.header>

        <x-fltc::card.body>
            <form>
                <div class="grid grid-cols-1 gap-x-4 sm:grid-cols-2">
                    <x-fltc::form.input.text id="first_name" label="First name" value="Jane" :theme="$theme" required />
                    <x-fltc::form.input.text id="last_name" label="Last name" value="Doe" :theme="$theme" required />
                </div>

                <x-fltc::form.input.email id="email" label="Email address" value="jane@acme.test" icon="envelope" :theme="$theme" required />

                <x-fltc::form.input.select id="role" label="Role" :theme="$theme">
                    <option selected>Administrator</option>
                    <option>Editor</option>
                    <option>Viewer</option>
                </x-fltc::form.input.select>

                <x-fltc::form.textarea id="bio" label="Bio" :theme="$theme" :rows="4"
                    value="Product designer turned engineer. I build component libraries." />

                <div class="mt-2">
                    <x-fltc::form.checkbox id="notify" label="Email me about account activity" :theme="$theme" checked />
                </div>
            </form>
        </x-fltc::card.body>

        <x-fltc::card.footer :theme="$theme" class="flex justify-end gap-2">
            <x-fltc::button theme="slate" variant="outline">Reset</x-fltc::button>
            <x-fltc::button :theme="$theme">Save changes</x-fltc::button>
        </x-fltc::card.footer>
    </x-fltc::card>
</div>
