## Component Catalog

### General Properties

All components support:
- **theme**: See supported themes below
- **$attributes**: Every component view must render `$attributes` on its root element so passthrough attributes like `wire:*`, `id`, and `class` always work
- **classList**: Classes must be provided to the view in the "classList" variable and merged with `$attributes->class(...)`. Build `classList` in the component class by combining default classes and theme classes

For components with multiple class properties, name them according to placement (e.g., `headerClasses`, `bodyClasses`).

### Supported Themes

All components support the full color palette:
- **Colors**: red, orange, amber, yellow, lime, green, emerald, teal, cyan, sky, blue, indigo, violet, purple, fuchsia, pink, rose
- **Neutrals**: slate, gray, zinc, neutral, stone, taupe, mauve, mist, olive

### Color Shades

Within a theme, surfaces and text are assigned fixed **roles**, each defined as a
light/dark pair so components flip cleanly in dark mode. For a theme colour `c`:

- **Background** — page `c-50`/`c-950`, surface (tables, boxes, cards) `c-100`/`c-900`
- **Primary Content** `c-900`/`c-100` — headings and body copy
- **Secondary Content** `c-700`/`c-300` — supporting text, table cells
- **Tertiary Content** `c-500`/`c-400` — muted text, placeholders, icons

Any component that sets a Background **must** set or inherit a paired Content text colour
for the same mode, otherwise its text will not follow a dark-mode switch. Tables sit one
step darker than the page (surface vs. page Background) for context. See the
[README "Color shades"](../README.md#color-shades) section for the full guide.

### Layout and Navigation

**Layouts**:
- `x-app-layout`, `x-guest-layout`, `x-formular-layout`, `x-admin-layout`, `x-profile-layout`, `x-error-layout`, `x-editor-layout`

**Breadcrumbs** (`x-fltc::nav.breadcrumbs`):
- `theme`: full palette (default: slate) — propagated to all items
- `crumbs`: array of `{href, label, icon?, isActive?}` for programmatic rendering
- `containerClass`: wrapper div class (default: `w-full px-4 sm:px-6 lg:px-8`)

**Breadcrumb Item** (`x-fltc::nav.breadcrumbs.item`):
- `theme`: full palette (default: inherited from parent)
- `href`: link target (renders as `<a>` when set and not active)
- `icon`: icon class string
- `isActive`: marks the current page item
- `showSeparator`: show preceding caret separator (default: true)

**Stepper** (`x-fltc::nav.stepper`):
- `theme`: full palette (default: slate)
- `steps`: array keyed by step number/name; each step may be string label, `[label, icon]`, or `['label' => ..., 'icon' => ...]`. The step `icon` is a Phosphor icon name (e.g. `check`), rendered internally through `x-fltc::icon`
- `stepIndex`: current active step key (default: `1`)
- `stepParam`: query-string parameter for tab links (default: `step`)
- `tabs`: renders linked step tabs with previous/next controls (default: false)
- `iconsOnly`: hides step labels in tab mode, exposes via tooltip (default: false)
- `savebtn`: renders save actions in non-tab mode for legacy form stepper (default: false)
- `onclick`: JavaScript prefix before legacy `util.stepperPreviousStep/NextStep` calls
- `class`: extra wrapper classes

**Navbar** (`x-fltc::nav.navbar`): a horizontal top/bottom bar.
- `theme`: full palette (default: slate) — shared with all navbar children (which inherit it unless given their own `theme`)
- `containerClass`: inner container width/padding (default: `w-full px-4 sm:px-6 lg:px-8`)
- `stickyTop` / `stickyBottom`: pin the bar to the top/bottom; sets the matching edge border and applies `zIndexClass`. Use `stickyBottom` to make the navbar double as a page footer (bottom-pinned, top edge border)
- `zIndexClass`: z-index when sticky (default: `z-40`)
- Slots: `logo` (optional start-aligned logo box — only rendered when provided), `left` (or the default slot) and `right` for start/end aligned content
- Children: `x-fltc::nav.navbar.link` (`href`), `x-fltc::nav.navbar.item` (static label), `x-fltc::nav.navbar.onclick` (`onclick` JS string), `x-fltc::nav.navbar.toggle` (sidebar drawer button, see below), and `x-fltc::nav.navbar.dropdown` (`trigger` slot, optional `hover`) with `dropdown.link` (`href`) and `dropdown.postlink` (`action` — POST form + CSRF) menu items. Self-initialising vanilla JS handles open/close, outside-click, Escape and optional hover.

**Navbar toggle** (`x-fltc::nav.navbar.toggle`): a hamburger button that opens the responsive sidebar drawer on small screens. Place it in the navbar's `left` slot.
- `target`: the `name` of the sidebar to control — only needed when more than one sidebar is on the page (default: the unnamed sidebar)
- `label`: accessible label (default: `Toggle navigation`)
- `theme`: full palette (default: inherited from the navbar)
- `class`: extra classes; the default slot overrides the built-in hamburger icon
- Behaviour: hidden from `lg` up (where the sidebar is a permanent column) and dispatches the `fltc-sidebar-toggle` window event the sidebar listens for. Requires Alpine.

**Sidebar** (`x-fltc::nav.sidebar`): a full-height vertical navigation column that automatically collapses into an off-canvas drawer below `lg`.
- `theme`: full palette (default: slate) — shared with all child links/groups/footer/profile, which inherit it unless they set their own `theme`
- `width`: column width class (default: `w-64`)
- `heightClass`: height class (default: `h-screen` for full viewport height; override when nesting inside a layout, e.g. `h-full`)
- `collapsible`: enable the responsive mobile drawer (default: `true`); set `false` for a sidebar that is always an in-flow column (the original behaviour, no Alpine)
- `name`: stable key so a `x-fltc::nav.navbar.toggle` with a matching `target` controls this specific sidebar (only needed with multiple sidebars)
- `class`: extra wrapper classes — apply desktop positioning with the `lg:` prefix (e.g. `lg:sticky lg:top-0`) so it doesn't fight the mobile `fixed` drawer
- Slots: `brand` (top header row, e.g. logo), default slot (nav body), `footer` (pinned to the bottom)
- Behaviour (when `collapsible`): below `lg` the sidebar is pinned off-screen and slides in over a dimmed backdrop when toggled; it closes on backdrop click, Escape, navigating a link, and when the viewport grows to `lg`. From `lg` up it is a static column, always visible regardless of the toggle state. Self-contained Alpine, no extra wiring — pair it with `x-fltc::nav.navbar.toggle`.

**Sidebar link** (`x-fltc::nav.sidebar.link`):
- `href`: link target (default `#`)
- `icon`: full icon class string (e.g. `ph ph-gauge`)
- `active`: force the active state; when omitted it is auto-derived by matching the current request URL
- `activePattern`: `Request::is()` pattern for active detection (defaults to the href path; supports wildcards like `settings/*`)
- `theme`: full palette (default: inherited from the sidebar)
- Active links render `aria-current="page"` and a `data-sidebar-active` marker (the latter is what auto-opens an enclosing group)
- `trailing` slot: right-aligned content such as a badge or counter

**Sidebar group** (`x-fltc::nav.sidebar.group`): a collapsible section of links.
- `label`: trigger label
- `icon`: full icon class string
- `open`: force the initial open state; defaults to open when `activeWhen` matches
- `activeWhen`: `Request::is()` pattern that both highlights the trigger and opens the group by default (e.g. `settings/*`)
- `id`: stable key for persisting the open state in `localStorage` (defaults to a slug of `label`)
- `theme`: full palette (default: inherited)
- Behaviour: groups **stay open once opened** (the choice is remembered in `localStorage` across page loads / `wire:navigate`) and are **forced open when the URL is on one of their sub-items** (detected via a child `data-sidebar-active` link). Self-initialising vanilla JS, no Alpine dependency.

**Sidebar footer** (`x-fltc::nav.sidebar.footer`): bottom region pinned with `mt-auto` and a top border. Drop it in the sidebar's `footer` slot. `theme` inherited; `class` for extras.

**Sidebar profile** (`x-fltc::nav.sidebar.profile`): an optional account row for the footer.
- `name`: display name; `email`: secondary line
- `avatar`: image URL (falls back to auto-derived `initials` when omitted)
- `initials`: override the derived initials
- `href`: link target used when no menu is provided
- When the default slot has content it renders a button that toggles a popover menu (opens upward, closes on outside-click/Escape); otherwise it renders a static row (or an `<a>` when `href` is set). Put `x-fltc::nav.sidebar.link`s in the slot for menu items.

### Cards

Components:
- `x-fltc::card`
- `x-fltc::card.header`
- `x-fltc::card.body`
- `x-fltc::card.rows`
- `x-fltc::card.footer`

Use cards for grouped content, filter panels, summaries, dashboard blocks, and table-heavy sections.

Card props:
- `class`: extra wrapper classes

Header, body, rows, and footer sections inherit card theme automatically. Use `rows` when card content is primarily a table or table rows. Rows is the table-shell section: provide optional head slot and direct `x-fltc::table.row` children. It forwards the table options `striped`, `hover`, `bordered`, `compact`, `responsive`, and `floating` (same meaning as on `x-fltc::table`) down to the underlying table; `floating` switches the rows to the separated rounded-pill variant.

### Counter

**Counter** (`x-fltc::counter`): a self-contained dashboard stat card. Layout, top-left to bottom-right: title (top left), icon (small, top right), counter value (left, next row), description (small/muted, left, next row).

Props:
- `theme`: full palette (default: slate) — colors the counter value and icon
- `title`: small label shown top left
- `count`: the counter value shown large/left-aligned (falls back to the default slot when empty, so a formatted/animated value can be passed as inner content)
- `description`: small muted line under the value
- `icon`: Phosphor icon class string (e.g. `ph ph-users`) shown small in the top right
- `link`: when set, the entire counter renders as an `<a>` and becomes clickable with a pointer cursor and hover elevation
- `navigate`: adds `wire:navigate` to the link (only when `link` is set; default: false)
- `class`: extra wrapper classes

Use for dashboard KPIs and at-a-glance metrics. Description text is intentionally muted and theme-independent.

### Accordion

Components:
- `x-fltc::accordion`
- `x-fltc::accordion.item`

Use for stacked expandable sections, sortable checklists, and grouped form/record details.

**Accordion** props:
- `theme`: full palette (default: slate)
- `draggable`: enables drag-and-drop sorting (default: false)
- `openFirst`: open first item on initial render when none open (default: true)
- `class`: extra wrapper classes

**Accordion Item** props:
- `theme`: full palette (default: inherited from accordion)
- `title`: primary label on left side of trigger button
- `subtext`: optional muted secondary line below title
- `draggable`: enable/disable drag handle for this item (default: inherited)
- `class`: extra item wrapper classes

### Buttons

Components:
- `x-fltc::button`
- `x-fltc::button.link`

Use for action buttons, submit actions, links styled as buttons, inline onclick actions, and Livewire actions.

Shared props:
- `width`: fit or full
- `height`: xs, sm, md, lg, xl, auto, or numeric pixel value
- `disabled`: true or false
- `variant`: solid or outline
- `tooltip`: plain text tooltip; when set, button renders inside `x-fltc::tooltip`
- `icon`: Phosphor icon name rendered via `x-fltc::icon` (e.g. `floppy-disk`). Automatically spaced from the label
- `iconVariant`: Phosphor weight for the icon (default: `solid`) — see Icon below
- `iconPosition`: `before` (default) or `after` the label

Default button text is white. Use color names for semantic meaning.

**Button Link** additional props:
- `href`: link target
- `navigate`: adds `wire:navigate` when true

### Forms

Components:
- `x-fltc::form.label`
- `x-fltc::form.input.text`
- `x-fltc::form.input.select`
- `x-fltc::form.input.password`
- `x-fltc::form.input.email`
- `x-fltc::form.textarea`
- `x-fltc::form.checkbox`
- `x-fltc::form.container.auth.simple`
- `x-fltc::form.container.auth.two-col-left`
- `x-fltc::form.container.auth.two-col-right`

Use for all standard form fields. They handle labels, errors, and theme styling.

Common props:
- `id` and `name`
- `label`
- `placeholder`
- `required`
- `model`: Livewire binding target
- `live`: use `wire:model.live` when true
- `icon`: a Phosphor icon name (e.g. `user`, `envelope`) on the text/email/password/select inputs. Rendered internally through `x-fltc::icon` — the host app only needs the Phosphor icon stylesheet loaded.
- `iconVariant`: Phosphor weight for the input icon (default: `solid`) — see Icon below

**Auth Container** props:
- `id`: optional wrapper id
- `class`: extra wrapper classes
- `theme`: full palette (default: slate)

Auth container variants:
- `simple`: minimal login form, no extra edge content
- `two-col-left`: main content in default slot, side content in side slot (left visual panel)
- `two-col-right`: side content in side slot (left visual panel), main content in default slot

### Tables

Table props:
- `radius`: none, xs, sm, md, lg, xl, 2xl, 3xl, full, or numeric pixel values
- `striped`
- `hover`
- `bordered`
- `compact`
- `responsive`
- `floating`: switches to the "floating row" variant — rows are separated by vertical spacing and rendered as themed rounded pills with no cell borders, instead of the default collapsed/bordered grid. Same `theme`, `hover`, and child markup (`x-fltc::table.head/row/cell`) apply; `striped`, `bordered`, and `radius` are ignored in this mode (the outer radius is replaced by per-row pill rounding). The variant is computed entirely in `Table.php` and propagated to the section children through the existing `@aware` keys, so no separate floating components exist.

Use `x-fltc::table.cell` as `th` for headers and as `td` for data cells. Keep row actions inside cells rather than building separate mini-layouts.

### Feedback and Status

Components:
- `x-fltc::messagebox`
- `x-fltc::alert`
- `x-fltc::badge`

Use message boxes for alerts, empty-state notices, warnings, and selected-item summaries. Use alerts for simple inline messages with theme support. Badge is for compact labels and status chips.

### Utility

Components:
- `x-fltc::buttongroup`
- `x-fltc::darkmode.toggle`
- `x-fltc::tooltip`
- `x-fltc::icon`

**Icon** (`x-fltc::icon`): renders a single [Phosphor](https://phosphoricons.com) webfont glyph
as an `<i>` element. The host app must load the Phosphor icon stylesheet. This is the
canonical way to render an icon — prefer it over hand-written `<i class="ph …">` markup,
and most components that take an `icon` prop render it through this component.

Props:
- `name`: the Phosphor icon identifier (e.g. `user`, `caret-right`). A full class string
  (`ph ph-user`) is also accepted and rendered verbatim, so props that pass a complete icon
  class keep working
- `variant`: Phosphor weight — `thin`, `light`, `regular`, `bold`, `fill`/`solid`, or
  `duotone` (default: `solid`, i.e. Phosphor "fill"). Ignored when `name` is a full class string
- `color`: theme palette name; applies the tertiary-content icon role
  (`text-{c}-500 dark:text-{c}-400`). Omit to inherit the surrounding text colour
  (`currentColor`). `theme` is accepted as an alias
- `size`: Tailwind text-size token sans prefix (e.g. `sm`, `lg`, `2xl`) — Phosphor glyphs
  scale with font size
- `before` / `after`: logical margin before / after the glyph (e.g. `2` → `ms-2` / `me-2`),
  for spacing the icon next to adjacent text
- `align`: vertical-align token (e.g. `middle`, `text-bottom`)
- `class`, `id`, `wire:*`, `data-*`: pass through and merge onto the `<i>` as usual.
  `aria-hidden="true"` is applied by default and can be overridden

**Tooltip** props:
- `text`: tooltip body content
- `theme`: full palette (default: gray)
- `class`: extra wrapper classes

Use tooltip for short helper text around interactive elements. Keep content brief and non-essential.