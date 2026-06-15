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

    public function __construct(
        public string $theme = 'gray',
        ?string $color = null,
        public string $radius = 'xl',
        public bool $striped = false,
        public bool $hover = true,
        public bool $bordered = true,
        public bool $compact = false,
        public bool $responsive = true,
        public bool $floating = false,
    ) {
        // Backward compatibility: allow legacy `color` while standardizing on `theme`.
        if ($color !== null && $this->theme === 'gray') {
            $this->theme = $color;
        }

        $colors = $this->getThemeColors($this->theme);

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

        // Pills are *elevated*: rather than the panel-flush `row` color (which blends
        // into a same-theme surface behind it — e.g. a card — leaving only the border
        // visible), they use a surface a step lighter than the page/card (white in light
        // mode, the -800 shade in dark mode) plus a slightly stronger border and a
        // shadow, so each row reads as a raised card with real contrast in any context.
        $theme = isset($this->themeMap[$this->theme]) ? $this->theme : 'gray';
        $pillSurface = "bg-white dark:bg-{$theme}-800";
        $pillBorder = "border-{$theme}-200 dark:border-{$theme}-700";

        // The pill surface, border and shadow live on the row's cells (both <td> and
        // <th>, so the head row gets the same shade as the body rows) rather than the
        // <tr>, so the first/last-cell corner radius clips a solid box cleanly. Hover,
        // when enabled, is likewise re-targeted onto the cells. No horizontal
        // border-spacing means adjacent cells join into one continuous pill: the border
        // runs top/bottom across every cell and only left/right on the outer cells, so
        // there are no seams between cells.
        $this->rowBorderClasses = trim(implode(' ', array_filter([
            $this->retarget($pillSurface, '[&>*]:', 'dark:[&>*]:'),
            $this->retarget($pillBorder, '[&>*]:', 'dark:[&>*]:'),
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
