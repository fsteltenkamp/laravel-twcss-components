<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;

/**
 * Generates the static example pages under examples/dist/ and an index that
 * links to them. Running the suite (./test.sh) therefore (re)produces a
 * browsable set of full-page demos built entirely from <x-fltc::…> components.
 *
 * The same $groups manifest drives both the rendered pages and the index, so
 * they can never drift apart.
 */

/**
 * The example pages, grouped for the index. `view` is the source template under
 * examples/views/; `slug` is the output filename (slug.html).
 *
 * @return array<int, array{title: string, items: array<int, array<string, string>>}>
 */
function exampleGroups(): array
{
    return [
        [
            'title' => 'App — top navbar layout',
            'items' => [
                ['slug' => 'app-navbar-profile', 'view' => 'examples::pages.app.navbar.profile', 'label' => 'Profile', 'desc' => 'Account page under a sticky top navbar.', 'icon' => 'ph ph-identification-card'],
                ['slug' => 'app-navbar-list', 'view' => 'examples::pages.app.navbar.list', 'label' => 'Customers list', 'desc' => 'Data table with toolbar and pagination.', 'icon' => 'ph ph-table'],
            ],
        ],
        [
            'title' => 'App — sidebar layout',
            'items' => [
                ['slug' => 'app-sidebar-profile', 'view' => 'examples::pages.app.sidebar.profile', 'label' => 'Profile', 'desc' => 'Account page with a collapsible sidebar.', 'icon' => 'ph ph-identification-card'],
                ['slug' => 'app-sidebar-list', 'view' => 'examples::pages.app.sidebar.list', 'label' => 'Customers list', 'desc' => 'Data table beside a fixed sidebar.', 'icon' => 'ph ph-table'],
            ],
        ],
        [
            'title' => 'Authentication',
            'items' => [
                ['slug' => 'login-simple', 'view' => 'examples::pages.auth.login-simple', 'label' => 'Login — Simple', 'desc' => 'Centered card with social buttons.', 'icon' => 'ph ph-sign-in'],
                ['slug' => 'login-split', 'view' => 'examples::pages.auth.login-split', 'label' => 'Login — Split', 'desc' => 'Form beside a marketing panel.', 'icon' => 'ph ph-columns'],
                ['slug' => 'register', 'view' => 'examples::pages.auth.register', 'label' => 'Register', 'desc' => 'Simple centered sign-up form.', 'icon' => 'ph ph-user-plus'],
            ],
        ],
    ];
}

beforeEach(function () {
    $examples = realpath(__DIR__.'/../examples/views');

    // `view('examples::…')` resolves page templates; `<x-ex::…>` resolves the
    // example-only layout/shell/content components.
    View::addNamespace('examples', $examples);
    Blade::anonymousComponentPath($examples.'/components', 'ex');

    // Form inputs read the shared $errors bag that Laravel's session middleware
    // normally provides on a web request; supply an empty one for rendering.
    View::share('errors', new Illuminate\Support\ViewErrorBag);
});

it('generates the example pages and a linking index', function () {
    $dist = __DIR__.'/../examples/dist';

    if (! is_dir($dist)) {
        mkdir($dist, 0777, true);
    }

    $groups = exampleGroups();

    foreach ($groups as $group) {
        foreach ($group['items'] as $item) {
            $html = view($item['view'])->render();

            expect($html)
                ->toContain('<!DOCTYPE html>')
                ->toContain('cdn.tailwindcss.com');

            file_put_contents($dist.'/'.$item['slug'].'.html', $html);

            expect(file_exists($dist.'/'.$item['slug'].'.html'))->toBeTrue();
        }
    }

    $index = view('examples::index', ['groups' => $groups])->render();

    foreach ($groups as $group) {
        foreach ($group['items'] as $item) {
            expect($index)->toContain($item['slug'].'.html');
        }
    }

    file_put_contents($dist.'/index.html', $index);

    expect(file_exists($dist.'/index.html'))->toBeTrue();
});
