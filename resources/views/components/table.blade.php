<div class="fltc-table-scroll fltc-color-{{ $color }} @if ($floating) fltc-table-floating @endif {{ $scrollClasses }}" @if($scrollStyle !== '') style="{{ $scrollStyle }}" @endif>
    <table {{ $attributes->class($tableClasses) }}>
        {{ $slot }}
    </table>
</div>
