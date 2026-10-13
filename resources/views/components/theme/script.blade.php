@props([
    'skinStorageKey' => 'fltc-skin',
    'themeStorageKey' => 'fltc-theme',
    'skin' => null,
    'theme' => null,
    'nonce' => null,
])
{{--
    Put in <head>, before the stylesheets: restores the skin and theme picked with
    x-fltc::theme.picker (data-skin / data-theme on <html>, plus the custom theme's
    data-theme-<role> palettes) and the light/dark/system mode shared by
    x-fltc::darkmode.toggle (the `dark` class) before the first paint, so the page never
    flashes the wrong look. `skin` and `theme` apply when nothing is stored yet.
--}}
<script @if ($nonce) nonce="{{ $nonce }}" @endif>
(function () {
    var root = document.documentElement;
    try {
        var skin = localStorage.getItem(@js($skinStorageKey)) || @js($skin);
        if (skin) root.setAttribute('data-skin', skin);
        var theme = localStorage.getItem(@js($themeStorageKey)) || @js($theme);
        if (theme) root.setAttribute('data-theme', theme);
        var roles = JSON.parse(localStorage.getItem(@js($themeStorageKey.'-custom')) || '{}');
        for (var role in roles) {
            if (/^[a-z]+$/.test(role) && /^[a-z]+$/.test(roles[role])) root.setAttribute('data-theme-' + role, roles[role]);
        }
    } catch (e) {}
    var mode = 'system';
    try { mode = localStorage.getItem('theme') || 'system'; } catch (e) {}
    var dark = mode === 'dark' || (mode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
    root.classList.toggle('dark', dark);
})();
</script>
