// Custom theme palettes for fsteltenkamp/laravel-twcss-components (Tailwind v3).
// Same values as resources/css/themes.css — see that file for how the shades map
// onto the package's colour roles. `skin` is the palette selected at runtime through
// data-skin; it needs resources/css/skins.css loaded too. In tailwind.config.js:
//     const fltcThemes = require('./vendor/fsteltenkamp/laravel-twcss-components/resources/js/themes.js');
//     theme: { extend: { colors: fltcThemes } }
module.exports = {
    cyberpunk: { 50: '#f6f2fb', 100: '#d8fbff', 200: '#82fdf9', 300: '#00fff0', 400: '#ff2bd6', 500: '#e216b2', 600: '#c4008f', 700: '#00707c', 800: '#053b4a', 900: '#0a0618', 950: '#04020a' },
    fantasy:   { 50: '#f0e6cf', 100: '#f3e9cf', 200: '#eee2c2', 300: '#e6d7ae', 400: '#d98e32', 500: '#b27422', 600: '#8a5a12', 700: '#503c1e', 800: '#3a2b16', 900: '#241a0e', 950: '#140f08' },
    wh40k:     { 50: '#e7e3d7', 100: '#ded7c2', 200: '#d6cfba', 300: '#c9c2ad', 400: '#bf2a1f', 500: '#a7241a', 600: '#8f1d14', 700: '#3a3630', 800: '#282626', 900: '#17171b', 950: '#0b0b0d' },
    skin:      { 50: 'rgb(var(--fltc-skin-50) / <alpha-value>)', 100: 'rgb(var(--fltc-skin-100) / <alpha-value>)', 200: 'rgb(var(--fltc-skin-200) / <alpha-value>)', 300: 'rgb(var(--fltc-skin-300) / <alpha-value>)', 400: 'rgb(var(--fltc-skin-400) / <alpha-value>)', 500: 'rgb(var(--fltc-skin-500) / <alpha-value>)', 600: 'rgb(var(--fltc-skin-600) / <alpha-value>)', 700: 'rgb(var(--fltc-skin-700) / <alpha-value>)', 800: 'rgb(var(--fltc-skin-800) / <alpha-value>)', 900: 'rgb(var(--fltc-skin-900) / <alpha-value>)', 950: 'rgb(var(--fltc-skin-950) / <alpha-value>)' },
};
