@if ($variant === 'inline')
    <span
        x-data="{ shown: false, peek: false }"
        @if ($reveal === 'hover')
            x-on:mouseenter="peek = true"
            x-on:mouseleave="peek = false"
            x-on:focus="peek = true"
            x-on:blur="peek = false"
        @endif
        x-on:click="shown = true"
        x-on:keydown.enter.prevent="shown = true"
        x-on:keydown.space.prevent="shown = true"
        role="button"
        tabindex="0"
        aria-label="{{ __('Spoiler') }}"
        aria-expanded="false"
        x-bind:aria-expanded="shown || peek"
        x-bind:data-revealed="shown || peek"
        x-bind:class="{ [@js($hiddenClasses)]: ! (shown || peek), [@js($shownClasses)]: shown || peek }"
        data-revealed="false"
        {{ $attributes->class([$classList, $hiddenClasses]) }}
    >{{ $slot }}</span>
@else
    <div x-data="{ shown: false, reveal() { this.shown = true } }" x-bind:data-revealed="shown" data-revealed="false" {{ $attributes->class([$classList]) }}>
        <div
            class="fltc-spoiler-content transition duration-300 {{ $hiddenClasses }}"
            x-bind:class="{ [@js($hiddenClasses)]: ! shown }"
            x-bind:aria-hidden="! shown"
            aria-hidden="true"
        >{{ $slot }}</div>

        <div class="fltc-spoiler-overlay {{ $overlayClasses }}" x-show="! shown" x-transition.opacity>
            <p class="fltc-spoiler-title font-semibold {{ $messageClasses }}">{{ $title }}</p>
            @isset($message)
                <div class="fltc-spoiler-message {{ $messageClasses }}">{{ $message }}</div>
            @endisset
            @if (isset($button) && $button instanceof \Illuminate\View\ComponentSlot)
                {{ $button }}
            @else
                <x-fltc::button :color="$color" icon="eye" x-on:click="reveal()">{{ $buttonLabel }}</x-fltc::button>
            @endif
        </div>
    </div>
@endif
