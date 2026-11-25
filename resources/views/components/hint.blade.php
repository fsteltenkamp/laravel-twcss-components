<p {{ $attributes->class([$classList]) }}>@if ($icon !== '')<x-fltc::icon :name="$icon" class="mt-0.5 shrink-0" />@endif<span>{{ $slot }}</span></p>
