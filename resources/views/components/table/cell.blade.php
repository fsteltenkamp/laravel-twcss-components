@aware([
    'cellClasses' => 'text-gray-700 dark:text-gray-300',
    'cellBorderClasses' => 'border border-gray-200 dark:border-gray-700',
    'compact' => false,
    'stackCellClasses' => '',
    'stackValueClasses' => '',
    'stackLabelClasses' => '',
    'stackTitleClasses' => '',
    'stackActionsClasses' => '',
    'stackHideClasses' => '',
])

@php
    $isHeader = $header || $as === 'th';
    $useCompact = is_null($compactOverride) ? $compact : $compactOverride;
    $paddingClasses = $useCompact ? 'px-3 py-2' : 'px-4 py-3';
    $textAlignmentClasses = $numeric ? 'text-right tabular-nums' : 'text-left';
    $nowrapClasses = $nowrap ? 'whitespace-nowrap' : '';
    // Card layout (table `stack`): label + value per line; header cells are hidden with the head.
    $stacked = ! $isHeader && $stackCellClasses !== '';
    $cardClasses = match ($card) {
        'title' => $stackTitleClasses,
        'actions' => $stackActionsClasses,
        'hide' => $stackHideClasses,
        default => '',
    };
    $showLabel = $stacked && $label !== '' && ! in_array($card, ['title', 'actions'], true);
@endphp

@if($isHeader)
    <th {{ $attributes->class([
        $paddingClasses,
        'text-xs font-semibold uppercase tracking-wider',
        $textAlignmentClasses,
        $cellClasses,
        $cellBorderClasses,
        $nowrapClasses,
    ]) }}>
        {{ $slot }}
    </th>
@else
    <td {{ $attributes->class([
        $paddingClasses,
        'text-sm',
        $textAlignmentClasses,
        $cellClasses,
        $cellBorderClasses,
        $nowrapClasses,
        $stacked ? $stackCellClasses : '',
        $stacked ? $cardClasses : '',
        $stacked && $card !== 'title' ? $stackValueClasses : '',
    ]) }}>
        @if ($stacked)
            @if ($showLabel)<span class="fltc-table-cell-label {{ $stackLabelClasses }}">{{ $label }}</span>@endif
            <div class="fltc-table-cell-value min-w-0">{{ $slot }}</div>
        @else
            {{ $slot }}
        @endif
    </td>
@endif
