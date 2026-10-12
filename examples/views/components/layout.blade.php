{{--
    Example page shell — a full, standalone HTML document.

    These examples are rendered to static `.html` files by tests/ExamplesTest.php
    and are meant to be opened directly in a browser, so the document pulls in the
    Tailwind Play CDN and the Phosphor icon font from public CDNs. The Play CDN is
    a prototyping tool (it compiles classes in the browser); a real host app would
    build its own CSS. The inline `tailwind.config` also defines the package's
    extended neutral palettes (taupe / mauve / mist / olive) and the custom themes
    (cyberpunk / fantasy / wh40k) so those themes render.
--}}
@props(['title' => 'Example', 'theme' => 'slate'])
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} · laravel-twcss-components</title>

    {{-- Apply the persisted dark-mode choice before first paint to avoid a flash.
         The key matches <x-fltc::darkmode.toggle>'s storage key ("theme"), which
         stores "light", "dark", or "system" (missing = system = follow the OS). --}}
    <script>
        (function () {
            const pref = localStorage.getItem('theme') || 'system';
            const isDark = pref === 'dark'
                || (pref === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.classList.toggle('dark', isDark);
        })();
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        taupe: { 50: '#faf9f7', 100: '#f2efea', 200: '#e4ded4', 300: '#d0c6b6', 400: '#b3a48d', 500: '#9c8a70', 600: '#87765d', 700: '#6f604d', 800: '#5c5042', 900: '#4d443a', 950: '#29231d' },
                        mauve: { 50: '#faf8fb', 100: '#f3eef5', 200: '#e7dded', 300: '#d4c2dc', 400: '#b99dc7', 500: '#9f7bb0', 600: '#875f97', 700: '#6f4c7b', 800: '#5d4166', 900: '#4e3955', 950: '#2f2034' },
                        mist:  { 50: '#f5f8fa', 100: '#e9eff4', 200: '#d4e0e9', 300: '#b2c8d8', 400: '#89aac1', 500: '#6a8eab', 600: '#557591', 700: '#465f76', 800: '#3d5063', 900: '#364553', 950: '#232d37' },
                        olive: { 50: '#f8f9f3', 100: '#eef1e3', 200: '#dce2c8', 300: '#c2cd9f', 400: '#a6b574', 500: '#8a9a54', 600: '#6c7c40', 700: '#545f34', 800: '#454e2e', 900: '#3c432b', 950: '#1f2414' },
                        cyberpunk: { 50: '#f6f2fb', 100: '#d8fbff', 200: '#82fdf9', 300: '#00fff0', 400: '#ff2bd6', 500: '#e216b2', 600: '#c4008f', 700: '#00707c', 800: '#053b4a', 900: '#0a0618', 950: '#04020a' },
                        fantasy:   { 50: '#f0e6cf', 100: '#f3e9cf', 200: '#eee2c2', 300: '#e6d7ae', 400: '#d98e32', 500: '#b27422', 600: '#8a5a12', 700: '#503c1e', 800: '#3a2b16', 900: '#241a0e', 950: '#140f08' },
                        wh40k:     { 50: '#e7e3d7', 100: '#ded7c2', 200: '#d6cfba', 300: '#c9c2ad', 400: '#bf2a1f', 500: '#a7241a', 600: '#8f1d14', 700: '#3a3630', 800: '#282626', 900: '#17171b', 950: '#0b0b0d' },
                    },
                },
            },
        };
    </script>

    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/regular/style.css">
</head>
<x-fltc::body :theme="$theme">
    {{ $slot }}
</x-fltc::body>
</html>
