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

it('renders the icon component with the regular (base "ph") weight by default', function () {
    $html = Blade::render('<x-fltc::icon name="user" />');

    expect($html)
        ->toContain('<i')
        ->toContain('ph ph-user')
        ->not->toContain('ph-fill')
        ->toContain('aria-hidden="true"');
});

it('renders the solid (fill) weight when explicitly requested', function () {
    $html = Blade::render('<x-fltc::icon name="user" variant="solid" />');

    expect($html)->toContain('ph-fill')->toContain('ph-user');
});

it('applies icon modifiers: variant, color, size, spacing and alignment', function () {
    $html = Blade::render('<x-fltc::icon name="user" variant="bold" color="red" size="lg" before="2" after="3" align="middle" />');

    expect($html)
        ->toContain('ph-bold')
        ->toContain('ph-user')
        ->toContain('text-red-500')
        ->toContain('dark:text-red-400')
        ->toContain('text-lg')
        ->toContain('ms-2')
        ->toContain('me-3')
        ->toContain('align-middle');
});

it('renders a full icon class string verbatim without doubling the prefix', function () {
    $html = Blade::render('<x-fltc::icon name="ph ph-gauge" class="shrink-0" />');

    expect($html)
        ->toContain('ph ph-gauge')
        ->toContain('shrink-0')
        ->not->toContain('ph-fill');
});

it('renders a button with an icon before its label', function () {
    $html = Blade::render('<x-fltc::button icon="floppy-disk">Save</x-fltc::button>');

    expect($html)
        ->toContain('Save')
        ->toContain('ph-floppy-disk')
        ->toContain('me-2');
});

it('renders the buttongroup component via the fltc Blade handle', function () {
    $html = Blade::render('<x-fltc::buttongroup>inner</x-fltc::buttongroup>');

    expect($html)->toContain('inner');
});

it('renders the tooltip component via the fltc Blade handle', function () {
    $html = Blade::render('<x-fltc::tooltip text="hi">child</x-fltc::tooltip>');

    expect($html)->toContain('child');
});

it('renders the counter component via the fltc Blade handle', function () {
    $html = Blade::render('<x-fltc::counter title="Users" count="42" description="active this week" icon="ph ph-users" />');

    expect($html)
        ->toContain('Users')
        ->toContain('42')
        ->toContain('active this week')
        ->toContain('ph ph-users');
});

it('renders the counter component as a link when link is set', function () {
    $html = Blade::render('<x-fltc::counter title="Users" count="42" link="/dashboard/users" navigate />');

    expect($html)
        ->toContain('<a')
        ->toContain('href="/dashboard/users"')
        ->toContain('wire:navigate')
        ->toContain('cursor-pointer');
});

it('renders the default table variant with collapsed borders', function () {
    $html = Blade::render(<<<'BLADE'
        <x-fltc::table>
            <x-fltc::table.row><x-fltc::table.cell>Apple</x-fltc::table.cell></x-fltc::table.row>
        </x-fltc::table>
    BLADE);

    expect($html)
        ->toContain('Apple')
        ->not->toContain('border-separate');
});

it('renders the floating table variant as separated rounded pills', function () {
    $html = Blade::render(<<<'BLADE'
        <x-fltc::table floating theme="gray">
            <x-fltc::table.row><x-fltc::table.cell>Apple</x-fltc::table.cell></x-fltc::table.row>
        </x-fltc::table>
    BLADE);

    expect($html)
        ->toContain('Apple')
        ->toContain('border-separate')
        ->toContain('border-spacing-y-3')
        // pill surface, border and shadow re-targeted onto every row cell (td and th,
        // so the head row matches), with rounded outer corners. `&` and `>` are
        // HTML-escaped inside the attribute, so match the escaped form.
        ->toContain('[&amp;&gt;*]:bg-gray-100/90')
        ->toContain('[&amp;&gt;*]:border-gray-200')
        ->toContain('[&amp;&gt;*]:border-y')
        ->toContain('[&amp;&gt;*]:shadow-sm')
        ->toContain('[&amp;&gt;*:first-child]:rounded-l-lg')
        ->toContain('[&amp;&gt;*:last-child]:rounded-r-lg');
});

