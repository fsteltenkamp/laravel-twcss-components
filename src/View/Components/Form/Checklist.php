<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Checklist extends Component
{
    public array $normalizedItems = [];
    public string $iconColorCompleted;
    public string $iconColorFailed;
    public string $iconColorInProgress;
    public string $iconColorPending;
    public string $iconColorChecked;
    public string $iconColorCheckedPeer;
    public string $rowBgCompleted;
    public string $rowBgCompletedHas;
    public string $rowBgFailed;
    public string $rowBgInProgress;
    public string $containerBorder;
    public string $divider;
    public string $rowBgPending;
    public string $iconColorPendingThemed;
    public string $labelColorPendingThemed;
    public string $headingColor;
    public int $computedTotal = 0;
    public int $computedCompleted = 0;
    public int $computedPercent = 0;
    public string $progressBarColor;

    public function __construct(
        public array $items = [],
        public bool $manual = false,
        public string $model = '',
        public bool $live = false,
        public string $name = '',
        public string $idPrefix = '',
        public string $label = '',
        public string $theme = 'sky',
        public bool $showProgress = false,
        public bool $strikeThroughChecked = true,
        public ?int $completedSteps = null,
        public ?int $totalSteps = null,
        public ?int $progressPercent = null,
        public string $iconCompleted = 'ph ph-check-circle',
        public string $iconFailed = 'ph ph-x-circle',
        public string $iconInProgress = 'ph ph-spinner animate-spin',
        public string $iconPending = 'ph ph-circle',
    ) {
        $iconColorMap = [
            'slate'   => 'text-slate-500 dark:text-slate-400',
            'gray'    => 'text-gray-500 dark:text-gray-400',
            'zinc'    => 'text-zinc-500 dark:text-zinc-400',
            'neutral' => 'text-neutral-500 dark:text-neutral-400',
            'stone'   => 'text-stone-500 dark:text-stone-400',
            'red'     => 'text-red-500 dark:text-red-400',
            'orange'  => 'text-orange-500 dark:text-orange-400',
            'amber'   => 'text-amber-500 dark:text-amber-400',
            'yellow'  => 'text-yellow-500 dark:text-yellow-400',
            'lime'    => 'text-lime-500 dark:text-lime-400',
            'green'   => 'text-green-500 dark:text-green-400',
            'emerald' => 'text-emerald-500 dark:text-emerald-400',
            'teal'    => 'text-teal-500 dark:text-teal-400',
            'cyan'    => 'text-cyan-500 dark:text-cyan-400',
            'sky'     => 'text-sky-500 dark:text-sky-400',
            'blue'    => 'text-blue-500 dark:text-blue-400',
            'indigo'  => 'text-indigo-500 dark:text-indigo-400',
            'violet'  => 'text-violet-500 dark:text-violet-400',
            'purple'  => 'text-purple-500 dark:text-purple-400',
            'fuchsia' => 'text-fuchsia-500 dark:text-fuchsia-400',
            'pink'    => 'text-pink-500 dark:text-pink-400',
            'rose'    => 'text-rose-500 dark:text-rose-400',
            'taupe'   => 'text-taupe-500 dark:text-taupe-400',
            'mauve'   => 'text-mauve-500 dark:text-mauve-400',
            'mist'    => 'text-mist-500 dark:text-mist-400',
            'olive'   => 'text-olive-500 dark:text-olive-400',
        ];

        $iconColorPeerCheckedMap = [
            'slate'   => 'peer-checked:text-slate-500 dark:peer-checked:text-slate-400',
            'gray'    => 'peer-checked:text-gray-500 dark:peer-checked:text-gray-400',
            'zinc'    => 'peer-checked:text-zinc-500 dark:peer-checked:text-zinc-400',
            'neutral' => 'peer-checked:text-neutral-500 dark:peer-checked:text-neutral-400',
            'stone'   => 'peer-checked:text-stone-500 dark:peer-checked:text-stone-400',
            'red'     => 'peer-checked:text-red-500 dark:peer-checked:text-red-400',
            'orange'  => 'peer-checked:text-orange-500 dark:peer-checked:text-orange-400',
            'amber'   => 'peer-checked:text-amber-500 dark:peer-checked:text-amber-400',
            'yellow'  => 'peer-checked:text-yellow-500 dark:peer-checked:text-yellow-400',
            'lime'    => 'peer-checked:text-lime-500 dark:peer-checked:text-lime-400',
            'green'   => 'peer-checked:text-green-500 dark:peer-checked:text-green-400',
            'emerald' => 'peer-checked:text-emerald-500 dark:peer-checked:text-emerald-400',
            'teal'    => 'peer-checked:text-teal-500 dark:peer-checked:text-teal-400',
            'cyan'    => 'peer-checked:text-cyan-500 dark:peer-checked:text-cyan-400',
            'sky'     => 'peer-checked:text-sky-500 dark:peer-checked:text-sky-400',
            'blue'    => 'peer-checked:text-blue-500 dark:peer-checked:text-blue-400',
            'indigo'  => 'peer-checked:text-indigo-500 dark:peer-checked:text-indigo-400',
            'violet'  => 'peer-checked:text-violet-500 dark:peer-checked:text-violet-400',
            'purple'  => 'peer-checked:text-purple-500 dark:peer-checked:text-purple-400',
            'fuchsia' => 'peer-checked:text-fuchsia-500 dark:peer-checked:text-fuchsia-400',
            'pink'    => 'peer-checked:text-pink-500 dark:peer-checked:text-pink-400',
            'rose'    => 'peer-checked:text-rose-500 dark:peer-checked:text-rose-400',
            'taupe'   => 'peer-checked:text-taupe-500 dark:peer-checked:text-taupe-400',
            'mauve'   => 'peer-checked:text-mauve-500 dark:peer-checked:text-mauve-400',
            'mist'    => 'peer-checked:text-mist-500 dark:peer-checked:text-mist-400',
            'olive'   => 'peer-checked:text-olive-500 dark:peer-checked:text-olive-400',
        ];

        $progressBarMap = [
            'slate'   => 'bg-slate-500',
            'gray'    => 'bg-gray-500',
            'zinc'    => 'bg-zinc-500',
            'neutral' => 'bg-neutral-500',
            'stone'   => 'bg-stone-500',
            'red'     => 'bg-red-500',
            'orange'  => 'bg-orange-500',
            'amber'   => 'bg-amber-500',
            'yellow'  => 'bg-yellow-500',
            'lime'    => 'bg-lime-500',
            'green'   => 'bg-green-500',
            'emerald' => 'bg-emerald-500',
            'teal'    => 'bg-teal-500',
            'cyan'    => 'bg-cyan-500',
            'sky'     => 'bg-sky-500',
            'blue'    => 'bg-blue-500',
            'indigo'  => 'bg-indigo-500',
            'violet'  => 'bg-violet-500',
            'purple'  => 'bg-purple-500',
            'fuchsia' => 'bg-fuchsia-500',
            'pink'    => 'bg-pink-500',
            'rose'    => 'bg-rose-500',
            'taupe'   => 'bg-taupe-500',
            'mauve'   => 'bg-mauve-500',
            'mist'    => 'bg-mist-500',
            'olive'   => 'bg-olive-500',
        ];

        $containerBorderMap = [
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

        $dividerMap = [
            'slate'   => 'divide-slate-100 dark:divide-slate-800',
            'gray'    => 'divide-gray-100 dark:divide-gray-800',
            'zinc'    => 'divide-zinc-100 dark:divide-zinc-800',
            'neutral' => 'divide-neutral-100 dark:divide-neutral-800',
            'stone'   => 'divide-stone-100 dark:divide-stone-800',
            'red'     => 'divide-red-100 dark:divide-red-900',
            'orange'  => 'divide-orange-100 dark:divide-orange-900',
            'amber'   => 'divide-amber-100 dark:divide-amber-900',
            'yellow'  => 'divide-yellow-100 dark:divide-yellow-900',
            'lime'    => 'divide-lime-100 dark:divide-lime-900',
            'green'   => 'divide-green-100 dark:divide-green-900',
            'emerald' => 'divide-emerald-100 dark:divide-emerald-900',
            'teal'    => 'divide-teal-100 dark:divide-teal-900',
            'cyan'    => 'divide-cyan-100 dark:divide-cyan-900',
            'sky'     => 'divide-sky-100 dark:divide-sky-900',
            'blue'    => 'divide-blue-100 dark:divide-blue-900',
            'indigo'  => 'divide-indigo-100 dark:divide-indigo-900',
            'violet'  => 'divide-violet-100 dark:divide-violet-900',
            'purple'  => 'divide-purple-100 dark:divide-purple-900',
            'fuchsia' => 'divide-fuchsia-100 dark:divide-fuchsia-900',
            'pink'    => 'divide-pink-100 dark:divide-pink-900',
            'rose'    => 'divide-rose-100 dark:divide-rose-900',
            'taupe'   => 'divide-taupe-100 dark:divide-taupe-900',
            'mauve'   => 'divide-mauve-100 dark:divide-mauve-900',
            'mist'    => 'divide-mist-100 dark:divide-mist-900',
            'olive'   => 'divide-olive-100 dark:divide-olive-900',
        ];

        $rowBgPendingMap = [
            'slate'   => 'bg-white dark:bg-slate-900',
            'gray'    => 'bg-white dark:bg-gray-900',
            'zinc'    => 'bg-white dark:bg-zinc-900',
            'neutral' => 'bg-white dark:bg-neutral-900',
            'stone'   => 'bg-white dark:bg-stone-900',
            'red'     => 'bg-red-50/40 dark:bg-red-950/20',
            'orange'  => 'bg-orange-50/40 dark:bg-orange-950/20',
            'amber'   => 'bg-amber-50/40 dark:bg-amber-950/20',
            'yellow'  => 'bg-yellow-50/40 dark:bg-yellow-950/20',
            'lime'    => 'bg-lime-50/40 dark:bg-lime-950/20',
            'green'   => 'bg-green-50/40 dark:bg-green-950/20',
            'emerald' => 'bg-emerald-50/40 dark:bg-emerald-950/20',
            'teal'    => 'bg-teal-50/40 dark:bg-teal-950/20',
            'cyan'    => 'bg-cyan-50/40 dark:bg-cyan-950/20',
            'sky'     => 'bg-sky-50/40 dark:bg-sky-950/20',
            'blue'    => 'bg-blue-50/40 dark:bg-blue-950/20',
            'indigo'  => 'bg-indigo-50/40 dark:bg-indigo-950/20',
            'violet'  => 'bg-violet-50/40 dark:bg-violet-950/20',
            'purple'  => 'bg-purple-50/40 dark:bg-purple-950/20',
            'fuchsia' => 'bg-fuchsia-50/40 dark:bg-fuchsia-950/20',
            'pink'    => 'bg-pink-50/40 dark:bg-pink-950/20',
            'rose'    => 'bg-rose-50/40 dark:bg-rose-950/20',
            'taupe'   => 'bg-taupe-50/40 dark:bg-taupe-950/20',
            'mauve'   => 'bg-mauve-50/40 dark:bg-mauve-950/20',
            'mist'    => 'bg-mist-50/40 dark:bg-mist-950/20',
            'olive'   => 'bg-olive-50/40 dark:bg-olive-950/20',
        ];

        $iconColorPendingMap = [
            'slate'   => 'text-slate-300 dark:text-slate-600',
            'gray'    => 'text-gray-300 dark:text-gray-600',
            'zinc'    => 'text-zinc-300 dark:text-zinc-600',
            'neutral' => 'text-neutral-300 dark:text-neutral-600',
            'stone'   => 'text-stone-300 dark:text-stone-600',
            'red'     => 'text-red-300 dark:text-red-700',
            'orange'  => 'text-orange-300 dark:text-orange-700',
            'amber'   => 'text-amber-300 dark:text-amber-700',
            'yellow'  => 'text-yellow-300 dark:text-yellow-700',
            'lime'    => 'text-lime-300 dark:text-lime-700',
            'green'   => 'text-green-300 dark:text-green-700',
            'emerald' => 'text-emerald-300 dark:text-emerald-700',
            'teal'    => 'text-teal-300 dark:text-teal-700',
            'cyan'    => 'text-cyan-300 dark:text-cyan-700',
            'sky'     => 'text-sky-300 dark:text-sky-700',
            'blue'    => 'text-blue-300 dark:text-blue-700',
            'indigo'  => 'text-indigo-300 dark:text-indigo-700',
            'violet'  => 'text-violet-300 dark:text-violet-700',
            'purple'  => 'text-purple-300 dark:text-purple-700',
            'fuchsia' => 'text-fuchsia-300 dark:text-fuchsia-700',
            'pink'    => 'text-pink-300 dark:text-pink-700',
            'rose'    => 'text-rose-300 dark:text-rose-700',
            'taupe'   => 'text-taupe-300 dark:text-taupe-700',
            'mauve'   => 'text-mauve-300 dark:text-mauve-700',
            'mist'    => 'text-mist-300 dark:text-mist-700',
            'olive'   => 'text-olive-300 dark:text-olive-700',
        ];

        $labelPendingMap = [
            'slate'   => 'text-slate-500 dark:text-slate-400',
            'gray'    => 'text-gray-500 dark:text-gray-400',
            'zinc'    => 'text-zinc-500 dark:text-zinc-400',
            'neutral' => 'text-neutral-500 dark:text-neutral-400',
            'stone'   => 'text-stone-500 dark:text-stone-400',
            'red'     => 'text-red-700 dark:text-red-300',
            'orange'  => 'text-orange-700 dark:text-orange-300',
            'amber'   => 'text-amber-700 dark:text-amber-300',
            'yellow'  => 'text-yellow-700 dark:text-yellow-300',
            'lime'    => 'text-lime-700 dark:text-lime-300',
            'green'   => 'text-green-700 dark:text-green-300',
            'emerald' => 'text-emerald-700 dark:text-emerald-300',
            'teal'    => 'text-teal-700 dark:text-teal-300',
            'cyan'    => 'text-cyan-700 dark:text-cyan-300',
            'sky'     => 'text-sky-700 dark:text-sky-300',
            'blue'    => 'text-blue-700 dark:text-blue-300',
            'indigo'  => 'text-indigo-700 dark:text-indigo-300',
            'violet'  => 'text-violet-700 dark:text-violet-300',
            'purple'  => 'text-purple-700 dark:text-purple-300',
            'fuchsia' => 'text-fuchsia-700 dark:text-fuchsia-300',
            'pink'    => 'text-pink-700 dark:text-pink-300',
            'rose'    => 'text-rose-700 dark:text-rose-300',
            'taupe'   => 'text-taupe-700 dark:text-taupe-300',
            'mauve'   => 'text-mauve-700 dark:text-mauve-300',
            'mist'    => 'text-mist-700 dark:text-mist-300',
            'olive'   => 'text-olive-700 dark:text-olive-300',
        ];

        $headingColorMap = [
            'slate'   => 'text-slate-900 dark:text-slate-100',
            'gray'    => 'text-gray-900 dark:text-gray-100',
            'zinc'    => 'text-zinc-900 dark:text-zinc-100',
            'neutral' => 'text-neutral-900 dark:text-neutral-100',
            'stone'   => 'text-stone-900 dark:text-stone-100',
            'red'     => 'text-red-900 dark:text-red-100',
            'orange'  => 'text-orange-900 dark:text-orange-100',
            'amber'   => 'text-amber-900 dark:text-amber-100',
            'yellow'  => 'text-yellow-900 dark:text-yellow-100',
            'lime'    => 'text-lime-900 dark:text-lime-100',
            'green'   => 'text-green-900 dark:text-green-100',
            'emerald' => 'text-emerald-900 dark:text-emerald-100',
            'teal'    => 'text-teal-900 dark:text-teal-100',
            'cyan'    => 'text-cyan-900 dark:text-cyan-100',
            'sky'     => 'text-sky-900 dark:text-sky-100',
            'blue'    => 'text-blue-900 dark:text-blue-100',
            'indigo'  => 'text-indigo-900 dark:text-indigo-100',
            'violet'  => 'text-violet-900 dark:text-violet-100',
            'purple'  => 'text-purple-900 dark:text-purple-100',
            'fuchsia' => 'text-fuchsia-900 dark:text-fuchsia-100',
            'pink'    => 'text-pink-900 dark:text-pink-100',
            'rose'    => 'text-rose-900 dark:text-rose-100',
            'taupe'   => 'text-taupe-900 dark:text-taupe-100',
            'mauve'   => 'text-mauve-900 dark:text-mauve-100',
            'mist'    => 'text-mist-900 dark:text-mist-100',
            'olive'   => 'text-olive-900 dark:text-olive-100',
        ];

        $this->iconColorCompleted     = 'text-green-500 dark:text-green-400';
        $this->iconColorFailed        = 'text-red-500 dark:text-red-400';
        $this->iconColorInProgress    = 'text-blue-500 dark:text-blue-400';
        $this->iconColorPending       = 'text-slate-300 dark:text-slate-600';
        $this->containerBorder        = $containerBorderMap[$theme] ?? $containerBorderMap['sky'];
        $this->divider                = $dividerMap[$theme] ?? $dividerMap['sky'];
        $this->rowBgPending           = $rowBgPendingMap[$theme] ?? $rowBgPendingMap['sky'];
        $this->iconColorPendingThemed = $iconColorPendingMap[$theme] ?? $iconColorPendingMap['sky'];
        $this->labelColorPendingThemed = $labelPendingMap[$theme] ?? $labelPendingMap['sky'];
        $this->headingColor           = $headingColorMap[$theme] ?? $headingColorMap['sky'];
        $this->iconColorChecked     = $iconColorMap[$theme] ?? $iconColorMap['sky'];
        $this->iconColorCheckedPeer = $iconColorPeerCheckedMap[$theme] ?? $iconColorPeerCheckedMap['sky'];
        $this->rowBgCompleted       = 'bg-green-50 dark:bg-green-950/30';
        $this->rowBgCompletedHas    = 'has-[:checked]:bg-green-50 dark:has-[:checked]:bg-green-950/30';
        $this->rowBgFailed          = 'bg-red-50 dark:bg-red-950/30';
        $this->rowBgInProgress      = 'bg-blue-50 dark:bg-blue-950/30';
        $this->progressBarColor     = $progressBarMap[$theme] ?? $progressBarMap['sky'];

        if (empty($idPrefix)) {
            $this->idPrefix = 'checklist-' . uniqid();
        }

        $this->normalizedItems = $this->normalizeItems($items);

        $this->computedTotal = count($this->normalizedItems);
        $this->computedCompleted = count(array_filter(
            $this->normalizedItems,
            fn($i) => $i['status'] === 'completed'
        ));
        $this->computedPercent = $this->computedTotal > 0
            ? intval(($this->computedCompleted / $this->computedTotal) * 100)
            : 0;
    }

    private function normalizeItems(array $items): array
    {
        $out = [];
        foreach ($items as $key => $item) {
            if (is_string($item)) {
                $out[$key] = ['label' => $item, 'status' => 'pending'];
            } elseif (is_array($item)) {
                $out[$key] = [
                    'label'  => $item['label'] ?? (string) $key,
                    'status' => $item['status'] ?? 'pending',
                ];
            }
        }
        return $out;
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.form.checklist');
    }
}
