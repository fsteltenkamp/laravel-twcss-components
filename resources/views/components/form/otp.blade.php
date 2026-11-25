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
        // Spread digits over the boxes from box `start`, then focus the box after the last.
        fill(start, chars) {
            for (let k = 0; k < chars.length && (start + k) < {{ $length }}; k++) {
                this.digits[start + k] = chars[k];
            }
            this.sync();
            this.focusBox(Math.min(start + chars.length, {{ $length }} - 1));
        },
        // Typing, and autofill (one-time-code), which puts the whole code into one box: the
        // boxes have no length limit, so a box can briefly hold several digits.
        handleInput(i, e) {
            const chars = (e.target.value || '').replace(/\D/g, '').split('');
            if (! chars.length) { this.digits[i] = ''; e.target.value = ''; this.sync(); return; }
            this.fill(i, chars);
            e.target.value = this.digits[i];
        },
        // A pasted code ('123456', '123 456', '12-34-56'): a full code fills from the first
        // box wherever it is pasted, a shorter one from the box it is pasted into.
        handlePaste(i, e) {
            const chars = (e.clipboardData?.getData('text') || '').replace(/\D/g, '').split('');
            if (! chars.length) return;
            this.fill(chars.length >= {{ $length }} ? 0 : i, chars);
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
            x-ref="box{{ $i }}"
            x-model="digits[{{ $i }}]"
            x-on:input="handleInput({{ $i }}, $event)"
            x-on:paste.prevent="handlePaste({{ $i }}, $event)"
            x-on:keydown="handleKeydown({{ $i }}, $event)"
            x-on:focus="$event.target.select()"
            class="fltc-form-otp-box h-12 w-11 rounded-md border text-center text-lg font-semibold shadow-sm transition focus:outline-none focus:ring-2 {{ \Fsteltenkamp\TwcssComponents\Support\Shades::control($color) }}"
        />
    @endfor

    <input type="hidden" x-ref="hidden" {{ $attributes->except('class') }} />
</div>
