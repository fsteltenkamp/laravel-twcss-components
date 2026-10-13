<div @if (filled($id)) id="{{ $id }}" @endif {{ $attributes->class([$classList]) }}>
    {{ $slot }}
</div>
