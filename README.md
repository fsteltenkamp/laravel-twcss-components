# Laravel TWCSS Components

A collection of TailwindCSS components for Laravel's Blade component library.

## Installation

```bash
composer require fsteltenkamp/laravel-twcss-components
```

The service provider is auto-discovered via Laravel's package discovery.

### Tailwind CSS setup

Component classes live in this package's Blade views and PHP classes, not in the host
app's own `resources/views`. Tailwind only generates CSS for classes it can see in files
it's told to scan, so the host app's Tailwind config must include this package's source
files or component styling will be silently missing from the compiled CSS.

**Tailwind v4** (CSS-based config) — add to the app's main CSS file:

```css
@source '../../vendor/fsteltenkamp/laravel-twcss-components/resources/views/components/';
@source '../../vendor/fsteltenkamp/laravel-twcss-components/src/View/Components/';
@source '../../vendor/fsteltenkamp/laravel-twcss-components/src/Support/';
```

(Paths are relative to the CSS file; adjust for your app's directory layout.) All three
paths are needed — the Blade views hold most of the class strings, class-backed
components (e.g. `Button.php`, `TableBase.php`) build parts of their `classList` in PHP,
and `src/Support/` (`Shades.php`, `SidebarTheme.php`, `DrawerTheme.php`) holds the
shared role colours several components pull in.

**Tailwind v3** (`tailwind.config.js`) — add the same paths to `content`:

```js
content: [
    // ...
    './vendor/fsteltenkamp/laravel-twcss-components/resources/views/components/**/*.blade.php',
    './vendor/fsteltenkamp/laravel-twcss-components/src/View/Components/**/*.php',
    './vendor/fsteltenkamp/laravel-twcss-components/src/Support/**/*.php',
],
```

If you publish views with `vendor:publish --tag=fltc-components-views`, published files
land in `resources/views/vendor/fltc`, which your app's default content globs already
cover.

## Usage

Components are registered under the `fltc` namespace:

```blade
<x-fltc::button variant="primary">
    Save
</x-fltc::button>

<x-fltc::button variant="danger" type="submit">
    Delete
</x-fltc::button>
```

### Component Catalog:
[Component Catalog (WIKI)](wiki/components.md)

## Color shades

Every component is themed by passing a `theme` (any Tailwind palette, e.g. `slate`,
`blue`, `rose`, plus the extended neutrals `taupe`, `mauve`, `mist`, `olive` and the
[custom themes](#custom-themes) `cyberpunk`, `fantasy`, `wh40k`, and `palette` for
[runtime switching](#runtime-colour-switching)). The colour is separate from the
[skin](#skins), which is the look (fonts, corners, lines, glow). Within a
theme, each surface and piece of text is assigned one of a small, fixed set of **roles**.
Sticking to these roles is what makes a component flip cleanly between light and dark mode
— text and backgrounds are always defined as a *pair*, so nothing stays locked to the
wrong colour after a theme switch.

For a theme colour `c`:

| Role | Light | Dark | Used for |
| --- | --- | --- | --- |
| **Background** — page | `c-50` | `c-950` | The page/body itself (`<x-fltc::body>`) |
| **Background** — surface | `c-100` | `c-900` | Panels that sit *on* the page: tables, boxes, cards. One step darker than the page so they read as a distinct surface |
| **Primary Content** | `c-900` | `c-100` | Headings and body copy — the highest-contrast text |
| **Secondary Content** | `c-700` | `c-300` | Supporting text, table cells, sub-labels |
| **Tertiary Content** | `c-500` | `c-400` | Muted text, placeholders, icons, faint borders |

Notes:

- **Backgrounds always carry a paired Content colour.** A surface that sets a background
  must also set (or inherit) a Content text colour for the same mode, or its text will not
  follow a dark-mode switch. Child text inherits the nearest ancestor's Content colour, so
  setting Primary Content once on a container covers everything inside it.
- **Tables are intentionally one step darker than the page** (surface `c-100`/`c-900` vs.
  page `c-50`/`c-950`) to give rows visual context. In dark mode `c-950` is the floor, so
  the table surface reads as a *raised* panel rather than a darker one.
- **Nesting stays shallow** — at most a surface on a page; there is no fourth background
  level to reason about.

### Custom themes

Three custom themes ship with the package: `cyberpunk` (neon pink on ink, cyan
text), `fantasy` (gold and parchment) and `wh40k` (gunmetal, bone and blood). Use them
like any other theme: `<x-fltc::button theme="fantasy">`.

They are not in Tailwind, so the host app has to define them. **Tailwind v4**: import the
shipped palette after Tailwind:

```css
@import '../../vendor/fsteltenkamp/laravel-twcss-components/resources/css/themes.css';
```

**Tailwind v3**: merge the palette into `tailwind.config.js`:

```js
const fltcThemes = require('./vendor/fsteltenkamp/laravel-twcss-components/resources/js/themes.js');

module.exports = {
    theme: { extend: { colors: fltcThemes } },
};
```

Unlike the Tailwind palettes these scales change hue along the ladder, so each shade
role picks up the matching part of the original look — the page and surface shades are
the skin's backgrounds, the content shades its text colours, and `400`–`600` its accent:

| Shades | cyberpunk | fantasy | wh40k |
| --- | --- | --- | --- |
| `50` / `950` page | lavender / ink | parchment / dark leather | vellum / gunmetal |
| `100` / `900` surface & primary text | pale cyan / deep violet | parchment / brown | bone / iron |
| `300` / `700` secondary text | neon cyan / teal | parchment / sepia | bone / dark iron |
| `400`–`600` accent | neon pink | burnished gold | blood red |

The palettes are only colours: the matching looks (fonts, cut corners, glow) are the
[skins](#skins), and work with any colour.

### Runtime colour switching

`theme="palette"` renders a component in whichever colour the nearest `data-palette`
attribute selects, so the page can change colour in the browser without re-rendering:

```blade
<html data-palette="fantasy">
    ...
    <x-fltc::button theme="palette">Read</x-fltc::button>
```

Change it with `document.documentElement.dataset.palette = 'rose'`. It also works on a
region (`<div data-palette="rose">`), and without any `data-palette` the colour is `slate`.
Every theme above can be a palette.

Load `resources/css/palettes.css` (plain CSS, one block of colour variables per theme) and
define the `palette` colour: on **Tailwind v4** it is in `themes.css`, so import both
files; on **Tailwind v3** it is in `themes.js` (see Custom themes above), plus the
stylesheet:

```css
@import '../../vendor/fsteltenkamp/laravel-twcss-components/resources/css/themes.css';
@import '../../vendor/fsteltenkamp/laravel-twcss-components/resources/css/palettes.css';
```

The palette colours are Tailwind v3.4's palette; v4's palette differs from it very slightly.

### Skins

A skin is the look, independent of colour: `default` (plain Tailwind), `cyberpunk`,
`fantasy` and `wh40k`. Choose it with `data-skin` on `<html>` (or on a region); every
component inside takes the skin **in its own colour**:

```blade
<html data-skin="cyberpunk" data-palette="slate">
    ...
    <x-fltc::button theme="palette">Save</x-fltc::button>   {{-- slate neon lines --}}
    <x-fltc::button theme="green">Approve</x-fltc::button>  {{-- green neon lines --}}
    <x-fltc::card theme="cyberpunk">…</x-fltc::card>         {{-- the classic pink/cyan --}}
```

`resources/css/skin-effects.css` holds the skins: their fonts (Orbitron, Share Tech Mono,
VT323, Cinzel, EB Garamond, Grenze Gotisch — shipped in `resources/fonts`, SIL Open Font
License), corner rounding, glowing panels, buttons and focus rings, and page backgrounds —
including cyberpunk's scanlines and grid. Cyberpunk also restyles the controls in the style
of Cyberpunk 2077: buttons with cut corners, thin full-strength lines and a solid fill on
hover; square inputs with the bottom-right corner cut that light up on focus (add the class
`fltc-corner-tick` to an input for a filled corner tick instead), a drawn select arrow and
calendar icon; square checkboxes and toggles; tag-style badges; framed drawer handles.
Boxes, cards, tables, the checklist, stepper, dropdowns and the segmented dark-mode toggle
get the same cut corners; navbar and sidebar turn square with an accent edge.

Each colour gives the skin three roles to draw in: an accent (lines, fills, glow), a text
colour and a third colour (gradients). For the Tailwind palettes they are shades
`600`/`700`/`500` (`400`/`300`/`500` in dark mode); for `cyberpunk`, `fantasy` and `wh40k`
they are those looks' signature colours (neon pink, cyan and violet for cyberpunk).
Children inherit their parent's colour, as they inherit its theme. A theme alone never
switches a look on: `theme="cyberpunk"` under the default skin is just pink and cyan
Tailwind colours.

Native popups stay native: the select's list is fully styled only in browsers with
customizable selects (Chromium 135+), elsewhere it takes the option colours where the OS
allows; the date picker's calendar only follows light/dark (`color-scheme`), which all
inputs set in dark mode. `<x-fltc::heading glitch>` adds cyberpunk's glitching logo text.
Text glow shows in dark mode only.

It is opt-in and plain CSS, so it works with Tailwind v3 and v4. Import it after Tailwind:

```css
@import '../../vendor/fsteltenkamp/laravel-twcss-components/resources/css/skin-effects.css';
```

Vite bundles the fonts it references. Without a bundler, publish the stylesheets and fonts
with `php artisan vendor:publish --tag=fltc-assets` and link
`/vendor/fltc/css/skin-effects.css`.

Page effects (body font, background, scanlines) apply to the `<body>` inside a skinned
`<html>`, or to a `<body data-skin="…">`. Skin regions can sit on a default page; nesting a
different skin inside a skinned region is not supported (the outer skin's rules still
reach in).

The skins target the neutral hook classes every component carries (`fltc-<tag>`,
`fltc-theme-<theme>`, see the [wiki](wiki/components.md#hook-classes)), so a host can write
its own skin the same way. The rules are not in a cascade layer: while a skin is active
they win over Tailwind utilities, including a host's own `rounded-*` or `shadow-*` on a
component.

### Picking skin and colour

Let visitors choose with `<x-fltc::theme.picker>` (a Skin select, a Colour select and
light/dark/system, each saved in `localStorage`), and put `<x-fltc::theme.script />` in
`<head>` so the saved choices apply before the first paint:

```blade
<head>
    <x-fltc::theme.script skin="default" palette="slate" />
    @vite('resources/css/app.css')
</head>
...
<x-fltc::theme.picker :skins="['default', 'cyberpunk', 'fantasy', 'wh40k']" :palettes="['slate', 'rose', 'cyberpunk']" theme="palette" />
```

Pass an empty list to hide a select (`:palettes="[]"` for a skin-only picker).

### Migrating from `theme="skin"`

Earlier versions mixed look and colour in one setting. Now:

| Before | Now |
| --- | --- |
| `theme="skin"` | `theme="palette"` |
| `bg-skin-500` etc. (host classes) | `bg-palette-500` |
| `resources/css/skins.css` | `resources/css/palettes.css` |
| `data-skin="rose"` (colour) | `data-palette="rose"` |
| `data-skin="cyberpunk"` (colour + look) | `data-skin="cyberpunk" data-palette="cyberpunk"` |
| `data-skin-shape="all"` | not needed: every component takes the skin |
| `theme="cyberpunk"` switched the look on | it is only the colour; add `data-skin="cyberpunk"` |
| `theme.picker :themes storageKey` | `theme.picker :skins :palettes skinStorageKey paletteStorageKey` |
| `theme.script storageKey skin` | `theme.script skinStorageKey paletteStorageKey skin palette` |
| `--fltc-skin-<shade>` variables | `--fltc-palette-<shade>` |

The picker now stores the colour under `fltc-palette`, so a visitor's saved choice from
before (`fltc-skin`) is read as a skin: an old value like `rose` is simply an unknown skin
and shows the default look.

## Icons

Components that render icons use the [Phosphor Icons](https://phosphoricons.com) web font
(`<i class="ph ph-...">`). The host application must load the font CSS. Install it with
[Bun](https://bun.sh):

```bash
bun add @phosphor-icons/web
```

Then import the weight(s) you use in your app's CSS/JS bundle:

```js
import "@phosphor-icons/web/regular";
```

Alternatively, include it from a CDN in your layout `<head>`:

```html
<link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2/src/regular/style.css">
```

## Publishing

Publish views to override them:

```bash
php artisan vendor:publish --tag=fltc-components-views
```

## License

AGPL-3.0-only
