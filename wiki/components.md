## Component Catalog

### General Properties

All components support:
- **color**: See supported colours below
- **$attributes**: Every component view must render `$attributes` on its root element so passthrough attributes like `wire:*`, `id`, and `class` always work
- **classList**: Classes must be provided to the view in the "classList" variable and merged with `$attributes->class(...)`. Build `classList` in the component class by combining default classes and colour classes

For components with multiple class properties, name them according to placement (e.g., `headerClasses`, `bodyClasses`).

### Hook classes

Every component also carries neutral **hook classes** on the element that receives
`$attributes` (the root, by convention). They have no styles of their own; skin stylesheets
such as `resources/css/skin-effects.css` target them:
- `fltc-<tag>`: the tag with dots as dashes — `<x-fltc::nav.navbar.link>` → `fltc-nav-navbar-link`
- `fltc-color-<color>`: the component's `color` prop, when it has one (a role such as
  `fltc-color-primary` or a palette such as `fltc-color-green`). Skins match
  `[data-skin="…"] [class*="fltc-color-"]` for the look and read the colours each
  `fltc-color-*` sets. Components that inherit their parent's colour (navbar and sidebar
  children) hook the inherited one; a component that resolves its colour some other way sets
  the protected `$hookColor` in its constructor
- Part hooks for regions a skin styles separately: `fltc-drawer-tab` / `-header` / `-body`,
  `fltc-modal-panel`, `fltc-nav-navbar-dropdown-menu`, `fltc-tooltip-bubble`, the button variant
  (`fltc-button-solid` / `fltc-button-outline`), and the checkbox's visible parts
  (`fltc-form-checkbox-control` on the label, `-track` / `-knob` for the toggle; the
  `fltc-form-checkbox` hooks sit on the hidden `<input>`, so style the parts with `~`),
  the table's scroll wrapper (`fltc-table-scroll`, with its own `fltc-color-*` and
  `fltc-table-floating` for the floating variant), the stepper (`fltc-nav-stepper-panel` /
  `-tabs` / `-step`), the checklist (`fltc-form-checklist-list` / `-row` / `-track` / `-fill`)
  the segmented dark-mode toggle (`fltc-darkmode-toggle-group` / `-option`) and the sidebar
  profile (`fltc-nav-sidebar-profile-trigger` / `-avatar` / `-menu`), the dropdown
  (`fltc-dropdown-trigger` / `-menu`; items carry `fltc-dropdown-item`), the tabs
  (`fltc-tabs-list`; `fltc-tabs-tab` with `aria-selected` for the active one), the pagination
  summary (`fltc-nav-pagination-summary`) and the radio (`fltc-form-radio` on the `<input>`,
  `fltc-form-radio-label`, `fltc-form-radio-group-legend`), the segmented control
  (`fltc-segmented-option` with `aria-pressed`), chips (`fltc-badge-count` / `-remove`), the
  progress bar (`fltc-progress-track` / `-fill` / `-label` / `-value` / `-legend`), the empty
  state (`fltc-empty-icon` / `-title` / `-text` / `-actions`), the message box
  (`fltc-messagebox-title` / `-details` / `-actions`), fields and sections
  (`fltc-form-field-note`, `fltc-form-section-title` / `-hint`), star ratings
  (`fltc-rating-star` / `-fill`, `fltc-form-rating-star` / `-fill`) and the save status (one
  `fltc-status-<state>` part per state, each with its own `fltc-color-*`), the cover
  (`fltc-cover-image` / `-fallback`), the media card (`fltc-media-card-cover` / `-body` /
  `-title` / `-meta` / `-badges` / `-footer` / `-actions`, layout in `data-layout`), the action
  bar (`fltc-action-bar-title` / `-text` / `-actions`), spoilers (`data-revealed`;
  `fltc-spoiler-content` / `-overlay` / `-title` for the gate), the info card
  (`fltc-infocard-trigger` / `-preview` / `-card`), the timeline (`fltc-timeline-dot` / `-time` /
  `-title`), the file card (`fltc-file-card-preview` / `-name` / `-meta` / `-actions`) and the
  upload (`fltc-form-upload-zone` with `data-dragging`, `-prompt`, `-files`). The drawer tab
  and the tooltip bubble are teleported out of their component, so they repeat the
  `fltc-color-*` class themselves.

Class-backed components get them from `Fsteltenkamp\TwcssComponents\View\Component`, the base
class every component extends; anonymous components add theirs in the view.
`tests/HookClassesTest.php` fails when a component is missing its hooks.
It also fails when `skin-effects.css` has no rules for a component's hook, unless the
component is listed in `UNSKINNED_COMPONENTS` there (structural parts styled through their
parent, layout wrappers) — so give a new component its skin effects, or list it on purpose.

### Supported Colours

Every component takes a `color`:
- **Roles** (follow the theme): primary, secondary, accent, base, info, success, warning,
  danger. `base` is the default.
- **Fixed palettes**: red, orange, amber, yellow, lime, green, emerald, teal, cyan, sky, blue,
  indigo, violet, purple, fuchsia, pink, rose, and the neutrals slate, gray, zinc, neutral,
  stone, taupe, mauve, mist, olive.

The **theme** (`data-theme`: default, cyberpunk, fantasy, wh40k, dracula, nord, catppuccin,
solarized, gruvbox, custom) decides which palette each role uses; the **skin**
(`data-skin`: default, cyberpunk, fantasy, wh40k) is the look — fonts, cut corners, lines,
glow, page effects — and draws every component in its own colour. Roles need
`resources/css/colors.css` (Tailwind v4) or `resources/js/colors.js` (v3) plus
`resources/css/themes.css`; see the README "Colours, themes and skins" section.

New components must add a map entry for every colour above — `tests/CustomThemesTest.php`
fails when a file defines any colour fewer times than it defines `rose`. Build the role
entries from the same class strings as the palettes (`bg-primary-500` like `bg-rose-500`).
For a shade role outside a component's own maps (label text, icons, tracks), use
`Fsteltenkamp\TwcssComponents\Support\Shades` instead of hardcoding a neutral palette.

### Color Shades

Within a colour, surfaces and text are assigned fixed **shade roles**, each defined as a
light/dark pair so components flip cleanly in dark mode. For a colour `c`:

- **Background** — page `c-50`/`c-950`, surface (tables, boxes, cards) `c-100`/`c-900`
- **Primary Content** `c-900`/`c-100` — headings and body copy
- **Secondary Content** `c-700`/`c-300` — supporting text, table cells
- **Tertiary Content** `c-500`/`c-400` — muted text, placeholders, icons

