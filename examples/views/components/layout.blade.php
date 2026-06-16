{{--
    Example page shell — a full, standalone HTML document.

    These examples are rendered to static `.html` files by tests/ExamplesTest.php
    and are meant to be opened directly in a browser, so the document pulls in the
    Tailwind Play CDN and the Phosphor icon font from public CDNs. The Play CDN is
    a prototyping tool (it compiles classes in the browser); a real host app would
    build its own CSS. The inline `tailwind.config` also defines the package's
    extended neutral palettes (taupe / mauve / mist / olive) so those themes render.
--}}
@props(['title' => 'Example', 'theme' => 'slate'])
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} · laravel-twcss-components</title>

    {{-- Apply the persisted dark-mode choice before first paint to avoid a flash.
         The key matches <x-fltc::darkmode.toggle>'s storage key ("isDarkmode"). --}}
    <script>
        if (localStorage.getItem('isDarkmode') === 'true') {
            document.documentElement.classList.add('dark');
        }
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
