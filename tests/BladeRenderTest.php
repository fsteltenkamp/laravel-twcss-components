<?php

use Illuminate\Support\Facades\Blade;

/**
 * End-to-end smoke tests: render a handful of <x-fltc::…> tags and verify
 * the full pipeline (Blade tag → component namespace → PHP class → view)
 * resolves. If the handle or namespace registration breaks, every one of
 * these fails.
 */
it('renders the alert component via the fltc Blade handle', function () {
    $html = Blade::render('<x-fltc::alert>hello</x-fltc::alert>');

    expect($html)->toContain('hello');
});

it('renders the badge component via the fltc Blade handle', function () {
    $html = Blade::render('<x-fltc::badge>NEW</x-fltc::badge>');

    expect($html)->toContain('NEW');
});

it('renders the button component via the fltc Blade handle', function () {
    $html = Blade::render('<x-fltc::button>Click me</x-fltc::button>');

    expect($html)
        ->toContain('Click me')
        ->toContain('<button');
});

it('renders the buttongroup component via the fltc Blade handle', function () {
    $html = Blade::render('<x-fltc::buttongroup>inner</x-fltc::buttongroup>');

    expect($html)->toContain('inner');
});

it('renders the tooltip component via the fltc Blade handle', function () {
    $html = Blade::render('<x-fltc::tooltip text="hi">child</x-fltc::tooltip>');

    expect($html)->toContain('child');
});

it('renders the counter component via the fltc Blade handle', function () {
    $html = Blade::render('<x-fltc::counter title="Users" count="42" description="active this week" icon="ph ph-users" />');

    expect($html)
        ->toContain('Users')
        ->toContain('42')
        ->toContain('active this week')
        ->toContain('ph ph-users');
});

it('renders the counter component as a link when link is set', function () {
    $html = Blade::render('<x-fltc::counter title="Users" count="42" link="/dashboard/users" navigate />');

    expect($html)
        ->toContain('<a')
        ->toContain('href="/dashboard/users"')
        ->toContain('wire:navigate')
        ->toContain('cursor-pointer');
});

it('renders the default table variant with collapsed borders', function () {
    $html = Blade::render(<<<'BLADE'
        <x-fltc::table>
            <x-fltc::table.row><x-fltc::table.cell>Apple</x-fltc::table.cell></x-fltc::table.row>
        </x-fltc::table>
    BLADE);

    expect($html)
        ->toContain('Apple')
        ->not->toContain('border-separate');
});

it('renders the floating table variant as separated rounded pills', function () {
    $html = Blade::render(<<<'BLADE'
        <x-fltc::table floating theme="gray">
            <x-fltc::table.row><x-fltc::table.cell>Apple</x-fltc::table.cell></x-fltc::table.row>
        </x-fltc::table>
    BLADE);

    expect($html)
        ->toContain('Apple')
        ->toContain('border-separate')
        ->toContain('border-spacing-y-3')
        // pill background re-targeted onto the row cells, with rounded outer corners.
        // `&` and `>` are HTML-escaped inside the attribute, so match the escaped form.
        ->toContain('[&amp;&gt;td]:')
        ->toContain('[&amp;&gt;td:first-child]:rounded-l-lg')
        ->toContain('[&amp;&gt;td:last-child]:rounded-r-lg');
});
