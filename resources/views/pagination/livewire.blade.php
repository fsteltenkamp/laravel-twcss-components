{{--
    Livewire paginator view (WithPagination): return 'fltc::pagination.livewire' from the
    component's paginationView(), or call $items->links('fltc::pagination.livewire').
--}}
<x-fltc::nav.pagination :paginator="$paginator" livewire />
