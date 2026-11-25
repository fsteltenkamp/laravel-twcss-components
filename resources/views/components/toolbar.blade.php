<div {{ $attributes->class([$classList])->merge(['role' => 'toolbar', 'data-fltc-toolbar-button-class' => $buttonClassList] + ($label !== '' ? ['aria-label' => $label] : [])) }}>
    {{ $slot }}
</div>
