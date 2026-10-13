<?php

use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;

/**
 * Neutral hook classes (src/View/Component.php) are what skin stylesheets such as
 * resources/css/skin-effects.css target. Every component must carry them, so this
 * renders each class-backed component and looks for fltc-<tag> and fltc-theme-<theme>.
 */
function classBackedComponents(): array
{
    $root = realpath(__DIR__.'/../src/View/Components');
    $components = [];

    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root)) as $file) {
        if ($file->getExtension() !== 'php') {
            continue;
        }

        $path = Str::of($file->getRealPath())->after($root.'/')->beforeLast('.php');
        $class = 'Fsteltenkamp\\TwcssComponents\\View\\Components\\'.$path->replace('/', '\\');

        if (! (new ReflectionClass($class))->isAbstract()) {
            $tag = $path->explode('/')->map(fn ($part) => Str::kebab($part))->implode('.');
            $components[$tag] = [$tag, $class];
        }
    }

    ksort($components);

    return $components;
}

beforeEach(fn () => View::share('errors', new ViewErrorBag));

it('extends the hook-class base component', function (string $tag, string $class) {
    expect(is_subclass_of($class, Component::class))->toBeTrue("{$class} should extend ".Component::class);
})->with(classBackedComponents());

it('renders its hook classes', function (string $tag, string $class) {
    // Content some components require to render at all. The dropdowns get only their
    // trigger: bare text after a named slot leaves an output buffer open under
    // Blade::render (any component does it, card too), which marks the test risky.
    $content = [
        'nav.navbar.dropdown' => '<x-slot:trigger>Menu</x-slot:trigger>',
        'dropdown' => '<x-slot:trigger>Menu</x-slot:trigger>',
        'progress' => '',
        'infocard' => '<x-slot:trigger>Ada</x-slot:trigger>',
    ];

    $html = Blade::render("<x-fltc::{$tag} theme=\"rose\">".($content[$tag] ?? 'x')."</x-fltc::{$tag}>");

    expect($html)->toContain($class::hookName());

    // The hooks put a class into every attribute bag, so a view that renders the bag
    // next to its own class="..." emits two class attributes; browsers drop the second.
    preg_match_all('/<[a-z][^>]*>/s', $html, $tags);
    foreach ($tags[0] as $element) {
        expect(preg_match_all('/\sclass=/', $element))->toBeLessThan(2, "duplicate class attribute: {$element}");
    }

    // Any component that takes a theme must hook it; a constructor that reads $theme
    // without storing it (Body, Container\Box once did) leaves the skin rules unmatched.
    $constructor = (new ReflectionClass($class))->getConstructor();
    $takesTheme = $constructor && collect($constructor->getParameters())->contains(fn ($p) => $p->getName() === 'theme');

    if ($takesTheme || property_exists($class, 'theme')) {
        expect($html)->toContain('fltc-theme-rose');
    }
})->with(classBackedComponents());

it('names hooks after the component tag', function () {
    expect(\Fsteltenkamp\TwcssComponents\View\Components\Nav\Navbar\Link::hookName())->toBe('fltc-nav-navbar-link')
        ->and(\Fsteltenkamp\TwcssComponents\View\Components\Form\Container\Auth\TwoColLeft::hookName())->toBe('fltc-form-container-auth-two-col-left');
});

it('keeps host classes next to the hooks', function () {
    $html = Blade::render('<x-fltc::badge theme="palette" class="ml-2" id="b">x</x-fltc::badge>');

    expect($html)
        ->toMatch('/class="[^"]*\bml-2\b[^"]*"/')
        ->toContain('fltc-badge')
        ->toContain('fltc-theme-palette')
        ->toContain('id="b"');
});

it('puts hooks on the anonymous components and teleported parts', function () {
    expect(Blade::render('<x-fltc::heading>x</x-fltc::heading>'))->toContain('fltc-heading')
        ->and(Blade::render('<x-fltc::subheading>x</x-fltc::subheading>'))->toContain('fltc-subheading')
        ->and(Blade::render('<x-fltc::separator />'))->toContain('fltc-separator')
        ->and(Blade::render('<x-fltc::modal name="m">x</x-fltc::modal>'))->toContain('fltc-modal')->toContain('fltc-modal-panel')
        ->and(Blade::render('<x-fltc::form.otp theme="rose" />'))->toContain('fltc-form-otp')->toContain('fltc-theme-rose')
        ->and(Blade::render('<x-fltc::drawer label="Wiki" theme="rose">x</x-fltc::drawer>'))->toMatch('/fltc-drawer-tab[^"]*fltc-theme-rose/')
        ->and(Blade::render('<x-fltc::tooltip text="t" theme="rose">x</x-fltc::tooltip>'))->toMatch('/fltc-tooltip-bubble[^"]*fltc-theme-rose/');
});

