#!/usr/bin/env python3
"""
Generates the colour stylesheets of fsteltenkamp/laravel-twcss-components:

    resources/css/themes.css   runtime theme variables (plain CSS, data-theme)
    resources/css/colors.css   the eight role colours for Tailwind v4 (@theme)
    resources/js/colors.js     the same for Tailwind v3 (tailwind.config.js)

Run it after changing a theme below:  python3 tools/themes.py

A theme gives each of the eight roles an 11-shade scale. Scales are built in OKLCH
from anchor colours: anchors land exactly on their shade (by convention the
light-mode accent on 600 and the dark-mode accent on 400, which is where the
components and skins read them), shades between anchors are interpolated, and
shades beyond them follow Tailwind's lightness ladder.
"""
import math
import os

ROLES = ['primary', 'secondary', 'accent', 'base', 'info', 'success', 'warning', 'danger']
SHADES = [50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950]

# Tailwind v3.4 palettes (the extended neutrals taupe/mauve/mist/olive included).
TAILWIND = {
    'slate'   : ['#f8fafc', '#f1f5f9', '#e2e8f0', '#cbd5e1', '#94a3b8', '#64748b', '#475569', '#334155', '#1e293b', '#0f172a', '#020617'],
    'gray'    : ['#f9fafb', '#f3f4f6', '#e5e7eb', '#d1d5db', '#9ca3af', '#6b7280', '#4b5563', '#374151', '#1f2937', '#111827', '#030712'],
    'zinc'    : ['#fafafa', '#f4f4f5', '#e4e4e7', '#d4d4d8', '#a1a1aa', '#71717a', '#52525b', '#3f3f46', '#27272a', '#18181b', '#09090b'],
    'neutral' : ['#fafafa', '#f5f5f5', '#e5e5e5', '#d4d4d4', '#a3a3a3', '#737373', '#525252', '#404040', '#262626', '#171717', '#0a0a0a'],
    'stone'   : ['#fafaf9', '#f5f5f4', '#e7e5e4', '#d6d3d1', '#a8a29e', '#78716c', '#57534e', '#44403c', '#292524', '#1c1917', '#0c0a09'],
    'taupe'   : ['#faf9f7', '#f2efea', '#e4ded4', '#d0c6b6', '#b3a48d', '#9c8a70', '#87765d', '#6f604d', '#5c5042', '#4d443a', '#29231d'],
    'mauve'   : ['#faf8fb', '#f3eef5', '#e7dded', '#d4c2dc', '#b99dc7', '#9f7bb0', '#875f97', '#6f4c7b', '#5d4166', '#4e3955', '#2f2034'],
    'mist'    : ['#f5f8fa', '#e9eff4', '#d4e0e9', '#b2c8d8', '#89aac1', '#6a8eab', '#557591', '#465f76', '#3d5063', '#364553', '#232d37'],
    'olive'   : ['#f8f9f3', '#eef1e3', '#dce2c8', '#c2cd9f', '#a6b574', '#8a9a54', '#6c7c40', '#545f34', '#454e2e', '#3c432b', '#1f2414'],
    'red'     : ['#fef2f2', '#fee2e2', '#fecaca', '#fca5a5', '#f87171', '#ef4444', '#dc2626', '#b91c1c', '#991b1b', '#7f1d1d', '#450a0a'],
    'orange'  : ['#fff7ed', '#ffedd5', '#fed7aa', '#fdba74', '#fb923c', '#f97316', '#ea580c', '#c2410c', '#9a3412', '#7c2d12', '#431407'],
    'amber'   : ['#fffbeb', '#fef3c7', '#fde68a', '#fcd34d', '#fbbf24', '#f59e0b', '#d97706', '#b45309', '#92400e', '#78350f', '#451a03'],
    'yellow'  : ['#fefce8', '#fef9c3', '#fef08a', '#fde047', '#facc15', '#eab308', '#ca8a04', '#a16207', '#854d0e', '#713f12', '#422006'],
    'lime'    : ['#f7fee7', '#ecfccb', '#d9f99d', '#bef264', '#a3e635', '#84cc16', '#65a30d', '#4d7c0f', '#3f6212', '#365314', '#1a2e05'],
    'green'   : ['#f0fdf4', '#dcfce7', '#bbf7d0', '#86efac', '#4ade80', '#22c55e', '#16a34a', '#15803d', '#166534', '#14532d', '#052e16'],
    'emerald' : ['#ecfdf5', '#d1fae5', '#a7f3d0', '#6ee7b7', '#34d399', '#10b981', '#059669', '#047857', '#065f46', '#064e3b', '#022c22'],
    'teal'    : ['#f0fdfa', '#ccfbf1', '#99f6e4', '#5eead4', '#2dd4bf', '#14b8a6', '#0d9488', '#0f766e', '#115e59', '#134e4a', '#042f2e'],
    'cyan'    : ['#ecfeff', '#cffafe', '#a5f3fc', '#67e8f9', '#22d3ee', '#06b6d4', '#0891b2', '#0e7490', '#155e75', '#164e63', '#083344'],
    'sky'     : ['#f0f9ff', '#e0f2fe', '#bae6fd', '#7dd3fc', '#38bdf8', '#0ea5e9', '#0284c7', '#0369a1', '#075985', '#0c4a6e', '#082f49'],
    'blue'    : ['#eff6ff', '#dbeafe', '#bfdbfe', '#93c5fd', '#60a5fa', '#3b82f6', '#2563eb', '#1d4ed8', '#1e40af', '#1e3a8a', '#172554'],
    'indigo'  : ['#eef2ff', '#e0e7ff', '#c7d2fe', '#a5b4fc', '#818cf8', '#6366f1', '#4f46e5', '#4338ca', '#3730a3', '#312e81', '#1e1b4b'],
    'violet'  : ['#f5f3ff', '#ede9fe', '#ddd6fe', '#c4b5fd', '#a78bfa', '#8b5cf6', '#7c3aed', '#6d28d9', '#5b21b6', '#4c1d95', '#2e1065'],
    'purple'  : ['#faf5ff', '#f3e8ff', '#e9d5ff', '#d8b4fe', '#c084fc', '#a855f7', '#9333ea', '#7e22ce', '#6b21a8', '#581c87', '#3b0764'],
    'fuchsia' : ['#fdf4ff', '#fae8ff', '#f5d0fe', '#f0abfc', '#e879f9', '#d946ef', '#c026d3', '#a21caf', '#86198f', '#701a75', '#4a044e'],
    'pink'    : ['#fdf2f8', '#fce7f3', '#fbcfe8', '#f9a8d4', '#f472b6', '#ec4899', '#db2777', '#be185d', '#9d174d', '#831843', '#500724'],
    'rose'    : ['#fff1f2', '#ffe4e6', '#fecdd3', '#fda4af', '#fb7185', '#f43f5e', '#e11d48', '#be123c', '#9f1239', '#881337', '#4c0519'],
}

