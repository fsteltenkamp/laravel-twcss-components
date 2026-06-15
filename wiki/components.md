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
- `steps`: array keyed by step number/name; each step may be string label, `[label, icon]`, or `['label' => ..., 'icon' => ...]`
- `stepIndex`: current active step key (default: `1`)
- `stepParam`: query-string parameter for tab links (default: `step`)
- `tabs`: renders linked step tabs with previous/next controls (default: false)
- `iconsOnly`: hides step labels in tab mode, exposes via tooltip (default: false)
- `savebtn`: renders save actions in non-tab mode for legacy form stepper (default: false)
- `onclick`: JavaScript prefix before legacy `util.stepperPreviousStep/NextStep` calls
- `class`: extra wrapper classes

**Navbar**: `x-fltc::nav.navbar`, `x-fltc::nav.navbar.item`, `x-fltc::nav.navbar.link`, `x-fltc::nav.navbar.dropdown` and dropdown link/postlink/onclick variants

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

Header, body, rows, and footer sections inherit card theme automatically. Use `rows` when card content is primarily a table or table rows. Rows is the table-shell section: provide optional head slot and direct `x-fltc::table.row` children.

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

**Tooltip** props:
- `text`: tooltip body content
- `theme`: full palette (default: gray)
- `class`: extra wrapper classes

Use tooltip for short helper text around interactive elements. Keep content brief and non-essential.