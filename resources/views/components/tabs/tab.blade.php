@php
    $tabId = $tabsId.'-tab-'.$name;
    $panelId = $tabsId.'-panel-'.$name;
@endphp

@if ($href !== '')
    <a
        {{ $attributes->class([$classList, $initiallyActive ? $activeClasses : $inactiveClasses]) }}
        href="{{ $disabled ? '#' : $href }}"
        role="tab"
        @if ($name !== '') id="{{ $tabId }}" @endif
        aria-selected="{{ $initiallyActive ? 'true' : 'false' }}"
        @if ($initiallyActive) aria-current="page" @endif
        @if ($disabled) aria-disabled="true" tabindex="-1" @endif
    >
        @if ($icon !== '')<x-fltc::icon :name="$icon" :variant="$iconVariant" />@endif
        {{ $slot }}
    </a>
@else
    <button
        {{ $attributes->class([$classList, $initiallyActive ? $activeClasses : $inactiveClasses]) }}
        type="button"
        role="tab"
        id="{{ $tabId }}"
        data-tab="{{ $name }}"
        aria-controls="{{ $panelId }}"
        aria-selected="{{ $initiallyActive ? 'true' : 'false' }}"
        x-on:click="active = @js($name)"
        x-bind:aria-selected="active === @js($name)"
        x-bind:tabindex="active === @js($name) ? 0 : -1"
        x-bind:class="{ [@js($activeClasses)]: active === @js($name), [@js($inactiveClasses)]: active !== @js($name) }"
        @disabled($disabled)
    >
        @if ($icon !== '')<x-fltc::icon :name="$icon" :variant="$iconVariant" />@endif
        {{ $slot }}
    </button>
@endif
