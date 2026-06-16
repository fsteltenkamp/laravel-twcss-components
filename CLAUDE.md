# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A Laravel package (`fsteltenkamp/laravel-twcss-components`) that ships a library of
TailwindCSS-styled Blade components. It has no application shell — there is nothing to
"run"; the package is consumed by host Laravel apps and exercised here only through tests
backed by `orchestra/testbench`.

## Commands

**PHP and Composer are not installed on the host** — everything runs in a
container via the wrapper scripts. Always verify progress with `./test.sh`.

```bash
./test.sh                                   # install deps + run the full Pest suite (use this to check progress)
./test.sh tests/BladeRenderTest.php         # one test file
./test.sh --filter="renders the button"     # one test by name (args forward to pest)

./php.sh php --version                       # run php in the container
./php.sh composer install                    # composer ships in the image
```

There is no linter or build step configured.

## Architecture

### General Properties

All components support:
- **theme**: See supported themes below
- **$attributes**: Every component view must render `$attributes` on its root element so passthrough attributes like `wire:*`, `id`, and `class` always work
- **classList**: Classes must be provided to the view in the "classList" variable and merged with `$attributes->class(...)`. Build `classList` in the component class by combining default classes and theme classes

For components with multiple class properties, name them according to placement (e.g., `headerClasses`, `bodyClasses`).

### Rules

1. **Prefer existing components** before adding new raw markup
2. **Look for reusable components first** when patterns repeat (forms, cards, tables, actions)
3. **Update the wiki files** when creating new components or changing public component APIs
4. **Document immediately** when changing props, slots, or usage conventions
5. **Support all themes** - any theme property must support all themes listed above
6. **Inherit parent themes** - child components should inherit parent theme by default when no explicit child theme provided
7. **Implement general properties** - all components must implement requirements listed in General Properties section
8. **Document new sections** - when a card gains new section component, document the section and its intended use
9. **Inspect before editing** - when in doubt, inspect component classes and Blade templates before editing a view

### When To Add A New Component

Add a component when:
- Pattern appears in multiple views
- Chunk of Blade is hard to scan
- JavaScript is generating markup that should match existing component style

Avoid over-componentizing one-off markup.


Everything is wired in `src/TwcssComponentsServiceProvider.php`, which registers the
`fltc` handle three ways, so components are always used as `<x-fltc::...>`:

- `Blade::componentNamespace(...)` — maps `<x-fltc::button>` to the **class-backed**
  component `src/View/Components/Button.php`.
- `Blade::anonymousComponentPath(...)` — lets a Blade file under
  `resources/views/components/` exist as an **anonymous** component with no PHP class.
- `loadViewsFrom(...)` registers the `fltc::` view namespace, so a class's
  `render()` returns `view('fltc::components.button')`.

A component is therefore one of two shapes:

1. **Class-backed**: a PHP class in `src/View/Components/<Path>.php` whose `render()`
   resolves a Blade template in `resources/views/components/<path>.blade.php`. Directory
   nesting maps to the tag: `src/View/Components/Nav/Link.php` → `<x-fltc::nav.link>`.
2. **Anonymous**: a Blade-only file in `resources/views/components/` with no PHP class.
   (The class and view file counts differ because not every component has a class.)

The class's job is to compute Tailwind class strings from props; the Blade file just
renders them. Keep logic in the PHP class, markup in the Blade file.

### Component conventions (enforced by `wiki/components.md`)

- Build the final Tailwind string in the constructor into a public property named
  `classList` (or, when a component has several styled regions, `headerClasses`,
  `bodyClasses`, etc. named by placement).
- In the Blade template, render that property through the attribute bag so host
  passthrough attributes (`class`, `id`, `wire:*`) merge correctly:
  `{{ $attributes->class([$classList])->merge([...]) }}`. Always render `$attributes`
  on the root element.
- Props use sensible defaults and fall back gracefully on unknown values — see
  `Button.php`: `$themeMap[$theme] ?? $themeMap['gray']`.

### Theming

All components accept a `theme` prop spanning the full Tailwind palette plus extended
neutrals (`taupe`, `mauve`, `mist`, `olive` — these require the host app's Tailwind
config to define them). Table components share one large theme map via the abstract
`src/View/Components/TableBase.php`; extend it rather than duplicating color tables.

### Tests

Pest, bootstrapped through `tests/TestCase.php` (extends Testbench and loads the service
provider). Beyond per-component render smoke tests (`BladeRenderTest.php`), two suites are
**structural guards** that iterate over the filesystem — they will fail if you add or move
files inconsistently:

- `ComponentClassesTest.php` — every `*.php` under `src/View/Components/` must autoload to
  a class whose namespace matches its path (catches namespace drift after a move/rename).
- `ComponentViewsTest.php` — every `view('fltc::...')` reference in a component class must
  resolve to an existing template and carry the `fltc::` prefix.

When adding a class-backed component, place the class and the matching Blade file at
mirrored paths and use the `fltc::components.*` view name, or these tests break.

## Publishing

Host apps override templates with
`php artisan vendor:publish --tag=fltc-components-views`.
</content>
</invoke>
