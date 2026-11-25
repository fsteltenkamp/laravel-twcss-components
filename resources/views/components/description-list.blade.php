<dl {{ $attributes->class([$classList]) }}>
    @foreach ($rows as $row)
        <x-fltc::description-list.item :label="$row['label']" :icon="$row['icon']">{{ $row['value'] }}</x-fltc::description-list.item>
    @endforeach
    {{ $slot }}
</dl>
