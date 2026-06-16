{{--
    Shared "Customers" list page body, reused by both app shells. Stat counters,
    a toolbar, a data table with status badges and row actions, and pagination —
    all composed from <x-fltc::*> components.
--}}
@props(['theme' => 'slate'])

@php
    $customers = [
        ['name' => 'Olivia Martin',  'email' => 'olivia@acme.test',   'plan' => 'Enterprise', 'status' => 'Active',   'badge' => 'green',  'spend' => '$12,400'],
        ['name' => 'Jackson Lee',    'email' => 'jackson@acme.test',  'plan' => 'Pro',        'status' => 'Active',   'badge' => 'green',  'spend' => '$3,210'],
        ['name' => 'Isabella Nguyen','email' => 'isabella@acme.test', 'plan' => 'Pro',        'status' => 'Trialing', 'badge' => 'amber',  'spend' => '$0'],
        ['name' => 'William Kim',    'email' => 'william@acme.test',  'plan' => 'Free',       'status' => 'Inactive', 'badge' => 'slate',  'spend' => '$0'],
        ['name' => 'Sofia Davis',    'email' => 'sofia@acme.test',    'plan' => 'Enterprise', 'status' => 'Past due', 'badge' => 'red',    'spend' => '$8,900'],
    ];
@endphp

<x-ex::page-header
    title="Customers"
    subtitle="128 customers across all plans."
    :crumbs="[
        ['label' => 'Home', 'href' => '#', 'icon' => 'ph ph-house'],
        ['label' => 'Customers'],
    ]"
>
    <x-slot:actions>
        <x-fltc::button theme="slate" variant="outline">
            <i class="ph ph-export mr-2" aria-hidden="true"></i> Export
        </x-fltc::button>
        <x-fltc::button :theme="$theme">
            <i class="ph ph-plus mr-2" aria-hidden="true"></i> New customer
        </x-fltc::button>
    </x-slot:actions>
</x-ex::page-header>

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
    <x-fltc::counter :theme="$theme" title="Total customers" count="128" description="+6 this month" icon="ph ph-users" />
    <x-fltc::counter theme="green" title="Active" count="98" description="76% of total" icon="ph ph-pulse" />
    <x-fltc::counter theme="amber" title="Trialing" count="14" description="ending soon" icon="ph ph-hourglass" />
</div>

<x-fltc::card :theme="$theme">
    <x-fltc::card.header :theme="$theme" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-base font-semibold">All customers</h2>
        <div class="w-full sm:max-w-xs">
            <x-fltc::form.input.text id="search" placeholder="Search customers…" icon="magnifying-glass" :theme="$theme" class="!mb-0" />
        </div>
    </x-fltc::card.header>

    <x-fltc::table :theme="$theme" striped hover bordered="false">
        <x-fltc::table.head>
            <x-fltc::table.row>
                <x-fltc::table.cell header>Customer</x-fltc::table.cell>
                <x-fltc::table.cell header>Plan</x-fltc::table.cell>
                <x-fltc::table.cell header>Status</x-fltc::table.cell>
                <x-fltc::table.cell header numeric>Lifetime spend</x-fltc::table.cell>
                <x-fltc::table.cell header numeric>Actions</x-fltc::table.cell>
            </x-fltc::table.row>
        </x-fltc::table.head>

        @foreach ($customers as $customer)
            <x-fltc::table.row>
                <x-fltc::table.cell>
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-{{ $theme }}-500 text-xs font-semibold text-white">
                            {{ \Illuminate\Support\Str::of($customer['name'])->explode(' ')->map(fn ($p) => $p[0])->take(2)->implode('') }}
                        </span>
                        <span class="min-w-0">
                            <span class="block truncate font-medium">{{ $customer['name'] }}</span>
                            <span class="block truncate text-xs opacity-60">{{ $customer['email'] }}</span>
                        </span>
                    </div>
                </x-fltc::table.cell>
                <x-fltc::table.cell>{{ $customer['plan'] }}</x-fltc::table.cell>
                <x-fltc::table.cell>
                    <x-fltc::badge :theme="$customer['badge']">{{ $customer['status'] }}</x-fltc::badge>
                </x-fltc::table.cell>
                <x-fltc::table.cell numeric class="font-medium">{{ $customer['spend'] }}</x-fltc::table.cell>
                <x-fltc::table.cell numeric>
                    <div class="inline-flex items-center gap-1">
                        <x-fltc::button.link href="#" theme="slate" variant="outline" tooltip="View" class="!px-2.5">
                            <i class="ph ph-eye" aria-hidden="true"></i>
                        </x-fltc::button.link>
                        <x-fltc::button.link href="#" :theme="$theme" tooltip="Edit" class="!px-2.5">
                            <i class="ph ph-pencil-simple" aria-hidden="true"></i>
                        </x-fltc::button.link>
                    </div>
                </x-fltc::table.cell>
            </x-fltc::table.row>
        @endforeach
    </x-fltc::table>

    <x-fltc::card.footer :theme="$theme" class="flex flex-col items-center justify-between gap-3 sm:flex-row">
        <span class="text-xs opacity-70">Showing 1–5 of 128</span>
        <x-fltc::nav.pagination :currentPage="1" :totalPages="26" :start="1" :end="5" mainTheme="slate" :accentTheme="$theme" />
    </x-fltc::card.footer>
</x-fltc::card>
