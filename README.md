# Laravel TWCSS Components

A collection of TailwindCSS components for Laravel's Blade component library.

## Installation

```bash
composer require fsteltenkamp/laravel-twcss-components
```

The service provider is auto-discovered via Laravel's package discovery.

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
`blue`, `rose`, plus the extended neutrals `taupe`, `mauve`, `mist`, `olive`). Within a
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
php artisan vendor:publish --tag=twcss-components-views
```

## License

AGPL-3.0-only
