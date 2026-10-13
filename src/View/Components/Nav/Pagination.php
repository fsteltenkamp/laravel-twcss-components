<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Nav;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;

/**
 * Page buttons, fed either by a Laravel paginator (`paginator`) or by plain integers
 * (`currentPage`, `totalPages`, `start`, `end`).
 *
 * Buttons are links to the paginator's URLs, or Livewire gotoPage() calls when
 * `livewire` is set (the default without a paginator, as before paginator support).
 */
class Pagination extends Component
{
    public int $currentPage;
    public int $totalPages;
    public int $start;
    public int $end;
    public string $mainColor;
    public string $accentColor;
    public bool $livewire;
    public string $pageName;
    public string $summaryClasses;

    /**
     * "Showing first–last of total"; null when there is nothing to summarise.
     *
     * @var array{first: int, last: int, total: ?int}|null
     */
    public ?array $summary = null;

    /**
     * The buttons in order. `page` is the target page, `url` its link (null in
     * Livewire mode), `label`/`icon` the content.
     *
     * @var array<int, array{key: string, page: int, url: ?string, label: ?string, icon: ?string, ariaLabel: ?string, current: bool, disabled: bool}>
     */
    public array $links = [];

    public function __construct(
        public ?Paginator $paginator = null,
        int $currentPage = 1,
        int $totalPages = 1,
        int $start = 1,
        int $end = 1,
        public string $color = 'base',
        ?string $accentColor = null,
        ?string $mainColor = null,
        ?bool $livewire = null,
        bool $showSummary = true,
        int $window = 2,
    ) {
        // `mainColor` is an older alias of `color`. The current page is a solid button
        // among outline ones, so it stands out even without a separate accent.
        $this->mainColor = $mainColor ?? $color;
        $this->accentColor = $accentColor ?? $this->mainColor;
        $this->hookColor = $this->mainColor;
        $this->livewire = $livewire ?? $paginator === null;
        $this->pageName = $paginator !== null && method_exists($paginator, 'getPageName') ? $paginator->getPageName() : 'page';
        $this->summaryClasses = 'text-sm '.Shades::secondary($this->mainColor);

        if ($paginator !== null) {
            $currentPage = $paginator->currentPage();
            $totalPages = $paginator instanceof LengthAwarePaginator
                ? max(1, $paginator->lastPage())
                : ($paginator->hasMorePages() ? $currentPage + 1 : $currentPage);
            $start = max(1, $currentPage - $window);
            $end = min($totalPages, $currentPage + $window);

            if ($showSummary && $paginator->isNotEmpty()) {
                $this->summary = [
                    'first' => $paginator->firstItem(),
                    'last' => $paginator->lastItem(),
                    'total' => $paginator instanceof LengthAwarePaginator ? $paginator->total() : null,
                ];
            }
        }

        $this->currentPage = $currentPage;
        $this->totalPages = $totalPages;
        $this->start = $start;
        $this->end = $end;

        if ($paginator === null || $paginator->hasPages()) {
            $this->links = $this->buildLinks($paginator instanceof LengthAwarePaginator || $paginator === null);
        }
    }

    /**
     * @param  bool  $knowsLastPage  false for a simple paginator: no first/last
     *                               buttons, since the last page is unknown
     */
    protected function buildLinks(bool $knowsLastPage): array
    {
        $links = [];
        $atStart = $this->currentPage <= 1;
        $atEnd = $this->currentPage >= $this->totalPages;

        if ($knowsLastPage) {
            $links[] = $this->link('first', 1, icon: 'skip-back', ariaLabel: __('First page'), disabled: $atStart);
        }
        $links[] = $this->link('previous', $this->currentPage - 1, icon: 'rewind', ariaLabel: __('Previous page'), disabled: $atStart);

        for ($page = $this->start; $page <= $this->end; $page++) {
            $links[] = $this->link('page_link_'.$page, $page, label: (string) $page, current: $page === $this->currentPage);
        }

        $links[] = $this->link('next', $this->currentPage + 1, icon: 'fast-forward', ariaLabel: __('Next page'), disabled: $atEnd);
        if ($knowsLastPage) {
            $links[] = $this->link('last', $this->totalPages, icon: 'skip-forward', ariaLabel: __('Last page'), disabled: $atEnd);
        }

        return $links;
    }

    protected function link(string $key, int $page, ?string $label = null, ?string $icon = null, ?string $ariaLabel = null, bool $current = false, bool $disabled = false): array
    {
        return [
            'key' => $key,
            'page' => $page,
            'url' => ! $this->livewire && $this->paginator !== null && ! $disabled ? $this->paginator->url($page) : null,
            'label' => $label,
            'icon' => $icon,
            'ariaLabel' => $ariaLabel,
            'current' => $current,
            'disabled' => $disabled,
        ];
    }

    /**
     * Livewire call for a page: the paginator's page name is passed along so
     * several paginators on one component stay apart.
     */
    public function wireClick(int $page): string
    {
        return $this->paginator === null
            ? "gotoPage({$page})"
            : "gotoPage({$page}, '{$this->pageName}')";
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.nav.pagination');
    }
}
