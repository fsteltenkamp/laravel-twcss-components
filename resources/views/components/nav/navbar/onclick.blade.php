<a onclick="{{ $onclick }}" {{ $attributes->merge(['class' => $classList]) }}>
    {{ $slot }}
</a>
