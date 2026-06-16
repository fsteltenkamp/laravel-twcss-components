# Examples

Full-page demos built entirely from this package's `<x-fltc::…>` components.
They show how the pieces compose into real screens — app shells, auth screens
and data pages.

## How it works

The pages live as Blade templates under `views/`. The test suite renders them to
static HTML so you can open them in a browser with no Laravel app or build step:

```bash
./test.sh                              # renders everything (plus runs the suite)
./test.sh tests/ExamplesTest.php       # just (re)generate the examples
```

Output lands in `examples/dist/` (git-ignored). Open the generated index:

```
examples/dist/index.html
```

Styling is provided by the **Tailwind Play CDN** loaded in each page's `<head>`
(see `views/components/layout.blade.php`). That's a prototyping convenience — it
also defines the package's extended neutral palettes (`taupe`, `mauve`, `mist`,
`olive`). A real host app would compile its own Tailwind CSS instead. Icons use
the Phosphor web font from a CDN. Dark mode persists via `localStorage` and the
toggle in the corner of every page.

## What's here

| Page | Source |
| --- | --- |
| App / navbar layout — Profile | `views/pages/app/navbar/profile.blade.php` |
| App / navbar layout — Customers list | `views/pages/app/navbar/list.blade.php` |
| App / sidebar layout — Profile | `views/pages/app/sidebar/profile.blade.php` |
| App / sidebar layout — Customers list | `views/pages/app/sidebar/list.blade.php` |
| Login — Simple (centered) | `views/pages/auth/login-simple.blade.php` |
| Login — Split | `views/pages/auth/login-split.blade.php` |
| Register | `views/pages/auth/register.blade.php` |

### Example-only building blocks (`<x-ex::…>`)

These compose the library components into page chrome; they are not part of the
published package:

- `layout` — the full HTML document (CDN setup, dark-mode boot).
- `shell/navbar`, `shell/sidebar` — the two app shells.
- `content/profile`, `content/list` — page bodies shared by both shells.
- `page-header` — breadcrumbs + title + actions.

Add a page by dropping a template under `views/pages/` and registering it in the
`exampleGroups()` manifest in `tests/ExamplesTest.php`.
