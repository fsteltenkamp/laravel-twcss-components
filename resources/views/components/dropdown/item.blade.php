@if ($tag === 'a')
    <a
        {{ $attributes->class([$classList]) }}
        href="{{ $disabled ? '#' : $href }}"
        role="menuitem"
        @if ($disabled) aria-disabled="true" tabindex="-1" @endif
    >
        @if ($icon !== '')<x-fltc::icon :name="$icon" :variant="$iconVariant" />@endif
        {{ $slot }}
    </a>
@elseif ($tag === 'form')
    <form method="POST" action="{{ $href }}" class="contents">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif
        <button {{ $attributes->class([$classList]) }} type="submit" role="menuitem" @disabled($disabled)>
            @if ($icon !== '')<x-fltc::icon :name="$icon" :variant="$iconVariant" />@endif
            {{ $slot }}
        </button>
    </form>
@else
    <button {{ $attributes->class([$classList]) }} type="button" role="menuitem" @disabled($disabled)>
        @if ($icon !== '')<x-fltc::icon :name="$icon" :variant="$iconVariant" />@endif
        {{ $slot }}
    </button>
@endif
