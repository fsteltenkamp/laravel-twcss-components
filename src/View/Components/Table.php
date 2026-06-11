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
    ) {
        // Backward compatibility: allow legacy `color` while standardizing on `theme`.
        if ($color !== null && $this->theme === 'gray') {
            $this->theme = $color;
        }

        $colors = $this->getThemeColors($this->theme);
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
        return view('twcss::components.table');
    }
}
