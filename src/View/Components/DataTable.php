<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

/**
 * A list view: a toolbar (search, rows per page, filters, actions), the table, an empty
 * state and the pagination. Built for Livewire: `search` and `perPage` name the
 * component's properties, `paginator` is the page of rows being shown. Below the
 * `stack` breakpoint the rows turn into cards (see the table's `stack`).
 */
class DataTable extends Component
{
    public string $accentColor;
    public string $inputId;
    public bool $isEmpty;
    public string $countClasses;

    // The inner <x-fltc::table>'s class strings, re-exposed for the rows and cells in
    // this component's slots (see Card\Rows: their @aware lookups stop here).
    public string $headClasses;
    public string $cellClasses;
    public string $cellBorderClasses;
    public string $footClasses;
    public string $rowBorderClasses;
    public string $stripeClasses;
    public string $hoverClasses;
    public string $stackRowClasses;
    public string $stackCellClasses;
    public string $stackValueClasses;
    public string $stackLabelClasses;
    public string $stackTitleClasses;
    public string $stackActionsClasses;
    public string $stackHideClasses;

    /**
     * @param  Paginator|null  $paginator  the shown page; drives the pagination, the
     *                                     "x–y of z" summary and the empty state
     * @param  string|null  $search  Livewire property bound to the search field (no field when null)
     * @param  string|null  $perPage  Livewire property bound to the rows-per-page select
     * @param  array<int, int>  $perPageOptions
     * @param  bool|null  $empty  force the empty state; default: the paginator has no rows
     * @param  bool  $livewire  pagination buttons call gotoPage() instead of linking
     */
    public function __construct(
        public ?Paginator $paginator = null,
        public ?string $search = null,
        public string $searchLabel = '',
        public string $searchPlaceholder = '',
        public string $debounce = '300ms',
        public ?string $perPage = null,
        public array $perPageOptions = [10, 25, 50, 100],
        public string $perPageLabel = '',
        public ?bool $empty = null,
        public string $emptyTitle = '',
        public string $emptyIcon = 'magnifying-glass',
        public string $color = 'base',
        ?string $accentColor = null,
        public string $stack = 'md',
        public string $radius = 'xl',
        public bool $striped = false,
        public bool $hover = true,
        public bool $bordered = true,
        public bool $compact = false,
        public bool $livewire = true,
        public string $id = '',
    ) {
        $this->accentColor = $accentColor ?? $color;
        $this->searchLabel = $searchLabel !== '' ? $searchLabel : __('Search');
        $this->searchPlaceholder = $searchPlaceholder !== '' ? $searchPlaceholder : __('Search…');
        $this->perPageLabel = $perPageLabel !== '' ? $perPageLabel : __('Per page');
        $this->emptyTitle = $emptyTitle !== '' ? $emptyTitle : __('No entries found');
        $this->inputId = $id !== '' ? $id : 'fltc-data-table-'.Str::random(6);
        $this->isEmpty = $empty ?? ($paginator !== null && $paginator->isEmpty());
        $this->countClasses = 'text-sm '.Shades::secondary($color);

        $table = new Table(
            color: $color,
            radius: $radius,
            striped: $striped,
            hover: $hover,
            bordered: $bordered,
            compact: $compact,
            stack: $stack,
        );

        foreach (Table::AWARE_KEYS as $key) {
            $this->{$key} = $table->{$key};
        }
    }

    public function hasToolbar(bool $filters, bool $actions): bool
    {
        return $this->search !== null || $this->perPage !== null || $filters || $actions;
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.data-table');
    }
}
