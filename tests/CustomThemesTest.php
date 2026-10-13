<?php

use Illuminate\Support\Facades\Blade;

/**
 * Every theme must be supported wherever the Tailwind palettes are: each file
 * must define every theme as often as it defines `rose` (the last Tailwind
 * colour, present in every theme map), so a map that stops short fails here.
 */
const CUSTOM_THEMES = ['cyberpunk', 'fantasy', 'wh40k'];

const ALL_THEMES = [
    'slate', 'gray', 'zinc', 'neutral', 'stone', 'red', 'orange', 'amber', 'yellow', 'lime',
    'green', 'emerald', 'teal', 'cyan', 'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia',
    'pink', 'rose', 'taupe', 'mauve', 'mist', 'olive', 'skin', 'cyberpunk', 'fantasy', 'wh40k',
];

it('defines every theme in every theme map', function () {
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__.'/../src'));

    foreach ($files as $file) {
        if ($file->getExtension() !== 'php') {
            continue;
        }

        $source = file_get_contents($file->getPathname());
        $maps = preg_match_all("/'rose'\s*=>/", $source);

        foreach (ALL_THEMES as $theme) {
            expect(preg_match_all("/'{$theme}'\s*=>/", $source))
                ->toBe($maps, "{$file->getFilename()}: '{$theme}' entries should match 'rose' entries");
        }
    }
});

it('defines a skin block for every theme except skin itself', function () {
    $css = file_get_contents(__DIR__.'/../resources/css/skins.css');
    preg_match_all('/\[data-skin="([a-z0-9]+)"\]/', $css, $m);

    expect($m[1])->toEqualCanonicalizing(array_values(array_diff(ALL_THEMES, ['skin'])));
});

it('defines all eleven shades of every custom theme in the shipped palettes', function () {
    $css = file_get_contents(__DIR__.'/../resources/css/themes.css');
    $js = file_get_contents(__DIR__.'/../resources/js/themes.js');

    foreach (CUSTOM_THEMES as $theme) {
        foreach ([50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950] as $shade) {
            preg_match("/--color-{$theme}-{$shade}: (#[0-9a-f]{6});/", $css, $m);
            expect($m)->not->toBeEmpty("themes.css is missing {$theme}-{$shade}");
            expect($js)->toMatch("/{$theme}:[^\\n]*\\b{$shade}: '{$m[1]}'/");
        }
    }
});

it('renders components with a custom theme instead of falling back', function (string $theme) {
    expect(Blade::render("<x-fltc::button theme=\"{$theme}\">Go</x-fltc::button>"))
        ->toContain("bg-{$theme}-400");
    expect(Blade::render("<x-fltc::badge theme=\"{$theme}\">x</x-fltc::badge>"))
        ->toContain("{$theme}-");
    expect(Blade::render("<x-fltc::card theme=\"{$theme}\"><x-fltc::card.body>x</x-fltc::card.body></x-fltc::card>"))
        ->toContain("text-{$theme}-900");
})->with([...CUSTOM_THEMES, 'skin']);

it('themes rows and cells passed through card rows', function () {
    $html = Blade::render('<x-fltc::card theme="rose"><x-fltc::card.rows><x-fltc::table.row><x-fltc::table.cell>x</x-fltc::table.cell></x-fltc::table.row></x-fltc::card.rows></x-fltc::card>');

    expect($html)
        ->toContain('border-rose-200')
        ->toContain('odd:bg-rose-200/70')
        ->not->toContain('text-gray-700');
});

/*
 * One default theme everywhere: a component used without `theme` must look like its
 * neighbours. Child components that inherit their parent's theme default to null.
 */
it('defaults every theme prop to slate', function () {
    $root = realpath(__DIR__.'/../src/View/Components');

    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root)) as $file) {
        if ($file->getExtension() !== 'php') {
            continue;
        }

        $class = 'Fsteltenkamp\\TwcssComponents\\View\\Components\\'.str_replace('/', '\\', substr($file->getRealPath(), strlen($root) + 1, -4));
        $constructor = (new ReflectionClass($class))->getConstructor();

        foreach ($constructor?->getParameters() ?? [] as $param) {
            if (! in_array($param->getName(), ['theme', 'mainTheme'], true) || ! $param->isDefaultValueAvailable()) {
                continue;
            }

            // null inherits the parent's theme; the icon's '' inherits the text colour.
            expect($param->getDefaultValue())->toBeIn(['slate', null, ''], "{$class}: \${$param->getName()} should default to slate");
        }
    }

    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__.'/../resources/views')) as $file) {
        if (preg_match_all("/'theme'\s*=>\s*'([a-z0-9]+)'/", (string) @file_get_contents($file->getPathname()), $m)) {
            expect(array_unique($m[1]))->toBe(['slate'], "{$file->getFilename()}: theme prop should default to slate");
        }
    }
});

it('falls back to slate for an unknown theme', function () {
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__.'/../src'));
    $others = implode('|', array_diff(ALL_THEMES, ['slate']));

    foreach ($files as $file) {
        if ($file->getExtension() === 'php') {
            expect(file_get_contents($file->getPathname()))
                ->not->toMatch("/\\?\\?\\s*\\\$[a-zA-Z>-]+\\['({$others})'\\]/", "{$file->getFilename()} falls back to a theme other than slate");
        }
    }
});
