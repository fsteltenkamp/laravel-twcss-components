<div @if (filled($id)) id="{{ $id }}" @endif class="{{ $classList }}">
    {{ $slot }}
</div>