Any component that sets a Background **must** set or inherit a paired Content text colour
for the same mode, otherwise its text will not follow a dark-mode switch. Tables sit one
step darker than the page (surface vs. page Background) for context. See the
[README "Shades"](../README.md#shades) section for the full guide.

### Layout and Navigation

**Page container** (`x-fltc::container.page`): the centred content column of a page. Its side
gutters leave room for the drawer tabs (the 2.5rem rail plus a 0.5rem gap), so the tabs sit
in the margin between the screen edge and the content instead of covering it. From `sm` up a
gutter also grows by the width of a pinned drawer on that side and animates with it.
- `width`: max content width — `sm` … `7xl` (default), `prose`, `full`. The width applies to
  the content alone (`box-content`), so on wide screens the gutters sit outside it
- `gutter`: sides that reserve drawer room — `both` (default), `left`, `right`, `none`;
  the other sides get the usual `px-4 sm:px-6`
- No theme: it sets no colours. `class` and passthrough attributes go on the root `<div>`

```blade
<x-fltc::container.page width="5xl" class="py-8">
    ...page content...
</x-fltc::container.page>
```

**Layouts**:
- `x-app-layout`, `x-guest-layout`, `x-formular-layout`, `x-admin-layout`, `x-profile-layout`, `x-error-layout`, `x-editor-layout`

**Breadcrumbs** (`x-fltc::nav.breadcrumbs`):
- `color`: role or palette (default: base) — propagated to all items
- `crumbs`: array of `{href, label, icon?, isActive?}` for programmatic rendering
- `containerClass`: wrapper div class (default: `w-full px-4 sm:px-6 lg:px-8`)

**Breadcrumb Item** (`x-fltc::nav.breadcrumbs.item`):
- `color`: role or palette (default: inherited from parent)
- `href`: link target (renders as `<a>` when set and not active)
- `icon`: icon class string
- `isActive`: marks the current page item
- `showSeparator`: show preceding caret separator (default: true)

**Stepper** (`x-fltc::nav.stepper`):
- `color`: role or palette (default: base)
- `steps`: array keyed by step number/name; each step may be string label, `[label, icon]`, or `['label' => ..., 'icon' => ...]`. The step `icon` is a Phosphor icon name (e.g. `check`), rendered internally through `x-fltc::icon`
- `stepIndex`: current active step key (default: `1`)
- `stepParam`: query-string parameter for tab links (default: `step`)
- `tabs`: renders linked step tabs with previous/next controls (default: false)
- `iconsOnly`: hides step labels in tab mode, exposes via tooltip (default: false)
- `savebtn`: renders save actions in non-tab mode for legacy form stepper (default: false)
- `onclick`: JavaScript prefix before legacy `util.stepperPreviousStep/NextStep` calls
- `class`: extra wrapper classes

**Tabs** (`x-fltc::tabs`, `x-fltc::tabs.tab`, `x-fltc::tabs.panel`): a tab strip and the
panels it switches between. The tabs go in the `list` slot, the panels in the default slot;
a tab and its panel share a `name`. Requires Alpine.

```blade
<x-fltc::tabs active="profile" color="primary" wire:model="tab">
    <x-slot:list>
        <x-fltc::tabs.tab name="profile" icon="user">Profile</x-fltc::tabs.tab>
        <x-fltc::tabs.tab name="security">Security</x-fltc::tabs.tab>
        <x-fltc::tabs.tab name="billing" disabled>Billing</x-fltc::tabs.tab>
    </x-slot:list>

    <x-fltc::tabs.panel name="profile">…</x-fltc::tabs.panel>
    <x-fltc::tabs.panel name="security">…</x-fltc::tabs.panel>
</x-fltc::tabs>
```

- The active tab is Alpine state (`active`) and is `x-modelable`, so `x-model="…"` or
  `wire:model="…"` on `x-fltc::tabs` binds it both ways
- Arrow Left/Right moves between tabs; the strip is `role="tablist"` with matching
  `aria-controls` / `aria-labelledby` ids

`x-fltc::tabs` props:
- `active`: initially active tab name. When set, the other panels render hidden, so the right
  panel shows before Alpine starts; when empty, Alpine activates the first enabled tab and the
  panels are `x-cloak`ed until then (the host needs the usual `[x-cloak] { display: none }`)
- `color`: role or palette (default: base) — inherited by the tabs
- `id`: base for the tab and panel ids (random when omitted)

`x-fltc::tabs.tab` props:
- `name`: the panel it activates
- `href`: render a link instead of a button (navigation tabs; panels are optional then). Mark
  the current page with `current`
- `current`: active state of a link tab
- `disabled`
- `icon`, `iconVariant`: Phosphor icon before the label
- `color`: overrides the inherited colour

`x-fltc::tabs.panel` props: `name`. Panels get `pt-4`; pass `class` to change it.

**Pagination** (`x-fltc::nav.pagination`): first / previous / page numbers / next / last
buttons, plus a "Showing x–y of z" summary. Feed it a Laravel paginator, or integers:

```blade
{{-- a paginator: links to its URLs --}}
<x-fltc::nav.pagination :paginator="$customers" color="primary" />

{{-- in a Livewire component (WithPagination): gotoPage() calls --}}
<x-fltc::nav.pagination :paginator="$customers" livewire />

{{-- or through the paginator's links(): --}}
{{ $customers->links('fltc::pagination.livewire') }}   {{-- or 'fltc::pagination.links' --}}
```

To make it the default for a Livewire component, return the view from `paginationView()`:
`public function paginationView() { return 'fltc::pagination.livewire'; }`.

Props:
- `paginator`: a `LengthAwarePaginator` (page numbers, first/last, total in the summary) or a
  simple `Paginator` (previous/next only, no total). Cursor paginators are not supported.
  With a single page only the summary renders
- `livewire`: render `wire:click="gotoPage(n, 'pageName')"` buttons instead of links. Default:
  false with a paginator, true without one
- `showSummary`: show "Showing x–y of z" (default: true; paginator only). Translatable via the
  `Showing` and `of` strings
- `window`: page numbers shown either side of the current one (default: 2)
- `color`: role or palette (default: base) — buttons and summary. The current page is the one
  solid button among outline ones
- `accentColor`: a different colour for the current page's button (default: `color`)
- `mainColor`: the old name of `color`, still accepted
- Without a paginator: `currentPage`, `totalPages`, `start`, `end` (integers) — renders
  `gotoPage(n)` buttons for a Livewire component, as before
- `class` and passthrough attributes go on the root `<nav>`

**Navbar** (`x-fltc::nav.navbar`): a horizontal top/bottom bar.
- `color`: role or palette (default: base) — shared with all navbar children (which inherit it unless given their own `color`)
- `containerClass`: inner container width/padding (default: `w-full px-4 sm:px-6 lg:px-8`)
- `stickyTop` / `stickyBottom`: pin the bar to the top/bottom; sets the matching edge border and applies `zIndexClass`. Use `stickyBottom` to make the navbar double as a page footer (bottom-pinned, top edge border)
- `zIndexClass`: z-index when sticky (default: `z-40`)
- Slots: `logo` (optional start-aligned logo box — only rendered when provided), `left` (or the default slot) and `right` for start/end aligned content
- Children: `x-fltc::nav.navbar.link` (`href`), `x-fltc::nav.navbar.postlink` (`action` — styled like a link but submits a POST form + CSRF, e.g. logout), `x-fltc::nav.navbar.item` (static label), `x-fltc::nav.navbar.onclick` (`onclick` JS string), `x-fltc::nav.navbar.toggle` (sidebar drawer button, see below), and `x-fltc::nav.navbar.dropdown` (`trigger` slot, optional `hover`) with `dropdown.link` (`href`) and `dropdown.postlink` (`action` — POST form + CSRF) menu items. Self-initialising vanilla JS handles open/close, outside-click, Escape and optional hover.

**Navbar link** (`x-fltc::nav.navbar.link`):
- `href`: link target (default `#`)
- `active`: force the active state; when omitted it is auto-derived by matching the current request URL (same rules as the sidebar link)
- `activePattern`: `Request::is()` pattern for active detection (defaults to the href path; supports wildcards like `invoices/*`)
- `color`: role or palette (default: inherited from the navbar)
- Active links render `aria-current="page"` and keep the hover background with a continuous underline beneath icon and text (an inset shadow, not a text underline, which breaks at the gap between icon and label). Under the cyberpunk skin they look exactly like hovered links. Use `active` rather than adding `underline` yourself

**Navbar toggle** (`x-fltc::nav.navbar.toggle`): a hamburger button that opens the responsive sidebar drawer on small screens. Place it in the navbar's `left` slot.
- `target`: the `name` of the sidebar to control — only needed when more than one sidebar is on the page (default: the unnamed sidebar)
- `label`: accessible label (default: `Toggle navigation`)
- `color`: role or palette (default: inherited from the navbar)
- `class`: extra classes; the default slot overrides the built-in hamburger icon
- Behaviour: hidden from `lg` up (where the sidebar is a permanent column) and dispatches the `fltc-sidebar-toggle` window event the sidebar listens for. Requires Alpine.

**Sidebar** (`x-fltc::nav.sidebar`): a full-height vertical navigation column that automatically collapses into an off-canvas drawer below `lg`.
- `color`: role or palette (default: base) — shared with all child links/groups/footer/profile, which inherit it unless they set their own `color`
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
- `color`: role or palette (default: inherited from the sidebar)
- Active links render `aria-current="page"` and a `data-sidebar-active` marker (the latter is what auto-opens an enclosing group)
- `trailing` slot: right-aligned content such as a badge or counter

**Sidebar postlink** (`x-fltc::nav.sidebar.postlink`): styled like a sidebar link but submits a surrounding POST form (with CSRF) instead of navigating — e.g. logout. Works standalone or inside a `x-fltc::nav.sidebar.group`.
- `action`: form action the submit button posts to
- `icon`: full icon class string (e.g. `ph ph-sign-out`)
- `color`: role or palette (default: inherited from the sidebar)
- `trailing` slot: right-aligned content such as a badge or counter

**Sidebar group** (`x-fltc::nav.sidebar.group`): a collapsible section of links.
- `label`: trigger label
- `icon`: full icon class string
- `open`: force the initial open state; defaults to open when `activeWhen` matches
- `activeWhen`: `Request::is()` pattern that both highlights the trigger and opens the group by default (e.g. `settings/*`)
- `id`: stable key for persisting the open state in `localStorage` (defaults to a slug of `label`)
- `color`: role or palette (default: inherited)
- Behaviour: groups **stay open once opened** (the choice is remembered in `localStorage` across page loads / `wire:navigate`) and are **forced open when the URL is on one of their sub-items** (detected via a child `data-sidebar-active` link). Self-initialising vanilla JS, no Alpine dependency.

**Sidebar footer** (`x-fltc::nav.sidebar.footer`): bottom region pinned with `mt-auto` and a top border. Drop it in the sidebar's `footer` slot. `color` inherited; `class` for extras.

**Sidebar profile** (`x-fltc::nav.sidebar.profile`): an optional account row for the footer.
- `name`: display name; `email`: secondary line
- `avatar`: image URL (falls back to auto-derived `initials` when omitted)
- `initials`: override the derived initials
- `href`: link target used when no menu is provided
- When the default slot has content it renders a button that toggles a popover menu (opens upward, closes on outside-click/Escape); otherwise it renders a static row (or an `<a>` when `href` is set). Put `x-fltc::nav.sidebar.link`s in the slot for menu items.

### Typography

Components:
- `x-fltc::heading`
- `x-fltc::subheading`
- `x-fltc::text`

**Text** (`x-fltc::text`): inline text in the theme's Primary Content colour.
- `color`: role or palette (default: base). Ignored when `color` is set
- `color`, `ff`, `fs` (pt), `fw`, `ta`, `lh`, `ls`: inline font/colour overrides

Use for section titles and supporting copy. Both use the neutral Primary/Tertiary Content
roles so they flip cleanly in dark mode.

**Heading** (`x-fltc::heading`):
- `size`: `sm`, `base` (default), `lg`, `xl`, `2xl`
- `level`: heading level `1`–`6`, renders the matching `<h1>`–`<h6>` tag (default: `2`)
- `glitch`: opt into a skin's glitch effect (cyberpunk in `skin-effects.css`); copies the
  text into `data-text` for the effect layers. No visible change without such a skin
- `color`: role or palette — the theme's Primary Content colour. Default: none, which keeps
  the neutral zinc/white
- `class`, `id`, etc.: passed through and merged

**Subheading** (`x-fltc::subheading`): muted secondary line rendered as a `<p>`.
- `size`: `xs`, `sm` (default), `base`, `lg`
- `color`: role or palette — the theme's Tertiary Content colour. Default: none, which keeps
  the neutral zinc

### Overlays

**Modal** (`x-fltc::modal`): a self-contained Alpine dialog with a dimmed backdrop. No
Flux/Livewire JS runtime required — open state can be driven three ways:
- `wire:model="prop"`: entangles the open state with a Livewire boolean
- `name` + `open-modal` event: dispatch `$dispatch('open-modal', 'your-name')` to open and
  `$dispatch('close-modal', 'your-name')` to close. The modal also emits a `close` event when
  it closes, so a host can react with `@close="$wire.someMethod()"`
- `open`: initial open state (e.g. pass `:open="$errors->isNotEmpty()"`)

Props:
- `name`: stable key for event-based opening
- `open`: initial open state (default: false)
- `maxWidth`: `sm`, `md`, `lg` (default), `xl`, `2xl`, `3xl`, `4xl`, `5xl`, `6xl`, `7xl`, `full`
- `closeable`: allow closing via backdrop/Escape (default: true)
- `color`: role or palette (default: base) — panel surface, border and text, and the tint of
  the dimmed backdrop. Pass the same `color` to headings and buttons inside it
- `teleport`: move the overlay to `<body>` (default: true), so a transformed, filtered or
  clipped ancestor can't trap it. Pass `:teleport="false"` to render it in place

The overlay is teleported, but the modal's wrapper stays where it is written: it holds the
Alpine scope and the host's attributes (`id`, `wire:*`, `@close`), while `class` and the
`fltc-*` hooks go on the overlay. A modal inside a `data-skin` or `data-theme` region (other
than `<html>`) copies that region's attributes (with a custom theme's `data-theme-*`) onto the
overlay whenever it opens, so the skin and theme keep working after the move.

