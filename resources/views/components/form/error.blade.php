@php
    $key = rtrim($name, '[]');
    $slotText = trim((string) $slot);
    $text = $message !== '' ? $message : ($slotText !== '' ? $slotText : ($key !== '' && isset($errors) ? ($errors->first($key) ?: $errors->first($key.'.*')) : ''));
@endphp
@if ($text !== '')
    <p {{ $attributes->class([$classList])->merge($key !== '' ? ['id' => $key.'-error'] : []) }}>@if ($icon !== '')<x-fltc::icon :name="$icon" class="mt-0.5 shrink-0" />@endif<span>{{ $text }}</span></p>
@endif
