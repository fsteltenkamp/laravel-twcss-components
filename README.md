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
<x-fltc::button color="primary">
    Save
</x-fltc::button>

<x-fltc::button color="danger" variant="outline" type="submit">
    Delete
</x-fltc::button>
```

### Component Catalog:
[Component Catalog (WIKI)](wiki/components.md)

## Colours, themes and skins

Three independent settings decide how a component looks:

| | What it is | Set with |
| --- | --- | --- |
| **Colour** | which colour a component uses: a **role** of the theme (`primary`, `secondary`, `accent`, `base`, `info`, `success`, `warning`, `danger`) or a fixed Tailwind palette (`green`, `rose`, …) | the component's `color` prop (default `base`) |
| **Theme** | the colour scheme: which palette each role uses | `data-theme` on `<html>` or a region |
| **Skin** | the look: fonts, corners, lines, glow, page effects | `data-skin` on `<html>` or a region |

```blade
<html data-theme="dracula" data-skin="cyberpunk">
    ...
    <x-fltc::button color="primary">Save</x-fltc::button>       {{-- Dracula purple, cyberpunk shape --}}
    <x-fltc::button color="danger">Delete</x-fltc::button>      {{-- Dracula red --}}
    <x-fltc::badge color="green">paid</x-fltc::badge>           {{-- always Tailwind green --}}
```

Roles follow the theme, so switching `data-theme` re-colours the page in the browser
without re-rendering; fixed palettes stay put. Use roles for anything that should follow
the theme and palettes for colours with a fixed meaning.

### Setup

Load the theme variables and register the role colours with Tailwind. **Tailwind v4**:

```css
@import '../../vendor/fsteltenkamp/laravel-twcss-components/resources/css/colors.css';
@import '../../vendor/fsteltenkamp/laravel-twcss-components/resources/css/themes.css';
/* optional: the skins */
@import '../../vendor/fsteltenkamp/laravel-twcss-components/resources/css/skin-effects.css';
```

**Tailwind v3**: merge the roles into `tailwind.config.js` and import `themes.css` (and
optionally `skin-effects.css`) in your CSS:

```js
const fltcColors = require('./vendor/fsteltenkamp/laravel-twcss-components/resources/js/colors.js');

