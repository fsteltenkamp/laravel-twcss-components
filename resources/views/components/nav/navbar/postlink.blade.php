@props(['action'])

<form method="POST" action="{{ $action }}" class="contents">
    @csrf
    <button
        type="submit"
        {{ $attributes->merge(['class' => $classList]) }}
    >
        {{ $slot }}
    </button>
</form>
