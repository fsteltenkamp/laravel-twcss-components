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
            'Chips' => [
                ['link, icon and count', '<x-fltc::badge.cloud theme="skin" label="Tags">
    <x-fltc::badge href="#" icon="tag" :count="12">fantasy</x-fltc::badge>
    <x-fltc::badge href="#" icon="tag" :count="4">romance</x-fltc::badge>
    <x-fltc::badge href="#" icon="tag" :count="31">mystery</x-fltc::badge>
</x-fltc::badge.cloud>'],
                ['toggle (facets)', '<x-fltc::badge.cloud theme="skin" label="Genres">
    <x-fltc::badge variant="toggle" name="genres[]" value="scifi" checked>Sci-fi</x-fltc::badge>
    <x-fltc::badge variant="toggle" name="genres[]" value="horror">Horror</x-fltc::badge>
    <x-fltc::badge variant="toggle" name="genres[]" value="poetry" :count="3">Poetry</x-fltc::badge>
</x-fltc::badge.cloud>'],
                ['removable (✕ dispatches badge-remove)', '<div class="flex flex-wrap gap-2">
    <span x-data="{ shown: true }" x-show="shown" x-on:badge-remove="shown = false"><x-fltc::badge theme="skin" removable value="draft">draft</x-fltc::badge></span>
    <span x-data="{ shown: true }" x-show="shown" x-on:badge-remove="shown = false"><x-fltc::badge theme="skin" removable value="needs-edit">needs edit</x-fltc::badge></span>
    <span x-data="{ shown: true }" x-show="shown" x-on:badge-remove="shown = false"><x-fltc::badge theme="skin" removable value="beta">beta</x-fltc::badge></span>
</div>'],
            ],
            'Progress' => [
                ['single bar', '<x-fltc::progress theme="skin" :value="64" label="Chapter 4 of 7" showValue class="max-w-md" />'],
                ['split with legend', '<x-fltc::progress :max="40" legend class="max-w-md">
    <x-fltc::progress.segment :value="22" theme="green" label="Read" />
    <x-fltc::progress.segment :value="6" theme="amber" label="Reading" />
    <x-fltc::progress.segment :value="4" theme="skin" label="Want to read" />
</x-fltc::progress>'],
                ['meter (ok / warning / over limit)', '<div class="max-w-md space-y-4">
    <x-fltc::progress variant="meter" theme="skin" label="Storage" :value="1.2" :max="5" unit="GB" />
    <x-fltc::progress variant="meter" theme="skin" label="Storage" :value="4.3" :max="5" unit="GB" />
    <x-fltc::progress variant="meter" theme="skin" label="Storage" :value="5.4" :max="5" unit="GB" />
</div>'],
            ],
            'Star rating' => [
                ['half stars', '<span class="inline-flex flex-col gap-2"><x-fltc::rating theme="skin" value="3.5" showValue /><x-fltc::rating theme="skin" value="4.8" size="lg" /><x-fltc::rating theme="skin" value="1" size="sm" /></span>'],
            ],
            'Save status' => [
                ['driven from Alpine', '<div x-data="{ status: \'saved\' }" class="flex flex-wrap items-center gap-3">
    <x-fltc::status state="saved" x-bind:data-state="status" />
    <x-fltc::segmented theme="skin" value="saved" label="State" x-model="status">
        <x-fltc::segmented.option value="live" label="live" />
        <x-fltc::segmented.option value="unsaved" label="unsaved" />
        <x-fltc::segmented.option value="saving" label="saving" />
        <x-fltc::segmented.option value="saved" label="saved" />
        <x-fltc::segmented.option value="error" label="error" />
    </x-fltc::segmented>
</div>'],
                ['theme="skin" for every state', '<x-fltc::status theme="skin" state="unsaved" />'],
            ],
            'Empty state' => [
                ['bordered with actions', '<x-fltc::empty theme="skin" icon="books" title="No stories yet" bordered>
    Your library is empty. Start writing or import a manuscript.
    <x-slot:actions>
        <x-fltc::button theme="skin" icon="plus">New story</x-fltc::button>
        <x-fltc::button theme="skin" variant="outline" icon="upload-simple">Import</x-fltc::button>
    </x-slot:actions>
</x-fltc::empty>'],
            ],
            'Error panel' => [
                ['messagebox variant="error"', '<x-fltc::messagebox variant="error" class="max-w-xl">
    We could not load your chapters. Check your connection and try again.
    <x-slot:details summary="Technical details">GET /api/chapters → 503 Service Unavailable
request id 7f3a9c</x-slot:details>
    <x-slot:actions><x-fltc::button theme="red" icon="arrow-clockwise">Retry</x-fltc::button></x-slot:actions>
</x-fltc::messagebox>'],
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
            'Number input' => [
                ['min / max / step', '<x-fltc::form.input.number theme="skin" label="Quantity" min="0" max="10" step="1" value="3" icon="hash" class="max-w-sm" />'],
            ],
            'Date, time and datetime' => [
                ['date', '<x-fltc::form.input.date theme="skin" label="Due on" class="max-w-sm" />'],
                ['time', '<x-fltc::form.input.time theme="skin" label="Reminder at" class="max-w-sm" />'],
                ['datetime', '<x-fltc::form.input.datetime theme="skin" label="Starts at" class="max-w-sm" />'],
            ],
            'File input' => [
                ['single', '<x-fltc::form.input.file theme="skin" label="Avatar" accept="image/*" wrapperClass="max-w-sm" />'],
                ['multiple', '<x-fltc::form.input.file theme="skin" label="Attachments" name="files[]" multiple wrapperClass="max-w-sm" />'],
            ],
            'Inline fields (filter bar)' => [
                ['flex items-end', '<div class="flex flex-wrap items-end gap-3">
    <x-fltc::form.input.text theme="skin" label="Search" placeholder="Name or email" icon="magnifying-glass" inline wrapperClass="w-64" />
    <x-fltc::form.input.select theme="skin" label="Status" inline wrapperClass="w-40"><option>Active</option><option>Archived</option></x-fltc::form.input.select>
    <x-fltc::form.input.date theme="skin" label="Since" inline wrapperClass="w-44" />
    <x-fltc::button theme="skin" icon="funnel">Filter</x-fltc::button>
</div>'],
            ],
            'Radio group' => [
                ['vertical', '<x-fltc::form.radio.group theme="skin" name="gallery-plan" label="Plan" value="pro" required>
    <x-fltc::form.radio value="free" label="Free" />
    <x-fltc::form.radio value="pro" label="Pro" />
    <x-fltc::form.radio value="team" label="Team" disabled />
</x-fltc::form.radio.group>'],
                ['horizontal', '<x-fltc::form.radio.group theme="skin" name="gallery-size" label="Size" value="m" horizontal>
    <x-fltc::form.radio value="s" label="Small" />
    <x-fltc::form.radio value="m" label="Medium" />
    <x-fltc::form.radio value="l" label="Large" />
</x-fltc::form.radio.group>'],
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
            'Field wrapper' => [
                ['custom control with note', '<x-fltc::form.field theme="skin" label="Accent colour" note="Used for your profile header." for="gallery-colour" class="max-w-sm">
    <input id="gallery-colour" type="color" value="#f472b6" class="h-10 w-20 cursor-pointer rounded border" />
</x-fltc::form.field>'],
                ['input with note', '<x-fltc::form.input.email theme="skin" label="Email" note="We never share it." icon="envelope" class="max-w-sm" />'],
            ],
            'Settings section' => [
                ['split', '<x-fltc::form.section theme="skin" title="Profile" hint="Shown on your public page." split>
    <x-fltc::form.input.text theme="skin" label="Display name" value="Jane Doe" />
    <x-fltc::form.textarea theme="skin" label="Bio" rows="2" />
    <x-slot:actions><x-fltc::button theme="skin">Save</x-fltc::button></x-slot:actions>
</x-fltc::form.section>
<x-fltc::form.section theme="skin" title="Notifications" hint="What we email you about." split>
    <x-fltc::form.checkbox theme="skin" label="New followers" checked />
</x-fltc::form.section>'],
            ],
            'Star rating input' => [
                ['click / arrow keys', '<x-fltc::form.rating theme="skin" name="gallery-score" label="Your rating" :value="3" note="Click the chosen star again to clear it." />'],
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
            'Segmented toggle' => [
                ['icons and labels', '<div x-data="{ layout: \'card\' }" class="space-y-2">
    <x-fltc::segmented theme="skin" name="layout" value="card" label="Layout" x-model="layout">
        <x-fltc::segmented.option value="card" icon="squares-four" label="Card" />
        <x-fltc::segmented.option value="compact" icon="rows" label="Compact" />
        <x-fltc::segmented.option value="list" icon="list" label="List" />
    </x-fltc::segmented>
    <x-fltc::text theme="skin" class="block text-xs">x-model value: <code x-text="layout"></code></x-fltc::text>
</div>'],
            ],
            'Tabs' => [
                ['panels', '<x-fltc::tabs theme="skin" active="profile" class="max-w-xl">
    <x-slot:list>
        <x-fltc::tabs.tab name="profile" icon="user">Profile</x-fltc::tabs.tab>
        <x-fltc::tabs.tab name="security" icon="lock">Security</x-fltc::tabs.tab>
        <x-fltc::tabs.tab name="billing" disabled>Billing</x-fltc::tabs.tab>
    </x-slot:list>
    <x-fltc::tabs.panel name="profile">Profile panel.</x-fltc::tabs.panel>
    <x-fltc::tabs.panel name="security">Security panel.</x-fltc::tabs.panel>
    <x-fltc::tabs.panel name="billing">Billing panel.</x-fltc::tabs.panel>
</x-fltc::tabs>'],
                ['links', '<x-fltc::tabs theme="skin" class="max-w-xl">
    <x-slot:list>
        <x-fltc::tabs.tab href="#" current>Overview</x-fltc::tabs.tab>
        <x-fltc::tabs.tab href="#">Activity</x-fltc::tabs.tab>
    </x-slot:list>
</x-fltc::tabs>'],
            ],
            'Pagination' => [
                ['paginator (links + summary)', '<x-fltc::nav.pagination :paginator="$paginator" theme="skin" />', ['paginator' => new \Illuminate\Pagination\LengthAwarePaginator(range(31, 40), 157, 10, 4, ['path' => '#'])]],
                ['integers (Livewire gotoPage)', '<x-fltc::nav.pagination theme="skin" :currentPage="2" :totalPages="5" :start="1" :end="5" />'],
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
            'Modal' => [
                ['default', '<x-fltc::button theme="skin" x-data x-on:click="$dispatch(\'open-modal\', \'gallery-modal\')">Open modal</x-fltc::button>
<x-fltc::modal name="gallery-modal" theme="skin">
    <div class="space-y-4">
        <x-fltc::heading level="2" size="lg" theme="skin">Edit profile</x-fltc::heading>
        <x-fltc::subheading theme="skin">Changes are saved when you press Save.</x-fltc::subheading>
        <x-fltc::form.input.text theme="skin" label="Display name" value="Jane Doe" />
        <div class="flex justify-end gap-2">
            <x-fltc::button theme="skin" variant="outline" x-on:click="close()">Close</x-fltc::button>
            <x-fltc::button theme="skin" x-on:click="close()">Save</x-fltc::button>
        </div>
    </div>
</x-fltc::modal>'],
                ['confirm', '<x-fltc::button theme="skin" variant="outline" icon="trash" x-data x-on:click="$dispatch(\'open-modal\', \'gallery-confirm\')">Delete…</x-fltc::button>
<x-fltc::modal.confirm name="gallery-confirm" theme="skin" title="Delete this post?" description="This cannot be undone.">
    <x-fltc::button theme="red" x-on:click="close()">Delete</x-fltc::button>
</x-fltc::modal.confirm>'],
            ],
            'Dropdown' => [
                ['actions menu', '<x-fltc::dropdown theme="skin">
    <x-slot:trigger><x-fltc::button theme="skin" icon="dots-three" iconPosition="after">Actions</x-fltc::button></x-slot:trigger>
    <x-fltc::dropdown.item href="#" icon="pencil-simple">Edit</x-fltc::dropdown.item>
    <x-fltc::dropdown.item icon="copy" x-on:click="console.log(\'duplicate\')">Duplicate</x-fltc::dropdown.item>
    <x-fltc::dropdown.item icon="archive" disabled>Archive (disabled)</x-fltc::dropdown.item>
    <x-fltc::separator class="my-1" />
    <x-fltc::dropdown.item href="#" method="delete" icon="trash" theme="red">Delete</x-fltc::dropdown.item>
</x-fltc::dropdown>'],
                ['right-aligned, opens upward', '<div class="flex justify-end pt-48"><x-fltc::dropdown theme="skin" align="right" position="top" width="sm">
    <x-slot:trigger><x-fltc::button theme="skin" variant="outline" icon="gear" /></x-slot:trigger>
    <x-fltc::dropdown.item href="#">Settings</x-fltc::dropdown.item>
    <x-fltc::dropdown.item href="#">Sign out</x-fltc::dropdown.item>
</x-fltc::dropdown></div>'],
            ],
            'Drawer' => [
                ['right-edge tabs (the Menu tab on the left edge is the gallery\'s own contents drawer)', '<x-fltc::drawer name="gallery-wiki" side="right" title="Wiki" label="Wiki" icon="book-open" theme="skin" offset="5rem" pinnable>
    Pinnable right drawer. Pin it, then click outside — it stays open.
</x-fltc::drawer>
<x-fltc::drawer name="gallery-notes" side="right" title="Notes" label="Notes" icon="note" theme="skin" offset="5rem" :order="1">
    Opening this closes the Wiki drawer first.
</x-fltc::drawer>
'],
                ['without a tab, opened by event', '<x-fltc::drawer name="gallery-quiet" side="left" title="Filters" theme="skin" offset="5rem">
    No activation tab — opened from a trigger.
</x-fltc::drawer>
<x-fltc::button theme="skin" icon="funnel" x-data x-on:click="$dispatch(\'fltc-drawer-toggle\', \'gallery-quiet\')" data-fltc-drawer-trigger>Filters</x-fltc::button>'],
            ],
        ],

        'Utility' => [
            'Theme picker' => [
                ['theme + mode (also in the Style drawer)', '<x-fltc::theme.picker :themes="[\'slate\', \'rose\', \'cyberpunk\', \'fantasy\', \'wh40k\']" storageKey="fltc-gallery-skin" theme="skin" />'],
            ],
            'Spinner' => [
                ['sizes', '<span class="inline-flex items-center gap-4"><x-fltc::spinner theme="skin" size="xs" /><x-fltc::spinner theme="skin" size="sm" /><x-fltc::spinner theme="skin" /><x-fltc::spinner theme="skin" size="lg" /><x-fltc::spinner theme="skin" size="xl" /></span>'],
                ['in a button (theme="current")', '<x-fltc::button theme="skin" x-data="{ busy: false }" x-on:click="busy = true; setTimeout(() => busy = false, 1500)"><x-fltc::spinner theme="current" size="sm" class="mr-2" x-show="busy" x-cloak />Save</x-fltc::button>'],
            ],
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
    $nav = [];

    foreach ($groups as $section => $components) {
        $cards = '';
        $sectionId = 'section-'.\Illuminate\Support\Str::slug($section);
        $nav[$section] = ['id' => $sectionId, 'items' => []];

        foreach ($components as $componentName => $variants) {
            $cardId = \Illuminate\Support\Str::slug($section.' '.$componentName);
            $nav[$section]['items'][$cardId] = $componentName;
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
                <div id="{$cardId}" class="scroll-mt-24 rounded-lg border border-skin-200 dark:border-skin-700 bg-white dark:bg-skin-800 overflow-hidden">
                    <div class="px-6 py-3 text-sm font-semibold text-skin-700 dark:text-skin-200 border-b border-skin-100 dark:border-skin-700">{$componentName}</div>
                    {$blocks}
                </div>
                HTML;
        }

        $sections .= <<<HTML
            <section id="{$sectionId}" class="scroll-mt-24 space-y-5">
                <h2 class="text-lg font-bold text-skin-800 dark:text-skin-100">{$section}</h2>
                <div class="space-y-5">{$cards}</div>
            </section>
            HTML;
    }

    // The selectable skins come straight from the shipped stylesheet.
    $skinCss = file_get_contents(dirname(__DIR__).'/resources/css/skins.css');
    preg_match_all('/\[data-skin="([a-z0-9]+)"\]/', $skinCss, $m);
    $skins = $m[1];

    // The style controls live in a drawer (first tab on the right edge) so the header
    // stays one line on small screens. They are library components too, so they follow
    // the theme and the skin effects like everything else on the page.
    $controls = Blade::render(<<<'BLADE'
        <x-fltc::drawer name="gallery-style" side="right" title="Style" label="Style" icon="palette" theme="skin" offset="5rem" :order="-1" pinnable>
            <div class="space-y-6">
                <x-fltc::theme.picker :themes="$skins" storageKey="fltc-gallery-skin" theme="skin" stacked />
                <div class="space-y-2">
                    <x-fltc::form.label theme="skin" for="gallery-fx">Skin effects</x-fltc::form.label>
                    <x-fltc::form.checkbox theme="skin" themeOff="skin" variant="toggle" id="gallery-fx" label="Fonts, rounding and glow" checked
                        onchange="document.getElementById('fltc-fx').disabled = ! this.checked; try { localStorage.setItem('fltc-gallery-fx', this.checked ? 'on' : 'off'); } catch (e) {}" />
                    <x-fltc::text theme="skin" class="block text-xs opacity-75">Fonts, rounding and glow for cyberpunk, fantasy and wh40k; no change for other themes.</x-fltc::text>
                </div>
            </div>
        </x-fltc::drawer>
        BLADE, ['skins' => $skins]);
    $themeScript = Blade::render('<x-fltc::theme.script storageKey="fltc-gallery-skin" />');

    // Contents: a link to every section and card, filterable. Links close the drawer
    // unless it is pinned (they run inside the drawer's Alpine scope).
    $contents = Blade::render(<<<'BLADE'
        <x-fltc::drawer name="gallery-nav" side="left" title="Contents" label="Menu" icon="list" theme="skin" offset="5rem" width="18rem" pinnable>
            <div x-data="{ q: '' }" class="space-y-4">
                <x-fltc::form.input.text theme="skin" id="gallery-nav-filter" type="search" placeholder="Filter components…" icon="magnifying-glass" x-model="q" inline autocomplete="off" />
                @foreach ($nav as $section => $entry)
                    @php($terms = mb_strtolower($section.' '.implode(' ', $entry['items'])))
                    <div x-show="q === '' || @js($terms).includes(q.toLowerCase())">
                        <a href="#{{ $entry['id'] }}" x-on:click="if (! pinned) hide()" class="mb-1 block px-3 text-xs font-semibold uppercase tracking-wide text-skin-500 hover:text-skin-800 dark:text-skin-400 dark:hover:text-skin-100">{{ $section }}</a>
                        @foreach ($entry['items'] as $id => $name)
                            <div x-show="q === '' || @js(mb_strtolower($section.' '.$name)).includes(q.toLowerCase())">
                                <x-fltc::nav.sidebar.link theme="skin" href="#{{ $id }}" :active="false" x-on:click="if (! pinned) hide()">{{ $name }}</x-fltc::nav.sidebar.link>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </x-fltc::drawer>
        BLADE, ['nav' => $nav]);

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
            </script>
            <!-- restores the chosen skin and dark mode before first paint -->
            {$themeScript}
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
            {$contents}
            <script>
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
