<?php

/*
 * Visual gallery generator.
 *
 * This is not an assertion test — it renders one representative example of every
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
 * The gallery content: a list of [section => [ [label, code, data?], ... ] ].
 * `code` is rendered with Blade::render($code, $data ?? []).
 */
function galleryGroups(): array
{
    return [
        'Typography' => [
            ['Text', '<x-fltc::text>The quick brown fox jumps over the lazy dog.</x-fltc::text>'],
        ],

        'Buttons' => [
            ['Button — solid', '<x-fltc::button theme="sky">Save</x-fltc::button>'],
            ['Button — outline', '<x-fltc::button theme="rose" variant="outline">Delete</x-fltc::button>'],
            ['Button — disabled', '<x-fltc::button theme="gray" disabled>Disabled</x-fltc::button>'],
            ['Button link', '<x-fltc::button.link href="#" theme="emerald">Go somewhere</x-fltc::button.link>'],
            ['Button group', '<x-fltc::buttongroup>
    <x-fltc::button theme="slate">Left</x-fltc::button>
    <x-fltc::button theme="slate">Middle</x-fltc::button>
    <x-fltc::button theme="slate">Right</x-fltc::button>
</x-fltc::buttongroup>'],
        ],

        'Status & Feedback' => [
            ['Badge', '<x-fltc::badge theme="green">available</x-fltc::badge> <x-fltc::badge theme="red">no stock</x-fltc::badge> <x-fltc::badge theme="yellow">start sale</x-fltc::badge>'],
            ['Alert', '<x-fltc::alert theme="amber">Heads up — your trial ends soon.</x-fltc::alert>'],
            ['Message box', '<x-fltc::messagebox theme="sky" title="Note">
    Selected 3 items. Choose an action below.
</x-fltc::messagebox>'],
            ['Tooltip', '<x-fltc::tooltip text="More info here" theme="gray">Hover me</x-fltc::tooltip>'],
        ],

        'Cards' => [
            ['Card with sections', '<x-fltc::card theme="slate" class="max-w-sm">
    <x-fltc::card.header class="px-4 py-3 font-semibold border-b border-slate-200 dark:border-slate-700">Project</x-fltc::card.header>
    <x-fltc::card.body class="p-4">Body content goes here, inheriting the card theme.</x-fltc::card.body>
    <x-fltc::card.footer class="px-4 py-3 border-t border-slate-200 dark:border-slate-700 text-sm">Updated just now</x-fltc::card.footer>
</x-fltc::card>'],
        ],

        'Counters' => [
            ['Counter', '<x-fltc::counter theme="indigo" title="Users" count="1,204" description="active this week" icon="ph ph-users" class="max-w-xs" />'],
        ],

        'Accordion' => [
            ['Accordion', '<x-fltc::accordion theme="slate" class="max-w-md">
    <x-fltc::accordion.item title="First section" subtext="open by default">Content of the first item.</x-fltc::accordion.item>
    <x-fltc::accordion.item title="Second section">Content of the second item.</x-fltc::accordion.item>
</x-fltc::accordion>'],
        ],

        'Tables' => [
            ['Table — default (bordered grid)', tableExample(false)],
            ['Table — floating variant', tableExample(true)],
        ],

        'Forms' => [
            ['Text input', '<x-fltc::form.input.text label="Name" placeholder="Jane Doe" icon="user" class="max-w-sm" />'],
            ['Email input', '<x-fltc::form.input.email label="Email" placeholder="you@example.com" icon="envelope" class="max-w-sm" />'],
            ['Password input', '<x-fltc::form.input.password label="Password" placeholder="••••••••" class="max-w-sm" />'],
            ['Select', '<x-fltc::form.input.select label="Country" placeholder="Choose…" class="max-w-sm">
    <option value="de">Germany</option>
    <option value="us">United States</option>
</x-fltc::form.input.select>'],
            ['Datetime', '<x-fltc::form.input.datetime label="Starts at" class="max-w-sm" />'],
            ['Textarea', '<x-fltc::form.textarea label="Notes" rows="3" placeholder="Write something…" class="max-w-sm" />'],
            ['Checkbox', '<x-fltc::form.checkbox label="I agree to the terms" theme="sky" />'],
            ['Label', '<x-fltc::form.label for="x" required description="Shown to other members">Display name</x-fltc::form.label>'],
            ['Checklist', '<x-fltc::form.checklist :items="$items" theme="emerald" showProgress />', ['items' => [
                ['label' => 'Create account', 'status' => 'completed'],
                ['label' => 'Verify email', 'status' => 'inProgress'],
                ['label' => 'Add payment', 'status' => 'pending'],
            ]]],
        ],

        'Navigation' => [
            ['Nav link', '<x-fltc::nav.link href="#" theme="slate">Dashboard</x-fltc::nav.link>'],
            ['Breadcrumbs', '<x-fltc::nav.breadcrumbs :crumbs="$crumbs" theme="slate" />', ['crumbs' => [
                ['label' => 'Home', 'href' => '#'],
                ['label' => 'Library', 'href' => '#'],
                ['label' => 'Data', 'href' => null],
            ]]],
            ['Pagination', '<x-fltc::nav.pagination :currentPage="2" :totalPages="5" :start="1" :end="5" />'],
            ['Stepper', '<x-fltc::nav.stepper :steps="$steps" :stepIndex="2" theme="sky" />', ['steps' => [
                ['label' => 'Cart'], ['label' => 'Shipping'], ['label' => 'Payment'],
            ]]],
        ],

        'Utility' => [
            ['Dark mode toggle', '<x-fltc::darkmode.toggle />'],
            ['Container box', '<x-fltc::container.box theme="slate" class="p-4 max-w-sm">Boxed content.</x-fltc::container.box>'],
        ],
    ];
}

function tableExample(bool $floating): string
{
    $floatAttr = $floating ? ' floating' : '';

    return <<<BLADE
        <x-fltc::table theme="gray"{$floatAttr} class="max-w-2xl">
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
                <x-fltc::table.cell><x-fltc::badge theme="green">available</x-fltc::badge></x-fltc::table.cell>
            </x-fltc::table.row>
            <x-fltc::table.row>
                <x-fltc::table.cell>Realme</x-fltc::table.cell>
                <x-fltc::table.cell>Technology</x-fltc::table.cell>
                <x-fltc::table.cell numeric>200.00\$</x-fltc::table.cell>
                <x-fltc::table.cell><x-fltc::badge theme="red">no stock</x-fltc::badge></x-fltc::table.cell>
            </x-fltc::table.row>
        </x-fltc::table>
        BLADE;
}

function renderGalleryHtml(array $groups): string
{
    $sections = '';

    foreach ($groups as $section => $examples) {
        $cards = '';

        foreach ($examples as $example) {
            $label = $example[0];
            $code = $example[1];
            $data = $example[2] ?? [];

            try {
                $rendered = Blade::render($code, $data);
                $preview = $rendered;
            } catch (\Throwable $e) {
                $preview = '<div class="text-sm text-red-600 dark:text-red-400 font-mono">'
                    .'⚠ render error (likely needs host-app context): '
                    .htmlspecialchars($e->getMessage())
                    .'</div>';
            }

            $source = htmlspecialchars(trim($code));

            $cards .= <<<HTML
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                    <div class="px-4 py-2 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">{$label}</div>
                    <div class="p-5 flex flex-wrap items-start gap-3 bg-[repeating-conic-gradient(#0000_0_25%,#00000008_0_50%)] dark:bg-none">{$preview}</div>
                    <pre class="m-0 px-4 py-3 text-xs leading-relaxed overflow-x-auto bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 border-t border-gray-100 dark:border-gray-700"><code>{$source}</code></pre>
                </div>
                HTML;
        }

        $sections .= <<<HTML
            <section class="space-y-4">
                <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">{$section}</h2>
                <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">{$cards}</div>
            </section>
            HTML;
    }

    return <<<HTML
        <!doctype html>
        <html lang="en" class="">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>fltc — component gallery</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <script>tailwind.config = { darkMode: 'class' };</script>
            <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js"></script>
            <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/regular/style.css">
            <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Round" rel="stylesheet">
        </head>
        <body class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <header class="sticky top-0 z-50 flex items-center justify-between px-6 py-4 bg-white/80 dark:bg-gray-800/80 backdrop-blur border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100">fltc component gallery</h1>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Rendered through real Blade — regenerate with <code>./test.sh tests/GalleryTest.php</code></p>
                </div>
                <button onclick="document.documentElement.classList.toggle('dark')"
                    class="rounded-md border border-gray-300 dark:border-gray-600 px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    Toggle dark
                </button>
            </header>
            <main class="max-w-7xl mx-auto px-6 py-8 space-y-12">
                {$sections}
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
