@php
    $onclickPrefix = filled(trim($onclick)) ? rtrim(trim($onclick), ';').'; ' : '';
@endphp

<div {{ $attributes->class([$classList]) }}>
    @if ($stepCount === 0)
        <div class="{{ $emptyStateClass }}">
            Keine Schritte vorhanden.
        </div>
    @elseif ($tabs)
        <div class="{{ $tabsListClass }}">
            <nav class="{{ $tabsNavClass }}" aria-label="Stepper">
                @if ($hasBackward)
                    <a href="{{ $previousStepUrl }}" class="{{ $controlClass }}">
                        <x-fltc::icon name="arrow-left" />
                        <span>Zurück</span>
                    </a>
                @endif

                @foreach ($stepItems as $step)
                    <a
                        href="{{ $step['href'] }}"
                        @if ($step['isActive']) aria-current="step" @endif
                        @if ($iconsOnly) title="{{ $step['label'] }}" @endif
                        class="{{ $iconsOnly ? $stepIconOnlyClass : $stepBaseClass }} {{ $step['isActive'] ? $activeStepClass : $inactiveStepClass }}"
                    >
                        @if ($step['icon'])
                            <x-fltc::icon :name="$step['icon']" />
                        @endif

                        @unless ($iconsOnly)
                            <span>{{ $step['label'] }}</span>
                        @else
                            <span class="sr-only">{{ $step['label'] }}</span>
                        @endunless
                    </a>
                @endforeach

                @if ($hasForward)
                    <a href="{{ $nextStepUrl }}" class="{{ $controlClass }}">
                        <span>Weiter</span>
                        <x-fltc::icon name="arrow-right" />
                    </a>
                @endif
            </nav>
        </div>
    @else
        <div class="{{ $panelClass }}">
            <div class="flex flex-wrap items-center gap-2 sm:min-w-0 sm:flex-1">
                @if ($hasBackward)
                    <x-fltc::button
                        :theme="$theme"
                        variant="outline"
                        onclick="{{ $onclickPrefix }}util.stepperPreviousStep({{ $currentStepKey }})"
                    >
                        <x-fltc::icon name="arrow-left" />
                        <span>Zuruck</span>
                    </x-fltc::button>

                    @if ($savebtn)
                        <x-fltc::button theme="green" id="formularInstanceUpdateButton" onclick="submit()">
                            <x-fltc::icon name="floppy-disk" />
                            <span>Speichern</span>
                        </x-fltc::button>
                    @endif
                @endif
            </div>

            <div class="{{ $summaryClass }} sm:flex-none">
                Schritt {{ $currentPosition + 1 }} / {{ $stepCount }}: {{ $currentStepLabel }}
            </div>

            <div class="flex flex-wrap items-center justify-start gap-2 sm:min-w-0 sm:flex-1 sm:justify-end">
                @if ($hasForward)
                    @if ($savebtn)
                        <x-fltc::button theme="green" id="formularInstanceUpdateButton" onclick="submit()">
                            <x-fltc::icon name="floppy-disk" />
                            <span>Speichern</span>
                        </x-fltc::button>
                    @endif

                    <x-fltc::button
                        :theme="$theme"
                        onclick="{{ $onclickPrefix }}util.stepperNextStep({{ $currentStepKey }})"
                    >
                        <span>Weiter</span>
                        <x-fltc::icon name="arrow-right" />
                    </x-fltc::button>
                @endif
            </div>
        </div>
    @endif
</div>