# The default theme maps roles onto Tailwind palettes.
DEFAULT = {
    'primary': 'blue', 'secondary': 'violet', 'accent': 'teal', 'base': 'slate',
    'info': 'sky', 'success': 'green', 'warning': 'amber', 'danger': 'red',
}

# Named themes: role -> {shade: hex} anchors. `base` is the surfaces-and-text scale:
# 50/950 page, 100/900 surface and primary text, 300/700 secondary text (light/dark
# mode pairs, see the README "Color shades"), so its anchors are set shade by shade.
THEMES = {
    'cyberpunk': {
        'base': dict(zip(SHADES, ['#f6f2fb', '#d8fbff', '#82fdf9', '#00fff0', '#ff2bd6', '#e216b2', '#c4008f', '#00707c', '#053b4a', '#0a0618', '#04020a'])),
        'primary': {400: '#ff2bd6', 600: '#c4008f'},
        'secondary': {300: '#00fff0', 700: '#00707c'},
        'accent': {400: '#9d00ff', 600: '#7a1fd0'},
        'info': {400: '#00b4ff', 600: '#0072b8'},
        'success': {400: '#00ff9f', 600: '#00a868'},
        'warning': {400: '#fcee0a', 600: '#a89a00'},
        'danger': {400: '#ff3b3b', 600: '#d31c1c'},
    },
    'fantasy': {
        'base': dict(zip(SHADES, ['#f0e6cf', '#f3e9cf', '#eee2c2', '#e6d7ae', '#d98e32', '#b27422', '#8a5a12', '#503c1e', '#3a2b16', '#241a0e', '#140f08'])),
        'primary': {400: '#d98e32', 600: '#8a5a12'},
        'secondary': {400: '#7fb069', 600: '#3f6b2e'},
        'accent': {400: '#b07fe0', 600: '#6b3fa0'},
        'info': {400: '#6fa3d6', 600: '#2f5f8a'},
        'success': {400: '#8cc061', 600: '#4a7c2a'},
        'warning': {400: '#f2c94c', 600: '#a8761a'},
        'danger': {400: '#e0604f', 600: '#9b2c22'},
    },
    'wh40k': {
        'base': dict(zip(SHADES, ['#e7e3d7', '#ded7c2', '#d6cfba', '#c9c2ad', '#bf2a1f', '#a7241a', '#8f1d14', '#3a3630', '#282626', '#17171b', '#0b0b0d'])),
        'primary': {400: '#bf2a1f', 600: '#8f1d14'},
        'secondary': {400: '#c9a227', 600: '#7a5f16'},
        'accent': {400: '#4f74d0', 600: '#1f3f8f'},
        'info': {400: '#6d9fd0', 600: '#2b5c8a'},
        'success': {400: '#7fa860', 600: '#3f6a2a'},
        'warning': {400: '#e0a030', 600: '#a36a12'},
        'danger': {400: '#e04b3a', 600: '#b3261b'},
    },
    # Dracula for dark mode, its official light variant (Alucard) for light mode.
    'dracula': {
        'base': {50: '#fffbeb', 100: '#f8f8f2', 300: '#c8cad8', 500: '#6272a4', 700: '#44475a', 800: '#343746', 900: '#282a36', 950: '#21222c'},
        'primary': {400: '#bd93f9', 600: '#644ac9'},
        'secondary': {400: '#ff79c6', 600: '#a3144d'},
        'accent': {400: '#8be9fd', 600: '#036a96'},
        'info': {400: '#8be9fd', 600: '#036a96'},
        'success': {400: '#50fa7b', 600: '#14710a'},
        'warning': {400: '#ffb86c', 600: '#a34d14'},
        'danger': {400: '#ff5555', 600: '#cb3a2a'},
    },
    'nord': {
        'base': {50: '#eceff4', 100: '#e5e9f0', 200: '#d8dee9', 300: '#b8c2d3', 700: '#4c566a', 800: '#3b4252', 900: '#2e3440', 950: '#242933'},
        'primary': {400: '#81a1c1', 600: '#5e81ac'},
        'secondary': {400: '#88c0d0', 600: '#4c8a9c'},
        'accent': {400: '#b48ead', 600: '#8a6383'},
        'info': {400: '#8fbcbb', 600: '#4f8a89'},
        'success': {400: '#a3be8c', 600: '#6f8f55'},
        'warning': {400: '#ebcb8b', 600: '#b08a3c'},
        'danger': {400: '#d08770', 600: '#bf616a'},
    },
    # Catppuccin Latte for light mode, Mocha for dark mode.
    'catppuccin': {
        'base': dict(zip(SHADES, ['#eff1f5', '#e6e9ef', '#dce0e8', '#bac2de', '#9399b2', '#7f849c', '#6c6f85', '#5c5f77', '#313244', '#1e1e2e', '#11111b'])),
        'primary': {400: '#cba6f7', 600: '#8839ef'},
        'secondary': {400: '#f5c2e7', 600: '#ea76cb'},
        'accent': {400: '#94e2d5', 600: '#179299'},
        'info': {400: '#74c7ec', 600: '#209fb5'},
        'success': {400: '#a6e3a1', 600: '#40a02b'},
        'warning': {400: '#f9e2af', 600: '#df8e1d'},
        'danger': {400: '#f38ba8', 600: '#d20f39'},
    },
    # Solarized uses the same accents in light and dark mode.
    'solarized': {
        'base': {50: '#fdf6e3', 100: '#eee8d5', 300: '#93a1a1', 400: '#839496', 500: '#657b83', 600: '#586e75', 900: '#073642', 950: '#002b36'},
        'primary': {500: '#268bd2'},
        'secondary': {500: '#6c71c4'},
        'accent': {500: '#d33682'},
        'info': {500: '#2aa198'},
        'success': {500: '#859900'},
        'warning': {500: '#b58900'},
        'danger': {500: '#dc322f'},
    },
    # Gruvbox: the light variant's faded accents on 600, the dark variant's bright ones on 400.
    'gruvbox': {
        'base': dict(zip(SHADES, ['#fbf1c7', '#ebdbb2', '#d5c4a1', '#bdae93', '#a89984', '#928374', '#7c6f64', '#665c54', '#504945', '#3c3836', '#282828'])),
        'primary': {400: '#fe8019', 600: '#af3a03'},
        'secondary': {400: '#8ec07c', 600: '#427b58'},
        'accent': {400: '#d3869b', 600: '#8f3f71'},
        'info': {400: '#83a598', 600: '#076678'},
        'success': {400: '#b8bb26', 600: '#79740e'},
        'warning': {400: '#fabd2f', 600: '#b57614'},
        'danger': {400: '#fb4934', 600: '#9d0006'},
    },
}