module.exports = {
    theme: { extend: { colors: fltcColors } },
};
```

The extended neutrals `taupe`, `mauve`, `mist` and `olive` are not in Tailwind; define
them in your Tailwind config to use them as fixed colours (`themes.css` has their values for
the custom theme and the skins). The theme values are Tailwind v3.4's palette; v4's
palette differs from it very slightly.

### Roles

| Role | Used for | Default theme |
| --- | --- | --- |
| `primary` | main actions, highlights | blue |
| `secondary` | supporting actions | violet |
| `accent` | decoration, the skins' gradients | teal |
| `base` | surfaces and text: the default colour of every component | slate |
| `info` / `success` / `warning` / `danger` | status: alerts, toasts, validation, the save status | sky / green / amber / red |

Status components default to their role: `x-fltc::status` uses `success`, `warning`,
`info` and `danger`, the error message box `danger`, a meter's thresholds `warning` and
`danger`, and toasts dispatched with a Flux-style `variant` the matching role.

### Themes

| Theme | |
| --- | --- |
| `default` | Tailwind palettes (see Roles); the theme without any `data-theme` |
| `cyberpunk` | neon pink, cyan and violet on ink |
| `fantasy` | gold, forest and royal purple on parchment and leather |
| `wh40k` | blood red, brass and ultramarine on bone and gunmetal |
| `dracula` | Dracula in dark mode, its light variant Alucard in light mode |
| `nord` | Nord's polar night, snow storm, frost and aurora |
| `catppuccin` | Catppuccin Latte in light mode, Mocha in dark mode |
| `solarized` | Solarized light and dark |
| `gruvbox` | Gruvbox light (faded accents) and dark (bright accents) |
| `custom` | a Tailwind palette per role, chosen with `data-theme-<role>` |

```html
<html data-theme="custom" data-theme-primary="rose" data-theme-base="zinc">
```

Roles a custom theme leaves out keep the default theme's palette. Themes live in
`resources/css/themes.css`, generated by `tools/themes.py`: each role is an 11-shade scale
built from a few anchor colours (the light-mode accent on shade 600, the dark-mode one on
400). Add or change a theme there and run `python3 tools/themes.py`.

### Shades

Within a colour, each surface and piece of text uses one of a small, fixed set of shades.
Sticking to them is what makes a component flip cleanly between light and dark mode — text
and backgrounds are always defined as a *pair*, so nothing stays locked to the wrong colour
after a mode switch. For a colour `c`:

| Shade role | Light | Dark | Used for |
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

The themes' `base` scales follow the same pairs, which is why some (cyberpunk, fantasy,
wh40k) change hue along the ladder: page and surface shades are the look's backgrounds,
the content shades its text colours.

### Skins

A skin is the look, independent of colour and theme: `default` (plain Tailwind),
`cyberpunk`, `fantasy` and `wh40k`. Choose it with `data-skin` on `<html>` (or on a
region); every component inside takes the skin **in its own colour**: a `primary` button
under the cyberpunk skin is drawn in the theme's primary neon lines, a `green` one in green.

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

A skin draws each component with three colours taken from its `color`: an accent (lines,
fills, glow, shade 600 / 400 in dark mode), a text colour (700 / 300) and a third colour
for gradients (500; for `base` the theme's `accent`). Children inherit their parent's
colour. The look pairs naturally with the theme of the same name, but any skin works with
any theme.

Native popups stay native: the select's list is fully styled only in browsers with
customizable selects (Chromium 135+), elsewhere it takes the option colours where the OS
allows; the date picker's calendar only follows light/dark (`color-scheme`), which all
inputs set in dark mode. `<x-fltc::heading glitch>` adds cyberpunk's glitching logo text.
Text glow shows in dark mode only.

Vite bundles the fonts the skins reference. Without a bundler, publish the stylesheets and
fonts with `php artisan vendor:publish --tag=fltc-assets` and link the files under
`/vendor/fltc/css/`.

Page effects (body font, background, scanlines) apply to the `<body>` inside a skinned
`<html>`, or to a `<body data-skin="…">`. Skin regions can sit on a default page; nesting a
different skin inside a skinned region is not supported (the outer skin's rules still
reach in).

The skins target the neutral hook classes every component carries (`fltc-<tag>`,
`fltc-color-<color>`, see the [wiki](wiki/components.md#hook-classes)), so a host can write
its own skin the same way. The rules are not in a cascade layer: while a skin is active
they win over Tailwind utilities, including a host's own `rounded-*` or `shadow-*` on a
component.

### Picking skin and theme

Let visitors choose with `<x-fltc::theme.picker>` — a Skin select, a Theme select (with
one palette select per role when they pick Custom) and light/dark/system, each saved in
`localStorage` — and put `<x-fltc::theme.script />` in `<head>` so the saved choices apply
before the first paint:

```blade
<head>
    <x-fltc::theme.script skin="default" theme="default" />
    @vite('resources/css/app.css')
</head>
...
<x-fltc::theme.picker :skins="['default', 'cyberpunk']" :themes="['default', 'dracula', 'nord', 'custom']" />
```

Pass an empty list to hide a select (`:skins="[]"` for a theme-only picker).

### Migrating

Earlier versions had one `theme` prop for colour, scheme and look. Now:

| Before | Now |
| --- | --- |
| `theme="rose"` (any component) | `color="rose"` |
| default `theme="slate"` | default `color="base"` (slate in the default theme) |
| `theme="skin"` + `data-skin="rose"` | `color="base"` (or another role) + `data-theme="custom" data-theme-base="rose"`, or a named theme |
| `data-skin="cyberpunk"` (colour + look) | `data-skin="cyberpunk" data-theme="cyberpunk"` |
| `theme="cyberpunk"` / `fantasy` / `wh40k` | `data-theme="cyberpunk"` on a region, with roles on the components |
| `themeOff`, `cancelTheme`, `warningTheme`, `dangerTheme`, `accentTheme`, `mainTheme`, status `themes` | `colorOff`, `cancelColor`, `warningColor`, `dangerColor`, `accentColor`, `mainColor`, `colors` |
| `bg-skin-500` etc. (host classes) | `bg-base-500`, `bg-primary-500`, … |
| `resources/css/themes.css` + `resources/js/themes.js` (custom palettes) | `resources/css/colors.css` / `resources/js/colors.js` (roles) |
| `resources/css/skins.css` | `resources/css/themes.css` |
| hook class `fltc-theme-<theme>` | `fltc-color-<color>` |
| `<x-fltc::text color="#f00">` (raw CSS colour) | `<x-fltc::text fc="#f00">` |
| toast payload `theme: 'green'` | `color: 'success'` (or `'green'`) |
| `theme.picker :themes storageKey` / `theme.script storageKey skin` | `theme.picker :skins :themes skinStorageKey themeStorageKey` / `theme.script skinStorageKey themeStorageKey skin theme` |

The picker keeps the skin under `fltc-skin` and stores the theme under `fltc-theme`, so a
visitor's saved choice from before (a colour like `rose` under `fltc-skin`) is read as a
skin: an unknown skin shows the default look until they pick again.

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
