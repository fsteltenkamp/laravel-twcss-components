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
