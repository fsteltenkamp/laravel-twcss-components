@props([
    'length' => 6,
    'color' => 'base',
])
@php
    $length = (int) $length;
@endphp
<div
    x-data="{
        digits: Array({{ $length }}).fill(''),
        get value() { return this.digits.join(''); },
        sync() {
            this.$refs.hidden.value = this.value;
            this.$refs.hidden.dispatchEvent(new Event('input', { bubbles: true }));
            this.$refs.hidden.dispatchEvent(new Event('change', { bubbles: true }));
        },
        focusBox(i) {
            const el = this.$refs['box' + i];
            if (el) { el.focus(); el.select(); }
        },
        handleInput(i, e) {
            const cleaned = (e.target.value || '').replace(/\D/g, '');
            if (cleaned === '') { this.digits[i] = ''; this.sync(); return; }
            const chars = cleaned.split('');
            for (let k = 0; k < chars.length && (i + k) < {{ $length }}; k++) {
                this.digits[i + k] = chars[k];
            }
            this.sync();
            this.focusBox(Math.min(i + chars.length, {{ $length }} - 1));
        },
        handleKeydown(i, e) {
            if (e.key === 'Backspace' && this.digits[i] === '' && i > 0) {
                this.focusBox(i - 1);
            } else if (e.key === 'ArrowLeft' && i > 0) {
                e.preventDefault();
                this.focusBox(i - 1);
            } else if (e.key === 'ArrowRight' && i < {{ $length }} - 1) {
                e.preventDefault();
                this.focusBox(i + 1);
            }
        },
    }"
    {{ $attributes->only('class')->class(['fltc-form-otp', 'fltc-color-'.$color, 'flex items-center justify-center gap-2']) }}
>
    @for ($i = 0; $i < $length; $i++)
        <input
            type="text"
            inputmode="numeric"
            autocomplete="one-time-code"
            maxlength="1"
            x-ref="box{{ $i }}"
            x-model="digits[{{ $i }}]"
            x-on:input="handleInput({{ $i }}, $event)"
            x-on:keydown="handleKeydown({{ $i }}, $event)"
            x-on:focus="$event.target.select()"
            class="h-12 w-11 rounded-md border border-{{ $color }}-300 bg-white text-center text-lg font-semibold text-{{ $color }}-900 shadow-sm transition focus:border-{{ $color }}-500 focus:outline-none focus:ring-2 focus:ring-{{ $color }}-500 dark:border-{{ $color }}-600 dark:bg-{{ $color }}-950 dark:text-{{ $color }}-100 dark:focus:border-{{ $color }}-400 dark:focus:ring-{{ $color }}-400"
        />
    @endfor

    <input type="hidden" x-ref="hidden" {{ $attributes->except('class') }} />
</div>
