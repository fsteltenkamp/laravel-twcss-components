<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Thread;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * One message of x-fltc::thread: a card with the author and meta (time, state) on top,
 * the slot as body and an optional `footer` slot (attachments, actions).
 */
class Message extends Component
{
    public string $classList;
    public string $headClasses;
    public string $metaClasses;

    public function __construct(
        public bool $own = false,
        public string $author = '',
        public string $meta = '',
        public string $avatar = '',
        public bool $showAvatar = true,
        public ?string $color = null,
    ) {
        $thread = ViewFacade::shared('fltcThread', []);
        $this->color = $color ?? ($own ? ($thread['ownColor'] ?? 'primary') : ($thread['color'] ?? 'base'));

        $cardMap = [
            'slate'     => 'border-slate-200 bg-slate-50 text-slate-900 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100',
            'gray'      => 'border-gray-200 bg-gray-50 text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100',
            'zinc'      => 'border-zinc-200 bg-zinc-50 text-zinc-900 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100',
            'neutral'   => 'border-neutral-200 bg-neutral-50 text-neutral-900 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100',
            'stone'     => 'border-stone-200 bg-stone-50 text-stone-900 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100',
            'red'       => 'border-red-200 bg-red-50 text-red-900 dark:border-red-700 dark:bg-red-900 dark:text-red-100',
            'orange'    => 'border-orange-200 bg-orange-50 text-orange-900 dark:border-orange-700 dark:bg-orange-900 dark:text-orange-100',
            'amber'     => 'border-amber-200 bg-amber-50 text-amber-900 dark:border-amber-700 dark:bg-amber-900 dark:text-amber-100',
            'yellow'    => 'border-yellow-200 bg-yellow-50 text-yellow-900 dark:border-yellow-700 dark:bg-yellow-900 dark:text-yellow-100',
            'lime'      => 'border-lime-200 bg-lime-50 text-lime-900 dark:border-lime-700 dark:bg-lime-900 dark:text-lime-100',
            'green'     => 'border-green-200 bg-green-50 text-green-900 dark:border-green-700 dark:bg-green-900 dark:text-green-100',
            'emerald'   => 'border-emerald-200 bg-emerald-50 text-emerald-900 dark:border-emerald-700 dark:bg-emerald-900 dark:text-emerald-100',
            'teal'      => 'border-teal-200 bg-teal-50 text-teal-900 dark:border-teal-700 dark:bg-teal-900 dark:text-teal-100',
            'cyan'      => 'border-cyan-200 bg-cyan-50 text-cyan-900 dark:border-cyan-700 dark:bg-cyan-900 dark:text-cyan-100',
            'sky'       => 'border-sky-200 bg-sky-50 text-sky-900 dark:border-sky-700 dark:bg-sky-900 dark:text-sky-100',
            'blue'      => 'border-blue-200 bg-blue-50 text-blue-900 dark:border-blue-700 dark:bg-blue-900 dark:text-blue-100',
            'indigo'    => 'border-indigo-200 bg-indigo-50 text-indigo-900 dark:border-indigo-700 dark:bg-indigo-900 dark:text-indigo-100',
            'violet'    => 'border-violet-200 bg-violet-50 text-violet-900 dark:border-violet-700 dark:bg-violet-900 dark:text-violet-100',
            'purple'    => 'border-purple-200 bg-purple-50 text-purple-900 dark:border-purple-700 dark:bg-purple-900 dark:text-purple-100',
            'fuchsia'   => 'border-fuchsia-200 bg-fuchsia-50 text-fuchsia-900 dark:border-fuchsia-700 dark:bg-fuchsia-900 dark:text-fuchsia-100',
            'pink'      => 'border-pink-200 bg-pink-50 text-pink-900 dark:border-pink-700 dark:bg-pink-900 dark:text-pink-100',
            'rose'      => 'border-rose-200 bg-rose-50 text-rose-900 dark:border-rose-700 dark:bg-rose-900 dark:text-rose-100',
            'taupe'     => 'border-taupe-200 bg-taupe-50 text-taupe-900 dark:border-taupe-700 dark:bg-taupe-900 dark:text-taupe-100',
            'mauve'     => 'border-mauve-200 bg-mauve-50 text-mauve-900 dark:border-mauve-700 dark:bg-mauve-900 dark:text-mauve-100',
            'mist'      => 'border-mist-200 bg-mist-50 text-mist-900 dark:border-mist-700 dark:bg-mist-900 dark:text-mist-100',
            'olive'     => 'border-olive-200 bg-olive-50 text-olive-900 dark:border-olive-700 dark:bg-olive-900 dark:text-olive-100',
            'primary'   => 'border-primary-200 bg-primary-50 text-primary-900 dark:border-primary-700 dark:bg-primary-900 dark:text-primary-100',
            'secondary' => 'border-secondary-200 bg-secondary-50 text-secondary-900 dark:border-secondary-700 dark:bg-secondary-900 dark:text-secondary-100',
            'accent'    => 'border-accent-200 bg-accent-50 text-accent-900 dark:border-accent-700 dark:bg-accent-900 dark:text-accent-100',
            'base'      => 'border-base-200 bg-base-50 text-base-900 dark:border-base-700 dark:bg-base-900 dark:text-base-100',
            'info'      => 'border-info-200 bg-info-50 text-info-900 dark:border-info-700 dark:bg-info-900 dark:text-info-100',
            'success'   => 'border-success-200 bg-success-50 text-success-900 dark:border-success-700 dark:bg-success-900 dark:text-success-100',
            'warning'   => 'border-warning-200 bg-warning-50 text-warning-900 dark:border-warning-700 dark:bg-warning-900 dark:text-warning-100',
            'danger'    => 'border-danger-200 bg-danger-50 text-danger-900 dark:border-danger-700 dark:bg-danger-900 dark:text-danger-100',
        ];

        $this->classList = trim('fltc-thread-message-card min-w-0 flex-1 rounded-xl border '.($cardMap[$this->color] ?? $cardMap['base']));
        $this->headClasses = 'flex flex-wrap items-baseline justify-between gap-x-3 gap-y-0.5 px-4 pt-3 text-sm';
        $this->metaClasses = 'text-xs '.Shades::tertiary($this->color);
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.thread.message');
    }
}
