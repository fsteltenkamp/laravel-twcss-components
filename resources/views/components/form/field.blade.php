@php
    $errorMessage = $error !== '' ? $error : ($errorKey !== '' ? ($errors->first($errorKey) ?: $errors->first($errorKey.'.*')) : '');
    $errorId = ($errorKey !== '' ? $errorKey : $for).'-error';
    $hasToggle = $noteToggle && $note !== '';
    $hasHead = isset($aside) || $hasToggle;
@endphp
<div {{ $attributes->class([$classList])->merge($hasToggle ? ['x-data' => '{ noteOpen: false }'] : []) }}>
    @if ($hasHead)
        {{-- Label row: the label with the note's info button, and the aside at the right end. --}}
        <div class="fltc-form-field-head flex items-end justify-between gap-3">
            <div class="flex min-w-0 items-center gap-1.5">
                @if ($label !== '')
                    <x-fltc::form.label :for="$for" :required="$required" :color="$color">{{ $label }}</x-fltc::form.label>
                @endif
                @if ($hasToggle)
                    <button
                        type="button"
                        class="fltc-form-field-note-toggle {{ $toggleClasses }}"
                        x-on:click="noteOpen = ! noteOpen"
                        x-bind:aria-expanded="noteOpen.toString()"
                        aria-expanded="false"
                        aria-controls="{{ $for }}-note"
                        aria-label="{{ __('Show description') }}"
                    ><x-fltc::icon name="info" /></button>
                @endif
            </div>
            @isset($aside)
                <div class="fltc-form-field-aside {{ $asideClasses }}">{{ $aside }}</div>
            @endisset
        </div>
    @elseif ($label !== '')
        <x-fltc::form.label :for="$for" :required="$required" :color="$color">
            {{ $label }}
        </x-fltc::form.label>
    @endif

    {{ $slot }}

    @if ($note !== '')
        <p id="{{ $for }}-note" class="fltc-form-field-note {{ $noteClasses }}" @if ($hasToggle) x-show="noteOpen" x-cloak @endif>{{ $note }}</p>
    @endif

    @if ($errorMessage !== '')
        <p id="{{ $errorId }}" class="fltc-form-field-error mt-2 flex items-start gap-1.5 text-sm text-danger-600 dark:text-danger-400">@if ($errorIcon !== '')<x-fltc::icon :name="$errorIcon" class="mt-0.5 shrink-0" />@endif<span>{{ $errorMessage }}</span></p>
    @endif
</div>