The Alpine scope exposes a `close()` method, so any element inside the modal can close it
with `x-on:click="close()"` (use this for a Cancel button — no separate close component needed).

**Confirm modal** (`x-fltc::modal.confirm`): a modal with a title, an optional description and
a Cancel button that closes it. The default slot holds the confirming action(s), rendered after
Cancel.

```blade
<x-fltc::modal.confirm name="delete-post" title="Delete this post?" description="This cannot be undone.">
    <x-fltc::button color="red" wire:click="delete">Delete</x-fltc::button>
</x-fltc::modal.confirm>
```

Props: everything `x-fltc::modal` takes, plus
- `title` (required), `description`
- `color`: role or palette (default: base) — the panel, title, description and Cancel button
- `cancelColor`: overrides the Cancel button's colour only (default: `color`)
- `cancelLabel`: Cancel button text (default: `__('Cancel')`)
- `teleport`: as on `x-fltc::modal` (default: true)

**Dropdown** (`x-fltc::dropdown` + `x-fltc::dropdown.item`): a menu that opens from any
trigger — row actions, a user menu, a "more" button. Unlike `nav.navbar.dropdown` it is not
tied to the navbar. Requires Alpine. Closes on an item click, a click outside and Escape;
Arrow Down from the trigger opens it and Arrow Up/Down move between items.

