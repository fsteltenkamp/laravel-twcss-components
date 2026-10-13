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

**Browser testing:** there is no browser in the dev environment, so JavaScript/interactive
behaviour (Alpine state, transitions, layout) cannot be verified directly. When something
needs checking in a browser, add/update its demo in `tests/GalleryTest.php`, run `./test.sh`
(which regenerates `gallery.html`), and ask the user to inspect `gallery.html` and report
back — say exactly what to click and what to look for. Gallery demos use role colours
(`color="primary"`, `color="base"`) so the Theme select in the gallery's Style drawer
re-colours every component at once (the Skin select changes the look); don't add
per-theme showcases.

## Architecture

### General Properties

All components support:
- **color**: See Theming below
- **$attributes**: Every component view must render `$attributes` on its root element so passthrough attributes like `wire:*`, `id`, and `class` always work
- **classList**: Classes must be provided to the view in the "classList" variable and merged with `$attributes->class(...)`. Build `classList` in the component class by combining default classes and colour classes

For components with multiple class properties, name them according to placement (e.g., `headerClasses`, `bodyClasses`).

**Hook classes**: every class-backed component extends
`Fsteltenkamp\TwcssComponents\View\Component` (not `Illuminate\View\Component`), which adds
`fltc-<tag>` and `fltc-color-<color>` to the attribute bag. Anonymous components add their
`fltc-<tag>` hook in the view. Skin stylesheets (`resources/css/skin-effects.css`) style
those hooks — never put skin-specific classes into a component's class strings.
`tests/HookClassesTest.php` enforces the hooks, and that every component's hook appears in
`skin-effects.css` (or in its `UNSKINNED_COMPONENTS` allowlist): a new component needs its
hook added to the shared `:is(...)` lists there (shape, panels, controls) and, for
cyberpunk, rules of its own where its markup differs (cut corners, neon lines).

### Rules

1. **Prefer existing components** before adding new raw markup
2. **Look for reusable components first** when patterns repeat (forms, cards, tables, actions)
3. **Update the wiki files** when creating new components or changing public component APIs
4. **Document immediately** when changing props, slots, or usage conventions
5. **Support all colours** - any colour property must support every role and palette listed below
6. **Inherit parent colours** - child components should inherit the parent's colour by default when no explicit child colour is provided
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
  `Button.php`: `$themeMap[$color] ?? $themeMap['base']`.

### Theming

Three separate settings (README "Colours, themes and skins"):

- **Colour** — every component's `color` prop: one of the eight theme roles (`primary`,
  `secondary`, `accent`, `base`, `info`, `success`, `warning`, `danger`; Tailwind colours
  `bg-primary-500` etc. backed by CSS variables) or a fixed Tailwind palette (the full
  palette plus `taupe`, `mauve`, `mist`, `olive`, which the host's Tailwind config must
  define). Every colour map needs an entry for all of them — build role entries from the
  same class strings as the palettes — enforced by `tests/CustomThemesTest.php`.
- **Theme** — `data-theme` (default, cyberpunk, fantasy, wh40k, dracula, nord, catppuccin,
  solarized, gruvbox, custom): which palette each role uses. `resources/css/themes.css`,
  `colors.css` and `resources/js/colors.js` are **generated** by `tools/themes.py`; edit the
  themes there and rerun `python3 tools/themes.py`, never the generated files.
- **Skin** — `data-skin` (default, cyberpunk, fantasy, wh40k): the look, from
  `resources/css/skin-effects.css`, applied to every component inside a skin region in that
  component's own colour.

Shade roles outside a component's own maps come from `src/Support/Shades.php`. Table
components share one large colour map via the abstract
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
Exception: the typed inputs (`Form/Input/Number`, `Date`, `Time`, `Datetime`, `Email`,
`Password`) only override `$defaultType` on `Form/Input/Text` and share its
`form/input/text.blade.php` view — add new input types the same way.

Default colour is `base` everywhere (constructor defaults and `?? $map['base']`
fallbacks); child components that inherit a parent colour default to `null`.
`CustomThemesTest.php` enforces both.

## Publishing

Host apps override templates with
`php artisan vendor:publish --tag=fltc-components-views`.
</content>
</invoke>
