<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;

it('registers the fltc Blade component namespace pointing at the package PHP namespace', function () {
    $namespaces = Blade::getClassComponentNamespaces();

    expect($namespaces)->toHaveKey('fltc');
    expect($namespaces['fltc'])->toBe('Fsteltenkamp\\TwcssComponents\\View\\Components');
});

it('registers the fltc view namespace pointing at the package resources/views directory', function () {
    $hints = View::getFinder()->getHints();

    expect($hints)->toHaveKey('fltc');
    expect($hints['fltc'][0])->toEndWith('resources/views');
});

it('loads the service provider class under the expected namespace', function () {
    expect(class_exists(\Fsteltenkamp\TwcssComponents\TwcssComponentsServiceProvider::class))
        ->toBeTrue();
});
