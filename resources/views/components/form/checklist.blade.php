<div class="space-y-4">
    @if ($label !== '')
        <h3 class="text-sm font-semibold {{ $headingColor }}">{{ $label }}</h3>
    @endif

    @if ($showProgress)
        @php
            $displayCompleted = $completedSteps ?? $computedCompleted;
            $displayTotal     = $totalSteps     ?? $computedTotal;
            $displayPercent   = $progressPercent ?? $computedPercent;
        @endphp
        <div class="space-y-1">
            <div class="flex justify-between text-xs {{ $labelColorPendingThemed }}">
                <span>{{ $displayCompleted }} von {{ $displayTotal }} Schritten abgeschlossen</span>
                <span>{{ $displayPercent }}%</span>
            </div>
            <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2.5 overflow-hidden">
                <div
                    class="h-2.5 rounded-full transition-all duration-500
                        @if ($displayPercent === 100) bg-green-500
                        @else {{ $progressBarColor }}
                        @endif"
                    style="width: {{ $displayPercent }}%"
                ></div>
            </div>
        </div>
    @endif

    @if (!empty($normalizedItems))
        <div class="divide-y {{ $divider }} border {{ $containerBorder }} rounded-lg overflow-hidden">
            @foreach ($normalizedItems as $key => $item)
                @php $status = $item['status']; $itemId = $idPrefix . '-' . $key; @endphp

                @if ($manual)
                    <label
                        for="{{ $itemId }}"
                        class="flex items-center gap-3 px-4 py-2.5 transition-colors cursor-pointer {{ $rowBgPending }} hover:bg-slate-50 dark:hover:bg-slate-800/50 {{ $rowBgCompletedHas }}"
                    >
                        <input
                            type="checkbox"
                            id="{{ $itemId }}"
                            @if ($name !== '') name="{{ $name }}[]" @endif
                            value="{{ $key }}"
                            @if ($model !== '')
                                @if ($live)
                                    wire:model.live="{{ $model }}"
                                @else
                                    wire:model="{{ $model }}"
                                @endif
                            @endif
                            @checked($status === 'completed')
                            class="peer sr-only"
                        />

                        <x-fltc::icon :name="$iconPending" class="text-base leading-none flex-shrink-0 {{ $iconColorPendingThemed }} peer-checked:hidden" />
                        <x-fltc::icon :name="$iconCompleted" class="text-base leading-none flex-shrink-0 {{ $iconColorChecked }} hidden peer-checked:inline" />

                        <span class="text-sm {{ $labelColorPendingThemed }} @if ($strikeThroughChecked) peer-checked:line-through peer-checked:opacity-60 @endif">
                            {{ $item['label'] }}
                        </span>
                    </label>
                @else
                    <div class="flex items-center gap-3 px-4 py-2.5
                        @if ($status === 'completed') {{ $rowBgCompleted }}
                        @elseif ($status === 'failed') {{ $rowBgFailed }}
                        @elseif ($status === 'in_progress') {{ $rowBgInProgress }}
                        @else {{ $rowBgPending }}
                        @endif">
                        <span class="flex-shrink-0 text-base leading-none
                            @if ($status === 'completed') {{ $iconColorCompleted }}
                            @elseif ($status === 'failed') {{ $iconColorFailed }}
                            @elseif ($status === 'in_progress') {{ $iconColorInProgress }}
                            @else {{ $iconColorPendingThemed }}
                            @endif">
                            @if ($status === 'completed')
                                <x-fltc::icon :name="$iconCompleted" />
                            @elseif ($status === 'failed')
                                <x-fltc::icon :name="$iconFailed" />
                            @elseif ($status === 'in_progress')
                                <x-fltc::icon :name="$iconInProgress" />
                            @else
                                <x-fltc::icon :name="$iconPending" />
                            @endif
                        </span>
                        <span class="text-sm
                            @if ($status === 'completed') opacity-60 line-through {{ $labelColorPendingThemed }}
                            @elseif ($status === 'failed') text-red-600 dark:text-red-400 font-medium
                            @elseif ($status === 'in_progress') {{ $headingColor }} font-medium
                            @else {{ $labelColorPendingThemed }}
                            @endif">
                            {{ $item['label'] }}
                        </span>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