it('renders the glitch heading with its text for the effect layers', function () {
    $html = Blade::render('<x-fltc::heading glitch>SYSTEM ONLINE</x-fltc::heading>');

    expect($html)->toContain('fltc-glitch')->toContain('data-text="SYSTEM ONLINE"');
    expect(Blade::render('<x-fltc::heading>SYSTEM ONLINE</x-fltc::heading>'))->not->toContain('data-text');
});

it('ships every font the skin stylesheet references, with its licence', function () {
    $css = file_get_contents(__DIR__.'/../resources/css/skin-effects.css');
    preg_match_all("/url\\('\\.\\.\\/fonts\\/([^']+)'\\)/", $css, $m);

    expect($m[1])->not->toBeEmpty();

    foreach ($m[1] as $font) {
        expect(__DIR__.'/../resources/fonts/'.$font)->toBeFile();
    }

    foreach (['orbitron', 'share-tech-mono', 'vt323', 'cinzel', 'eb-garamond', 'grenze-gotisch'] as $family) {
        expect(__DIR__."/../resources/fonts/licenses/{$family}.txt")->toBeFile();
    }
});

it('puts part hooks on tables, checklists, steppers and the dark-mode toggle', function () {
    expect(Blade::render('<x-fltc::table theme="rose" floating><x-fltc::table.row><x-fltc::table.cell>x</x-fltc::table.cell></x-fltc::table.row></x-fltc::table>'))
        ->toMatch('/class="fltc-table-scroll fltc-theme-rose\s+fltc-table-floating/')
        ->and(Blade::render('<x-fltc::form.checklist :items="[[\'label\' => \'a\', \'status\' => \'pending\']]" showProgress />'))
        ->toContain('fltc-form-checklist-list')->toContain('fltc-form-checklist-row')->toContain('fltc-form-checklist-track')
        ->and(Blade::render('<x-fltc::nav.stepper :steps="[[\'label\' => \'a\'], [\'label\' => \'b\']]" :stepIndex="1" />'))
        ->toContain('fltc-nav-stepper-panel')
        ->and(Blade::render('<x-fltc::darkmode.toggle />'))
        ->toContain('fltc-darkmode-toggle-group')->toContain('fltc-darkmode-toggle-option');
});

it('renders native input parts for a dark background in dark mode', function () {
    expect(Blade::render('<x-fltc::form.input.datetime label="x" />'))->toContain('dark:[color-scheme:dark]')
        ->and(Blade::render('<x-fltc::form.textarea label="x" />'))->toContain('dark:[color-scheme:dark]');
});

it('hooks the theme that navbar and sidebar children inherit', function () {
    $navbar = Blade::render(<<<'BLADE'
        <x-fltc::nav.navbar theme="rose">
            <x-slot:left>
                <x-fltc::nav.navbar.dropdown><x-slot:trigger>Menu</x-slot:trigger><x-fltc::nav.navbar.dropdown.link href="#">a</x-fltc::nav.navbar.dropdown.link></x-fltc::nav.navbar.dropdown>
            </x-slot:left>
        </x-fltc::nav.navbar>
        BLADE);

    expect($navbar)
        ->toMatch('/class="[^"]*fltc-nav-navbar-dropdown fltc-theme-rose/')
        ->toMatch('/class="[^"]*fltc-nav-navbar-dropdown-link fltc-theme-rose/');

    $sidebar = Blade::render(<<<'BLADE'
        <x-fltc::nav.sidebar theme="rose">
            <x-slot:footer>
                <x-fltc::nav.sidebar.profile name="Ada"><x-fltc::nav.sidebar.link href="#">Account</x-fltc::nav.sidebar.link></x-fltc::nav.sidebar.profile>
            </x-slot:footer>
        </x-fltc::nav.sidebar>
        BLADE);

    expect($sidebar)
        ->toMatch('/class="[^"]*fltc-nav-sidebar-profile fltc-theme-rose/')
        ->toContain('fltc-nav-sidebar-profile-trigger')
        ->toContain('fltc-nav-sidebar-profile-avatar')
        ->toContain('fltc-nav-sidebar-profile-menu');
});

