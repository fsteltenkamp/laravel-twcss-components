@php
    $content = $value !== '' ? e($value) : trim((string) $slot);
@endphp
@if ($inline)
    <code {{ $attributes->class([$classList])->merge($language !== '' ? ['data-language' => $language] : []) }}>{!! $content !!}</code>
@else
<div
    {{ $attributes->class([$classList]) }}
    x-data="{
        wrap: @js($wrap),
        copied: false,
        copy() {
            navigator.clipboard?.writeText(this.$refs.code.innerText).then(() => {
                this.copied = true;
                setTimeout(() => this.copied = false, 1500);
                window.dispatchEvent(new CustomEvent('fltc:toast', { detail: { title: @js(__('Copied to the clipboard')), color: 'success', icon: 'ph ph-check' } }));
            });
        },
    }"
>
    @if ($language !== '' || $copy)
        <div class="fltc-code-head {{ $headClasses }}">
            <span class="fltc-code-language font-mono uppercase tracking-wide">{{ $language }}</span>
            <span class="flex items-center gap-1">
                <x-fltc::button variant="ghost" square height="xs" :color="$color" icon="text-align-left" class="fltc-code-wrap" x-on:click="wrap = ! wrap" x-bind:aria-pressed="wrap.toString()" :aria-label="__('Wrap lines')" :title="__('Wrap lines')" />
                @if ($copy)
                    <x-fltc::button variant="ghost" square height="xs" :color="$color" icon="copy" class="fltc-code-copy" x-on:click="copy()" :aria-label="__('Copy')" :title="__('Copy')" />
                @endif
            </span>
        </div>
    @endif
    <pre
        class="fltc-code-block overflow-auto p-3 font-mono text-xs leading-5 @if ($lines) [counter-reset:fltc-line] @endif"
        x-bind:class="wrap ? 'whitespace-pre-wrap break-words' : 'whitespace-pre'"
        @if ($maxHeight !== '') style="max-height: {{ $maxHeight }};" @endif
    ><code x-ref="code" @if ($language !== '') data-language="{{ $language }}" class="language-{{ $language }}" @endif>@if ($lines)@foreach (preg_split('/\r\n|\r|\n/', html_entity_decode($content)) as $line)<span class="block before:mr-4 before:inline-block before:w-6 before:text-right before:opacity-40 before:content-[counter(fltc-line)] [counter-increment:fltc-line]">{{ $line }}</span>@endforeach @else{!! $content !!}@endif</code></pre>
</div>
@endif