it('renders the sidebar with nav links, a collapsible group and a footer', function () {
    $html = Blade::render(<<<'BLADE'
        <x-fltc::nav.sidebar theme="indigo">
            <x-fltc::nav.sidebar.link href="/dashboard" icon="ph ph-gauge">Dashboard</x-fltc::nav.sidebar.link>

            <x-fltc::nav.sidebar.group label="Settings" icon="ph ph-gear">
                <x-fltc::nav.sidebar.link href="/settings/profile">Profile</x-fltc::nav.sidebar.link>
            </x-fltc::nav.sidebar.group>

            <x-slot:footer>
                <x-fltc::nav.sidebar.footer>
                    <x-fltc::nav.sidebar.profile name="Ada Lovelace" email="ada@example.com">
                        <x-fltc::nav.sidebar.link href="/logout">Sign out</x-fltc::nav.sidebar.link>
                    </x-fltc::nav.sidebar.profile>
                </x-fltc::nav.sidebar.footer>
            </x-slot:footer>
        </x-fltc::nav.sidebar>
    BLADE);

    expect($html)
        ->toContain('<aside')
        ->toContain('h-screen')
        ->toContain('Dashboard')
        ->toContain('Profile')
        // collapsible group wiring
        ->toContain('data-sidebar-group')
        ->toContain('data-sidebar-group-key="settings"')
        ->toContain('data-sidebar-group-trigger')
        // profile menu + derived initials
        ->toContain('data-sidebar-profile')
        ->toContain('Ada Lovelace')
        ->toContain('AL')
        ->toContain('Sign out');
});

it('makes the sidebar a collapsible off-canvas drawer by default', function () {
    $html = Blade::render('<x-fltc::nav.sidebar name="main">links</x-fltc::nav.sidebar>');

    expect($html)
        // mobile drawer positioning + the always-visible desktop override
        ->toContain('max-lg:fixed')
        ->toContain('max-lg:-translate-x-full')
        ->toContain('lg:translate-x-0')
        // Alpine wiring + the named-target event hooks
        ->toContain('x-data')
        ->toContain('fltc-sidebar-toggle.window')
        ->toContain('main')
        ->toContain('x-teleport="body"');
});

it('opts a sidebar out of the mobile drawer with collapsible=false', function () {
    $html = Blade::render('<x-fltc::nav.sidebar :collapsible="false">links</x-fltc::nav.sidebar>');

    expect($html)
        ->not->toContain('max-lg:fixed')
        ->not->toContain('x-data')
        ->not->toContain('fltc-sidebar-toggle');
});

it('renders the navbar toggle as a button dispatching the sidebar event', function () {
    $html = Blade::render('<x-fltc::nav.navbar.toggle target="main" />');

    expect($html)
        ->toContain('<button')
        ->toContain('lg:hidden')
        ->toContain('aria-label="Toggle navigation"')
        ->toContain('$dispatch(')
        ->toContain('fltc-sidebar-toggle')
        ->toContain('main')
        // default hamburger icon
        ->toContain('ph-list');
});

it('marks the sidebar link active when its href matches the current url', function () {
    $html = Blade::render(
        '<x-fltc::nav.sidebar.link href="/dashboard">Dashboard</x-fltc::nav.sidebar.link>',
        [],
    );

    // No active state for a non-matching path under the test request ("/").
    expect($html)->not->toContain('aria-current="page"');

    $active = Blade::render('<x-fltc::nav.sidebar.link active href="/dashboard">Dashboard</x-fltc::nav.sidebar.link>');

    expect($active)
        ->toContain('aria-current="page"')
        ->toContain('data-sidebar-active');
});

it('renders the navbar with links, an item, a dropdown and an onclick action', function () {
    $html = Blade::render(<<<'BLADE'
        <x-fltc::nav.navbar theme="slate">
            <x-slot:left>
                <x-fltc::nav.navbar.link href="/dashboard">Dashboard</x-fltc::nav.navbar.link>
                <x-fltc::nav.navbar.item>Static</x-fltc::nav.navbar.item>
                <x-fltc::nav.navbar.dropdown>
                    <x-slot:trigger>Resources</x-slot:trigger>
                    <x-fltc::nav.navbar.dropdown.link href="/docs">Docs</x-fltc::nav.navbar.dropdown.link>
                </x-fltc::nav.navbar.dropdown>
            </x-slot:left>
            <x-slot:right>
                <x-fltc::nav.navbar.onclick onclick="toggle()">Action</x-fltc::nav.navbar.onclick>
            </x-slot:right>
        </x-fltc::nav.navbar>
    BLADE);

    expect($html)
        ->toContain('<nav')
        ->toContain('Dashboard')
        ->toContain('Static')
        ->toContain('Resources')
        ->toContain('Docs')
        ->toContain('data-navbar-dropdown')
        ->toContain('data-dropdown-menu')
        ->toContain('onclick="toggle()"');
});

