<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class Table extends TableBase
{
    public string $scrollClasses;
    public string $scrollStyle;
    public string $tableClasses;
    public string $headClasses;
    public string $cellClasses;
    public string $cellBorderClasses;
    public string $footClasses;
    public string $rowBorderClasses;
    public string $stripeClasses;
    public string $hoverClasses;

    // Card layout below the `stack` breakpoint; empty strings when stacking is off.
    public string $stackTableClasses = '';
    public string $stackRowClasses = '';
    public string $stackCellClasses = '';
    public string $stackValueClasses = '';
    public string $stackLabelClasses = '';
    public string $stackTitleClasses = '';
    public string $stackActionsClasses = '';
    public string $stackHideClasses = '';

    /**
     * The class strings handed to rows, cells and the head through @aware; wrappers
     * (card.rows, data-table) re-expose them for rows passed in through their slots.
     */
    public const AWARE_KEYS = [
        'headClasses', 'cellClasses', 'cellBorderClasses', 'footClasses', 'rowBorderClasses',
        'stripeClasses', 'hoverClasses', 'stackRowClasses', 'stackCellClasses', 'stackValueClasses', 'stackLabelClasses',
        'stackTitleClasses', 'stackActionsClasses', 'stackHideClasses',
    ];

    public function __construct(
        public string $color = 'base',
        public string $radius = 'xl',
        public bool $striped = false,
        public bool $hover = true,
        public bool $bordered = true,
        public bool $compact = false,
        public bool $responsive = true,
        public bool $floating = false,
        public string $stack = 'none',
    ) {
        $colors = $this->getThemeColors($this->color);

        // Floating pills keep their own row layout; stacking applies to the grid variant only.
        if (! $this->floating) {
            $this->buildStackClasses($this->stack, $colors);
        }

        // The "floating" variant is a different border/spacing model (rows render as
        // separated rounded pills). It reuses the same theme colors and flows down to
        // the head/row/cell children through the existing @aware keys, so no Blade
        // changes are needed — only the computed class strings differ.
        if ($this->floating) {
            $this->buildFloatingClasses($colors);

            return;
        }

        $radiusOptions = $this->resolveRadiusOptions($this->radius);

        $this->scrollClasses = trim(implode(' ', array_filter([
            'w-full',
            $this->responsive ? 'overflow-x-auto' : '',
            $radiusOptions['class'],
            $radiusOptions['hasRadius'] ? 'overflow-y-hidden' : '',
        ])));
        $this->scrollStyle = $radiusOptions['style'];

        $this->tableClasses = trim(implode(' ', array_filter([
            'w-full min-w-full font-mono text-sm',
            $colors['divide'],
        ])));

        $this->headClasses = trim(implode(' ', array_filter([
            $colors['head'],
            'text-left text-xs font-semibold tracking-wide uppercase border-b backdrop-blur-sm',
            $colors['border'],
        ])));

        $this->cellClasses = $colors['cell'];
        $this->cellBorderClasses = $this->bordered ? 'border '.$colors['border'] : '';
        $this->footClasses = $colors['foot'];
        $this->rowBorderClasses = trim(implode(' ', array_filter([
            $colors['row'],
            $this->bordered ? 'border-b '.$colors['border'] : '',
        ])));
        $this->stripeClasses = $this->striped ? $colors['stripe'] : '';
        $this->hoverClasses = $this->hover ? $colors['hover'] : '';
    }

    /**
     * Below the breakpoint every row becomes a card: the head is hidden, each cell is a
     * line with its `label` on the left and the value on the right. Cells marked
     * `card="title"` lead the card, `card="actions"` align right, `card="hide"` drop out.
     * The literal class strings stay in this map so Tailwind's scanner finds them.
     */
    protected function buildStackClasses(string $stack, array $colors): void
    {
        $map = [
            'sm' => [
                'table' => 'max-sm:block max-sm:[&>tbody]:block max-sm:[&>tbody]:space-y-3 max-sm:[&>thead]:hidden max-sm:[&>tfoot]:block',
                'row' => 'max-sm:block max-sm:rounded-lg max-sm:border max-sm:py-1 max-sm:shadow-sm',
                'cell' => 'max-sm:flex max-sm:items-baseline max-sm:justify-between max-sm:gap-4 max-sm:border-0 max-sm:px-3 max-sm:py-1.5',
                'value' => 'max-sm:text-right',
                'label' => 'hidden max-sm:block',
                'title' => 'max-sm:justify-start max-sm:text-left max-sm:text-base max-sm:font-semibold',
                'actions' => 'max-sm:justify-end max-sm:pt-2',
                'hide' => 'max-sm:hidden',
            ],
            'md' => [
                'table' => 'max-md:block max-md:[&>tbody]:block max-md:[&>tbody]:space-y-3 max-md:[&>thead]:hidden max-md:[&>tfoot]:block',
                'row' => 'max-md:block max-md:rounded-lg max-md:border max-md:py-1 max-md:shadow-sm',
                'cell' => 'max-md:flex max-md:items-baseline max-md:justify-between max-md:gap-4 max-md:border-0 max-md:px-3 max-md:py-1.5',
                'value' => 'max-md:text-right',
                'label' => 'hidden max-md:block',
                'title' => 'max-md:justify-start max-md:text-left max-md:text-base max-md:font-semibold',
                'actions' => 'max-md:justify-end max-md:pt-2',
                'hide' => 'max-md:hidden',
            ],
            'lg' => [
                'table' => 'max-lg:block max-lg:[&>tbody]:block max-lg:[&>tbody]:space-y-3 max-lg:[&>thead]:hidden max-lg:[&>tfoot]:block',
                'row' => 'max-lg:block max-lg:rounded-lg max-lg:border max-lg:py-1 max-lg:shadow-sm',
                'cell' => 'max-lg:flex max-lg:items-baseline max-lg:justify-between max-lg:gap-4 max-lg:border-0 max-lg:px-3 max-lg:py-1.5',
                'value' => 'max-lg:text-right',
                'label' => 'hidden max-lg:block',
                'title' => 'max-lg:justify-start max-lg:text-left max-lg:text-base max-lg:font-semibold',
                'actions' => 'max-lg:justify-end max-lg:pt-2',
                'hide' => 'max-lg:hidden',
            ],
        ];

        $classes = $map[strtolower(trim($stack))] ?? null;
        if ($classes === null) {
            return;
        }

        $this->stackTableClasses = $classes['table'];
        $this->stackRowClasses = $classes['row'].' '.$colors['border'];
        $this->stackCellClasses = $classes['cell'];
        // Values sit right of their label; the title cell keeps its own (left) alignment.
        $this->stackValueClasses = $classes['value'];
        $this->stackLabelClasses = $classes['label'].' shrink-0 text-left text-xs font-semibold uppercase tracking-wide opacity-70';
        $this->stackTitleClasses = $classes['title'];
        $this->stackActionsClasses = $classes['actions'];
        $this->stackHideClasses = $classes['hide'];
    }

    /**
     * Compute the class strings for the "floating" variant: rows separated by
     * vertical spacing, each rendered as a themed rounded pill with no cell borders.
     */
    protected function buildFloatingClasses(array $colors): void
    {
        $this->scrollClasses = trim(implode(' ', array_filter([
            'w-full',
            $this->responsive ? 'overflow-x-auto' : '',
        ])));
        $this->scrollStyle = '';

        // border-separate + vertical border-spacing produces the gap between rows.
        $this->tableClasses = 'w-full min-w-full text-sm border-separate border-spacing-y-3';

        // The head row is a pill like the others (same surface), so it only needs the
        // shared label typography here; the pill surface/border/shadow come from
        // rowBorderClasses below, which every row — head included — receives.
        $this->headClasses = trim(implode(' ', array_filter([
            $colors['cell'],
            'text-left text-xs font-semibold tracking-wide uppercase',
        ])));

        // pillBorder uses -700 in dark mode (one step lighter than border's -800) so pills
        // read as raised against a same-theme card body (whose dark surface is -800).
        // The literal strings live in the theme map so Tailwind's scanner can detect them.

        // The pill surface, border and shadow live on the row's cells (both <td> and
        // <th>, so the head row gets the same shade as the body rows) rather than the
        // <tr>, so the first/last-cell corner radius clips a solid box cleanly. Hover,
        // when enabled, is likewise re-targeted onto the cells. No horizontal
        // border-spacing means adjacent cells join into one continuous pill: the border
        // runs top/bottom across every cell and only left/right on the outer cells, so
        // there are no seams between cells.
        $this->rowBorderClasses = trim(implode(' ', array_filter([
            $this->retarget($colors['row'], '[&>*]:', 'dark:[&>*]:'),
            $this->retarget($colors['pillBorder'], '[&>*]:', 'dark:[&>*]:'),
            '[&>*]:border-y [&>*:first-child]:border-l [&>*:last-child]:border-r',
            '[&>*]:shadow-sm',
            $this->hover ? $this->retarget($colors['hover'], '[&:hover>*]:', 'dark:[&:hover>*]:') : '',
            '[&>*:first-child]:rounded-l-lg [&>*:last-child]:rounded-r-lg',
        ])));

        $this->cellClasses = $colors['cell'];
        $this->cellBorderClasses = ''; // floating rows have no cell borders
        $this->footClasses = $colors['foot'];

        // Striping and the standard row-level hover are folded into the pill above.
        $this->stripeClasses = '';
        $this->hoverClasses = '';
    }

    /**
     * Re-target a space-separated class string onto the row's cells via arbitrary
     * variants, preserving `dark:` / `hover:` modifiers. e.g. `dark:bg-gray-800/90`
     * with prefixes `[&>*]:` / `dark:[&>*]:` becomes `dark:[&>*]:bg-gray-800/90`.
     */
    protected function retarget(string $classes, string $prefix, string $darkPrefix): string
    {
        $out = [];

        foreach (preg_split('/\s+/', trim($classes), -1, PREG_SPLIT_NO_EMPTY) as $token) {
            if (str_starts_with($token, 'dark:hover:')) {
                $out[] = $darkPrefix.substr($token, strlen('dark:hover:'));
            } elseif (str_starts_with($token, 'dark:')) {
                $out[] = $darkPrefix.substr($token, strlen('dark:'));
            } elseif (str_starts_with($token, 'hover:')) {
                $out[] = $prefix.substr($token, strlen('hover:'));
            } else {
                $out[] = $prefix.$token;
            }
        }

        return implode(' ', $out);
    }

    protected function resolveRadiusOptions(string $radius): array
    {
        $radiusMap = [
            'none' => 'rounded-none',
            'xs' => 'rounded',
            'sm' => 'rounded-sm',
            'md' => 'rounded-md',
            'lg' => 'rounded-lg',
            'xl' => 'rounded-xl',
            '2xl' => 'rounded-2xl',
            '3xl' => 'rounded-3xl',
            'full' => 'rounded-full',
        ];

        $trimmedRadius = strtolower(trim($radius));

        if (isset($radiusMap[$trimmedRadius])) {
            return [
                'class' => $radiusMap[$trimmedRadius],
                'style' => '',
                'hasRadius' => $trimmedRadius !== 'none',
            ];
        }

        if (preg_match('/^\d+(?:\.\d+)?(?:px)?$/', $trimmedRadius) === 1) {
            $pixelRadius = str_ends_with($trimmedRadius, 'px') ? $trimmedRadius : $trimmedRadius.'px';

            return [
                'class' => '',
                'style' => 'border-radius: '.$pixelRadius.';',
                'hasRadius' => true,
            ];
        }

        return [
            'class' => $radiusMap['xl'],
            'style' => '',
            'hasRadius' => true,
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('fltc::components.table');
    }
}
