@props([
    'icon' => 'tray',
    'title' => '',
    'theme' => 'slate',
    'bordered' => false,
    'size' => 'md',
])
@php
    // Anonymous: `Empty` is a reserved word in PHP, so this cannot be a component class.
    // Colours come from the shared roles in Support\Shades (README "Color shades").
    $shades = \Fsteltenkamp\TwcssComponents\Support\Shades::class;

    $sizes = [
        'sm' => ['box' => 'px-4 py-6 gap-2', 'icon' => 'text-3xl', 'title' => 'text-sm'],
        'md' => ['box' => 'px-6 py-10 gap-3', 'icon' => 'text-5xl', 'title' => 'text-base'],
        'lg' => ['box' => 'px-8 py-16 gap-4', 'icon' => 'text-6xl', 'title' => 'text-lg'],
    ];
    $sizeSet = $sizes[$size] ?? $sizes['md'];

    $classList = trim(implode(' ', [
        'fltc-empty fltc-theme-'.$theme.' flex flex-col items-center justify-center text-center',
        $sizeSet['box'],
        $bordered ? 'rounded-xl border-2 border-dashed '.\Fsteltenkamp\TwcssComponents\Support\SidebarTheme::divider($theme) : '',
    ]));
@endphp
<div {{ $attributes->class([$classList]) }}>
    @if ($icon)
        <x-fltc::icon :name="$icon" @class(['fltc-empty-icon', $sizeSet['icon'], $shades::faint($theme)]) aria-hidden="true" />
    @endif
    @if ($title !== '')
        <p @class(['fltc-empty-title font-semibold', $sizeSet['title'], $shades::primary($theme)])>{{ $title }}</p>
    @endif
    @if ($slot->isNotEmpty())
        <div @class(['fltc-empty-text max-w-md text-sm', $shades::tertiary($theme)])>{{ $slot }}</div>
    @endif
    @isset($actions)
        <div class="fltc-empty-actions mt-2 flex flex-wrap items-center justify-center gap-2">{{ $actions }}</div>
    @endisset
</div>