```blade
<x-fltc::dropdown align="right">
    <x-slot:trigger>
        <x-fltc::button icon="dots-three" />
    </x-slot:trigger>

    <x-fltc::dropdown.item href="{{ route('posts.edit', $post) }}" icon="pencil-simple">Edit</x-fltc::dropdown.item>
    <x-fltc::dropdown.item wire:click="duplicate({{ $post->id }})" icon="copy">Duplicate</x-fltc::dropdown.item>
    <x-fltc::separator class="my-1" />
    <x-fltc::dropdown.item href="{{ route('posts.destroy', $post) }}" method="delete" color="red">Delete</x-fltc::dropdown.item>
</x-fltc::dropdown>
```

`x-fltc::dropdown` props:
- `color`: role or palette (default: base) — menu surface; inherited by the items
- `align`: `left` (default) or `right` — which trigger edge the menu lines up with
- `position`: `bottom` (default) or `top` (opens upward)
- `width`: `sm` (10rem), `md` (14rem, default), `lg` (18rem), `auto` (fits the content, at
  least the trigger's width)

Slots: `trigger` (required; any button or element — the wrapper handles the click), default
(items; separate groups with `x-fltc::separator class="my-1"`).

`x-fltc::dropdown.item` props:
- `href`: renders a link. With `method` other than `get` it renders a form submit instead
  (POST with `@csrf`, plus `@method` for PUT/PATCH/DELETE)
- no `href`: renders a `<button type="button">` — use `wire:click` / `x-on:click`
- `icon`, `iconVariant`: Phosphor icon before the label
- `disabled`
- `color`: overrides the inherited colour (e.g. `danger` for a destructive action)

**Drawer** (`x-fltc::drawer`): a full-height side panel that slides in from the left or right
screen edge. Requires Alpine (no Livewire needed); open and pinned state live in Alpine, so they
survive Livewire morphs.

```blade
<x-fltc::drawer name="wiki" side="right" title="Wiki" label="Wiki" icon="book-open" color="amber" pinnable offset="4rem">
    <x-slot:actions>
        <x-fltc::button.link href="/wiki" color="amber">All</x-fltc::button.link>
    </x-slot:actions>

    …drawer content…
</x-fltc::drawer>
```

Behaviour:
- **Activation tabs**: when `label` and/or `icon` is set, the drawer adds a vertical tab to a
  shared rail on its screen edge. Tabs on the same side stack top-to-bottom by `order`, and the
  rail slides out beside the open panel so the tabs never cover it. Without `label` and `icon`
  there is no tab — open the drawer through events (below).
- **One active drawer**: opening a drawer first closes the drawer already open on the same side,
  then slides in once that one has closed. A left and a right drawer can be open together on
  desktop; below the `sm` breakpoint the panel is near full-width, so any open drawer closes
  the others, whichever side they are on.
- **Dismissal**: the close button, Escape, or a click outside every drawer closes unpinned
  drawers. Closing a drawer also unpins it.
- **Pinning** (`pinnable`): adds a pin button. A pinned drawer ignores outside clicks and Escape,
  and its pin is restored on the next page load (localStorage key
  `fltc-drawer-pinned:{name}`). While pinned drawers are open, `<html>` gets a
  `data-fltc-drawer-pinned` attribute plus the CSS variables `--fltc-drawer-pin-left` /
  `--fltc-drawer-pin-right` (the pinned panel's width, `0px` otherwise), so a host can keep its
  content clear of them. `x-fltc::container.page` does this (and keeps clear of the tabs);
  by hand: `<main class="sm:ps-[var(--fltc-drawer-pin-left,0px)] sm:pe-[var(--fltc-drawer-pin-right,0px)] transition-[padding]">`.

Opening from elsewhere:
- Alpine: `$dispatch('fltc-drawer-open', 'wiki')`, `fltc-drawer-close`, `fltc-drawer-toggle`
  (the detail may also be `{ name: 'wiki' }`).
- Plain JS: `window.fltcDrawers.open('wiki')` / `.close('wiki')` / `.toggle('wiki')`.
- Add `data-fltc-drawer-trigger` to a custom trigger button. Otherwise the outside-click
  handler closes the drawer on pointerdown and the click immediately re-opens it, so a toggle
  button could never close it.

Props:
- `name`: stable key for events and the persisted pin (random when omitted — set it for pinnable
  drawers)
- `side`: `left` or `right` (default: right)
- `title`: heading in the panel header
- `label`: text on the activation tab (default: none → no tab)
- `icon`: Phosphor icon on the activation tab, e.g. `book-open`
- `order`: tab position within its side's rail (default: 0)
- `color`: role or palette (default: base) — panel surface, header, tab
- `pinnable`: show the pin button (default: false)
- `open`: initial open state (default: false)
- `width`: panel width as a CSS length (default: `24rem`); always capped to leave room for the tab
  rail on small screens
- `offset`: distance from the viewport top as a CSS length, e.g. the height of a sticky navbar
  (default: `0px`); the tab rail starts `1rem` below it
- `class`: extra panel classes

Slots:
- default: the scrollable panel body
- `actions`: extra header controls, rendered before the pin/close buttons

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

Header, body, rows, and footer sections inherit the card's colour automatically. Use `rows` when card content is primarily a table or table rows. Rows is the table-shell section: provide optional head slot and direct `x-fltc::table.row` children. It forwards the table options `striped`, `hover`, `bordered`, `compact`, `responsive`, and `floating` (same meaning as on `x-fltc::table`) down to the underlying table; `floating` switches the rows to the separated rounded-pill variant.

### Counter

**Counter** (`x-fltc::counter`): a self-contained dashboard stat card. Layout, top-left to bottom-right: title (top left), icon (small, top right), counter value (left, next row), description (small/muted, left, next row).

Props:
- `color`: role or palette (default: base) — colors the counter value and icon
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
- `color`: role or palette (default: base)
- `draggable`: enables drag-and-drop sorting (default: false)
- `openFirst`: open first item on initial render when none open (default: true)
- `class`: extra wrapper classes

**Accordion Item** props:
- `color`: role or palette (default: inherited from accordion)
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
- `iconVariant`: Phosphor weight for the icon (default: `regular`) — see Icon below
- `iconPosition`: `before` (default) or `after` the label

Default button text is white. Use color names for semantic meaning.

**Button Link** additional props:
- `href`: link target
- `navigate`: adds `wire:navigate` when true

### Forms

**Label** (`x-fltc::form.label`) uses the colour's Secondary Content shade (`color`, default
base). The inputs pass their own `color` to their label, so a label matches its field.

Components:
- `x-fltc::form.label`
- `x-fltc::form.field`
- `x-fltc::form.section`
- `x-fltc::form.input.text`
- `x-fltc::form.input.number`
- `x-fltc::form.input.date`
- `x-fltc::form.input.time`
- `x-fltc::form.input.datetime`
- `x-fltc::form.input.email`
- `x-fltc::form.input.password`
- `x-fltc::form.input.file`
- `x-fltc::form.input.select`
- `x-fltc::form.textarea`
- `x-fltc::form.checkbox`
- `x-fltc::form.radio`
- `x-fltc::form.radio.group`
- `x-fltc::form.rating`
- `x-fltc::form.upload`
- `x-fltc::form.otp`
- `x-fltc::form.container.auth.simple`
- `x-fltc::form.container.auth.two-col-left`
- `x-fltc::form.container.auth.two-col-right`

Use for all standard form fields. They handle labels, errors, and theme styling.

Common props:
- `id` and `name`
- `label`
- `note`: help text under the control (linked with `aria-describedby`)
- `placeholder`
- `required`
- `model`: Livewire binding target
- `live`: use `wire:model.live` when true
- `icon`: a Phosphor icon name (e.g. `user`, `envelope`) on the text/email/password/select inputs. Rendered internally through `x-fltc::icon` — the host app only needs the Phosphor icon stylesheet loaded.
- `iconVariant`: Phosphor weight for the input icon (default: `regular`) — see Icon below
- `color`: role or palette (default: base)
- `inline`: drop the wrapper's bottom margin (`mb-4`) so the field lines up in a flex row,
  e.g. a filter bar with `flex items-end` (text-family inputs, select, file, textarea, radio group)
- `wrapperClass`: classes for the wrapper `<div>` (label + field + error), e.g. `w-64` or
  `flex-1` to size an inline field. `class` and other attributes go on the control itself

```blade
<div class="flex flex-wrap items-end gap-3">
    <x-fltc::form.input.text label="Search" icon="magnifying-glass" wire:model.live="search" inline wrapperClass="w-64" />
    <x-fltc::form.input.date label="Since" wire:model.live="since" inline />
    <x-fltc::button icon="funnel">Filter</x-fltc::button>
</div>
```

**Field** (`x-fltc::form.field`): label, note and validation error around any control. The
library's inputs render their own field through it, so use it for custom controls (a colour
picker, a third-party widget) to make them look like the rest of the form.