# ---- OKLCH -------------------------------------------------------------------

def _lin(c):
    return c / 12.92 if c <= 0.04045 else ((c + 0.055) / 1.055) ** 2.4

def _gam(c):
    return 12.92 * c if c <= 0.0031308 else 1.055 * c ** (1 / 2.4) - 0.055

def hex_to_oklab(h):
    r, g, b = (_lin(int(h[i:i + 2], 16) / 255) for i in (1, 3, 5))
    l = (0.4122214708 * r + 0.5363325363 * g + 0.0514459929 * b) ** (1 / 3)
    m = (0.2119034982 * r + 0.6806995451 * g + 0.1073969566 * b) ** (1 / 3)
    s = (0.0883024619 * r + 0.2817188376 * g + 0.6299787005 * b) ** (1 / 3)
    return (0.2104542553 * l + 0.7936177850 * m - 0.0040720468 * s,
            1.9779984951 * l - 2.4285922050 * m + 0.4505937099 * s,
            0.0259040371 * l + 0.7827717662 * m - 0.8086757660 * s)

def oklab_to_rgb(L, a, b):
    l = (L + 0.3963377774 * a + 0.2158037573 * b) ** 3
    m = (L - 0.1055613458 * a - 0.0638541728 * b) ** 3
    s = (L - 0.0894841775 * a - 1.2914855480 * b) ** 3
    return (4.0767416621 * l - 3.3077115913 * m + 0.2309699292 * s,
            -1.2684380046 * l + 2.6097574011 * m - 0.3413193965 * s,
            -0.0041960863 * l - 0.7034186147 * m + 1.7076147010 * s)

