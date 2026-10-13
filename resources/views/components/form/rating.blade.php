@php($star = \Fsteltenkamp\TwcssComponents\View\Components\Rating::STAR_PATH)
<x-fltc::form.field :label="$label" :note="$note" :for="$id" :name="$name" :required="$required" :color="$color" :inline="$inline" :class="$wrapperClass">
    <div
        x-data="{
            value: @js($current),
            hover: 0,
            set(star) {
                if (@js($disabled)) return;
                this.value = @js($clearable) && this.value === star ? 0 : star;
            },
            step(delta) {
                if (@js($disabled)) return;
                this.value = Math.max(@js($clearable ? 0 : 1), Math.min(@js($max), this.value + delta));
                this.$nextTick(() => this.$refs['star' + Math.max(1, this.value)]?.focus());
            },
        }"
        x-modelable="value"
        @if ($model !== '')
            @if ($live) wire:model.live="{{ $model }}" @else wire:model="{{ $model }}" @endif
        @endif
        x-on:keydown.arrow-right.prevent="step(1)"
        x-on:keydown.arrow-up.prevent="step(1)"
        x-on:keydown.arrow-left.prevent="step(-1)"
        x-on:keydown.arrow-down.prevent="step(-1)"
        x-on:mouseleave="hover = 0"
        role="radiogroup"
        id="{{ $id }}"
        @if ($label !== '') aria-label="{{ $label }}" @endif
        @if ($required) aria-required="true" @endif
        {{ $attributes->class([$classList]) }}
    >
        @if ($name !== '')
            <input type="hidden" name="{{ $name }}" value="{{ $current ?: '' }}" x-bind:value="value || ''" />
        @endif
        @for ($i = 1; $i <= $max; $i++)
            <button
                type="button"
                role="radio"
                x-ref="star{{ $i }}"
                class="fltc-form-rating-star {{ $buttonClasses }} {{ $filledClasses }}"
                aria-label="{{ trans_choice(':count star|:count stars', $i) }}"
                aria-checked="{{ $current === $i ? 'true' : 'false' }}"
                tabindex="{{ $current === $i || ($current === 0 && $i === 1) ? 0 : -1 }}"
                x-bind:aria-checked="value === {{ $i }}"
                x-bind:tabindex="value === {{ $i }} || (value === 0 && {{ $i }} === 1) ? 0 : -1"
                x-on:click="set({{ $i }})"
                x-on:mouseenter="hover = {{ $i }}"
                @disabled($disabled)
            >
                <span class="{{ $starClasses }}" aria-hidden="true">
                    <svg class="absolute inset-0 h-full w-full {{ $emptyClasses }}" viewBox="0 0 24 24" fill="currentColor"><path d="{{ $star }}" /></svg>
                    <svg class="fltc-form-rating-fill absolute inset-0 h-full w-full {{ $filledClasses }}" viewBox="0 0 24 24" fill="currentColor"
                        x-show="(hover || value) >= {{ $i }}" @if ($current < $i) style="display: none;" @endif><path d="{{ $star }}" /></svg>
                </span>
            </button>
        @endfor
    </div>
</x-fltc::form.field>