```blade
<x-fltc::form.field label="Accent colour" note="Used for your profile header." for="accent" name="accent">
    <input id="accent" name="accent" type="color" />
</x-fltc::form.field>
```

- `label`, `note`, `required`
- `for`: id of the control (the label's `for`, the note's id is `{for}-note`)
- `name`: field name whose validation error to show (default: `for`; `name[]` and `name.*`
  errors count too). The error's id is `{name}-error`
- `color`: role or palette (default: base); `inline`: no bottom margin
- `class` and attributes go on the wrapper `<div>`

**Settings section** (`x-fltc::form.section`): a titled group of fields with hint text, e.g.
one block of a settings page. Consecutive sections are separated by a rule.

```blade
<x-fltc::form.section title="Profile" hint="Shown on your public page." split>
    <x-fltc::form.input.text label="Display name" name="name" />
    <x-slot:actions><x-fltc::button type="submit">Save</x-fltc::button></x-slot:actions>
</x-fltc::form.section>
```

- `title`, `hint`
- `split`: title and hint in a column beside the fields from `md` up (default: stacked)
- `color`: role or palette (default: base)
- Slots: default (the fields), `actions` (right-aligned under the fields)

**Typed inputs**: `number`, `date`, `time`, `datetime` (`datetime-local`), `email` and
`password` are `form.input.text` with a different `type` and take the same props. Type
specific attributes (`min`, `max`, `step`, `inputmode`, `pattern`, …) pass through to the
`<input>`. `form.input.text` also takes a `type` prop for any other type
(`<x-fltc::form.input.text type="search" />`, `tel`, `url`, …) — use it rather than a `type`
attribute, which the component used to duplicate.

**File input** (`x-fltc::form.input.file`): a native file picker with a themed "Choose file"
button. Props: `id`, `name`, `label`, `required`, `disabled`, `model`/`live` (Livewire file
uploads with `WithFileUploads`), `color`, `inline`, `wrapperClass`. `accept` and `multiple`
pass through as attributes. For a multiple upload use `name="files[]"`; errors on
`files` and `files.*` are both shown. (A drop-zone upload control is planned separately.)

**Upload** (`x-fltc::form.upload`): a drop zone around a real `<input type="file">`. Click it
to browse or drop files on it; dropped files are put into the input and a `change` event is
fired, so it works in a plain form and with `wire:model` (Livewire `WithFileUploads`) alike.
The chosen file names are listed under the zone.

```blade
<x-fltc::form.upload name="attachments[]" label="Attachments" accept="image/*,.pdf" multiple model="attachments" />
```

- `name` (use `name[]` with `multiple`), `id`, `label`, `note`, `required`, `disabled`
- `accept` (also shown as a hint), `multiple` (a single-file zone keeps only the first dropped file)
- `model` / `live`: Livewire binding on the input; other attributes go on the input too
- `icon` (default `upload-simple`), `prompt` (default "Drop a file / files here or click to browse")
- `color`: role or palette (default: base); `inline`, `wrapperClass`
- Errors on `name` and `name.*` are shown. The plain picker is `x-fltc::form.input.file`

**Radio** (`x-fltc::form.radio`) and **Radio group** (`x-fltc::form.radio.group`): native
radio buttons, coloured with the theme's accent colour. Inside a group the radios take the
group's `name`, `model`, `live`, `required` and `color` unless they set their own.

```blade
<x-fltc::form.radio.group name="plan" label="Plan" :value="$user->plan" horizontal>
    <x-fltc::form.radio value="free" label="Free" />
    <x-fltc::form.radio value="pro" label="Pro" />
</x-fltc::form.radio.group>
```

Group props:
- `name`, `label` (rendered as the `<legend>`), `required`
- `value`: the selected option for plain forms; `old()` input wins after a failed validation
- `model` / `live`: Livewire binding for every option (then `wire:model` decides the checked one)
- `horizontal`: options in a wrapping row instead of a column
- `color`: role or palette (default: base); `inline`: no bottom margin
- Shows the validation error for `name`

**Star rating input** (`x-fltc::form.rating`): pick 1 to `max` stars by click or arrow keys;
clicking the chosen star again clears it (`clearable`, default true). A `role="radiogroup"` of
star buttons; hovering previews the value.

```blade
<x-fltc::form.rating name="score" label="Your rating" :value="$review->score" />
<x-fltc::form.rating label="Your rating" model="score" />   {{-- Livewire --}}
```

- `name`: posts the value through a hidden input (empty when cleared); `old()` input wins
- `value` (int, default 0), `max` (default 5)
- `model` / `live`: Livewire binding; the value is also `x-modelable`, so `x-model` works
- `label`, `note`, `required`, `disabled`, `clearable`, `size` (`sm`, `md`, `lg`)
- `color`: role or palette (default: base) — filled stars use its tertiary shade
- `inline`, `wrapperClass` as for the other fields

Radio props: `value`, `label` (or the default slot), `id`, `checked` (overrides the group's
`value`), `disabled`, plus `name`, `model`, `live`, `required`, `color` to override the
group. Attributes go on the `<input>`.

**Checkbox** (`x-fltc::form.checkbox`): a CSS-only checkbox backed by a real
`<input type="checkbox">`, so it works with plain forms and `wire:model` without any
JavaScript. Two visual variants:
- `variant="default"` (default): a bordered row that swaps `iconUnchecked` → `iconChecked`
  (Phosphor names) when checked. Props: `bordered` (default: true), `color` (role or palette,
  default `base`), `iconChecked`, `iconUnchecked`.
- `variant="toggle"`: a pill-style switch (the "darkmode toggle" look) with a sliding knob.
  - `color`: track color while **on** (checked) — role or palette, default `slate`
  - `colorOff`: track color while **off** (unchecked) — role or palette, default `slate`
  - `size`: `sm`, `md` (default), or `lg` — sets track, knob and icon sizes
  - `iconChecked` / `iconUnchecked`: optional Phosphor icons shown inside the knob for the
    on / off states (colored by `color` / `colorOff`). Pass an empty string to hide one.

Shared props: `id`, `name`, `value`, `label`, `model` (Livewire binding), `live`
(`wire:model.live`), `checked`, `disabled`, `class`.

