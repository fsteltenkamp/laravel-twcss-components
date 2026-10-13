<?php

/*
 * Visual gallery generator.
 *
 * This is not an assertion test — it renders representative examples of every
 * component through the REAL Blade pipeline (same service provider + @aware +
 * theming as production) and writes a browsable static page to ./gallery.html.
 *
 * Regenerate it with:
 *     ./test.sh tests/GalleryTest.php
 * then open gallery.html in a browser. It has a light/dark toggle and pulls in
 * Tailwind (Play CDN), Alpine, and the Phosphor/Material icon fonts the
 * components reference, so interactive bits (accordion, dropdowns, dark toggle)
 * work standalone.
 *
 * Each snippet renders in its own try/catch: a component that needs host-app
 * context (e.g. array-to-table's <x-icon>, or Livewire wiring) shows its error
 * inline instead of breaking the whole page.
 */

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

/**
 * The gallery content, grouped section => [ component => [ variant, ... ] ].
 *
 * Each component renders as one full-width card; every variant inside it is a
 * [label, code, data?] triple, where `code` is rendered with
 * Blade::render($code, $data ?? []). When a component has more than one variant
 * the variant label is shown above its preview; a single-variant component
 * renders without a label.
 */
function galleryGroups(): array
{
    return [
        'Typography' => [
            'Heading' => [
                ['default', '<x-fltc::heading size="2xl">Chapter 12 — The Archive</x-fltc::heading>'],
                ['glitch (cyberpunk skin effect)', '<x-fltc::heading size="2xl" glitch>SYSTEM ONLINE</x-fltc::heading>'],
            ],
            'Subheading' => [
                ['default', '<x-fltc::subheading>// 42 volumes in the library</x-fltc::subheading>'],
            ],
            'Text' => [
                ['default', '<x-fltc::text theme="skin">The quick brown fox jumps over the lazy dog.</x-fltc::text>'],
            ],
        ],

        'Buttons' => [
            'Button' => [
                ['solid', '<x-fltc::button theme="skin">Save</x-fltc::button>'],
                ['outline', '<x-fltc::button theme="skin" variant="outline">Delete</x-fltc::button>'],
                ['disabled', '<x-fltc::button theme="skin" disabled>Disabled</x-fltc::button>'],
                ['with icon', '<x-fltc::button theme="skin" icon="floppy-disk">Save</x-fltc::button> <x-fltc::button theme="skin" icon="arrow-right" iconPosition="after">Next</x-fltc::button> <x-fltc::button theme="skin" icon="trash" />'],
            ],
            'Button link' => [
                ['default', '<x-fltc::button.link href="#" theme="skin">Go somewhere</x-fltc::button.link>'],
            ],
            'Button group' => [
                ['default', '<x-fltc::buttongroup>
    <x-fltc::button theme="skin">Left</x-fltc::button>
    <x-fltc::button theme="skin">Middle</x-fltc::button>
    <x-fltc::button theme="skin">Right</x-fltc::button>
</x-fltc::buttongroup>'],
            ],
        ],

        'Status & Feedback' => [
            'Badge' => [
                ['themes', '<x-fltc::badge theme="skin">available</x-fltc::badge> <x-fltc::badge theme="skin">no stock</x-fltc::badge> <x-fltc::badge theme="skin">start sale</x-fltc::badge>'],
            ],
            'Alert' => [
                ['default', '<x-fltc::alert theme="skin">Heads up — your trial ends soon.</x-fltc::alert>'],
            ],
            'Message box' => [
                ['default', '<x-fltc::messagebox theme="skin" title="Note">
    Selected 3 items. Choose an action below.
</x-fltc::messagebox>'],
            ],
            'Tooltip' => [
                ['default', '<x-fltc::tooltip text="More info here" theme="skin">Hover me</x-fltc::tooltip>'],
            ],
            'Toast' => [
                ['toast (default) — compact solid bar', '<x-fltc::toast title="File saved" theme="skin" message="Your changes are safe." />'],
                ['pill — lightweight bordered pill', '<x-fltc::toast variant="pill" title="File saved" theme="skin" />'],
                ['card — header + body', '<x-fltc::toast variant="card" theme="skin" title="Profile updated" message="Your changes have been saved successfully." />'],
                ['baguette — centered 80% banner', '<div class="w-full py-2"><x-fltc::toast variant="baguette" theme="skin" title="Deploying to production…" message="This may take a moment." /></div>'],
            ],
        ],

        'Cards' => [
            'Card' => [
                ['sections (header / body / footer)', '<x-fltc::card theme="skin" class="max-w-sm">
    <x-fltc::card.header class="px-4 py-3 font-semibold border-b border-skin-200 dark:border-skin-700">Project</x-fltc::card.header>
    <x-fltc::card.body class="p-4">Body content goes here, inheriting the card theme.</x-fltc::card.body>
    <x-fltc::card.footer class="px-4 py-3 border-t border-skin-200 dark:border-skin-700 text-sm">Updated just now</x-fltc::card.footer>
</x-fltc::card>'],
                ['themed (emerald)', '<x-fltc::card theme="skin" class="max-w-sm">
    <x-fltc::card.header class="px-4 py-3 font-semibold border-b border-skin-200 dark:border-skin-900">Deployment</x-fltc::card.header>
    <x-fltc::card.body class="p-4">Sections inherit the card theme automatically.</x-fltc::card.body>
</x-fltc::card>'],
            ],
            'Card content' => [
                ['header + body only', '<x-fltc::card theme="skin" class="max-w-sm">
    <x-fltc::card.header class="px-4 py-3 font-semibold border-b border-skin-200 dark:border-skin-900">Summary</x-fltc::card.header>
    <x-fltc::card.body class="p-4">Just a header and a body — no footer.</x-fltc::card.body>
</x-fltc::card>'],
                ['rows — default table', cardRowsExample(false)],
                ['rows — floating', cardRowsExample(true)],
            ],
        ],

        'Counters' => [
            'Counter' => [
                ['default', '<x-fltc::counter theme="skin" title="Users" count="1,204" description="active this week" icon="ph ph-users" class="max-w-xs" />'],
                ['linked', '<x-fltc::counter theme="skin" title="Revenue" count="€48k" description="this month" icon="ph ph-currency-eur" link="#" class="max-w-xs" />'],
            ],
        ],

        'Accordion' => [
            'Accordion' => [
                ['default', '<x-fltc::accordion theme="skin" class="max-w-md">
    <x-fltc::accordion.item title="First section" subtext="open by default">Content of the first item.</x-fltc::accordion.item>
    <x-fltc::accordion.item title="Second section">Content of the second item.</x-fltc::accordion.item>
</x-fltc::accordion>'],
            ],
        ],

        'Tables' => [
            'Table' => [
                ['default (bordered grid)', tableExample(false)],
                ['floating', tableExample(true)],
            ],
        ],

        'Forms' => [
            'Text input' => [
                ['default', '<x-fltc::form.input.text theme="skin" label="Name" placeholder="Jane Doe" icon="user" class="max-w-sm" />'],
            ],
            'Email input' => [
                ['default', '<x-fltc::form.input.email theme="skin" label="Email" placeholder="you@example.com" icon="envelope" class="max-w-sm" />'],
            ],
            'Password input' => [
                ['default', '<x-fltc::form.input.password theme="skin" label="Password" placeholder="••••••••" class="max-w-sm" />'],
            ],
            'Select' => [
                ['default', '<x-fltc::form.input.select theme="skin" label="Country" placeholder="Choose…" class="max-w-sm">
    <option value="de">Germany</option>
    <option value="us">United States</option>
</x-fltc::form.input.select>'],
            ],
            'Datetime' => [
                ['default', '<x-fltc::form.input.datetime theme="skin" label="Starts at" class="max-w-sm" />'],
            ],
            'Textarea' => [
                ['default', '<x-fltc::form.textarea theme="skin" label="Notes" rows="3" placeholder="Write something…" class="max-w-sm" />'],
            ],
            'Checkbox' => [
                ['default', '<x-fltc::form.checkbox label="I agree to the terms" theme="skin" />'],
                ['toggle', '<x-fltc::form.checkbox variant="toggle" label="Email notifications" theme="skin" themeOff="skin" checked />'],
                ['toggle with icons', '<x-fltc::form.checkbox variant="toggle" size="lg" label="Dark mode" theme="skin" themeOff="skin" iconChecked="ph ph-moon" iconUnchecked="ph ph-sun" />'],
            ],
            'Label' => [
                ['default', '<x-fltc::form.label theme="skin" for="x" required description="Shown to other members">Display name</x-fltc::form.label>'],
            ],
            'Checklist' => [
                ['default', '<x-fltc::form.checklist :items="$items" theme="skin" showProgress />', ['items' => [
                    ['label' => 'Create account', 'status' => 'completed'],
                    ['label' => 'Verify email', 'status' => 'inProgress'],
                    ['label' => 'Add payment', 'status' => 'pending'],
                ]]],
            ],
        ],

        'Navigation' => [
            'Nav link' => [
                ['default', '<x-fltc::nav.link href="#" theme="skin">Dashboard</x-fltc::nav.link>'],
            ],
            'Breadcrumbs' => [
                ['default', '<x-fltc::nav.breadcrumbs :crumbs="$crumbs" theme="skin" />', ['crumbs' => [
                    ['label' => 'Home', 'href' => '#'],
                    ['label' => 'Library', 'href' => '#'],
                    ['label' => 'Data', 'href' => null],
                ]]],
            ],
            'Pagination' => [
                ['default', '<x-fltc::nav.pagination mainTheme="skin" accentTheme="skin" :currentPage="2" :totalPages="5" :start="1" :end="5" />'],
            ],
            'Stepper' => [
                ['default', '<x-fltc::nav.stepper :steps="$steps" :stepIndex="2" theme="skin" />', ['steps' => [
                    ['label' => 'Cart'], ['label' => 'Shipping'], ['label' => 'Payment'],
                ]]],
            ],
            'Navbar' => [
                ['default', navbarExample()],
                ['footer (stickyBottom)', navbarFooterExample()],
            ],
            'Sidebar' => [
                ['default', sidebarExample()],
            ],
        ],

        'Overlays' => [
            'Drawer' => [
                ['tabs on both sides (look at the screen edges)', '<x-fltc::drawer name="gallery-wiki" side="right" title="Wiki" label="Wiki" icon="book-open" theme="skin" offset="5rem" pinnable>
    Pinnable right drawer. Pin it, then click outside — it stays open.
</x-fltc::drawer>
<x-fltc::drawer name="gallery-notes" side="right" title="Notes" label="Notes" icon="note" theme="skin" offset="5rem" :order="1">
    Opening this closes the Wiki drawer first.
</x-fltc::drawer>
<x-fltc::drawer name="gallery-nav" side="left" title="Navigation" label="Menu" icon="list" theme="skin" offset="5rem">
    Left drawer.
</x-fltc::drawer>'],
                ['without a tab, opened by event', '<x-fltc::drawer name="gallery-quiet" side="left" title="Filters" theme="skin" offset="5rem">
    No activation tab — opened from a trigger.
</x-fltc::drawer>
<x-fltc::button theme="skin" icon="funnel" x-data x-on:click="$dispatch(\'fltc-drawer-toggle\', \'gallery-quiet\')" data-fltc-drawer-trigger>Filters</x-fltc::button>'],
            ],
        ],

        'Utility' => [
            'Icon' => [
                ['variants', '<span class="text-2xl"><x-fltc::icon name="heart" variant="thin" after="2" /><x-fltc::icon name="heart" variant="regular" after="2" /><x-fltc::icon name="heart" variant="bold" after="2" /><x-fltc::icon name="heart" variant="fill" after="2" /><x-fltc::icon name="heart" variant="duotone" /></span>'],
                ['colors', '<span class="text-2xl"><x-fltc::icon name="circle" color="red" after="2" /><x-fltc::icon name="circle" color="amber" after="2" /><x-fltc::icon name="circle" color="emerald" after="2" /><x-fltc::icon name="circle" color="sky" after="2" /><x-fltc::icon name="circle" color="violet" /></span>'],
                ['sizes', '<span class="inline-flex items-baseline"><x-fltc::icon name="star" size="sm" after="2" /><x-fltc::icon name="star" size="lg" after="2" /><x-fltc::icon name="star" size="2xl" after="2" /><x-fltc::icon name="star" size="4xl" /></span>'],
            ],
            'Dark mode toggle' => [
                ['default (segmented)', '<x-fltc::darkmode.toggle theme="skin" />'],
                ['toggle', '<x-fltc::darkmode.toggle variant="toggle" theme="skin" themeOff="skin" />'],
            ],
            'Page container' => [
                ['the gallery itself', '<div class="text-sm">This page\'s content column is an <code>x-fltc::container.page</code>: the drawer tabs on both edges sit in its gutters. Narrow the window and pin a drawer to see the gutters adapt.</div>'],
            ],
            'Container box' => [
                ['default', '<x-fltc::container.box theme="skin" class="p-4 max-w-sm">Boxed content.</x-fltc::container.box>'],
            ],
        ],
    ];
}

function navbarExample(): string
{
    return <<<'BLADE'
        <x-fltc::nav.navbar theme="skin" class="rounded-xl border shadow-sm">
            <x-slot:left>
                <x-fltc::nav.navbar.link href="#">Dashboard</x-fltc::nav.navbar.link>
                <x-fltc::nav.navbar.link href="#">Projects</x-fltc::nav.navbar.link>
                <x-fltc::nav.navbar.dropdown>
                    <x-slot:trigger>Resources</x-slot:trigger>
                    <x-fltc::nav.navbar.dropdown.link href="#">Docs</x-fltc::nav.navbar.dropdown.link>
                    <x-fltc::nav.navbar.dropdown.link href="#">Guides</x-fltc::nav.navbar.dropdown.link>
                </x-fltc::nav.navbar.dropdown>
            </x-slot:left>
            <x-slot:right>
                <x-fltc::nav.navbar.dropdown>
                    <x-slot:trigger>Account</x-slot:trigger>
                    <x-fltc::nav.navbar.dropdown.link href="#">Profile</x-fltc::nav.navbar.dropdown.link>
                    <x-fltc::nav.navbar.dropdown.postlink action="#">Sign out</x-fltc::nav.navbar.dropdown.postlink>
                </x-fltc::nav.navbar.dropdown>
            </x-slot:right>
        </x-fltc::nav.navbar>
        BLADE;
}

function navbarFooterExample(): string
{
    // stickyBottom pins the bar to the bottom with a top edge border. The
    // wrapper uses translate-x-0 to create a containing block so the otherwise
    // viewport-`fixed` bar sits at the bottom of this preview box instead.
    return <<<'BLADE'
        <div class="relative h-40 translate-x-0 overflow-hidden rounded-xl border border-skin-200 dark:border-skin-700">
            <div class="p-4 text-sm text-skin-500 dark:text-skin-400">Page content…</div>
            <x-fltc::nav.navbar theme="skin" stickyBottom>
                <x-slot:left>
                    <x-fltc::nav.navbar.link href="#">Home</x-fltc::nav.navbar.link>
                    <x-fltc::nav.navbar.link href="#">Pricing</x-fltc::nav.navbar.link>
                </x-slot:left>
                <x-slot:right>
                    <x-fltc::nav.navbar.item>© Acme</x-fltc::nav.navbar.item>
                </x-slot:right>
            </x-fltc::nav.navbar>
        </div>
        BLADE;
}

function sidebarExample(): string
{
    return <<<'BLADE'
        <x-fltc::nav.sidebar theme="skin" heightClass="h-96" class="rounded-xl border shadow-sm">
            <x-slot:brand>
                <span class="text-base font-semibold">Acme Inc.</span>
            </x-slot:brand>

            <x-fltc::nav.sidebar.link href="#" icon="ph ph-gauge" active>Dashboard</x-fltc::nav.sidebar.link>

            <x-fltc::nav.sidebar.group label="Settings" icon="ph ph-gear" open>
                <x-fltc::nav.sidebar.link href="#">Profile</x-fltc::nav.sidebar.link>
                <x-fltc::nav.sidebar.link href="#">Billing</x-fltc::nav.sidebar.link>
            </x-fltc::nav.sidebar.group>

            <x-fltc::nav.sidebar.link href="#" icon="ph ph-users">Team</x-fltc::nav.sidebar.link>

            <x-slot:footer>
                <x-fltc::nav.sidebar.footer>
                    <x-fltc::nav.sidebar.profile name="Ada Lovelace" email="ada@example.com">
                        <x-fltc::nav.sidebar.link href="#">Account</x-fltc::nav.sidebar.link>
                        <x-fltc::nav.sidebar.link href="#">Sign out</x-fltc::nav.sidebar.link>
                    </x-fltc::nav.sidebar.profile>
                </x-fltc::nav.sidebar.footer>
            </x-slot:footer>
        </x-fltc::nav.sidebar>
        BLADE;
}

function tableExample(bool $floating): string
{
    $floatAttr = $floating ? ' floating' : '';

    return <<<BLADE
        <x-fltc::table theme="skin"{$floatAttr} class="max-w-2xl">
            <x-fltc::table.head>
                <x-fltc::table.row>
                    <x-fltc::table.cell as="th">Brand</x-fltc::table.cell>
                    <x-fltc::table.cell as="th">Category</x-fltc::table.cell>
                    <x-fltc::table.cell as="th" numeric>Price</x-fltc::table.cell>
                    <x-fltc::table.cell as="th">Status</x-fltc::table.cell>
                </x-fltc::table.row>
            </x-fltc::table.head>
            <x-fltc::table.row>
                <x-fltc::table.cell>Apple</x-fltc::table.cell>
                <x-fltc::table.cell>Technology</x-fltc::table.cell>
                <x-fltc::table.cell numeric>200.00\$</x-fltc::table.cell>
                <x-fltc::table.cell><x-fltc::badge theme="skin">available</x-fltc::badge></x-fltc::table.cell>
            </x-fltc::table.row>
            <x-fltc::table.row>
                <x-fltc::table.cell>Realme</x-fltc::table.cell>
                <x-fltc::table.cell>Technology</x-fltc::table.cell>
                <x-fltc::table.cell numeric>200.00\$</x-fltc::table.cell>
                <x-fltc::table.cell><x-fltc::badge theme="skin">no stock</x-fltc::badge></x-fltc::table.cell>
            </x-fltc::table.row>
        </x-fltc::table>
        BLADE;
}

function cardRowsExample(bool $floating): string
{
    $floatAttr = $floating ? ' floating' : '';

    return <<<BLADE
        <x-fltc::card theme="skin" class="max-w-2xl">
            <x-fltc::card.header class="px-4 py-3 font-semibold border-b border-skin-200 dark:border-skin-700">Products</x-fltc::card.header>
            <x-fltc::card.rows theme="skin"{$floatAttr}>
                <x-slot:head>
                    <x-fltc::table.row>
                        <x-fltc::table.cell as="th">Brand</x-fltc::table.cell>
                        <x-fltc::table.cell as="th" numeric>Price</x-fltc::table.cell>
                    </x-fltc::table.row>
                </x-slot:head>
                <x-fltc::table.row>
                    <x-fltc::table.cell>Apple</x-fltc::table.cell>
                    <x-fltc::table.cell numeric>200.00\$</x-fltc::table.cell>
                </x-fltc::table.row>
                <x-fltc::table.row>
                    <x-fltc::table.cell>Realme</x-fltc::table.cell>
                    <x-fltc::table.cell numeric>150.00\$</x-fltc::table.cell>
                </x-fltc::table.row>
            </x-fltc::card.rows>
        </x-fltc::card>
        BLADE;
}

function renderGalleryHtml(array $groups): string
{
    $sections = '';

    foreach ($groups as $section => $components) {
        $cards = '';

        foreach ($components as $componentName => $variants) {
            $multi = count($variants) > 1;
            $blocks = '';

            foreach ($variants as $variant) {
                $label = $variant[0];
                $code = $variant[1];
                $data = $variant[2] ?? [];

                try {
                    $preview = Blade::render($code, $data);
                } catch (\Throwable $e) {
                    $preview = '<div class="text-sm text-red-600 dark:text-red-400 font-mono">'
                        .'⚠ render error (likely needs host-app context): '
                        .htmlspecialchars($e->getMessage())
                        .'</div>';
                }

                $source = htmlspecialchars(trim($code));

                $variantLabel = $multi
                    ? '<div class="mb-3 text-xs font-medium uppercase tracking-wide text-skin-400 dark:text-skin-500">'.htmlspecialchars($label).'</div>'
                    : '';

                $blocks .= <<<HTML
                    <div class="border-t border-skin-100 dark:border-skin-700 first:border-t-0">
                        <div class="p-6">
                            {$variantLabel}
                            <div class="flex flex-wrap items-start gap-3 rounded-md p-4 bg-[repeating-conic-gradient(#0000_0_25%,#00000008_0_50%)] dark:bg-none">{$preview}</div>
                        </div>
                        <pre class="m-0 px-6 py-4 text-sm leading-relaxed overflow-x-auto bg-skin-50 dark:bg-skin-900 text-skin-700 dark:text-skin-300 border-t border-skin-100 dark:border-skin-700"><code>{$source}</code></pre>
                    </div>
                    HTML;
            }

            $cards .= <<<HTML
                <div class="rounded-lg border border-skin-200 dark:border-skin-700 bg-white dark:bg-skin-800 overflow-hidden">
                    <div class="px-6 py-3 text-sm font-semibold text-skin-700 dark:text-skin-200 border-b border-skin-100 dark:border-skin-700">{$componentName}</div>
                    {$blocks}
                </div>
                HTML;
        }

        $sections .= <<<HTML
            <section class="space-y-5">
                <h2 class="text-lg font-bold text-skin-800 dark:text-skin-100">{$section}</h2>
                <div class="space-y-5">{$cards}</div>
            </section>
            HTML;
    }

    // The selectable skins come straight from the shipped stylesheet.
    $skinCss = file_get_contents(dirname(__DIR__).'/resources/css/skins.css');
    preg_match_all('/\[data-skin="([a-z0-9]+)"\]/', $skinCss, $m);
    $skinOptions = implode('', array_map(fn ($s) => "<option value=\"{$s}\">{$s}</option>", $m[1]));

    // The style controls live in a drawer (first tab on the right edge) so the header
    // stays one line on small screens. They are library components too, so they follow
    // the theme and the skin effects like everything else on the page.
    $controls = Blade::render(<<<'BLADE'
        <x-fltc::drawer name="gallery-style" side="right" title="Style" label="Style" icon="palette" theme="skin" offset="5rem" :order="-1" pinnable>
            <div class="space-y-6">
                <x-fltc::form.input.select theme="skin" id="gallery-skin" label="Theme" icon="palette"
                    onchange="document.documentElement.dataset.skin = this.value; try { localStorage.setItem('fltc-gallery-skin', this.value); } catch (e) {}">
                    {!! $skinOptions !!}
                </x-fltc::form.input.select>
                <div class="space-y-2">
                    <x-fltc::form.label theme="skin">Mode</x-fltc::form.label>
                    <x-fltc::darkmode.toggle theme="skin" />
                </div>
                <div class="space-y-2">
                    <x-fltc::form.label theme="skin" for="gallery-fx">Skin effects</x-fltc::form.label>
                    <x-fltc::form.checkbox theme="skin" themeOff="skin" variant="toggle" id="gallery-fx" label="Fonts, rounding and glow" checked
                        onchange="document.getElementById('fltc-fx').disabled = ! this.checked; try { localStorage.setItem('fltc-gallery-fx', this.checked ? 'on' : 'off'); } catch (e) {}" />
                    <x-fltc::text theme="skin" class="block text-xs opacity-75">Fonts, rounding and glow for cyberpunk, fantasy and wh40k; no change for other themes.</x-fltc::text>
                </div>
            </div>
        </x-fltc::drawer>
        BLADE, ['skinOptions' => $skinOptions]);

    $main = Blade::render('<x-fltc::container.page width="5xl" class="space-y-12">{!! $sections !!}</x-fltc::container.page>', ['sections' => $sections]);

    return <<<HTML
        <!doctype html>
        <html lang="en" class="">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>fltc — component gallery</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    darkMode: 'class',
                    theme: { extend: { colors: {
                        skin: { 50: 'rgb(var(--fltc-skin-50) / <alpha-value>)', 100: 'rgb(var(--fltc-skin-100) / <alpha-value>)', 200: 'rgb(var(--fltc-skin-200) / <alpha-value>)', 300: 'rgb(var(--fltc-skin-300) / <alpha-value>)', 400: 'rgb(var(--fltc-skin-400) / <alpha-value>)', 500: 'rgb(var(--fltc-skin-500) / <alpha-value>)', 600: 'rgb(var(--fltc-skin-600) / <alpha-value>)', 700: 'rgb(var(--fltc-skin-700) / <alpha-value>)', 800: 'rgb(var(--fltc-skin-800) / <alpha-value>)', 900: 'rgb(var(--fltc-skin-900) / <alpha-value>)', 950: 'rgb(var(--fltc-skin-950) / <alpha-value>)' },
                    } } },
                };
                // Restore the chosen skin before first paint.
                try {
                    const skin = localStorage.getItem('fltc-gallery-skin');
                    if (skin) document.documentElement.dataset.skin = skin;
                } catch (e) {}
            </script>
            <style>{$skinCss}</style>
            <!-- skin effects; relative to gallery.html so the fonts resolve from the repo -->
            <link id="fltc-fx" rel="stylesheet" href="resources/css/skin-effects.css">
            <script>
                try { document.getElementById('fltc-fx').disabled = localStorage.getItem('fltc-gallery-fx') === 'off'; } catch (e) {}
            </script>
            <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js"></script>
            <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/regular/style.css">
            <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Round" rel="stylesheet">
        </head>
        <body class="min-h-screen bg-skin-100 dark:bg-skin-900">
            <header class="sticky top-0 z-50 flex items-center justify-between px-6 py-4 bg-white/80 dark:bg-skin-800/80 backdrop-blur border-b border-skin-200 dark:border-skin-700">
                <div>
                    <h1 class="text-xl font-bold text-skin-900 dark:text-skin-100">fltc component gallery</h1>
                    <p class="text-xs text-skin-500 dark:text-skin-400">Rendered through real Blade — regenerate with <code>./test.sh tests/GalleryTest.php</code></p>
                </div>
            </header>
            {$controls}
            <script>
                document.getElementById('gallery-skin').value = document.documentElement.dataset.skin || 'slate';
                document.getElementById('gallery-fx').checked = ! document.getElementById('fltc-fx').disabled;
            </script>
            <main class="py-8">
                {$main}
            </main>
        </body>
        </html>
        HTML;
}

it('generates the visual component gallery', function () {
    // Form components read Laravel's shared error bag (normally provided by the
    // session middleware); share an empty one so they render standalone.
    View::share('errors', new ViewErrorBag);

    $html = renderGalleryHtml(galleryGroups());

    $path = dirname(__DIR__).'/gallery.html';
    file_put_contents($path, $html);

    expect($path)->toBeFile()
        ->and($html)->toContain('component gallery')
        ->and($html)->toContain('x-fltc::table'); // sanity: snippets present
});
