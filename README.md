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
```

(Paths are relative to the CSS file; adjust for your app's directory layout.) Both paths
are needed — the Blade views hold most of the class strings, while class-backed
components (e.g. `Button.php`, `TableBase.php`) build parts of their `classList` in PHP.

**Tailwind v3** (`tailwind.config.js`) — add the same paths to `content`:

```js
content: [
    // ...
    './vendor/fsteltenkamp/laravel-twcss-components/resources/views/components/**/*.blade.php',
    './vendor/fsteltenkamp/laravel-twcss-components/src/View/Components/**/*.php',
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
[custom themes](#custom-themes) `cyberpunk`, `fantasy`, `wh40k`, and `skin` for
[runtime switching](#runtime-theme-switching)). Within a
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

Three themes replicate the skins of the readar app: `cyberpunk` (neon pink on ink, cyan
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
role picks up the matching part of the original skin — the page and surface shades are
the skin's backgrounds, the content shades its text colours, and `400`–`600` its accent:

| Shades | cyberpunk | fantasy | wh40k |
| --- | --- | --- | --- |
| `50` / `950` page | lavender / ink | parchment / dark leather | vellum / gunmetal |
| `100` / `900` surface & primary text | pale cyan / deep violet | parchment / brown | bone / iron |
| `300` / `700` secondary text | neon cyan / teal | parchment / sepia | bone / dark iron |
| `400`–`600` accent | neon pink | burnished gold | blood red |

The skins' fonts, corner rounding and glow effects are not part of the palettes.

### Runtime theme switching

`theme="skin"` renders a component in whichever theme the nearest `data-skin` attribute
selects, so the page can change theme in the browser without re-rendering:

```blade
<html data-skin="fantasy">
    ...
    <x-fltc::button theme="skin">Read</x-fltc::button>
```

Change it with `document.documentElement.dataset.skin = 'rose'`. It also works on a region
(`<div data-skin="rose">`), and without any `data-skin` the skin is `slate`. Every theme
above can be a skin.

Load `resources/css/skins.css` (plain CSS, one block of colour variables per theme) and
define the `skin` palette: on **Tailwind v4** it is in `themes.css`, so import both files;
on **Tailwind v3** it is in `themes.js` (see Custom themes above), plus the stylesheet:

```css
@import '../../vendor/fsteltenkamp/laravel-twcss-components/resources/css/themes.css';
@import '../../vendor/fsteltenkamp/laravel-twcss-components/resources/css/skins.css';
```

The skin colours are Tailwind v3.4's palette; v4's palette differs from it very slightly.
Saving the choice and applying it before the first paint is up to the host for now.

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