**OTP** (`x-fltc::form.otp`): a segmented one-time-code input with auto-advance, backspace,
arrow-key navigation and paste support. Renders `length` single-character boxes backed by a
hidden input that carries the joined value.
- `length`: number of digit boxes (default: 6)
- `color`: role or palette (default: base)
- `name`, `wire:model`, `x-model`: passed through to the hidden input, so the joined value
  posts with a form / binds to Livewire or Alpine. Use `wire:model.live` for live length checks
- The first visible box is the first `<input>` in the DOM, so
  `el.querySelector('input').focus()` focuses the field as expected

**Auth Container** props:
- `id`: optional wrapper id
- `class`: extra wrapper classes
- `color`: role or palette (default: base)

Auth container variants:
- `simple`: minimal login form, no extra edge content
- `two-col-left`: main content in default slot, side content in side slot (left visual panel)
- `two-col-right`: side content in side slot (left visual panel), main content in default slot

### Media

**Cover** (`x-fltc::cover`): a fixed-aspect-ratio image — book cover, poster, avatar — with
`object-cover`. When `src` is empty or the image fails to load, a placeholder takes its place
(swapped by an inline `onerror`, no Alpine needed).
- `src`, `alt`
- `ratio`: `2/3` (default), `3/4`, `1/1`, `4/3`, `3/2`, `16/9`, or any other `w/h` (set inline)
- `size`: `thumb-sm` (3rem), `thumb` (6rem), `sm`, `md`, `lg`, `full` (default — the container's width)
- `fallback`: placeholder text (default `NO COVER`; empty for none), `fallbackIcon` (default `image`)
- `color`: role or palette (default: base) — the placeholder

**Media card** (`x-fltc::media-card`): a card for a book, story or other item, built from the
cover, chips, rating and progress components.

```blade
<x-fltc::media-card :href="route('books.show', $book)" layout="list">
    <x-slot:cover><x-fltc::cover :src="$book->cover_url" :alt="$book->title" /></x-slot:cover>
    <x-slot:title>{{ $book->title }}</x-slot:title>
    <x-slot:meta>{{ $book->author }} · {{ $book->year }}</x-slot:meta>
    <x-slot:badges>@foreach ($book->tags as $tag)<x-fltc::badge>{{ $tag }}</x-fltc::badge>@endforeach</x-slot:badges>
    <x-slot:footer><x-fltc::rating :value="$book->rating" size="sm" /></x-slot:footer>
    <x-slot:actions><x-fltc::button icon="bookmark-simple" variant="outline" /></x-slot:actions>
</x-fltc::media-card>
```

- `layout`: `card` (default; cover on top), `compact` (one line: small cover, title, meta,
  actions — badges and footer hidden), `list` (cover beside the body)
- The layout is rendered as `data-layout` and every region styles itself per layout, so it can
  switch in the browser: `x-bind:data-layout="layout"` on the cards with an
  `x-fltc::segmented x-model="layout"` control (see the gallery)
- `href`: makes the title a stretched link, so the whole card is clickable; actions stay on top
- `color`: role or palette (default: base)
- Slots: `cover`, `title`, `meta`, `badges`, `footer`, `actions`, and the default slot (extra
  body content after the badges)

**Action bar** (`x-fltc::action-bar`): a banner with a title, text and actions — e.g. a draft
bar: "Unpublished draft — Publish / Discard".
- `title`, `icon`; default slot: the text; `actions` slot: buttons
- `sticky`: stays at the top while scrolling; `offset`: distance from the top (CSS length,
  e.g. the height of a sticky navbar)
- `quiet`: a lighter, dashed variant
- `color`: role or palette (default: base)

### Reveal and Context

**Spoiler** (`x-fltc::spoiler`): hidden content. Requires Alpine.
- Inline (default): blacked out in the text until clicked (or, with `reveal="hover"`, while
  hovered/focused); a click keeps it revealed. Keyboard: Enter / Space
- `variant="gate"`: a block whose content is blurred under an overlay with `title` and a reveal
  button (`buttonLabel`, default "Show anyway"). The `message` and `button` slots replace them;
  an own button reveals with `x-on:click="reveal()"`, e.g. to hide a puzzle's answer:

```blade
<x-fltc::spoiler variant="gate" title="The answer">
    …solution…
    <x-slot:message>Have a go at the riddle before you look.</x-slot:message>
    <x-slot:button><x-fltc::button icon="lightbulb" x-on:click="reveal()">Show the answer</x-fltc::button></x-slot:button>
</x-fltc::spoiler>
```

- `color`: role or palette (default: base) — the inline bar, the gate frame and button

**Info card** (`x-fltc::infocard`): context for a term in running text. On pointer devices,
hovering the trigger shows a small floating preview; a click or tap unfolds the full card inline
below it (Escape or its ✕ closes it). Requires Alpine.

```blade
<p>At dawn
    <x-fltc::infocard title="Mira Valen" icon="user" :image="$mira->portrait" :href="route('characters.show', $mira)">
        <x-slot:trigger>Mira</x-slot:trigger>
        Cartographer of the Glass Tower.
        <x-slot:actions><x-fltc::button wire:click="follow({{ $mira->id }})">Follow</x-fltc::button></x-slot:actions>
    </x-fltc::infocard>
    climbed the tower.</p>
```

- Slots: `trigger` (the inline term), default (the body; clamped to three lines in the
  preview), `actions` (full card only)
- `title`, `icon`, `image` (shown at the top), `href` + `linkLabel` (default "Read more")
- `preview` (default true): false skips the hover preview
- `color`: role or palette (default: base)
- The markup is phrasing content (spans), so it can sit inside a `<p>`

**Timeline** (`x-fltc::timeline` + `x-fltc::timeline.item`): dots on a vertical line, one entry
each, in the order you give them.

```blade
<x-fltc::timeline>
    <x-fltc::timeline.item time="Today" datetime="2026-10-13" title="Chapter 12 published" :href="$url" icon="paper-plane-tilt">
        Sent to 214 readers.
    </x-fltc::timeline.item>
</x-fltc::timeline>
```

- Timeline: `color` (role or palette, default: slate), inherited by the items
- Item: `time` (+ `datetime` for the `<time>` element), `title`, `href` (makes the title a link),
  `icon` (a larger dot with the icon), `color`; default slot: the entry's content

### Files

**File card** (`x-fltc::file-card`): a file in a list — preview, name, type and size, actions.
The preview is chosen from the extension: the image itself for images (`src`, or `href`),
the `excerpt` for text files (`txt`, `md`, `csv`, `json`, …), otherwise an icon for the type
(PDF, document, spreadsheet, archive, audio, video, code, text, or a generic file).

```blade
<x-fltc::file-card :name="$file->name" :href="$file->url" :size="$file->size">
    <x-slot:actions><x-fltc::button icon="trash" variant="outline" wire:click="delete({{ $file->id }})" /></x-slot:actions>
</x-fltc::file-card>
```

- `name` (its extension picks the preview), `extension` (override), `href` (name link)
- `size`: bytes (formatted, e.g. `1.5 MB`) or a ready string
- `src` (image preview URL), `excerpt` (text preview), `meta` (extra text after the size)
- `color`: role or palette (default: base)
- Slots: `preview` (replaces the chosen preview), `actions`

### Tables

Table props:
- `radius`: none, xs, sm, md, lg, xl, 2xl, 3xl, full, or numeric pixel values
- `striped`
- `hover`
- `bordered`
- `compact`
- `responsive`
- `floating`: switches to the "floating row" variant — rows are separated by vertical spacing and rendered as themed rounded pills with no cell borders, instead of the default collapsed/bordered grid. Same `color`, `hover`, and child markup (`x-fltc::table.head/row/cell`) apply; `striped`, `bordered`, and `radius` are ignored in this mode (the outer radius is replaced by per-row pill rounding). The variant is computed entirely in `Table.php` and propagated to the section children through the existing `@aware` keys, so no separate floating components exist.

Use `x-fltc::table.cell` as `th` for headers and as `td` for data cells. Keep row actions inside cells rather than building separate mini-layouts.

### Feedback and Status

Components:
- `x-fltc::messagebox`
- `x-fltc::alert`
- `x-fltc::badge`
- `x-fltc::toast`
- `x-fltc::toast.container`

- `x-fltc::badge.cloud`
- `x-fltc::progress` (+ `x-fltc::progress.segment`)
- `x-fltc::rating`
- `x-fltc::status`
- `x-fltc::empty`

Use message boxes for alerts, empty-state notices, warnings, and selected-item summaries. Use alerts for simple inline messages with theme support. Badge is for compact labels and status chips.

**Message box** (`x-fltc::messagebox`): a bordered box with an optional title bar.
- `title`, `icon` (Phosphor, shown in the title bar)
- `color`: role or palette (default: slate; red for the error variant)
- `variant="error"`: the **error panel** — red, a warning icon and the title
  `__('Something went wrong')` unless you give your own
- Slots: default (the message), `details` (collapsible `<details>` with preformatted text, e.g.
  a stack trace; its `summary` attribute is the toggle label, default `__('Details')`),
  `actions` (right-aligned buttons, e.g. Retry)

```blade
<x-fltc::messagebox variant="error">
    We could not load your chapters.
    <x-slot:details summary="Technical details">{{ $exception->getMessage() }}</x-slot:details>
    <x-slot:actions><x-fltc::button wire:click="reload">Retry</x-fltc::button></x-slot:actions>
</x-fltc::messagebox>
```

**Badge / chip** (`x-fltc::badge`): a compact label. Variants:
- plain (default): a `<span>`
- `href`: a link chip
- `variant="toggle"`: an on/off chip backed by a hidden checkbox — `name`, `value`, `checked`
  post with a form; `wire:model` / `x-model` go on the checkbox, other attributes on the chip
- `removable`: adds a ✕ button that dispatches a `badge-remove` browser event with `value`
  (or the label) as detail: `x-on:badge-remove="$wire.removeTag($event.detail)"`.
  `removeLabel`: its accessible name (default: `__('Remove')`)

Other props: `icon`, `iconVariant`, `count` (a small number after the label, e.g. facet counts),
`color` (role or palette, default: slate, or the surrounding chip cloud's).

**Chip cloud** (`x-fltc::badge.cloud`): wrapping layout for tag and facet lists. Its `color`
(default: base) is inherited by the chips inside; `gap`: `sm`, `md` (default), `lg`; `label`:
accessible group name.

```blade
<x-fltc::badge.cloud label="Genres" color="violet">
    @foreach ($genres as $genre)
        <x-fltc::badge variant="toggle" name="genres[]" :value="$genre->slug" :count="$genre->books_count" wire:model.live="genres">{{ $genre->name }}</x-fltc::badge>
    @endforeach
</x-fltc::badge.cloud>
```

**Progress** (`x-fltc::progress`): a progress bar (`role="progressbar"`).

```blade
<x-fltc::progress :value="$read" :max="$chapters" label="Progress" showValue />

<x-fltc::progress :max="$total" legend>
    <x-fltc::progress.segment :value="$read" color="green" label="Read" />
    <x-fltc::progress.segment :value="$reading" color="amber" label="Reading" />
</x-fltc::progress>

<x-fltc::progress variant="meter" label="Storage" :value="4.3" :max="5" unit="GB" />
```

- `value`, `max` (default 100), `color` (role or palette, default: slate), `size` (`sm`, `md`, `lg`)
- `label`; `showValue`: the percentage beside it
- Segments (`x-fltc::progress.segment value color label`) make a split bar, each `value` of
  the bar's `max`; `legend` lists them under the bar with a swatch and their value
- `variant="meter"`: label plus "used / limit" (with `unit`) above the bar; the fill turns
  `warningColor` (default amber) from `threshold` (fraction of max, default 0.8) and
  `dangerColor` (default red) at the limit and above

**Star rating** (`x-fltc::rating`): read-only stars, rounded to half stars. `value`, `max`
(default 5), `size` (`sm`, `md`, `lg`), `showValue` (the number after the stars), `color` (role or
palette, default base; filled stars use its tertiary shade), `label` (accessible name,
default "3.5 out of 5 stars"). For a picker see `x-fltc::form.rating` under Forms.

**Save status** (`x-fltc::status`): a chip for live / unsaved / saving / saved / error, each
with an icon and its own role colour (success, warning, info, success, danger). All five are rendered and
CSS shows the one named by `data-state`, so the app can switch it from Alpine without a
re-render:

```blade
<div x-data="{ status: 'saved' }" x-on:input.debounce="status = 'unsaved'">
    <x-fltc::status x-bind:data-state="status" />
</div>
```

- `state`: the initial state (default: `saved`)
- `color`: one colour for every state (e.g. `primary`) instead of the per-state roles
- `labels`, `colors`, `icons`: per-state overrides, e.g. `:labels="['error' => 'Offline']"`

**Empty state** (`x-fltc::empty`): an icon, a title and a line of text for an empty list or
search, with optional actions.

```blade
<x-fltc::empty icon="books" title="No stories yet" bordered>
    Start writing or import a manuscript.
    <x-slot:actions><x-fltc::button icon="plus">New story</x-fltc::button></x-slot:actions>
</x-fltc::empty>
```

- `icon` (Phosphor, default `tray`; empty for none), `title`
- `bordered`: dashed frame; `size`: `sm`, `md` (default), `lg`
- `color`: role or palette (default: base)
- Slots: default (the text), `actions`

### Toast Notifications

Components:
- `x-fltc::toast` — static single toast (Alpine-driven dismiss)
- `x-fltc::toast.container` — dynamic Alpine container; listens for `fltc:toast` events

**Static toast** (`x-fltc::toast`): renders a single, self-dismissing toast in-place.
- `color`: role or palette (default: `base`)
- `variant`: `simple` (pill, default), `card` (rounded box with separate description row), `baguette` (wide solid-fill horizontal bar)
- `message`: primary text (falls back to the default slot)
- `description`: optional secondary line
- `icon`: Phosphor icon class string (e.g. `ph ph-check-circle`)
- `duration`: auto-dismiss delay in milliseconds (`0` = no auto-dismiss, default `0`)
- `dismissible`: show/hide the close button (default `true`)

**Toast container** (`x-fltc::toast.container`): a fixed-position Alpine-powered container for dynamic toasts. Designed for use with `@persist` so toasts survive `wire:navigate` page loads.

Props:
- `position`: `top-left`, `top-center`, `top-right`, `bottom-left`, `bottom-center`, `bottom-right` (default: `bottom-right`)
- `color`: default colour applied to toasts that don't specify their own (default: `base`)
- `variant`: default variant for incoming toasts (default: `simple`)
- `duration`: default auto-dismiss delay in ms (default: `4000`)
- `width`: Tailwind width class for the container column (default: `w-80`; use `w-full max-w-2xl` for baguette-only setups)

**Placement in layout:**
```blade
@persist('fltc-toasts')
    <x-fltc::toast.container position="bottom-right" />
@endpersist
```

**Dispatching toasts:**
```blade
{{-- Alpine --}}
$dispatch('fltc:toast', { message: 'Saved!', color: 'success', variant: 'card', description: 'Changes persisted.' })

{{-- Livewire --}}
$this->dispatch('fltc:toast', message: 'Saved!', color: 'success')

{{-- Plain JS --}}
window.dispatchEvent(new CustomEvent('fltc:toast', { detail: { message: 'Saved!', icon: 'ph ph-check-circle' } }))
```

**Flux compatibility:** the container also listens for `flux:toast` events and maps Flux semantic variants to the matching roles (`success`, `warning`, `danger`, `info`; `default` → `base`).

**Variant visual guide:**
- `simple`: lightweight pill — good for brief confirmations
- `card`: bordered card with distinct title + description areas — good for richer messages
- `baguette`: wide, solid-filled horizontal bar — good for system-level notices or when you want high visual contrast

### Utility

Components:
- `x-fltc::buttongroup`
- `x-fltc::darkmode.toggle`
- `x-fltc::tooltip`
- `x-fltc::icon`
- `x-fltc::separator`
- `x-fltc::spinner`
- `x-fltc::segmented`
- `x-fltc::theme.script`
- `x-fltc::theme.picker`

**Segmented toggle** (`x-fltc::segmented` + `x-fltc::segmented.option`): a row of mutually
exclusive buttons, one active (`aria-pressed`) — view switches, filters. The dark-mode toggle
is built on it.

```blade
<x-fltc::segmented name="layout" value="card" wire:model.live="layout">
    <x-fltc::segmented.option value="card" icon="squares-four" label="Card" />
    <x-fltc::segmented.option value="list" icon="list" label="List" />
</x-fltc::segmented>
```

- The value is Alpine state and `x-modelable`: `x-model` / `wire:model` on the group bind it
- `value`: initially active option; `name`: posts the value through a hidden input
- `color`: role or palette (default: base), inherited by the options; `label`: accessible name
- `interactive` (default true): false renders the markup without Alpine, for your own script
- Option props: `value`, `label` (or the slot), `icon`, `iconVariant`, `disabled`

**Theme script** (`x-fltc::theme.script`): put it in `<head>`. Before the first paint it sets
`data-skin`, `data-theme` and a custom theme's `data-theme-<role>` palettes on `<html>` from
storage (the theme picker's choices) and the `dark` class from the light/dark/system mode the
dark-mode toggle stores, so the page never flashes the wrong look.
- `skinStorageKey` (default: `fltc-skin`), `themeStorageKey` (default: `fltc-theme`; the
  custom roles are stored under `<themeStorageKey>-custom`): match the picker's
- `skin`, `theme`: values to use when nothing is stored (default: none — keeps the
  server's attributes)
- `nonce`: for a Content Security Policy

**Theme picker** (`x-fltc::theme.picker`): a Skin select, a Theme select and the
light/dark/system control. Choosing a skin sets `data-skin` on `<html>` (the look of every
component); choosing a theme sets `data-theme` (re-colouring every role colour). With
`custom` among the themes, picking it shows one palette select per role, written as
`data-theme-<role>`. Each choice is saved and synced with other pickers on the page. The
mode part is `x-fltc::darkmode.toggle`, which owns that storage and the OS-following system
mode.
- `skins`: skin names, or name => label (default: default, cyberpunk, fantasy, wh40k)
- `themes`: theme names, or name => label (default: every shipped theme plus `custom`)
- `palettes`: the palettes offered per role for `custom` (default: every Tailwind palette)
- An empty `skins` or `themes` list hides that select
- `skinStorageKey` (default: `fltc-skin`), `themeStorageKey` (default: `fltc-theme`)
- `defaultSkin`, `defaultTheme`: when nothing is stored (default: the first option)
- `color`: its own chrome (default: base)
- `mode` (default true): show the light/dark/system control
- `stacked`: one above the other (e.g. in a drawer); `skinLabel`, `themeLabel`, `modeLabel`

**Spinner** (`x-fltc::spinner`): an animated loading indicator (SVG, `role="status"`).
Attributes pass through, so it pairs with Livewire's loading states:

```blade
<x-fltc::button wire:click="save">
    <x-fltc::spinner color="current" size="sm" class="mr-2" wire:loading wire:target="save" />
    Save
</x-fltc::button>
```

- `color`: role or palette (default: slate; tertiary content shade), or `current` to take the
  surrounding text colour (inside buttons)
- `size`: `xs`, `sm`, `md` (default), `lg`, `xl`
- `label`: accessible name (default: `__('Loading')`)

**Separator** (`x-fltc::separator`): a thin divider rule.
- `vertical`: render a vertical rule instead of horizontal (default: false)
- `variant`: `default` or `subtle` (lighter border)
- `class`: extra classes (e.g. `my-4`, `md:hidden`)

**Icon** (`x-fltc::icon`): renders a single [Phosphor](https://phosphoricons.com) webfont glyph
as an `<i>` element. The host app must load the Phosphor icon stylesheet. This is the
canonical way to render an icon — prefer it over hand-written `<i class="ph …">` markup,
and most components that take an `icon` prop render it through this component.

Props:
- `name`: the Phosphor icon identifier (e.g. `user`, `caret-right`). A full class string
  (`ph ph-user`) is also accepted and rendered verbatim, so props that pass a complete icon
  class keep working
- `variant`: Phosphor weight — `thin`, `light`, `regular`, `bold`, `fill`/`solid`, or
  `duotone` (default: `regular`, the base `ph` weight). The non-regular weights are opt-in
  and require the host app to load that weight's Phosphor CSS. Ignored when `name` is a full class string
- `color`: role or palette; applies the tertiary-content icon shade
  (`text-{c}-500 dark:text-{c}-400`). Omit to inherit the surrounding text colour
  (`currentColor`). `color` is accepted as an alias
- `size`: Tailwind text-size token sans prefix (e.g. `sm`, `lg`, `2xl`) — Phosphor glyphs
  scale with font size
- `before` / `after`: logical margin before / after the glyph (e.g. `2` → `ms-2` / `me-2`),
  for spacing the icon next to adjacent text
- `align`: vertical-align token (e.g. `middle`, `text-bottom`)
- `class`, `id`, `wire:*`, `data-*`: pass through and merge onto the `<i>` as usual.
  `aria-hidden="true"` is applied by default and can be overridden

**Tooltip** props:
- `text`: tooltip body content
- `color`: role or palette (default: base)
- `class`: extra wrapper classes

Use tooltip for short helper text around interactive elements. Keep content brief and non-essential.

**Dark mode toggle** (`x-fltc::darkmode.toggle`): switches the document between light and
dark by toggling the `dark` class on `<html>`. The chosen preference is persisted in
`localStorage` under the `color` key as `light`, `dark`, or `system`; a missing value is
treated as `system`, so the OS setting (`prefers-color-scheme`) is the default. While in
`system` mode the toggle follows live OS changes. All instances on the page stay in sync,
and state is re-applied after `livewire:navigated`. Two variants:
- `variant="default"` (default): a three-button segmented control — **Light**, **Dark**,
  **System** — with the active segment highlighted.
  - `color`: accent colour of the whole control — the track background plus the active
    segment fill and the muted/hover text of the inactive segments (role or palette, default
    `base`)
- `variant="toggle"`: the classic pill switch, built on the
  `x-fltc::form.checkbox` toggle (checked = dark). Forwards:
  - `color`: track colour while dark/on (role or palette, default `slate`)
  - `colorOff`: track colour while light/off (role or palette, default `slate`)
  - `size`: `sm`, `md` (default), or `lg`