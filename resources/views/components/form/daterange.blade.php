<div
    x-data="{
        apply(from, to) {
            for (const [input, value] of [[this.$refs.from, from], [this.$refs.to, to]]) {
                input.value = value;
                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        },
    }"
    {{ $attributes->class([$classList]) }}
>
    <x-fltc::form.input.date
        x-ref="from"
        :name="$fromName"
        :model="$fromModel"
        :live="$live"
        :value="$from"
        :label="$fromLabel"
        :color="$color"
        :size="$size"
        inline
        wrapperClass="fltc-form-daterange-from"
    />
    <x-fltc::form.input.date
        x-ref="to"
        :name="$toName"
        :model="$toModel"
        :live="$live"
        :value="$to"
        :label="$toLabel"
        :color="$color"
        :size="$size"
        inline
        wrapperClass="fltc-form-daterange-to"
    />
    @if ($presetButtons !== [])
        <div class="fltc-form-daterange-presets flex flex-wrap gap-1.5">
            @foreach ($presetButtons as $preset)
                <x-fltc::button
                    variant="ghost"
                    :color="$color"
                    :height="$size === 'sm' ? 'xs' : 'sm'"
                    x-on:click="apply({{ \Illuminate\Support\Js::from($preset['from']) }}, {{ \Illuminate\Support\Js::from($preset['to']) }})"
                    class="fltc-form-daterange-preset"
                >{{ $preset['label'] }}</x-fltc::button>
            @endforeach
        </div>
    @endif
</div>
