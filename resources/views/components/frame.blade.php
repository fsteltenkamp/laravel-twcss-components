@php
    $frameAttributes = fn (string $src) => trim(implode(' ', array_filter([
        $src !== '' ? 'src="'.e($src).'"' : null,
        $srcdoc !== '' && $src === '' ? 'srcdoc="'.e($srcdoc).'"' : null,
        $sandbox !== null ? 'sandbox="'.e($sandbox).'"' : null,
        'title="'.e($title).'"',
    ])));
@endphp
<div {{ $attributes->class([$classList])->merge(['style' => $heightStyle]) }} x-data="{ loading: true }">
    <div class="fltc-frame-loading absolute inset-0 flex items-center justify-center" x-show="loading" x-transition.opacity>
        <x-fltc::spinner :color="$color" />
    </div>
    @if ($srcDark !== '')
        <iframe {!! $frameAttributes($src) !!} loading="lazy" class="fltc-frame-document h-full w-full dark:hidden" x-on:load="loading = false"></iframe>
        <iframe {!! $frameAttributes($srcDark) !!} loading="lazy" class="fltc-frame-document hidden h-full w-full dark:block" x-on:load="loading = false"></iframe>
    @else
        <iframe {!! $frameAttributes($src) !!} class="fltc-frame-document h-full w-full" x-on:load="loading = false"></iframe>
    @endif
</div>