def lch_to_hex(L, C, h):
    """OKLCH to hex, lowering chroma until the colour fits sRGB."""
    lo, hi = 0.0, C
    for _ in range(30):
        rgb = oklab_to_rgb(L, hi * math.cos(h), hi * math.sin(h))
        if all(-1e-4 <= c <= 1 + 1e-4 for c in rgb):
            break
        mid = (lo + hi) / 2
        rgb = oklab_to_rgb(L, mid * math.cos(h), mid * math.sin(h))
        if all(-1e-4 <= c <= 1 + 1e-4 for c in rgb):
            lo = mid
        else:
            hi = mid
    rgb = oklab_to_rgb(L, (hi if hi == C else lo) * math.cos(h), (hi if hi == C else lo) * math.sin(h))
    return '#' + ''.join('%02x' % round(max(0, min(1, _gam(max(0, c)))) * 255) for c in rgb)

def to_lch(h):
    L, a, b = hex_to_oklab(h)
    return L, math.hypot(a, b), math.atan2(b, a)

# Tailwind's lightness ladder and relative chroma per shade.
LADDER = dict(zip(SHADES, [0.975, 0.94, 0.89, 0.81, 0.71, 0.63, 0.555, 0.49, 0.42, 0.37, 0.27]))
CHROMA = dict(zip(SHADES, [0.12, 0.25, 0.45, 0.7, 0.9, 1.0, 0.95, 0.85, 0.72, 0.6, 0.45]))

def scale(anchors):
    """11 hex shades from {shade: hex} anchors."""
    if len(anchors) == 1:
        (shade, hx), = anchors.items()
        L, C, h = to_lch(hx)
        nearest = min(SHADES, key=lambda s: abs(LADDER[s] - L))
        if nearest != shade:
            anchors = {nearest: hx}
    out = {}
    pins = sorted(anchors)
    for s in SHADES:
        if s in anchors:
            out[s] = anchors[s]
            continue
        lower = [p for p in pins if p < s]
        upper = [p for p in pins if p > s]
        if lower and upper:
            a, b = lower[-1], upper[0]
            t = (SHADES.index(s) - SHADES.index(a)) / (SHADES.index(b) - SHADES.index(a))
            la, lb = hex_to_oklab(anchors[a]), hex_to_oklab(anchors[b])
            L, A, B = (x + (y - x) * t for x, y in zip(la, lb))
            out[s] = lch_to_hex(L, math.hypot(A, B), math.atan2(B, A))
        else:
            p = lower[-1] if lower else upper[0]
            L, C, h = to_lch(anchors[p])
            if s < p:  # lighter than the anchor: stretch the ladder toward white
                L2 = L + (LADDER[s] - LADDER[p]) * (1 - L) / max(1e-6, 1 - LADDER[p])
            else:      # darker: scale the ladder toward black
                L2 = L * LADDER[s] / LADDER[p]
            out[s] = lch_to_hex(L2, C * CHROMA[s] / CHROMA[p], h)
    return [out[s] for s in SHADES]

