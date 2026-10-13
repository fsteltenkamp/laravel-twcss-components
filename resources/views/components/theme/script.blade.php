@props([
    'storageKey' => 'fltc-skin',
    'skin' => null,
    'nonce' => null,
])
{{--
    Put in <head>, before the stylesheets: restores the theme picked with
    x-fltc::theme.picker (data-skin on <html>) and the light/dark/system mode shared by
    x-fltc::darkmode.toggle (the `dark` class) before the first paint, so the page never
    flashes the wrong theme. `skin` is the theme to use when nothing is stored yet.
--}}
<script @if ($nonce) nonce="{{ $nonce }}" @endif>
(function () {
    var root = document.documentElement;
    try {
        var skin = localStorage.getItem(@js($storageKey)) || @js($skin);
        if (skin) root.setAttribute('data-skin', skin);
    } catch (e) {}
    var mode = 'system';
    try { mode = localStorage.getItem('theme') || 'system'; } catch (e) {}
    var dark = mode === 'dark' || (mode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
    root.classList.toggle('dark', dark);
})();
</script>
