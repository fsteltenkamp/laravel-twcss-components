@php
    $resolvedMessage = $message ?: (isset($slot) ? $slot->toHtml() : '');
@endphp
<div
    x-data="{
        visible: true,
        timer: null,
        init() {
            if ({{ $duration }} > 0) {
                this.timer = setTimeout(() => { this.visible = false; }, {{ $duration }});
            }
        },
        dismiss() {
            clearTimeout(this.timer);
            this.visible = false;
        }
    }"
    x-show="visible"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 translate-y-1"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-1"
    role="alert"
    aria-live="polite"
    style="display: none;"
>
    @if ($variant === 'card')
        {{-- Card: rounded box with separate title + description rows --}}
        <div {{ $attributes->class([$classList, 'rounded-xl p-4']) }}>
            <div class="flex items-start gap-3">
                @if ($icon)
                    <x-fltc::icon :name="$icon" :class="$iconClasses . ' mt-0.5 text-lg shrink-0'" aria-hidden="true" />
                @endif
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium leading-snug">{!! $resolvedMessage !!}</p>
                    @if ($description)
                        <p class="mt-1 text-xs leading-relaxed {{ $descClasses }}">{{ $description }}</p>
                    @endif
                </div>
                @if ($dismissible)
                    <button
                        x-on:click="dismiss()"
                        class="{{ $closeClasses }} -mr-0.5 -mt-0.5 rounded p-0.5 focus:outline-none focus:ring-2 focus:ring-current"
                        aria-label="{{ __('Dismiss') }}"
                    >
                        <x-fltc::icon name="x" size="sm" aria-hidden="true" />
                    </button>
                @endif
            </div>
        </div>

    @elseif ($variant === 'baguette')
        {{-- Baguette: wide solid-fill horizontal bar --}}
        <div {{ $attributes->class([$classList, 'flex w-full items-center gap-4 rounded-lg px-4 py-3 text-sm']) }}>
            @if ($icon)
                <x-fltc::icon :name="$icon" :class="$iconClasses . ' text-lg shrink-0'" aria-hidden="true" />
            @endif
            <div class="flex min-w-0 flex-1 items-baseline gap-2">
                <span class="font-medium">{!! $resolvedMessage !!}</span>
                @if ($description)
                    <span class="truncate text-xs {{ $descClasses }}">{{ $description }}</span>
                @endif
            </div>
            @if ($dismissible)
                <button
                    x-on:click="dismiss()"
                    class="{{ $closeClasses }} shrink-0 rounded p-0.5 focus:outline-none focus:ring-2 focus:ring-white/50"
                    aria-label="{{ __('Dismiss') }}"
                >
                    <x-fltc::icon name="x" size="sm" aria-hidden="true" />
                </button>
            @endif
        </div>

    @else
        {{-- Simple (default): lightweight pill --}}
        <div {{ $attributes->class([$classList, 'flex items-center gap-2.5 rounded-full px-4 py-2 text-sm']) }}>
            @if ($icon)
                <x-fltc::icon :name="$icon" :class="$iconClasses . ' shrink-0'" aria-hidden="true" />
            @endif
            <span class="min-w-0 flex-1 font-medium leading-snug">{!! $resolvedMessage !!}</span>
            @if ($description)
                <span class="shrink-0 text-xs {{ $descClasses }}">{{ $description }}</span>
            @endif
            @if ($dismissible)
                <button
                    x-on:click="dismiss()"
                    class="{{ $closeClasses }} shrink-0 rounded-full p-0.5 focus:outline-none focus:ring-2 focus:ring-current"
                    aria-label="{{ __('Dismiss') }}"
                >
                    <x-fltc::icon name="x" size="sm" aria-hidden="true" />
                </button>
            @endif
        </div>
    @endif
</div>
