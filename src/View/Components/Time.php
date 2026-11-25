<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use DateTimeInterface;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;

/**
 * A point in time as <time>: relative ("3 minutes ago") with the exact time as tooltip,
 * or formatted. Renders nothing without a value.
 */
class Time extends Component
{
    public ?Carbon $moment = null;
    public string $label = '';
    public string $exact = '';

    /**
     * @param  DateTimeInterface|string|int|null  $value  a date, a parseable string or a timestamp
     * @param  string  $format  isoFormat for the exact time (default: the locale's `LLL`)
     */
    public function __construct(
        public DateTimeInterface|string|int|null $value = null,
        public bool $relative = true,
        public string $format = 'LLL',
        public string $color = 'base',
    ) {
        if ($value === null || $value === '') {
            return;
        }

        $this->moment = $value instanceof DateTimeInterface ? Carbon::instance($value) : (is_int($value) ? Carbon::createFromTimestamp($value) : Carbon::parse($value));
        $this->moment->locale(app()->getLocale());
        $this->exact = $this->moment->isoFormat($format);
        $this->label = $relative ? $this->moment->diffForHumans() : $this->exact;
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.time');
    }
}