it('renders a navbar dropdown postlink as a POST form with a CSRF field', function () {
    $html = Blade::render(<<<'BLADE'
        <x-fltc::nav.navbar.dropdown.postlink action="/logout">Sign out</x-fltc::nav.navbar.dropdown.postlink>
    BLADE);

    expect($html)
        ->toContain('Sign out')
        ->toContain('method="POST"')
        ->toContain('action="/logout"')
        ->toContain('name="_token"')
        ->toContain('<button')
        ->toContain('type="submit"');
});

it('renders a navbar postlink as a POST form with a CSRF field', function () {
    $html = Blade::render(<<<'BLADE'
        <x-fltc::nav.navbar.postlink action="/logout">Sign out</x-fltc::nav.navbar.postlink>
    BLADE);

    expect($html)
        ->toContain('Sign out')
        ->toContain('method="POST"')
        ->toContain('action="/logout"')
        ->toContain('name="_token"')
        ->toContain('<button')
        ->toContain('type="submit"');
});

it('renders a sidebar postlink as a POST form with a CSRF field', function () {
    $html = Blade::render(<<<'BLADE'
        <x-fltc::nav.sidebar.postlink action="/logout" icon="ph ph-sign-out">Sign out</x-fltc::nav.sidebar.postlink>
    BLADE);

    expect($html)
        ->toContain('Sign out')
        ->toContain('method="POST"')
        ->toContain('action="/logout"')
        ->toContain('name="_token"')
        ->toContain('<button')
        ->toContain('type="submit"');
});

it('makes the navbar sticky to the top with a top edge border', function () {
    $html = Blade::render('<x-fltc::nav.navbar theme="gray" stickyTop>nav</x-fltc::nav.navbar>');

    expect($html)
        ->toContain('sticky')
        ->toContain('top-0')
        ->toContain('z-40')
        ->toContain('border-b');
});

it('uses the navbar as a footer pinned to the bottom via stickyBottom', function () {
    $html = Blade::render('<x-fltc::nav.navbar theme="gray" stickyBottom>footer</x-fltc::nav.navbar>');

    expect($html)
        ->toContain('fixed')
        ->toContain('inset-x-0')
        ->toContain('bottom-0')
        ->toContain('z-40')
        // a bottom-pinned bar carries its edge border on top, not bottom
        ->toContain('border-t')
        ->not->toContain('border-b');
});

it('renders the heading component with a level-based tag', function () {
    $html = Blade::render('<x-fltc::heading level="1" size="xl">Settings</x-fltc::heading>');

    expect($html)
        ->toContain('<h1')
        ->toContain('Settings')
        ->toContain('text-xl')
        ->toContain('font-semibold');
});

it('renders the subheading component as muted copy', function () {
    $html = Blade::render('<x-fltc::subheading>Manage your account</x-fltc::subheading>');

    expect($html)
        ->toContain('Manage your account')
        ->toContain('text-zinc-500');
});

it('renders the separator component', function () {
    $html = Blade::render('<x-fltc::separator />');

    expect($html)
        ->toContain('role="separator"')
        ->toContain('border-t');

    $vertical = Blade::render('<x-fltc::separator vertical />');

    expect($vertical)->toContain('border-l');
});

it('renders the modal component with an entangled open state', function () {
    $html = Blade::render('<x-fltc::modal name="demo"><p>body</p></x-fltc::modal>');

    expect($html)
        ->toContain('x-data')
        ->toContain('open-modal.window')
        ->toContain('role="dialog"')
        ->toContain('body');
});

it('renders the otp component with the requested number of boxes', function () {
    $html = Blade::render('<x-fltc::form.otp length="4" name="code" />');

    expect($html)
        ->toContain('x-ref="box0"')
        ->toContain('x-ref="box3"')
        ->not->toContain('x-ref="box4"')
        ->toContain('type="hidden"')
        ->toContain('name="code"');
});

