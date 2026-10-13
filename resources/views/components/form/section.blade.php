<section {{ $attributes->class([$classList]) }}>
    @if ($title !== '' || $hint !== '')
        <header @class(['fltc-form-section-header', 'mb-4' => ! $split])>
            @if ($title !== '')
                <h3 class="fltc-form-section-title {{ $titleClasses }}">{{ $title }}</h3>
            @endif
            @if ($hint !== '')
                <p class="fltc-form-section-hint {{ $hintClasses }}">{{ $hint }}</p>
            @endif
        </header>
    @endif

    <div @class(['md:col-span-2' => $split])>
        {{ $slot }}

        @isset($actions)
            <div class="fltc-form-section-actions mt-2 flex flex-wrap justify-end gap-2">{{ $actions }}</div>
        @endisset
    </div>
</section>
