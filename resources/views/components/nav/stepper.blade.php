@php
    $onclickPrefix = filled(trim($onclick)) ? rtrim(trim($onclick), ';').';' : '';
@endphp

<div {{ $attributes->class([$classList]) }}>
    @if ($stepCount === 0)
        <div class="{{ $emptyStateClass }}">
            {{ __('No steps.') }}
        </div>
    @elseif ($tabs)
        <div class="{{ $tabsListClass }}">
            <nav class="{{ $tabsNavClass }}" aria-label="Stepper">
                @if ($hasBackward)
                    <a href="{{ $previousStepUrl }}" class="{{ $controlClass }}">
                        <x-fltc::icon name="arrow-left" />
                        <span>{{ __('Back') }}</span>
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
                        <span>{{ __('Next') }}</span>
                        <x-fltc::icon name="arrow-right" />
                    </a>
                @endif
            </nav>
        </div>
    @else
        {{-- Panel mode: Back and Next are links to the neighbouring steps (an `onclick` runs
             first, e.g. to save); `savebtn` adds a submit button for the surrounding form. --}}
        <div class="{{ $panelClass }}">
            <div class="flex flex-wrap items-center gap-2 sm:min-w-0 sm:flex-1">
                @if ($hasBackward)
                    <x-fltc::button.link :href="$previousStepUrl" :color="$color" variant="outline" icon="arrow-left" :onclick="$onclickPrefix !== '' ? $onclickPrefix : null">{{ __('Back') }}</x-fltc::button.link>

                    @if ($savebtn)
                        <x-fltc::button type="submit" color="success" icon="floppy-disk" data-fltc-stepper-save>{{ __('Save') }}</x-fltc::button>
                    @endif
                @endif
            </div>

            <div class="{{ $summaryClass }} sm:flex-none">
                {{ __('Step :current / :count: :label', ['current' => $currentPosition + 1, 'count' => $stepCount, 'label' => $currentStepLabel]) }}
            </div>

            <div class="flex flex-wrap items-center justify-start gap-2 sm:min-w-0 sm:flex-1 sm:justify-end">
                @if ($hasForward)
                    @if ($savebtn)
                        <x-fltc::button type="submit" color="success" icon="floppy-disk" data-fltc-stepper-save>{{ __('Save') }}</x-fltc::button>
                    @endif

                    <x-fltc::button.link :href="$nextStepUrl" :color="$color" icon="arrow-right" iconPosition="after" :onclick="$onclickPrefix !== '' ? $onclickPrefix : null">{{ __('Next') }}</x-fltc::button.link>
                @endif
            </div>
        </div>
    @endif
</div>
