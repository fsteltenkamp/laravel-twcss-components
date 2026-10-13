<?php

use Fsteltenkamp\TwcssComponents\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

/*
 * The colours every component supports: the Tailwind palettes plus the eight theme
 * roles, and the themes resources/css/themes.css ships (tools/themes.py).
 */
const ROLES = ['primary', 'secondary', 'accent', 'base', 'info', 'success', 'warning', 'danger'];

const PALETTES = [
    'slate', 'gray', 'zinc', 'neutral', 'stone', 'red', 'orange', 'amber', 'yellow', 'lime',
    'green', 'emerald', 'teal', 'cyan', 'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia',
    'pink', 'rose', 'taupe', 'mauve', 'mist', 'olive',
];

const ALL_COLORS = [...PALETTES, ...ROLES];

const THEMES = ['default', 'cyberpunk', 'fantasy', 'wh40k', 'dracula', 'nord', 'catppuccin', 'solarized', 'gruvbox'];

const SHADES = [50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950];