/*
 * Every component either gets skin effects or is listed here on purpose: a new
 * component that skin-effects.css never mentions would look plain under cyberpunk.
 * These are structural parts styled through their parent, or layout wrappers.
 */
const UNSKINNED_COMPONENTS = [
    'accordion.item', 'array-to-table', 'body', 'card.body', 'card.footer', 'card.rows',
    'container.page', 'form.container.auth.simple', 'form.container.auth.two-col-left',
    'form.container.auth.two-col-right', 'nav.breadcrumbs.item', 'nav.link',
    'nav.navbar.dropdown.link', 'nav.navbar.dropdown.postlink', 'nav.navbar.item',
    'nav.navbar.toggle', 'nav.sidebar.footer', 'table.foot', 'tabs.panel', 'text',
    'toast.container', 'theme.picker', 'badge.cloud',
];

it('styles every component in the skin effects stylesheet', function (string $tag, string $class) {
    $css = file_get_contents(__DIR__.'/../resources/css/skin-effects.css');
    // Components whose effects target the part that carries their look.
    $hook = ['table' => 'fltc-table-scroll', 'tooltip' => 'fltc-tooltip-bubble', 'modal' => 'fltc-modal-panel'][$tag] ?? $class::hookName();
    $styled = preg_match('/\.'.preg_quote($hook, '/').'(?![\w-])/', $css) === 1;

    expect($styled || in_array($tag, UNSKINNED_COMPONENTS, true))
        ->toBeTrue("{$class::hookName()} has no rules in skin-effects.css; style it or add '{$tag}' to UNSKINNED_COMPONENTS");
})->with(classBackedComponents());

it('styles the part hooks of the newer components', function () {
    $css = file_get_contents(__DIR__.'/../resources/css/skin-effects.css');

    foreach (['fltc-dropdown-menu', 'fltc-dropdown-item', 'fltc-tabs-list', 'fltc-tabs-tab', 'fltc-nav-pagination-summary', 'fltc-form-radio-label', 'fltc-form-radio-group-legend', 'fltc-form-input-number', 'fltc-form-input-date', 'fltc-form-input-time', 'fltc-form-input-file', 'fltc-spinner'] as $hook) {
        expect($css)->toMatch('/\.'.$hook.'(?![\w-])/', "{$hook} is not styled");
    }

    expect(Blade::render('<x-fltc::form.radio.group label="L"><x-fltc::form.radio value="a" label="A" /></x-fltc::form.radio.group>'))
        ->toContain('fltc-form-radio-group-legend')->toContain('fltc-form-radio-label');
});

it('puts the theme hook on the body and the box so skin effects apply', function () {
    expect(Blade::render('<x-fltc::body theme="cyberpunk">x</x-fltc::body>'))->toMatch('/<body class="[^"]*fltc-body fltc-theme-cyberpunk/')
        ->and(Blade::render('<x-fltc::container.box theme="palette">x</x-fltc::container.box>'))->toContain('fltc-container-box fltc-theme-palette');
});

it('takes the look only from data-skin and the colour from every theme', function () {
    $css = file_get_contents(__DIR__.'/../resources/css/skin-effects.css');

    // A theme never switches a look on by itself (outside the COLOURS section, where
    // cyberpunk, fantasy and wh40k are colours like any other), and the old runtime
    // colour is gone.
    $looks = preg_replace('#/\* =+ COLOURS =+ \*/.*?/\* =+ PAGE =+ \*/#s', '', $css);
    expect($looks)->not->toBe($css);
    expect($looks)
        ->not->toMatch('/\.fltc-theme-(cyberpunk|fantasy|wh40k)(?![\w-])/')
        ->not->toContain('fltc-theme-skin')
        ->not->toContain('data-skin-shape')
        ->toContain('[data-skin="cyberpunk"] [class*="fltc-theme-"]');

    // Every theme sets the colour roles the skins draw in, in light and dark mode.
    preg_match_all('/\[data-palette="([a-z0-9]+)"\]/', file_get_contents(__DIR__.'/../resources/css/palettes.css'), $palettes);
    foreach ([...$palettes[1], 'palette'] as $theme) {
        expect(substr_count($css, ".fltc-theme-{$theme},\n"))->toBe(2, "{$theme} needs light and dark colour roles");
    }
});
