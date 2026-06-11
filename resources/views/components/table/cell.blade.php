@aware([
    'cellClasses' => 'text-gray-700 dark:text-gray-300',
    'cellBorderClasses' => 'border border-gray-200 dark:border-gray-700',
    'compact' => false,
])

@php
    $isHeader = $header || $as === 'th';
    $useCompact = is_null($compactOverride) ? $compact : $compactOverride;
    $paddingClasses = $useCompact ? 'px-3 py-2' : 'px-4 py-3';
    $textAlignmentClasses = $numeric ? 'text-right tabular-nums' : 'text-left';
    $nowrapClasses = $nowrap ? 'whitespace-nowrap' : '';
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
    ]) }}>
        {{ $slot }}
    </td>
@endif
