<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Nav;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Stepper extends Component
{
    public string $classList;
    public string $tabsListClass;
    public string $tabsNavClass;
    public string $panelClass;
    public string $summaryClass;
    public string $stepBaseClass;
    public string $stepIconOnlyClass;
    public string $activeStepClass;
    public string $inactiveStepClass;
    public string $controlClass;
    public string $emptyStateClass;

    /**
     * @var array<int, array{key:mixed, label:string, icon:mixed, isActive:bool, href:string}>
     */
    public array $stepItems = [];

    public int $stepCount = 0;
    public int $currentPosition = 0;
    public mixed $currentStepKey = 1;
    public string $currentStepLabel = '';
    public mixed $previousStepKey = null;
    public mixed $nextStepKey = null;
    public bool $hasBackward = false;
    public bool $hasForward = false;
    public string $previousStepUrl = '#';
    public string $nextStepUrl = '#';

    public function __construct(
        public mixed $steps = [],
        public mixed $stepIndex = 1,
        public bool $tabs = false,
        public bool $iconsOnly = false,
        public bool $savebtn = false,
        public string $onclick = '',
        public string $theme = 'slate',
        public string $class = '',
        public string $stepParam = 'step',
    ) {
        $containerThemeMap = [
            'slate' => 'border-slate-200 bg-slate-50/70 dark:border-slate-700 dark:bg-slate-900/30',
            'gray' => 'border-gray-200 bg-gray-50/70 dark:border-gray-700 dark:bg-gray-900/30',
            'zinc' => 'border-zinc-200 bg-zinc-50/70 dark:border-zinc-700 dark:bg-zinc-900/30',
            'neutral' => 'border-neutral-200 bg-neutral-50/70 dark:border-neutral-700 dark:bg-neutral-900/30',
            'stone' => 'border-stone-200 bg-stone-50/70 dark:border-stone-700 dark:bg-stone-900/30',
            'red' => 'border-red-200 bg-red-50/70 dark:border-red-700 dark:bg-red-950/30',
            'orange' => 'border-orange-200 bg-orange-50/70 dark:border-orange-700 dark:bg-orange-950/30',
            'amber' => 'border-amber-200 bg-amber-50/70 dark:border-amber-700 dark:bg-amber-950/30',
            'yellow' => 'border-yellow-200 bg-yellow-50/70 dark:border-yellow-700 dark:bg-yellow-950/30',
            'lime' => 'border-lime-200 bg-lime-50/70 dark:border-lime-700 dark:bg-lime-950/30',
            'green' => 'border-green-200 bg-green-50/70 dark:border-green-700 dark:bg-green-950/30',
            'emerald' => 'border-emerald-200 bg-emerald-50/70 dark:border-emerald-700 dark:bg-emerald-950/30',
            'teal' => 'border-teal-200 bg-teal-50/70 dark:border-teal-700 dark:bg-teal-950/30',
            'cyan' => 'border-cyan-200 bg-cyan-50/70 dark:border-cyan-700 dark:bg-cyan-950/30',
            'sky' => 'border-sky-200 bg-sky-50/70 dark:border-sky-700 dark:bg-sky-950/30',
            'blue' => 'border-blue-200 bg-blue-50/70 dark:border-blue-700 dark:bg-blue-950/30',
            'indigo' => 'border-indigo-200 bg-indigo-50/70 dark:border-indigo-700 dark:bg-indigo-950/30',
            'violet' => 'border-violet-200 bg-violet-50/70 dark:border-violet-700 dark:bg-violet-950/30',
            'purple' => 'border-purple-200 bg-purple-50/70 dark:border-purple-700 dark:bg-purple-950/30',
            'fuchsia' => 'border-fuchsia-200 bg-fuchsia-50/70 dark:border-fuchsia-700 dark:bg-fuchsia-950/30',
            'pink' => 'border-pink-200 bg-pink-50/70 dark:border-pink-700 dark:bg-pink-950/30',
            'rose' => 'border-rose-200 bg-rose-50/70 dark:border-rose-700 dark:bg-rose-950/30',
            'taupe' => 'border-taupe-200 bg-taupe-50/70 dark:border-taupe-700 dark:bg-taupe-950/30',
            'mauve' => 'border-mauve-200 bg-mauve-50/70 dark:border-mauve-700 dark:bg-mauve-950/30',
            'mist' => 'border-mist-200 bg-mist-50/70 dark:border-mist-700 dark:bg-mist-950/30',
            'olive' => 'border-olive-200 bg-olive-50/70 dark:border-olive-700 dark:bg-olive-950/30',
        ];

        $activeThemeMap = [
            'slate'   => 'border-slate-600 text-slate-700 dark:border-slate-400 dark:text-slate-200',
            'gray'    => 'border-gray-600 text-gray-700 dark:border-gray-400 dark:text-gray-200',
            'zinc'    => 'border-zinc-600 text-zinc-700 dark:border-zinc-400 dark:text-zinc-200',
            'neutral' => 'border-neutral-600 text-neutral-700 dark:border-neutral-400 dark:text-neutral-200',
            'stone'   => 'border-stone-600 text-stone-700 dark:border-stone-400 dark:text-stone-200',
            'red'     => 'border-red-600 text-red-700 dark:border-red-400 dark:text-red-300',
            'orange'  => 'border-orange-600 text-orange-700 dark:border-orange-400 dark:text-orange-300',
            'amber'   => 'border-amber-600 text-amber-700 dark:border-amber-400 dark:text-amber-300',
            'yellow'  => 'border-yellow-600 text-yellow-700 dark:border-yellow-400 dark:text-yellow-300',
            'lime'    => 'border-lime-600 text-lime-700 dark:border-lime-400 dark:text-lime-300',
            'green'   => 'border-green-600 text-green-700 dark:border-green-400 dark:text-green-300',
            'emerald' => 'border-emerald-600 text-emerald-700 dark:border-emerald-400 dark:text-emerald-300',
            'teal'    => 'border-teal-600 text-teal-700 dark:border-teal-400 dark:text-teal-300',
            'cyan'    => 'border-cyan-600 text-cyan-700 dark:border-cyan-400 dark:text-cyan-300',
            'sky'     => 'border-sky-600 text-sky-700 dark:border-sky-400 dark:text-sky-300',
            'blue'    => 'border-blue-600 text-blue-700 dark:border-blue-400 dark:text-blue-300',
            'indigo'  => 'border-indigo-600 text-indigo-700 dark:border-indigo-400 dark:text-indigo-300',
            'violet'  => 'border-violet-600 text-violet-700 dark:border-violet-400 dark:text-violet-300',
            'purple'  => 'border-purple-600 text-purple-700 dark:border-purple-400 dark:text-purple-300',
            'fuchsia' => 'border-fuchsia-600 text-fuchsia-700 dark:border-fuchsia-400 dark:text-fuchsia-300',
            'pink'    => 'border-pink-600 text-pink-700 dark:border-pink-400 dark:text-pink-300',
            'rose'    => 'border-rose-600 text-rose-700 dark:border-rose-400 dark:text-rose-300',
            'taupe'   => 'border-taupe-600 text-taupe-700 dark:border-taupe-400 dark:text-taupe-300',
            'mauve'   => 'border-mauve-600 text-mauve-700 dark:border-mauve-400 dark:text-mauve-300',
            'mist'    => 'border-mist-600 text-mist-700 dark:border-mist-400 dark:text-mist-300',
            'olive'   => 'border-olive-600 text-olive-700 dark:border-olive-400 dark:text-olive-300',
        ];

        $tabsBorderThemeMap = [
            'slate'   => 'border-slate-200 dark:border-slate-700',
            'gray'    => 'border-gray-200 dark:border-gray-700',
            'zinc'    => 'border-zinc-200 dark:border-zinc-700',
            'neutral' => 'border-neutral-200 dark:border-neutral-700',
            'stone'   => 'border-stone-200 dark:border-stone-700',
            'red'     => 'border-red-200 dark:border-red-800',
            'orange'  => 'border-orange-200 dark:border-orange-800',
            'amber'   => 'border-amber-200 dark:border-amber-800',
            'yellow'  => 'border-yellow-200 dark:border-yellow-800',
            'lime'    => 'border-lime-200 dark:border-lime-800',
            'green'   => 'border-green-200 dark:border-green-800',
            'emerald' => 'border-emerald-200 dark:border-emerald-800',
            'teal'    => 'border-teal-200 dark:border-teal-800',
            'cyan'    => 'border-cyan-200 dark:border-cyan-800',
            'sky'     => 'border-sky-200 dark:border-sky-800',
            'blue'    => 'border-blue-200 dark:border-blue-800',
            'indigo'  => 'border-indigo-200 dark:border-indigo-800',
            'violet'  => 'border-violet-200 dark:border-violet-800',
            'purple'  => 'border-purple-200 dark:border-purple-800',
            'fuchsia' => 'border-fuchsia-200 dark:border-fuchsia-800',
            'pink'    => 'border-pink-200 dark:border-pink-800',
            'rose'    => 'border-rose-200 dark:border-rose-800',
            'taupe'   => 'border-taupe-200 dark:border-taupe-800',
            'mauve'   => 'border-mauve-200 dark:border-mauve-800',
            'mist'    => 'border-mist-200 dark:border-mist-800',
            'olive'   => 'border-olive-200 dark:border-olive-800',
        ];

        // inactive tab state is theme-neutral: transparent border, gray text, hover reveals border
        $selectedInactiveTheme = 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-200';

        $summaryThemeMap = [
            'slate' => 'text-slate-700 dark:text-slate-200',
            'gray' => 'text-gray-700 dark:text-gray-200',
            'zinc' => 'text-zinc-700 dark:text-zinc-200',
            'neutral' => 'text-neutral-700 dark:text-neutral-200',
            'stone' => 'text-stone-700 dark:text-stone-200',
            'red' => 'text-red-700 dark:text-red-200',
            'orange' => 'text-orange-700 dark:text-orange-200',
            'amber' => 'text-amber-700 dark:text-amber-200',
            'yellow' => 'text-yellow-700 dark:text-yellow-200',
            'lime' => 'text-lime-700 dark:text-lime-200',
            'green' => 'text-green-700 dark:text-green-200',
            'emerald' => 'text-emerald-700 dark:text-emerald-200',
            'teal' => 'text-teal-700 dark:text-teal-200',
            'cyan' => 'text-cyan-700 dark:text-cyan-200',
            'sky' => 'text-sky-700 dark:text-sky-200',
            'blue' => 'text-blue-700 dark:text-blue-200',
            'indigo' => 'text-indigo-700 dark:text-indigo-200',
            'violet' => 'text-violet-700 dark:text-violet-200',
            'purple' => 'text-purple-700 dark:text-purple-200',
            'fuchsia' => 'text-fuchsia-700 dark:text-fuchsia-200',
            'pink' => 'text-pink-700 dark:text-pink-200',
            'rose' => 'text-rose-700 dark:text-rose-200',
            'taupe' => 'text-taupe-700 dark:text-taupe-200',
            'mauve' => 'text-mauve-700 dark:text-mauve-200',
            'mist' => 'text-mist-700 dark:text-mist-200',
            'olive' => 'text-olive-700 dark:text-olive-200',
        ];

        $selectedContainerTheme = $containerThemeMap[$this->theme] ?? $containerThemeMap['slate'];
        $selectedActiveTheme = $activeThemeMap[$this->theme] ?? $activeThemeMap['slate'];
        $selectedTabsBorder = $tabsBorderThemeMap[$this->theme] ?? $tabsBorderThemeMap['slate'];
        $selectedSummaryTheme = $summaryThemeMap[$this->theme] ?? $summaryThemeMap['slate'];

        $this->classList = trim(implode(' ', array_filter([
            'w-full py-2',
            $this->class,
        ])));

        $this->tabsListClass = 'w-full border-b ' . $selectedTabsBorder;
        $this->tabsNavClass = '-mb-px flex justify-center overflow-x-auto';

        $this->panelClass = trim(implode(' ', array_filter([
            'flex flex-col gap-4 rounded-2xl border p-4 sm:flex-row sm:items-center sm:justify-between',
            $selectedContainerTheme,
        ])));

        $this->summaryClass = trim(implode(' ', array_filter([
            'text-center text-sm font-semibold',
            $selectedSummaryTheme,
        ])));

        $this->stepBaseClass = 'inline-flex items-center gap-2 whitespace-nowrap border-b-2 px-4 py-3 text-sm font-medium transition';
        $this->stepIconOnlyClass = 'inline-flex items-center justify-center whitespace-nowrap border-b-2 px-3 py-3 text-sm transition';
        $this->activeStepClass = $selectedActiveTheme;
        $this->inactiveStepClass = $selectedInactiveTheme;
        $this->controlClass = 'inline-flex items-center gap-1.5 whitespace-nowrap border-b-2 border-transparent px-3 py-3 text-sm font-medium text-gray-400 transition hover:border-gray-300 hover:text-gray-600 dark:text-gray-500 dark:hover:border-gray-600 dark:hover:text-gray-300';
        $this->emptyStateClass = trim(implode(' ', array_filter([
            'rounded-2xl border border-dashed p-4 text-sm',
            $selectedSummaryTheme,
            $selectedContainerTheme,
        ])));

        if (!is_array($this->steps) || $this->steps === []) {
            return;
        }

        $normalizedSteps = [];

        foreach ($this->steps as $key => $step) {
            $label = '';
            $icon = null;

            if (is_array($step)) {
                $label = (string) ($step['label'] ?? $step[0] ?? '');
                $icon = $step['icon'] ?? $step[1] ?? null;
            } elseif (is_scalar($step) || $step instanceof \Stringable) {
                $label = (string) $step;
            }

            if ($label === '') {
                continue;
            }

            $normalizedSteps[] = [
                'key' => $key,
                'label' => $label,
                'icon' => $icon,
            ];
        }

        $this->stepCount = count($normalizedSteps);

        if ($this->stepCount === 0) {
            return;
        }

        $currentKey = $this->resolveCurrentKey($normalizedSteps);
        $keys = array_map(static fn (array $step): string => (string) $step['key'], $normalizedSteps);
        $currentPosition = array_search((string) $currentKey, $keys, true);

        $this->currentPosition = $currentPosition === false ? 0 : $currentPosition;
        $currentStep = $normalizedSteps[$this->currentPosition];
        $this->currentStepKey = $currentStep['key'];
        $this->currentStepLabel = $currentStep['label'];
        $this->hasBackward = $this->currentPosition > 0;
        $this->hasForward = $this->currentPosition < ($this->stepCount - 1);
        $this->previousStepKey = $this->hasBackward ? $normalizedSteps[$this->currentPosition - 1]['key'] : $currentStep['key'];
        $this->nextStepKey = $this->hasForward ? $normalizedSteps[$this->currentPosition + 1]['key'] : $currentStep['key'];
        $this->previousStepUrl = $this->buildStepUrl($this->previousStepKey);
        $this->nextStepUrl = $this->buildStepUrl($this->nextStepKey);

        $this->stepItems = array_map(function (array $step) use ($currentStep): array {
            return [
                'key' => $step['key'],
                'label' => $step['label'],
                'icon' => $step['icon'],
                'isActive' => (string) $step['key'] === (string) $currentStep['key'],
                'href' => $this->buildStepUrl($step['key']),
            ];
        }, $normalizedSteps);
    }

    /**
     * @param  array<int, array{key:mixed, label:string, icon:mixed}>  $steps
     */
    protected function resolveCurrentKey(array $steps): mixed
    {
        $requested = (string) $this->stepIndex;

        foreach ($steps as $step) {
            if ((string) $step['key'] === $requested) {
                return $step['key'];
            }
        }

        return $steps[0]['key'];
    }

    protected function buildStepUrl(mixed $stepKey): string
    {
        return request()->fullUrlWithQuery([$this->stepParam => $stepKey]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('twcss::components.nav.stepper');
    }
}
