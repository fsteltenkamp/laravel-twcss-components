<?php

use Illuminate\Support\Facades\Blade;

/**
 * Every colour must be supported wherever the Tailwind palettes are: each file must
 * define every colour (the Tailwind palettes plus the eight theme roles) as often as
 * it defines `rose` (present in every colour map), so a map that stops short fails.
 */
it('defines every colour in every colour map', function () {
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__.'/../src'));

    foreach ($files as $file) {
        // The picker's DEFAULT_ROLES maps roles to palettes; it is not a colour map.
        if ($file->getExtension() !== 'php' || $file->getFilename() === 'Picker.php') {
            continue;
        }

        $source = file_get_contents($file->getPathname());
        $maps = preg_match_all("/'rose'\s*=>/", $source);

        foreach (ALL_COLORS as $color) {
            expect(preg_match_all("/'{$color}'\s*=>/", $source))
                ->toBe($maps, "{$file->getFilename()}: '{$color}' entries should match 'rose' entries");
        }

        foreach (['cyberpunk', 'fantasy', 'wh40k', 'palette', 'skin'] as $gone) {
            expect(preg_match("/'{$gone}'\s*=>\s*['\[a]/", $source))->toBe(0, "{$file->getFilename()}: '{$gone}' is a theme or skin now, not a colour");
        }
    }
});

it('defines every role shade in every theme', function () {
    $css = file_get_contents(__DIR__.'/../resources/css/themes.css');

    foreach (THEMES as $theme) {
        expect(preg_match('/\[data-theme="'.$theme.'"\][^{]*\{(.*?)\n\}/s', $css, $m))->toBe(1, "themes.css has no {$theme} block");

        foreach (ROLES as $role) {
            foreach (SHADES as $shade) {
                expect($m[1])->toMatch("/--fltc-{$role}-{$shade}: (\\d+ \\d+ \\d+|var\\(--fltc-[a-z]+-{$shade}\\));/", "{$theme} misses {$role}-{$shade}");
            }
        }
    }
});

it('lets the custom theme pick any palette for any role', function () {
    $css = file_get_contents(__DIR__.'/../resources/css/themes.css');

    foreach (ROLES as $role) {
        foreach (PALETTES as $palette) {
            expect($css)->toContain("[data-theme=\"custom\"][data-theme-{$role}=\"{$palette}\"] { --fltc-{$role}-50: var(--fltc-{$palette}-50);");
        }
    }

    // The picker starts a custom theme from the default theme's palettes.
    foreach (\Fsteltenkamp\TwcssComponents\View\Components\Theme\Picker::DEFAULT_ROLES as $role => $palette) {
        expect($css)->toContain("--fltc-{$role}-500: var(--fltc-{$palette}-500);");
    }
    expect(\Fsteltenkamp\TwcssComponents\View\Components\Theme\Picker::PALETTES)->toEqualCanonicalizing(PALETTES);
});

it('registers every role shade with Tailwind v3 and v4', function () {
    $css = file_get_contents(__DIR__.'/../resources/css/colors.css');
    $js = file_get_contents(__DIR__.'/../resources/js/colors.js');

    foreach (ROLES as $role) {
        foreach (SHADES as $shade) {
            expect($css)->toContain("--color-{$role}-{$shade}: rgb(var(--fltc-{$role}-{$shade}));");
            expect($js)->toMatch("/{$role}: \\{[^\\n]*{$shade}: 'rgb\\(var\\(--fltc-{$role}-{$shade}\\) \\/ <alpha-value>\\)'/");
        }
    }
});

it('renders components in a role colour instead of falling back', function (string $role) {
    expect(Blade::render("<x-fltc::button color=\"{$role}\">Go</x-fltc::button>"))
        ->toContain("bg-{$role}-400");
    expect(Blade::render("<x-fltc::badge color=\"{$role}\">x</x-fltc::badge>"))
        ->toContain("{$role}-");
    expect(Blade::render("<x-fltc::card color=\"{$role}\"><x-fltc::card.body>x</x-fltc::card.body></x-fltc::card>"))
        ->toContain("text-{$role}-900");
})->with(ROLES);

it('themes rows and cells passed through card rows', function () {
    $html = Blade::render('<x-fltc::card color="rose"><x-fltc::card.rows><x-fltc::table.row><x-fltc::table.cell>x</x-fltc::table.cell></x-fltc::table.row></x-fltc::card.rows></x-fltc::card>');

    expect($html)
        ->toContain('border-rose-200')
        ->toContain('odd:bg-rose-200/70')
        ->not->toContain('text-gray-700');
});

/*
 * One default theme everywhere: a component used without `theme` must look like its
 * neighbours. Child components that inherit their parent's theme default to null.
 */
it('defaults every colour prop to base', function () {
    $root = realpath(__DIR__.'/../src/View/Components');

    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root)) as $file) {
        if ($file->getExtension() !== 'php') {
            continue;
        }

        $class = 'Fsteltenkamp\\TwcssComponents\\View\\Components\\'.str_replace('/', '\\', substr($file->getRealPath(), strlen($root) + 1, -4));
        $constructor = (new ReflectionClass($class))->getConstructor();

        foreach ($constructor?->getParameters() ?? [] as $param) {
            if (! in_array($param->getName(), ['theme', 'mainColor'], true) || ! $param->isDefaultValueAvailable()) {
                continue;
            }

            // null inherits the parent's theme; the icon's '' inherits the text colour.
            expect($param->getDefaultValue())->toBeIn(['base', null, ''], "{$class}: \${$param->getName()} should default to base");
        }
    }

    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__.'/../resources/views')) as $file) {
        if (preg_match_all("/'color'\s*=>\s*'([a-z0-9]+)'/", (string) @file_get_contents($file->getPathname()), $m)) {
            expect(array_unique($m[1]))->toBe(['base'], "{$file->getFilename()}: color prop should default to base");
        }
    }
});

it('falls back to base for an unknown colour', function () {
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__.'/../src'));
    $others = implode('|', array_diff(ALL_COLORS, ['base']));

    foreach ($files as $file) {
        if ($file->getExtension() === 'php') {
            expect(file_get_contents($file->getPathname()))
                ->not->toMatch("/\\?\\?\\s*\\\$[a-zA-Z>-]+\\['({$others})'\\]/", "{$file->getFilename()} falls back to a colour other than base");
        }
    }
});
