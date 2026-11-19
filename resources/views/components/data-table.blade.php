<div {{ $attributes->class(['space-y-4']) }}>
    @if ($hasToolbar(isset($filters), isset($actions)))
        <div class="fltc-data-table-toolbar flex flex-wrap items-end gap-3">
            @if ($search !== null)
                <x-fltc::form.input.text
                    :id="$inputId.'-search'"
                    :model="$search"
                    :live="true"
                    :debounce="$debounce"
                    type="search"
                    icon="magnifying-glass"
                    :label="$searchLabel"
                    :placeholder="$searchPlaceholder"
                    :color="$accentColor"
                    wrapper-class="w-full sm:w-72"
                />
            @endif
            @if ($perPage !== null)
                <x-fltc::form.input.select :id="$inputId.'-per-page'" :model="$perPage" :live="true" :label="$perPageLabel" :color="$accentColor" wrapper-class="w-28">
                    @foreach ($perPageOptions as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </x-fltc::form.input.select>
            @endif
            @isset($filters)
                <div class="fltc-data-table-filters flex flex-wrap items-end gap-3">{{ $filters }}</div>
            @endisset
            @isset($actions)
                <div class="fltc-data-table-actions ml-auto flex flex-wrap items-center gap-2">{{ $actions }}</div>
            @endisset
        </div>
    @endif

    @if ($isEmpty)
        @isset($emptyState)
            {{ $emptyState }}
        @else
            <x-fltc::empty :icon="$emptyIcon" :title="$emptyTitle" :color="$color" size="sm" bordered />
        @endisset
    @else
        <div class="fltc-data-table-body" @if ($livewire) wire:loading.class.delay="opacity-60" @endif>
            <x-fltc::table :color="$color" :radius="$radius" :striped="$striped" :hover="$hover" :bordered="$bordered" :compact="$compact" :stack="$stack">
                @isset($head)
                    <x-fltc::table.head>
                        {{ $head }}
                    </x-fltc::table.head>
                @endisset
                <tbody>
                    {{ $slot }}
                </tbody>
                @isset($foot)
                    <x-fltc::table.foot>
                        {{ $foot }}
                    </x-fltc::table.foot>
                @endisset
            </x-fltc::table>
        </div>
    @endif

    @if ($paginator !== null)
        <x-fltc::nav.pagination :paginator="$paginator" :livewire="$livewire" :color="$color" :accent-color="$accentColor" />
    @endif
    @isset($footer)
        <div class="fltc-data-table-footer">{{ $footer }}</div>
    @endisset
</div>
