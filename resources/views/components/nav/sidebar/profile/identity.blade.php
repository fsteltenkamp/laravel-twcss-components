<span class="{{ $avatarClass }}">
    @if ($avatar)
        <img src="{{ $avatar }}" alt="{{ $name }}" class="h-full w-full object-cover">
    @else
        {{ $initials }}
    @endif
</span>

<span class="min-w-0 flex-1 text-left">
    <span class="block truncate text-sm font-medium">{{ $name }}</span>
    @if ($email)
        <span class="block truncate text-xs opacity-70">{{ $email }}</span>
    @endif
</span>
