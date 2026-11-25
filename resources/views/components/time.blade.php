@if ($moment)
<time {{ $attributes->merge(['datetime' => $moment->toIso8601String()] + ($relative ? ['title' => $exact] : [])) }}>{{ $slot->isNotEmpty() ? $slot : $label }}</time>
@elseif ($slot->isNotEmpty())
<time {{ $attributes }}>{{ $slot }}</time>
@endif
