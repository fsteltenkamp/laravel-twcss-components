{{--
    Example-app page header: breadcrumbs + title + optional subtitle and an
    `actions` slot for buttons. This is example chrome composed from library
    components, not part of the package itself.
--}}
@props([
    'title',
    'subtitle' => null,
    'crumbs' => [],
])

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div class="min-w-0">
        @if (! empty($crumbs))
            <x-fltc::nav.breadcrumbs :crumbs="$crumbs" containerClass="" class="ml-0 mb-2" />
        @endif

        <h1 class="text-2xl font-bold tracking-tight">{{ $title }}</h1>

        @if ($subtitle)
            <p class="mt-1 text-sm opacity-70">{{ $subtitle }}</p>
        @endif
    </div>

    @isset($actions)
        <div class="flex shrink-0 items-center gap-2">
            {{ $actions }}
        </div>
    @endisset
</div>
