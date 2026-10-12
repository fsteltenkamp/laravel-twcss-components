# Import plan: readar components

Goal: bring readar's reusable UI pieces into this library, so readar can be rebuilt
on top of it. App-specific features (editor, story systems, family tree, narration
player, reader-group admin) stay in the app and are built from these pieces.

Phases are ordered by dependency. Items marked *(independent)* can be pulled forward.

Out of scope: the line diff view, and the 18+ variant of the content gate (the app
builds it from the spoiler gate).

**Every component, every phase:**

- [ ] Class in `src/View/Components/…` + view at the mirrored path; `classList` (or
      placement-named `*Classes`) built in the class, `$attributes` on the root.
- [ ] All themes, custom themes included (`tests/CustomThemesTest.php` checks this);
      children inherit the parent theme via `@aware`.
- [ ] Render test in `tests/BladeRenderTest.php`, demo in `tests/GalleryTest.php`.
- [ ] Wiki entry in `wiki/components.md` (props, slots, usage).
- [ ] Anything interactive: a browser check in `gallery.html` by the user, with
      exactly what to click and what to look for.
- [ ] Alpine for behaviour where the library already uses it; no app-specific JS.

---

## Phase 0 — Custom themes ✅

- [x] `cyberpunk`, `fantasy`, `wh40k` palettes (`resources/css/themes.css`,
      `resources/js/themes.js`), an entry in every theme map, gallery showcase, tests.

## Phase 1 — Runtime theme switching

Readar switches theme in the browser, without a reload. The library's `theme` prop is
resolved on the server into literal classes like `bg-fantasy-400`, so switching it
needs either a reload or a palette that changes underneath the classes.

Proposal: a **`skin`** palette whose shades are CSS variables. Components rendered
with `theme="skin"` re-colour whenever `<html data-skin="…">` changes.

- [x] `skin` palette in `themes.css`/`themes.js`, one `[data-skin="<name>"]` block per
      theme in `resources/css/skins.css` (RGB channels, so opacity modifiers work in v3
      and v4).
- [x] `skin` entry in every theme map; the structural guard now checks every theme
      against `rose`, which also caught the accordion missing the extended neutrals.
- [x] Gallery: Theme dropdown in the header re-themes every demo; per-theme showcase removed.
- [x] Theme gaps found on the way: `text`, `form.label`, input icons, `counter` title and
      description, checklist track and checkbox label now follow their theme
      (`Support\Shades`); `card.rows` cells were always gray.
- [x] `x-fltc::container.page`: content column clear of drawer tabs and pinned drawers.
- [ ] `<x-fltc::theme.script />`: an inline `<head>` script that sets `data-skin` and the
      `dark` class from storage before the first paint, so the wrong theme never
      flashes (readar's `theme.js`).
- [ ] `<x-fltc::theme.picker>`: chooses a theme plus light/dark/auto. It shares storage
      and the auto mode (following the OS setting) with `darkmode.toggle`. Props:
      `themes` (list of names), `storageKey`, `theme` (its own chrome).
- [ ] Optional, decide during the phase: a **skin extras** stylesheet with fonts, corner
      rounding and glow per `data-skin`, applied through a few `fltc-*` hook classes.
      Without it the themes change colour only.

## Phase 2 — Primitives *(independent of Phase 1)*

- [ ] **Tabs:** `<x-fltc::tabs>` + `<x-fltc::tabs.tab name="…">` +
      `<x-fltc::tabs.panel name="…">`. Alpine state; optional `wire:model`/`x-model` for
      the active tab; `disabled` tabs; links instead of buttons when `href` is set.
- [ ] **Segmented toggle:** `<x-fltc::segmented>` + `.option value icon label`. One
      active option, `aria-pressed`, `x-model`/`wire:model` passthrough. Shares the
      look of `darkmode.toggle`'s button group; pull that markup into this component
      and have the toggle use it.
- [ ] **Chip:** extend `badge` instead of adding a component: `href`, `icon`,
      `variant="toggle"` (on/off state, `name`/`value` for forms), `removable` (✕
      button). Also fixes `badge` not rendering `$attributes`.
- [ ] **Chip cloud:** `<x-fltc::badge.cloud>` wrapping layout for tag/facet lists, with
      an optional count per chip.
- [ ] **Progress bar:** `<x-fltc::progress value max>` for a single bar;
      `<x-fltc::progress>` + `.segment value theme label` for a split bar; `legend`
      prop; `meter` variant (label + "used / limit", turns the warning theme at a
      threshold) for quotas.
- [ ] **Empty state:** `<x-fltc::empty icon title>` with a slot for actions.
- [ ] **Error panel:** `messagebox` variant (`variant="error"`) instead of a new
      component, if the existing messagebox covers it; otherwise its own component.

## Phase 3 — Form helpers and status

- [ ] **Settings section:** `<x-fltc::form.section title hint>`: a titled group of
      fields with hint text, readar's `settingsSection`.
- [ ] **Field wrapper:** `<x-fltc::form.field label note>` around any control. Check
      the existing inputs first: if they already render label and note, use this only
      for custom controls.
- [ ] **Star rating, display:** `<x-fltc::rating value="3.5" />`, half stars, `aria-label`.
- [ ] **Star rating, input:** `<x-fltc::form.rating name>`: click/keyboard picker,
      hidden input, `wire:model`.
- [ ] **Save-status chip:** `<x-fltc::status state="saving">` with states live /
      unsaved / saving / saved / error, each with an icon and theme; the state can be
      bound from Alpine (`x-bind:data-state`) so the app drives it without re-rendering.

## Phase 4 — Media *(needs Phase 2 and 3)*

- [ ] **Cover box:** `<x-fltc::cover src ratio="2/3" fallback="NO COVER">`: fixed
      aspect ratio, `object-cover`, placeholder when `src` is empty or fails to load,
      sizes `thumb`/`thumb-sm`.
- [ ] **Media card:** `<x-fltc::media-card layout="card|compact|list">` with slots
      `cover`, `title`, `meta`, `badges`, `footer`, `actions`. Builds on the cover box,
      chips, progress bar and rating. The card/compact/list switch is the segmented
      toggle from Phase 2.
- [ ] **Action bar:** `<x-fltc::action-bar sticky>`: a banner with title, text and an
      actions slot, `quiet` variant (readar's draft bar: "unpublished draft — publish /
      discard").

## Phase 5 — Reveal and context

- [ ] **Spoiler:** `<x-fltc::spoiler>`, inline. Hidden until hover or click; `reveal`
      prop `hover|click`; stays revealed after a click.
- [ ] **Spoiler gate:** `<x-fltc::spoiler variant="gate" title button>`, block-level.
      Content is blurred under an overlay with a message and a reveal button. Slots for
      the message and the button, so the app can build the 18+ gate by swapping them.
- [ ] **Info card:** `<x-fltc::infocard>` with `trigger` and `card` slots. Small
      floating preview on hover (pointer devices only); on tap/click the full card
      unfolds inline below the trigger. The card has title, icon, image, body, link
      and action slots.
- [ ] **Timeline:** `<x-fltc::timeline>` + `.item time title`: dots on a vertical
      line, a slot per entry for its content and link.

## Phase 6 — Files

- [ ] **File card:** `<x-fltc::file-card name href>` with a preview slot (image / text
      excerpt / icon by extension, chosen in the class) and an actions slot (open,
      edit, delete).
- [ ] **Upload control:** `<x-fltc::form.upload>`: button + drop zone, `accept`,
      `multiple`, works with a plain form and with `wire:model` (Livewire file
      uploads), shows the chosen file names.