def rgb(hx):
    return ' '.join(str(int(hx[i:i + 2], 16)) for i in (1, 3, 5))

# ---- output ------------------------------------------------------------------

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

def write(rel, text):
    path = os.path.join(ROOT, rel)
    os.makedirs(os.path.dirname(path), exist_ok=True)
    with open(path, 'w') as f:
        f.write(text)

def themes_css():
    out = ['''/*
 * Colour themes for fsteltenkamp/laravel-twcss-components. Generated by
 * tools/themes.py — edit the themes there, not here.
 *
 * A theme gives each of eight roles an 11-shade scale; components with
 * color="primary" (secondary, accent, base, info, success, warning, danger) use it:
 *     <html data-theme="dracula">       (whole page; also works on a region)
 * Without a data-theme the theme is `default`. data-theme="custom" builds a theme
 * from Tailwind palettes, one per role, chosen with data-theme-<role>:
 *     <html data-theme="custom" data-theme-primary="rose" data-theme-base="zinc">
 * Roles without a choice keep the default theme's palette.
 *
 * Values are space-separated RGB channels so opacity modifiers work in both
 * Tailwind v3 and v4. The Tailwind palettes are the v3.4 hex values; v4's oklch
 * palette differs from them very slightly. Import it next to colors.css (v4) or
 * colors.js (v3). The look (fonts, corners, glow) is separate: the skin, data-skin.
 */

/* Tailwind palettes, for the default and custom themes and for the skins. */
:root {''']
    for name, hexes in TAILWIND.items():
        out.append('    ' + ' '.join(f'--fltc-{name}-{s}: {rgb(h)};' for s, h in zip(SHADES, hexes)))
    out.append('}\n')
    out.append('/* default */\n:root,\n[data-theme="default"],\n[data-theme="custom"] {')
    for role in ROLES:
        out.append('    ' + ' '.join(f'--fltc-{role}-{s}: var(--fltc-{DEFAULT[role]}-{s});' for s in SHADES))
    out.append('}\n')
    for name, roles in THEMES.items():
        out.append(f'/* {name} */\n[data-theme="{name}"] {{')
        for role in ROLES:
            out.append('    ' + ' '.join(f'--fltc-{role}-{s}: {rgb(h)};' for s, h in zip(SHADES, scale(roles[role]))))
        out.append('}\n')
    out.append('/* custom: one Tailwind palette per role */')
    for role in ROLES:
        for name in TAILWIND:
            out.append(f'[data-theme="custom"][data-theme-{role}="{name}"] {{ '
                       + ' '.join(f'--fltc-{role}-{s}: var(--fltc-{name}-{s});' for s in SHADES) + ' }')
    return '\n'.join(out) + '\n'

def colors_css():
    out = ['''/*
 * The eight colour roles of fsteltenkamp/laravel-twcss-components for Tailwind v4.
 * Generated by tools/themes.py.
 *
 * Import after Tailwind, together with themes.css (which sets the values):
 *     @import '../../vendor/fsteltenkamp/laravel-twcss-components/resources/css/colors.css';
 *     @import '../../vendor/fsteltenkamp/laravel-twcss-components/resources/css/themes.css';
 * `inline` makes utilities read the variables where they are used, so a data-theme
 * on any element re-colours just that region.
 */
@theme inline {''']
    for role in ROLES:
        for s in SHADES:
            out.append(f'    --color-{role}-{s}: rgb(var(--fltc-{role}-{s}));')
    out.append('}')
    return '\n'.join(out) + '\n'

def colors_js():
    out = ['''// The eight colour roles of fsteltenkamp/laravel-twcss-components for Tailwind v3.
// Generated by tools/themes.py. Load resources/css/themes.css too (it sets the
// values). In tailwind.config.js:
//     const fltcColors = require('./vendor/fsteltenkamp/laravel-twcss-components/resources/js/colors.js');
//     theme: { extend: { colors: fltcColors } }
module.exports = {''']
    for role in ROLES:
        out.append(f'    {role}: {{ ' + ', '.join(f"{s}: 'rgb(var(--fltc-{role}-{s}) / <alpha-value>)'" for s in SHADES) + ' },')
    out.append('};')
    return '\n'.join(out) + '\n'

if __name__ == '__main__':
    write('resources/css/themes.css', themes_css())
    write('resources/css/colors.css', colors_css())
    write('resources/js/colors.js', colors_js())
