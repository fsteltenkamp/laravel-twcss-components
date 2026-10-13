<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * Save-status chip: live / unsaved / saving / saved / error, each with its own icon
 * and theme. All five are rendered and CSS shows the one named by `data-state`, so
 * an app can drive it from Alpine (x-bind:data-state="status") without re-rendering.
 */
class Status extends Component
{
    public const STATES = ['live', 'unsaved', 'saving', 'saved', 'error'];

    public string $classList;

    /**
     * @var array<string, array{label: string, icon: string, theme: string, classes: string}>
     */
    public array $states = [];

    /**
     * @param  ?string  $color   one colour for every state instead of the per-state ones
     * @param  array<string, string>  $labels  state => label overrides
     * @param  array<string, string>  $colors  state => colour overrides
     * @param  array<string, string>  $icons   state => Phosphor icon overrides
     */
    public function __construct(
        public string $state = 'saved',
        public ?string $color = null,
        public array $labels = [],
        public array $colors = [],
        public array $icons = [],
    ) {
        $this->state = in_array($state, static::STATES, true) ? $state : 'saved';

        $defaults = [
            'live'    => ['label' => __('Live'), 'icon' => 'broadcast', 'color' => 'success'],
            'unsaved' => ['label' => __('Unsaved changes'), 'icon' => 'pencil-simple', 'color' => 'warning'],
            'saving'  => ['label' => __('Saving…'), 'icon' => '', 'color' => 'info'],
            'saved'   => ['label' => __('Saved'), 'icon' => 'check-circle', 'color' => 'success'],
            'error'   => ['label' => __('Not saved'), 'icon' => 'warning-circle', 'color' => 'danger'],
        ];

        // Literal per-state variants so Tailwind's scanner sees them: the chip shows
        // the part whose state its group's data-state names.
        $visibility = [
            'live'    => 'hidden group-data-[state=live]/status:inline-flex',
            'unsaved' => 'hidden group-data-[state=unsaved]/status:inline-flex',
            'saving'  => 'hidden group-data-[state=saving]/status:inline-flex',
            'saved'   => 'hidden group-data-[state=saved]/status:inline-flex',
            'error'   => 'hidden group-data-[state=error]/status:inline-flex',
        ];

        foreach ($defaults as $key => $default) {
            $stateColor = $colors[$key] ?? $color ?? $default['color'];

            $this->states[$key] = [
                'label' => $labels[$key] ?? $default['label'],
                'icon' => $icons[$key] ?? $default['icon'],
                'color' => $stateColor,
                'classes' => trim(implode(' ', [
                    'items-center gap-1.5 rounded-md border px-2.5 py-1 text-xs font-medium',
                    $visibility[$key],
                    Badge::surface($stateColor),
                ])),
            ];
        }

        $this->classList = 'group/status inline-flex';
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.status');
    }
}
