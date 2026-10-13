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
     * @param  ?string  $theme   one theme for every state instead of the per-state ones
     * @param  array<string, string>  $labels  state => label overrides
     * @param  array<string, string>  $themes  state => theme overrides
     * @param  array<string, string>  $icons   state => Phosphor icon overrides
     */
    public function __construct(
        public string $state = 'saved',
        public ?string $theme = null,
        public array $labels = [],
        public array $themes = [],
        public array $icons = [],
    ) {
        $this->state = in_array($state, static::STATES, true) ? $state : 'saved';

        $defaults = [
            'live'    => ['label' => __('Live'), 'icon' => 'broadcast', 'theme' => 'emerald'],
            'unsaved' => ['label' => __('Unsaved changes'), 'icon' => 'pencil-simple', 'theme' => 'amber'],
            'saving'  => ['label' => __('Saving…'), 'icon' => '', 'theme' => 'sky'],
            'saved'   => ['label' => __('Saved'), 'icon' => 'check-circle', 'theme' => 'green'],
            'error'   => ['label' => __('Not saved'), 'icon' => 'warning-circle', 'theme' => 'red'],
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
            $stateTheme = $themes[$key] ?? $theme ?? $default['theme'];

            $this->states[$key] = [
                'label' => $labels[$key] ?? $default['label'],
                'icon' => $icons[$key] ?? $default['icon'],
                'theme' => $stateTheme,
                'classes' => trim(implode(' ', [
                    'items-center gap-1.5 rounded-md border px-2.5 py-1 text-xs font-medium',
                    $visibility[$key],
                    Badge::surface($stateTheme),
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
