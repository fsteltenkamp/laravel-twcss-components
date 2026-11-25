<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;

/**
 * A from/to date pair with preset buttons (this month, last month, …). A preset fills
 * both dates and fires `input` on them, so wire:model and x-model pick it up.
 */
class Daterange extends Component
{
    /** Preset key => [label, from, to] for the presets the library knows. */
    public const PRESETS = ['today', 'this-week', 'this-month', 'last-month', 'last-30-days', 'last-12-months', 'this-year', 'last-year'];

    /** @var array<int, array{label: string, from: string, to: string}> */
    public array $presetButtons = [];

    public string $classList;

    /**
     * @param  array<int|string, string|array{0: string, 1: string}>  $presets  preset keys (see PRESETS), or
     *                                                                         label => [from, to] in Y-m-d
     */
    public function __construct(
        public string $fromName = 'from',
        public string $toName = 'to',
        public string $fromModel = '',
        public string $toModel = '',
        public string $from = '',
        public string $to = '',
        public string $fromLabel = '',
        public string $toLabel = '',
        public array $presets = ['this-month', 'last-month', 'last-12-months', 'this-year'],
        public bool $live = false,
        public string $color = 'base',
        public string $size = 'md',
        public bool $inline = false,
    ) {
        $this->fromLabel = $fromLabel !== '' ? $fromLabel : __('From');
        $this->toLabel = $toLabel !== '' ? $toLabel : __('To');
        $this->classList = 'flex flex-wrap items-end gap-3'.($inline ? '' : ' mb-4');

        foreach ($presets as $key => $preset) {
            if (is_string($key) && is_array($preset)) {
                $this->presetButtons[] = ['label' => $key, 'from' => (string) $preset[0], 'to' => (string) $preset[1]];
            } elseif (is_string($preset) && ($range = self::range($preset)) !== null) {
                $this->presetButtons[] = $range;
            }
        }
    }

    /**
     * @return array{label: string, from: string, to: string}|null
     */
    public static function range(string $preset, ?Carbon $now = null): ?array
    {
        $now ??= Carbon::now();

        [$label, $from, $to] = match ($preset) {
            'today' => [__('Today'), $now->copy(), $now->copy()],
            'this-week' => [__('This week'), $now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            'this-month' => [__('This month'), $now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
            'last-month' => [__('Last month'), $now->copy()->subMonthNoOverflow()->startOfMonth(), $now->copy()->subMonthNoOverflow()->endOfMonth()],
            'last-30-days' => [__('Last 30 days'), $now->copy()->subDays(29), $now->copy()],
            'last-12-months' => [__('Last 12 months'), $now->copy()->subMonthsNoOverflow(11)->startOfMonth(), $now->copy()->endOfMonth()],
            'this-year' => [__('This year'), $now->copy()->startOfYear(), $now->copy()->endOfYear()],
            'last-year' => [__('Last year'), $now->copy()->subYear()->startOfYear(), $now->copy()->subYear()->endOfYear()],
            default => [null, null, null],
        };

        return $label === null ? null : ['label' => $label, 'from' => $from->toDateString(), 'to' => $to->toDateString()];
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.form.daterange');
    }
}
