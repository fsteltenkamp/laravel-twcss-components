<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Nav;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Pagination extends Component
{
    public int $currentPage;
    public int $totalPages;
    public int $start;
    public int $end;
    public string $mainTheme;
    public string $accentTheme;

    public function __construct(
        int $currentPage = 1,
        int $totalPages = 1,
        int $start = 1,
        int $end = 1,
        string $mainTheme = 'slate',
        string $accentTheme = 'sky'
    ) {
        $this->currentPage = $currentPage;
        $this->totalPages = $totalPages;
        $this->start = $start;
        $this->end = $end;
        $this->mainTheme = $mainTheme;
        $this->accentTheme = $accentTheme;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.nav.pagination');
    }
}
