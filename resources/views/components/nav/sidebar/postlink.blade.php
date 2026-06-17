@props(['action', 'icon' => null])

<form method="POST" action="{{ $action }}" class="contents">
    @csrf
    <button
        type="submit"
        {{ $attributes->merge(['class' => $classList]) }}
    >
        @if ($icon)
            <x-fltc::icon :name="$icon" class="shrink-0 text-base" />
        @endif

        <span class="min-w-0 flex-1 truncate text-left">{{ $slot }}</span>

        @isset($trailing)
            <span class="ml-auto shrink-0">{{ $trailing }}</span>
        @endisset
    </button>
</form>
