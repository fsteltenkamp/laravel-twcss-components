@php
    $resolvedTitle = $title ?: (isset($slot) ? $slot->toHtml() : '');
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
        {{-- Card: proper header with title + body with message --}}
        <div {{ $attributes->class([$classList, 'fltc-toast-'.$variant, 'rounded-xl overflow-hidden']) }}>
            <div class="flex items-center gap-2.5 px-4 py-2.5 border-b {{ $borderClasses }}">
                @if ($icon)
                    <x-fltc::icon :name="$icon" :class="'fltc-toast-icon ' . $iconClasses . ' shrink-0'" aria-hidden="true" />
                @endif
                <p class="fltc-toast-title flex-1 text-sm font-semibold leading-snug">{!! $resolvedTitle !!}</p>
                @if ($dismissible)
                    <button
                        x-on:click="dismiss()"
                        class="fltc-toast-close {{ $closeClasses }} -mr-0.5 rounded p-0.5 focus:outline-none focus:ring-2 focus:ring-current"
                        aria-label="{{ __('Dismiss') }}"
                    >
                        <x-fltc::icon name="x" size="sm" aria-hidden="true" />
                    </button>
                @endif
            </div>
            @if ($message)
                <div class="fltc-toast-message px-4 py-3 text-sm leading-relaxed {{ $descClasses }}">{!! $message !!}</div>
            @endif
        </div>

    @elseif ($variant === 'baguette')
        {{-- Baguette: centered ~80% wide solid-fill banner --}}
        <div {{ $attributes->class([$classList, 'fltc-toast-'.$variant, 'mx-auto flex w-4/5 items-center gap-4 rounded-xl px-6 py-3.5 text-sm']) }}>
            @if ($icon)
                <x-fltc::icon :name="$icon" :class="'fltc-toast-icon ' . $iconClasses . ' text-lg shrink-0'" aria-hidden="true" />
            @endif
            <div class="flex min-w-0 flex-1 items-baseline gap-2">
                <span class="fltc-toast-title font-medium">{!! $resolvedTitle !!}</span>
                @if ($message)
                    <span class="fltc-toast-message truncate text-xs {{ $descClasses }}">{{ $message }}</span>
                @endif
            </div>
            @if ($dismissible)
                <button
                    x-on:click="dismiss()"
                    class="fltc-toast-close {{ $closeClasses }} shrink-0 rounded p-0.5 focus:outline-none focus:ring-2 focus:ring-current/50"
                    aria-label="{{ __('Dismiss') }}"
                >
                    <x-fltc::icon name="x" size="sm" aria-hidden="true" />
                </button>
            @endif
        </div>

    @elseif ($variant === 'toast')
        {{-- Toast (default): compact solid-fill horizontal bar --}}
        <div {{ $attributes->class([$classList, 'fltc-toast-'.$variant, 'flex w-full items-center gap-4 rounded-lg px-4 py-3 text-sm']) }}>
            @if ($icon)
                <x-fltc::icon :name="$icon" :class="'fltc-toast-icon ' . $iconClasses . ' text-lg shrink-0'" aria-hidden="true" />
            @endif
            <div class="flex min-w-0 flex-1 items-baseline gap-2">
                <span class="fltc-toast-title font-medium">{!! $resolvedTitle !!}</span>
                @if ($message)
                    <span class="fltc-toast-message truncate text-xs {{ $descClasses }}">{{ $message }}</span>
                @endif
            </div>
            @if ($dismissible)
                <button
                    x-on:click="dismiss()"
                    class="fltc-toast-close {{ $closeClasses }} shrink-0 rounded p-0.5 focus:outline-none focus:ring-2 focus:ring-current/50"
                    aria-label="{{ __('Dismiss') }}"
                >
                    <x-fltc::icon name="x" size="sm" aria-hidden="true" />
                </button>
            @endif
        </div>

    @else
        {{-- Pill: lightweight bordered pill --}}
        <div {{ $attributes->class([$classList, 'fltc-toast-'.$variant, 'flex items-center gap-2.5 rounded-full px-4 py-2 text-sm']) }}>
            @if ($icon)
                <x-fltc::icon :name="$icon" :class="'fltc-toast-icon ' . $iconClasses . ' shrink-0'" aria-hidden="true" />
            @endif
            <span class="fltc-toast-title min-w-0 flex-1 font-medium leading-snug">{!! $resolvedTitle !!}</span>
            @if ($message)
                <span class="fltc-toast-message shrink-0 text-xs {{ $descClasses }}">{{ $message }}</span>
            @endif
            @if ($dismissible)
                <button
                    x-on:click="dismiss()"
                    class="fltc-toast-close {{ $closeClasses }} shrink-0 rounded-full p-0.5 focus:outline-none focus:ring-2 focus:ring-current"
                    aria-label="{{ __('Dismiss') }}"
                >
                    <x-fltc::icon name="x" size="sm" aria-hidden="true" />
                </button>
            @endif
        </div>
    @endif
</div>
