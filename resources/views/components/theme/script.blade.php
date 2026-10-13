@props([
    'skinStorageKey' => 'fltc-skin',
    'paletteStorageKey' => 'fltc-palette',
    'skin' => null,
    'palette' => null,
    'nonce' => null,
])
{{--
    Put in <head>, before the stylesheets: restores the skin and colour picked with
    x-fltc::theme.picker (data-skin / data-palette on <html>) and the light/dark/system
    mode shared by x-fltc::darkmode.toggle (the `dark` class) before the first paint, so
    the page never flashes the wrong look. `skin` and `palette` apply when nothing is
    stored yet.
--}}
<script @if ($nonce) nonce="{{ $nonce }}" @endif>
(function () {
    var root = document.documentElement;
    try {
        var skin = localStorage.getItem(@js($skinStorageKey)) || @js($skin);
        if (skin) root.setAttribute('data-skin', skin);
        var palette = localStorage.getItem(@js($paletteStorageKey)) || @js($palette);
        if (palette) root.setAttribute('data-palette', palette);
    } catch (e) {}
    var mode = 'system';
    try { mode = localStorage.getItem('theme') || 'system'; } catch (e) {}
    var dark = mode === 'dark' || (mode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
    root.classList.toggle('dark', dark);
})();
</script>
