@php
    \Illuminate\Support\Facades\View::share('fltcRadioGroup', null);

    $hasError = $name !== '' && $errors->has($name);
@endphp

<fieldset
    {{ $attributes->class([$classList]) }}
    @if ($hasError) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif
>
    @if ($label !== '')
        <legend class="fltc-form-radio-group-legend {{ $legendClasses }}">
            {{ $label }}
            @if ($required)
                <span class="ml-1 text-red-500 dark:text-red-400">*</span>
            @endif
        </legend>
    @endif

    <div class="{{ $optionsClasses }}">
        {{ $slot }}
    </div>

    @if ($hasError)
        <p id="{{ $name }}-error" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->first($name) }}</p>
    @endif
</fieldset>
