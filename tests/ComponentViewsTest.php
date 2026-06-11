<?php

use Illuminate\Support\Facades\View;
use Symfony\Component\Finder\Finder;

/**
 * For every view('fltc::…') reference in component source files, ensure the
 * referenced Blade template actually exists. Guards against the handle
 * (`fltc`) and the view-namespace registration getting out of sync, or a
 * component file referencing a moved/renamed template.
 */
function viewReferencesFromComponents(): array
{
    $base = realpath(__DIR__.'/../src/View/Components');
    $refs = [];

    foreach ((new Finder())->files()->in($base)->name('*.php') as $file) {
        $contents = $file->getContents();
        if (preg_match_all("/view\\(\\s*['\"]([^'\"]+)['\"]/", $contents, $matches)) {
            foreach ($matches[1] as $viewName) {
                $refs[$file->getRelativePathname().' → '.$viewName] = [$viewName];
            }
        }
    }

    return $refs;
}

it('resolves every view() reference made from a component class', function (string $viewName) {
    expect(str_starts_with($viewName, 'fltc::'))
        ->toBeTrue("Component view reference '{$viewName}' is missing the 'fltc::' namespace prefix.");

    expect(View::exists($viewName))
        ->toBeTrue("View '{$viewName}' could not be found. Either the Blade template is missing or the package view namespace is misregistered.");
})->with(viewReferencesFromComponents());
