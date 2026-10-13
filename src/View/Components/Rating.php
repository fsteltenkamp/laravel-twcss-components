<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * Read-only star rating with half stars, e.g. 3.5 of 5. For a picker use
 * x-fltc::form.rating.
 */
class Rating extends Component
{
    /**
     * Star outline: a five-pointed star in a 24×24 box.
     */
    public const STAR_PATH = 'M12 2.5l2.94 5.96 6.58.96-4.76 4.64 1.12 6.55L12 17.52l-5.88 3.09 1.12-6.55L2.48 9.42l6.58-.96L12 2.5z';

    /**
     * @var array<int, 'full'|'half'|'empty'>
     */
    public array $stars = [];

    public string $classList;
    public string $starClasses;
    public string $filledClasses;
    public string $emptyClasses;
    public string $valueClasses;
    public float $rounded;

    public function __construct(
        public float $value = 0,
        public int $max = 5,
        public string $color = 'base',
        public string $size = 'md',
        public bool $showValue = false,
        public string $label = '',
    ) {
        $this->max = max(1, $max);
        $this->rounded = max(0, min($this->max, round($value * 2) / 2));

        for ($i = 1; $i <= $this->max; $i++) {
            $this->stars[] = match (true) {
                $this->rounded >= $i => 'full',
                $this->rounded >= $i - 0.5 => 'half',
                default => 'empty',
            };
        }

        ['star' => $this->starClasses, 'filled' => $this->filledClasses, 'empty' => $this->emptyClasses] = static::classes($color, $size);

        $this->classList = 'inline-flex items-center gap-0.5';
        $this->valueClasses = 'ml-1.5 text-sm tabular-nums '.Shades::secondary($color);

        if ($this->label === '') {
            $this->label = __(':value out of :max stars', ['value' => rtrim(rtrim(number_format($this->rounded, 1), '0'), '.'), 'max' => $this->max]);
        }
    }

    /**
     * Star box and colours, shared with x-fltc::form.rating: filled stars use the
     * theme's tertiary shade, empty ones its faint shade.
     *
     * @return array{star: string, filled: string, empty: string}
     */
    public static function classes(string $color, string $size): array
    {
        $sizeMap = [
            'sm' => 'h-4 w-4',
            'md' => 'h-5 w-5',
            'lg' => 'h-7 w-7',
        ];

        return [
            'star' => 'relative inline-block shrink-0 '.($sizeMap[$size] ?? $sizeMap['md']),
            'filled' => Shades::tertiary($color),
            'empty' => Shades::faint($color),
        ];
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.rating');
    }
}