it('renders the checkbox as a toggle switch with on/off themes, size and icons', function () {
    $html = Blade::render('<x-fltc::form.checkbox
        variant="toggle"
        size="lg"
        theme="emerald"
        themeOff="rose"
        iconChecked="ph ph-check"
        iconUnchecked="ph ph-x"
        label="Notifications" />');

    expect($html)
        ->toContain('type="checkbox"')
        ->toContain('group/toggle')
        // on-theme track tint applies only while the peer input is checked
        ->toContain('group-has-[:checked]/toggle:bg-emerald-500')
        // off-theme track tint is the resting state
        ->toContain('bg-rose-200')
        // large size knob travel
        ->toContain('h-7 w-14')
        ->toContain('group-has-[:checked]/toggle:translate-x-7')
        // both configurable icons are present and swap on state
        ->toContain('ph ph-x')
        ->toContain('ph ph-check')
        ->toContain('Notifications');
});

it('renders a static pill toast with title and dismiss button', function () {
    $html = Blade::render('<x-fltc::toast title="Saved!" theme="green" variant="pill" />');

    expect($html)
        ->toContain('Saved!')
        ->toContain('rounded-full')
        ->toContain('bg-green-100')
        ->toContain('x-data')
        ->toContain('ph ph-x');
});

it('renders a static toast (default) variant with title and message', function () {
    $html = Blade::render('<x-fltc::toast title="Connection lost" theme="red" message="Please try again." />');

    expect($html)
        ->toContain('Connection lost')
        ->toContain('Please try again.')
        ->toContain('bg-red-100')
        ->toContain('rounded-lg');
});

it('renders a static card toast with title and message', function () {
    $html = Blade::render('<x-fltc::toast variant="card" theme="blue" title="Updated" message="Your profile has been updated." />');

    expect($html)
        ->toContain('Updated')
        ->toContain('Your profile has been updated.')
        ->toContain('rounded-xl')
        ->toContain('border-blue-200')
        ->toContain('dark:border-blue-800');
});

it('renders a static baguette toast as a wide banner', function () {
    $html = Blade::render('<x-fltc::toast variant="baguette" theme="red" title="Error occurred" message="Please try again." />');

    expect($html)
        ->toContain('Error occurred')
        ->toContain('Please try again.')
        ->toContain('bg-red-100')
        ->toContain('rounded-xl')
        ->toContain('w-4/5');
});

it('renders the toast container with Alpine data and event listener wiring', function () {
    $html = Blade::render('<x-fltc::toast.container position="bottom-right" />');

    expect($html)
        ->toContain('x-data')
        ->toContain('fltc:toast')
        ->toContain('flux:toast')
        ->toContain('fixed')
        ->toContain('bottom-4')
        ->toContain('right-4')
        ->toContain('aria-live="polite"');
});

it('renders the toast container at top-left position', function () {
    $html = Blade::render('<x-fltc::toast.container position="top-left" />');

    expect($html)
        ->toContain('top-4')
        ->toContain('left-4');
});

it('passes default theme, variant and duration to the Alpine scope', function () {
    $html = Blade::render('<x-fltc::toast.container theme="emerald" variant="card" :duration="6000" />');

    // @js() wraps PHP strings in single quotes for JS output.
    expect($html)
        ->toContain("'emerald'")
        ->toContain("'card'")
        ->toContain('6000');
});

it('passes the full theme map to Alpine via @js()', function () {
    $html = Blade::render('<x-fltc::toast.container />');

    // Spot-check class strings are serialised into the Alpine themeMap.
    expect($html)
        ->toContain('bg-green-100')  // all variants share pill palette
        ->toContain('bg-red-100')    // toast/baguette now use pill colors
        ->toContain('rounded-full'); // pill template in Alpine HTML
});

it('renders a right drawer with an activation tab teleported into the side rail', function () {
    $html = Blade::render(
        '<x-fltc::drawer name="wiki" title="Wiki" label="Wiki" icon="book-open" theme="amber" :order="2">content</x-fltc::drawer>'
    );

    expect($html)
        ->toContain('content')
        ->toContain('data-fltc-drawer="wiki"')
        ->toContain('id="fltc-drawer-wiki"')
        ->toContain('fltcDrawer(')
        ->toContain('right-0 border-l')
        ->toContain('translate-x-full')
        ->toContain('inert')
        ->toContain('x-teleport="[data-fltc-drawer-rail=\'right\']"')
        ->toContain('data-fltc-drawer-tab="wiki"')
        ->toContain('aria-controls="fltc-drawer-wiki"')
        ->toContain('order: 2')
        ->toContain('rotate-180')
        ->toContain('ph ph-book-open')
        ->toContain('bg-amber-600')
        ->toContain('fltc-drawer-toggle.window')
        ->toContain('window.fltcDrawers')
        ->not->toContain('@assets')
        ->not->toMatch('/data-fltc-drawer-pin\s/');
});

it('renders a left drawer starting open', function () {
    $html = Blade::render('<x-fltc::drawer name="nav" side="left" label="Nav" open>x</x-fltc::drawer>');

    expect($html)
        ->toContain('left-0 border-r')
        ->toContain('x-teleport="[data-fltc-drawer-rail=\'left\']"')
        ->not->toMatch('/\\sclass="[^"]*-translate-x-full/')
        ->not->toMatch('/<aside[^>]*\sinert[\s>]/');
});

it('omits the activation tab when the drawer has no label or icon', function () {
    $html = Blade::render('<x-fltc::drawer name="quiet" title="Quiet">x</x-fltc::drawer>');

    expect($html)
        ->toContain('data-fltc-drawer="quiet"')
        ->not->toContain('<template x-teleport')
        ->not->toContain('data-fltc-drawer-tab=');
});

it('renders a pin button for pinnable drawers and an actions slot in the header', function () {
    $html = Blade::render(<<<'BLADE'
        <x-fltc::drawer name="notes" label="Notes" pinnable width="30rem" offset="4rem" class="custom-class" wire:key="notes">
            <x-slot:actions><a href="/notes">all</a></x-slot:actions>
            body
        </x-fltc::drawer>
        BLADE);

    expect($html)
        ->toContain('data-fltc-drawer-pin')
        ->toContain('togglePin()')
        ->toContain('<a href="/notes">all</a>')
        ->toContain('custom-class')
        ->toContain('wire:key="notes"')
        ->toContain('top: 4rem; width: min(30rem, calc(100vw - 2.5rem));');
});

it('emits the drawer script only once per page', function () {
    $html = Blade::render(
        '<x-fltc::drawer name="a" label="A" /><x-fltc::drawer name="b" label="B" side="left" />'
    );

    expect(substr_count($html, 'if (! window.fltcDrawers)'))->toBe(1);
});

it('keeps the page container clear of drawer rails and pinned drawers', function () {
    $html = Blade::render('<x-fltc::container.page width="5xl" gutter="left" id="main">x</x-fltc::container.page>');

    expect($html)
        ->toContain('max-w-5xl')
        ->toContain('sm:ps-[calc(var(--fltc-drawer-pin-left,0px)_+_3rem)]')
        ->toContain('pe-4 sm:pe-6')
        ->toContain('id="main"');
});

/*
 * Form fields: typed inputs, inline mode, file, radio.
 */
function shareErrors(array $messages = []): void
{
    \Illuminate\Support\Facades\View::share('errors', (new \Illuminate\Support\ViewErrorBag)->put('default', new \Illuminate\Support\MessageBag($messages)));
}

it('renders exactly one type attribute on every typed input', function (string $tag, string $type) {
    shareErrors();
    $html = Blade::render("<x-fltc::form.input.{$tag} id=\"f\" />");

    expect(preg_match_all('/\stype="/', $html))->toBe(1)
        ->and($html)->toContain("type=\"{$type}\"")
        ->and($html)->toContain("fltc-form-input-{$tag}");
})->with([
    ['text', 'text'],
    ['number', 'number'],
    ['date', 'date'],
    ['time', 'time'],
    ['datetime', 'datetime-local'],
    ['email', 'email'],
    ['password', 'password'],
]);

it('takes the input type from the type prop instead of duplicating it', function () {
    shareErrors();
    $html = Blade::render('<x-fltc::form.input.text type="search" id="q" />');

    expect(preg_match_all('/\stype="/', $html))->toBe(1)->and($html)->toContain('type="search"');
});

it('passes min, max and step through to a number input', function () {
    shareErrors();
    $html = Blade::render('<x-fltc::form.input.number id="qty" min="0" max="10" step="2" value="4" />');

    expect($html)->toContain('min="0"')->toContain('max="10"')->toContain('step="2"')->toContain('value="4"');
});

it('pads the input for the icon only when there is one', function () {
    shareErrors();

    expect(Blade::render('<x-fltc::form.input.text id="a" />'))->toContain(' pl-3 ')->not->toContain('pl-10')
        ->and(Blade::render('<x-fltc::form.input.text id="a" icon="user" />'))->toContain('pl-10');
});

it('drops the bottom margin of inline fields and sizes their wrapper', function (string $tag) {
    shareErrors();

    expect(Blade::render("<x-fltc::{$tag} id=\"a\" />"))->toMatch('/^\s*<div class="mb-4">/');

    $inline = Blade::render("<x-fltc::{$tag} id=\"a\" inline wrapperClass=\"w-48\" />");
    expect($inline)->toMatch('/^\s*<div class="w-48">/')->not->toContain('mb-4');
})->with(['form.input.text', 'form.input.number', 'form.input.select', 'form.input.file', 'form.textarea']);

it('renders a themed file input with accept, multiple and a Livewire model', function () {
    shareErrors();
    $html = Blade::render('<x-fltc::form.input.file id="photos" name="photos[]" label="Photos" accept="image/*" multiple model="photos" theme="rose" />');

    expect($html)
        ->toContain('type="file"')
        ->toContain('name="photos[]"')
        ->toContain('accept="image/*"')
        ->toContain('multiple')
        ->toContain('wire:model="photos"')
        ->toContain('file:bg-rose-100')
        ->toContain('fltc-form-input-file')
        ->not->toContain('value=');
});

it('shows errors of each file of a multiple upload', function () {
    shareErrors(['photos.1' => ['The second photo is too large.']]);
    $html = Blade::render('<x-fltc::form.input.file id="photos" name="photos[]" />');

    expect($html)->toContain('The second photo is too large.')->toContain('aria-invalid="true"');
});

it('renders a radio group whose options share its name, model and theme', function () {
    shareErrors();
    $html = Blade::render(<<<'BLADE'
        <x-fltc::form.radio.group name="plan" label="Plan" value="pro" theme="rose" horizontal required>
            <x-fltc::form.radio value="free" label="Free" />
            <x-fltc::form.radio value="pro">Pro</x-fltc::form.radio>
        </x-fltc::form.radio.group>
        <x-fltc::form.radio value="x" label="Standalone" />
        BLADE);

    expect($html)
        ->toContain('<fieldset')
        ->toContain('<legend')
        ->toContain('Plan')
        ->toContain('flex flex-wrap')
        ->and(substr_count($html, 'name="plan"'))->toBe(2)
        ->and(substr_count($html, 'accent-rose-600'))->toBe(2)
        ->and(substr_count($html, ' required'))->toBe(2)
        ->and($html)->toMatch('/value="pro"\s+checked/')
        ->not->toMatch('/value="free"\s+checked/')
        ->toContain('Pro</span>');

    // The standalone radio after the group must not inherit the group's name.
    expect(substr($html, strrpos($html, '<label')))->not->toContain('name="plan"');
});

it('binds radios to the group model instead of checking them server-side', function () {
    shareErrors();
    $html = Blade::render('<x-fltc::form.radio.group name="plan" model="plan" live><x-fltc::form.radio value="a" label="A" /></x-fltc::form.radio.group>');

    expect($html)->toContain('wire:model.live="plan"')->not->toContain('checked');
});

it('shows the radio group validation error', function () {
    shareErrors(['plan' => ['Pick a plan.']]);

    expect(Blade::render('<x-fltc::form.radio.group name="plan"><x-fltc::form.radio value="a" /></x-fltc::form.radio.group>'))
        ->toContain('Pick a plan.')->toContain('aria-describedby="plan-error"');
});

/*
 * Spinner, dropdown, tabs, pagination, confirm modal.
 */
it('renders a themed spinner that passes wire:loading through', function () {
    $html = Blade::render('<x-fltc::spinner theme="rose" size="lg" wire:loading wire:target="save" />');

    expect($html)
        ->toContain('<svg')
        ->toContain('animate-spin')
        ->toContain('h-8 w-8')
        ->toContain('text-rose-500')
        ->toContain('wire:loading')
        ->toContain('wire:target="save"')
        ->toContain('role="status"')
        ->toContain('aria-label="Loading"');

    expect(Blade::render('<x-fltc::spinner theme="current" />'))->toContain('text-current');
});

it('renders a dropdown whose items are links, buttons and method forms', function () {
    $html = Blade::render(<<<'BLADE'
        <x-fltc::dropdown theme="rose" align="right"><x-slot:trigger><x-fltc::button>Actions</x-fltc::button></x-slot:trigger><x-fltc::dropdown.item href="/edit" icon="pencil">Edit</x-fltc::dropdown.item><x-fltc::dropdown.item wire:click="archive">Archive</x-fltc::dropdown.item><x-fltc::dropdown.item href="/posts/1" method="delete" theme="red">Delete</x-fltc::dropdown.item><x-fltc::dropdown.item disabled>Locked</x-fltc::dropdown.item></x-fltc::dropdown>
        BLADE);

    expect($html)
        ->toContain('x-data=')
        ->toContain('role="menu"')
        ->toContain('right-0')
        ->toContain('fltc-dropdown-menu')
        ->toContain('Actions')
        ->toMatch('/<a[^>]*href="\/edit"[^>]*role="menuitem"/s')
        ->toContain('ph-pencil')
        ->toMatch('/<button[^>]*wire:click="archive"[^>]*type="button"/s')
        ->toContain('action="/posts/1"')
        ->toContain('name="_method" value="DELETE"')
        ->toContain('name="_token"')
        ->toContain('text-red-700')
        ->toMatch('/<button[^>]*disabled[^>]*>\s*Locked/s');

    // Items without a theme of their own take the dropdown's.
    expect($html)->toMatch('/class="[^"]*fltc-dropdown-item fltc-theme-rose/');
});

it('renders tabs with panels shown by the active tab', function () {
    $html = Blade::render(<<<'BLADE'
        <x-fltc::tabs active="security" theme="rose" id="settings" wire:model="tab"><x-slot:list><x-fltc::tabs.tab name="general">General</x-fltc::tabs.tab><x-fltc::tabs.tab name="security" icon="lock">Security</x-fltc::tabs.tab><x-fltc::tabs.tab name="billing" disabled>Billing</x-fltc::tabs.tab></x-slot:list><x-fltc::tabs.panel name="general">General panel</x-fltc::tabs.panel><x-fltc::tabs.panel name="security">Security panel</x-fltc::tabs.panel></x-fltc::tabs>
        BLADE);

    expect($html)
        ->toContain('x-modelable="active"')
        ->toContain('wire:model="tab"')
        ->toContain('id="settings"')
        ->toContain('role="tablist"')
        ->toContain('border-rose-200')
        ->toMatch('/id="settings-tab-security"[^>]*aria-selected="true"/s')
        ->toMatch('/id="settings-tab-general"[^>]*aria-selected="false"/s')
        ->toMatch('/data-tab="billing"[^>]*disabled/s')
        ->toMatch('/id="settings-panel-general"[^>]*style="display: none;"/s')
        ->not->toMatch('/id="settings-panel-security"[^>]*style="display: none;"/s')
        ->toContain('aria-labelledby="settings-tab-security"')
        ->toContain('ph-lock')
        ->toContain('border-rose-500');
});

it('cloaks the panels until Alpine picks the first tab when no tab is active', function () {
    $html = Blade::render('<x-fltc::tabs><x-slot:list><x-fltc::tabs.tab name="a">A</x-fltc::tabs.tab></x-slot:list><x-fltc::tabs.panel name="a">A panel</x-fltc::tabs.panel></x-fltc::tabs>');

    expect($html)->toContain('x-cloak')->not->toContain('display: none');
});

it('renders link tabs and marks the current one', function () {
    $html = Blade::render('<x-fltc::tabs><x-slot:list><x-fltc::tabs.tab href="/a" current>A</x-fltc::tabs.tab><x-fltc::tabs.tab href="/b">B</x-fltc::tabs.tab></x-slot:list></x-fltc::tabs>');

    expect($html)
        ->toMatch('/<a[^>]*href="\/a"[^>]*aria-current="page"/s')
        ->toMatch('/<a[^>]*href="\/b"[^>]*aria-selected="false"/s')
        ->not->toContain('x-on:click');
});

function fakePaginator(int $page, int $total = 57, int $perPage = 10): \Illuminate\Pagination\LengthAwarePaginator
{
    $items = collect(range(1, $total))->forPage($page, $perPage)->values();

    return new \Illuminate\Pagination\LengthAwarePaginator($items, $total, $perPage, $page, ['path' => '/customers']);
}

it('renders a paginator as links with a "showing x–y of z" summary', function () {
    $html = Blade::render('<x-fltc::nav.pagination :paginator="$p" class="mt-4" />', ['p' => fakePaginator(3)]);

    expect($html)
        ->toContain('<nav')
        ->toContain('mt-4')
        ->toMatch('/Showing\s*<span class="font-medium">21<\/span>–<span class="font-medium">30<\/span>\s*of\s*<span class="font-medium">57<\/span>/')
        ->toContain('href="/customers?page=1"')
        ->toContain('href="/customers?page=5"')
        ->toContain('href="/customers?page=6"')
        ->toContain('aria-current="page"')
        ->not->toContain('wire:click');
});

it('disables first and previous on the first page of a paginator', function () {
    $html = Blade::render('<x-fltc::nav.pagination :paginator="$p" />', ['p' => fakePaginator(1)]);

    expect($html)
        ->toMatch('/<button[^>]*disabled[^>]*aria-label="First page"/s')
        ->toMatch('/<button[^>]*disabled[^>]*aria-label="Previous page"/s')
        ->toContain('href="/customers?page=2"');
});

it('renders a paginator as Livewire gotoPage calls with the page name', function () {
    $html = Blade::render('<x-fltc::nav.pagination :paginator="$p" livewire />', ['p' => fakePaginator(2)]);

    expect($html)
        ->toContain('wire:click="gotoPage(3, &#039;page&#039;)"')
        ->toContain('wire:key="page_link_3"')
        ->not->toContain('href=');
});

it('renders paginators through the shipped pagination views', function () {
    expect((string) fakePaginator(2)->links('fltc::pagination.links'))->toContain('href="/customers?page=3"')
        ->and((string) fakePaginator(2)->links('fltc::pagination.livewire'))->toContain('gotoPage(3, &#039;page&#039;)');
});

it('renders only the summary when a paginator has a single page', function () {
    $html = Blade::render('<x-fltc::nav.pagination :paginator="$p" />', ['p' => fakePaginator(1, 4)]);

    expect($html)->toContain('Showing')->not->toContain('<button')->not->toContain('href=');
});

it('renders prev/next only for a simple paginator', function () {
    $p = new \Illuminate\Pagination\Paginator(range(1, 11), 10, 2, ['path' => '/feed']);
    $html = Blade::render('<x-fltc::nav.pagination :paginator="$p" />', ['p' => $p]);

    expect($html)
        ->toContain('aria-label="Previous page"')
        ->toContain('aria-label="Next page"')
        ->not->toContain('First page')
        ->not->toContain(' of ');
});

it('keeps the integer pagination API on Livewire gotoPage calls', function () {
    $html = Blade::render('<x-fltc::nav.pagination :currentPage="2" :totalPages="5" :start="1" :end="5" />');

    expect($html)
        ->toContain('wire:click="gotoPage(1)"')
        ->toContain('wire:click="gotoPage(5)"')
        ->not->toContain('Showing');
});

it('themes the confirm modal cancel button instead of hardcoding zinc', function () {
    expect(Blade::render('<x-fltc::modal.confirm name="c" title="Sure?" theme="rose">x</x-fltc::modal.confirm>'))
        ->toContain('border-rose-')->not->toContain('zinc-300')
        ->and(Blade::render('<x-fltc::modal.confirm name="c" title="Sure?" cancelTheme="amber" cancelLabel="Keep">x</x-fltc::modal.confirm>'))
        ->toContain('border-amber-')->toContain('Keep');
});

it('themes the modal panel and backdrop', function () {
    $html = Blade::render('<x-fltc::modal name="m" theme="rose" maxWidth="2xl">x</x-fltc::modal>');

    expect($html)
        ->toMatch('/class="[^"]*fltc-modal fltc-theme-rose/')
        ->toMatch('/class="fltc-modal-panel [^"]*max-w-2xl[^"]*border-rose-200[^"]*"/')
        ->toContain('bg-rose-950/50')
        ->not->toContain('zinc');

    expect(Blade::render('<x-fltc::modal name="m">x</x-fltc::modal>'))->toContain('border-slate-200')->toContain('bg-slate-950/50');
});

it('passes the confirm modal theme to its panel, title and description', function () {
    $html = Blade::render('<x-fltc::modal.confirm name="c" title="Sure?" description="Really." theme="rose">x</x-fltc::modal.confirm>');

    expect($html)
        ->toContain('border-rose-200')
        ->toMatch('/<h2[^>]*text-rose-900/')
        ->toMatch('/<p[^>]*fltc-subheading[^"]*text-rose-500/')
        ->not->toContain('zinc');
});

it('keeps the neutral heading colour when no theme is given', function () {
    expect(Blade::render('<x-fltc::heading>x</x-fltc::heading>'))->toContain('text-zinc-900')->not->toContain('fltc-theme-');
});

it('renders a select without a built-in placeholder option', function () {
    shareErrors();
    $html = Blade::render('<x-fltc::form.input.select id="s"><option value="a">A</option></x-fltc::form.input.select>');

    expect(substr_count($html, '<option'))->toBe(1)->and($html)->not->toContain('Bitte');
    expect(Blade::render('<x-fltc::form.input.select id="s" placeholder="Choose…"><option value="a">A</option></x-fltc::form.input.select>'))
        ->toContain('<option value="" disabled selected>Choose…</option>');
});

it('themes pagination with one theme and marks the current page as the solid button', function () {
    $html = Blade::render('<x-fltc::nav.pagination :paginator="$p" theme="rose" />', ['p' => fakePaginator(3)]);

    expect($html)
        ->toContain('fltc-theme-rose')
        ->not->toContain('-sky-')
        ->toMatch('/fltc-button-solid[^"]*"[^>]*aria-current="page"/s')
        ->and(substr_count($html, 'fltc-button-solid'))->toBe(1);

    // The old names still work.
    expect(Blade::render('<x-fltc::nav.pagination :currentPage="2" :totalPages="3" :start="1" :end="3" mainTheme="amber" accentTheme="sky" />'))
        ->toContain('fltc-theme-amber')->toContain('bg-sky-');
});
