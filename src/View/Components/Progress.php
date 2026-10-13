<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * A progress bar: one fill for `value` of `max`, or a split bar of
 * x-fltc::progress.segment children. `variant="meter"` adds a label and
 * "used / limit" above the bar and switches to `warningTheme` from `threshold`
 * (a fraction of max) and to `dangerTheme` once the limit is reached.
 */
class Progress extends Component
{
    public string $classList;
    public string $trackClasses;
    public string $fillClasses;
    public string $labelClasses;
    public string $valueClasses;
    public string $resolvedTheme;
    public float $percent;

    public string $legendClasses;

    /**
     * Segments registered by x-fltc::progress.segment while the slot renders. Read
     * through segments(): Blade copies public properties before the slot runs.
     *
     * @var array<int, array{value: float, percent: float, theme: string, label: string, fillClasses: string, swatchClasses: string}>
     */
    protected array $registered = [];

    public function __construct(
        public float $value = 0,
        public float $max = 100,
        public string $theme = 'slate',
        public string $label = '',
        public string $variant = 'bar',
        public float $threshold = 0.8,
        public string $warningTheme = 'amber',
        public string $dangerTheme = 'red',
        public string $unit = '',
        public string $size = 'md',
        public bool $legend = false,
        public bool $showValue = false,
    ) {
        $this->max = $max > 0 ? $max : 100;
        $this->percent = static::percentOf($value, $this->max);

        $ratio = $value / $this->max;
        $this->resolvedTheme = match (true) {
            $variant !== 'meter' => $theme,
            $ratio >= 1 => $dangerTheme,
            $ratio >= $threshold => $warningTheme,
            default => $theme,
        };

        $sizeMap = [
            'sm' => 'h-1.5',
            'md' => 'h-2.5',
            'lg' => 'h-4',
        ];

        $this->classList = 'w-full';
        $this->trackClasses = 'flex w-full overflow-hidden rounded-full '.($sizeMap[$size] ?? $sizeMap['md']).' '.Shades::track($theme);
        $this->fillClasses = 'h-full transition-[width] duration-300 '.Shades::fill($this->resolvedTheme);
        $this->labelClasses = 'text-sm font-medium '.Shades::secondary($theme);
        $this->valueClasses = 'text-sm tabular-nums '.Shades::tertiary($this->resolvedTheme);
        $this->legendClasses = 'mt-2 flex flex-wrap gap-x-4 gap-y-1 text-xs '.Shades::secondary($theme);
    }

    public static function percentOf(float $value, float $max): float
    {
        return round(max(0, min(100, $value / $max * 100)), 2);
    }

    public function addSegment(float $value, ?string $theme, string $label): array
    {
        $theme ??= $this->theme;

        return $this->registered[] = [
            'value' => $value,
            'percent' => static::percentOf($value, $this->max),
            'theme' => $theme,
            'label' => $label,
            'fillClasses' => 'h-full transition-[width] duration-300 '.Shades::fill($theme),
            'swatchClasses' => 'inline-block h-2.5 w-2.5 rounded-sm '.Shades::fill($theme),
        ];
    }

    public function segments(): array
    {
        return $this->registered;
    }

    public function formatValue(float $value): string
    {
        $number = fmod($value, 1.0) === 0.0 ? number_format($value, 0) : number_format($value, 1);

        return $this->unit !== '' ? $number.' '.$this->unit : $number;
    }

    public function render(): View|Closure|string
    {
        ViewFacade::share('fltcProgress', $this);

        return view('fltc::components.progress');
    }
}
