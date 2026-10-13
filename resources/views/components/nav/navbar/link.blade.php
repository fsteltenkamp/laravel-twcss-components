<a href="{{ $href }}" {{ $attributes->merge(['class' => $classList] + ($isActive ? ['aria-current' => 'page'] : [])) }}>
    {{ $slot }}
</a>
