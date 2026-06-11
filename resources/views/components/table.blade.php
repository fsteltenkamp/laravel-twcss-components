<div class="{{ $scrollClasses }}" @if($scrollStyle !== '') style="{{ $scrollStyle }}" @endif>
    <table {{ $attributes->class($tableClasses) }}>
        {{ $slot }}
    </table>
</div>
