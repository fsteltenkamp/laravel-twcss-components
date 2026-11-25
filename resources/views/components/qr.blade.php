<div {{ $attributes->class([$classList])->merge(['role' => 'img'] + ($label !== '' ? ['aria-label' => $label] : [])) }}>
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @else
        <x-fltc::spinner color="base" :label="__('Loading')" />
    @endif
</div>
