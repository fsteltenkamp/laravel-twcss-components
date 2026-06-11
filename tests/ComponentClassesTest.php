<?php

use Symfony\Component\Finder\Finder;

/**
 * Catches namespace drift: every PHP file under src/View/Components/
 * must autoload to a class under Fsteltenkamp\TwcssComponents\View\Components\…
 * matching its file path.
 */
function componentFiles(): array
{
    $base = realpath(__DIR__.'/../src/View/Components');
    $files = [];

    foreach ((new Finder())->files()->in($base)->name('*.php') as $file) {
        $relative = str_replace('\\', '/', substr($file->getRealPath(), strlen($base) + 1));
        $relative = substr($relative, 0, -4); // strip .php
        $fqcn = 'Fsteltenkamp\\TwcssComponents\\View\\Components\\'.str_replace('/', '\\', $relative);
        $files[$relative] = $fqcn;
    }

    return $files;
}

it('autoloads every component class in src/View/Components under the package namespace', function (string $fqcn) {
    expect(class_exists($fqcn))->toBeTrue("Class {$fqcn} cannot be autoloaded. Likely the file's namespace declaration drifted from Fsteltenkamp\\TwcssComponents\\View\\Components.");
})->with(componentFiles());

it('declares the expected namespace inside each component file', function (string $relativePath, string $fqcn) {
    $contents = file_get_contents(__DIR__.'/../src/View/Components/'.$relativePath.'.php');
    $expectedNamespace = substr($fqcn, 0, strrpos($fqcn, '\\'));

    expect($contents)->toMatch('/^namespace\s+'.preg_quote($expectedNamespace, '/').'\s*;/m');
})->with(function () {
    foreach (componentFiles() as $rel => $fqcn) {
        yield $rel => [$rel, $fqcn];
    }
});
