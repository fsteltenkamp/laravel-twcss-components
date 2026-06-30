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
