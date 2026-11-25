<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form;

use Closure;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * A Markdown textarea with a formatting toolbar (Ctrl/⌘+B, I, K) and an optional
 * preview. The preview's HTML comes from a Livewire method (`previewMethod`) or from the
 * host answering the `fltc-markdown-preview` window event; sanitise it on the server.
 * Slot `controls`: extra controls at the end of the toolbar; `insert(text)` puts text at
 * the cursor (e.g. a mention picker).
 */
class Markdown extends Component
{
    public const BUTTONS = [
        'bold' => ['icon' => 'text-b', 'label' => 'Bold (Ctrl+B)'],
        'italic' => ['icon' => 'text-italic', 'label' => 'Italic (Ctrl+I)'],
        'heading' => ['icon' => 'text-h', 'label' => 'Heading'],
        'code' => ['icon' => 'code', 'label' => 'Code'],
        'link' => ['icon' => 'link-simple', 'label' => 'Link (Ctrl+K)'],
        'ul' => ['icon' => 'list-bullets', 'label' => 'List'],
        'ol' => ['icon' => 'list-numbers', 'label' => 'Numbered list'],
        'quote' => ['icon' => 'quotes', 'label' => 'Quote'],
    ];

    /** @var array<string, array{icon: string, label: string}> */
    public array $toolbar = [];

    public string $frameClasses;
    public string $inputClasses;

    /**
     * @param  array<int, string>  $buttons  toolbar buttons, in order (keys of BUTTONS)
     * @param  bool  $preview  a Write / Preview switch
     * @param  string  $previewMethod  Livewire method that returns the preview HTML for the text
     */
    public function __construct(
        public string $id = '',
        public string $name = '',
        public string $label = '',
        public string $note = '',
        public string $value = '',
        public string $model = '',
        public bool $live = false,
        public string $placeholder = '',
        public int $rows = 8,
        public array $buttons = ['bold', 'italic', 'code', 'link', 'ul', 'ol', 'quote'],
        public bool $preview = false,
        public string $previewMethod = '',
        public bool $required = false,
        public bool $disabled = false,
        public string $color = 'base',
        public bool $inline = false,
        public string $wrapperClass = '',
        public string $error = '',
        public string $errorIcon = '',
        public bool $noteToggle = false,
    ) {
        if ($this->id === '') {
            $this->id = 'markdown-'.uniqid();
        }
        if ($this->name === '') {
            $this->name = $this->id;
        }

        foreach ($buttons as $button) {
            if (isset(self::BUTTONS[$button])) {
                $this->toolbar[$button] = ['icon' => self::BUTTONS[$button]['icon'], 'label' => __(self::BUTTONS[$button]['label'])];
            }
        }

        $frameMap = [
            'slate'     => 'border-slate-300 bg-white focus-within:border-slate-500 focus-within:ring-2 focus-within:ring-slate-500/30 dark:border-slate-600 dark:bg-slate-950 dark:focus-within:border-slate-400',
            'gray'      => 'border-gray-300 bg-white focus-within:border-gray-500 focus-within:ring-2 focus-within:ring-gray-500/30 dark:border-gray-600 dark:bg-gray-950 dark:focus-within:border-gray-400',
            'zinc'      => 'border-zinc-300 bg-white focus-within:border-zinc-500 focus-within:ring-2 focus-within:ring-zinc-500/30 dark:border-zinc-600 dark:bg-zinc-950 dark:focus-within:border-zinc-400',
            'neutral'   => 'border-neutral-300 bg-white focus-within:border-neutral-500 focus-within:ring-2 focus-within:ring-neutral-500/30 dark:border-neutral-600 dark:bg-neutral-950 dark:focus-within:border-neutral-400',
            'stone'     => 'border-stone-300 bg-white focus-within:border-stone-500 focus-within:ring-2 focus-within:ring-stone-500/30 dark:border-stone-600 dark:bg-stone-950 dark:focus-within:border-stone-400',
            'red'       => 'border-red-300 bg-white focus-within:border-red-500 focus-within:ring-2 focus-within:ring-red-500/30 dark:border-red-600 dark:bg-red-950 dark:focus-within:border-red-400',
            'orange'    => 'border-orange-300 bg-white focus-within:border-orange-500 focus-within:ring-2 focus-within:ring-orange-500/30 dark:border-orange-600 dark:bg-orange-950 dark:focus-within:border-orange-400',
            'amber'     => 'border-amber-300 bg-white focus-within:border-amber-500 focus-within:ring-2 focus-within:ring-amber-500/30 dark:border-amber-600 dark:bg-amber-950 dark:focus-within:border-amber-400',
            'yellow'    => 'border-yellow-300 bg-white focus-within:border-yellow-500 focus-within:ring-2 focus-within:ring-yellow-500/30 dark:border-yellow-600 dark:bg-yellow-950 dark:focus-within:border-yellow-400',
            'lime'      => 'border-lime-300 bg-white focus-within:border-lime-500 focus-within:ring-2 focus-within:ring-lime-500/30 dark:border-lime-600 dark:bg-lime-950 dark:focus-within:border-lime-400',
            'green'     => 'border-green-300 bg-white focus-within:border-green-500 focus-within:ring-2 focus-within:ring-green-500/30 dark:border-green-600 dark:bg-green-950 dark:focus-within:border-green-400',
            'emerald'   => 'border-emerald-300 bg-white focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-500/30 dark:border-emerald-600 dark:bg-emerald-950 dark:focus-within:border-emerald-400',
            'teal'      => 'border-teal-300 bg-white focus-within:border-teal-500 focus-within:ring-2 focus-within:ring-teal-500/30 dark:border-teal-600 dark:bg-teal-950 dark:focus-within:border-teal-400',
            'cyan'      => 'border-cyan-300 bg-white focus-within:border-cyan-500 focus-within:ring-2 focus-within:ring-cyan-500/30 dark:border-cyan-600 dark:bg-cyan-950 dark:focus-within:border-cyan-400',
            'sky'       => 'border-sky-300 bg-white focus-within:border-sky-500 focus-within:ring-2 focus-within:ring-sky-500/30 dark:border-sky-600 dark:bg-sky-950 dark:focus-within:border-sky-400',
            'blue'      => 'border-blue-300 bg-white focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/30 dark:border-blue-600 dark:bg-blue-950 dark:focus-within:border-blue-400',
            'indigo'    => 'border-indigo-300 bg-white focus-within:border-indigo-500 focus-within:ring-2 focus-within:ring-indigo-500/30 dark:border-indigo-600 dark:bg-indigo-950 dark:focus-within:border-indigo-400',
            'violet'    => 'border-violet-300 bg-white focus-within:border-violet-500 focus-within:ring-2 focus-within:ring-violet-500/30 dark:border-violet-600 dark:bg-violet-950 dark:focus-within:border-violet-400',
            'purple'    => 'border-purple-300 bg-white focus-within:border-purple-500 focus-within:ring-2 focus-within:ring-purple-500/30 dark:border-purple-600 dark:bg-purple-950 dark:focus-within:border-purple-400',
            'fuchsia'   => 'border-fuchsia-300 bg-white focus-within:border-fuchsia-500 focus-within:ring-2 focus-within:ring-fuchsia-500/30 dark:border-fuchsia-600 dark:bg-fuchsia-950 dark:focus-within:border-fuchsia-400',
            'pink'      => 'border-pink-300 bg-white focus-within:border-pink-500 focus-within:ring-2 focus-within:ring-pink-500/30 dark:border-pink-600 dark:bg-pink-950 dark:focus-within:border-pink-400',
            'rose'      => 'border-rose-300 bg-white focus-within:border-rose-500 focus-within:ring-2 focus-within:ring-rose-500/30 dark:border-rose-600 dark:bg-rose-950 dark:focus-within:border-rose-400',
            'taupe'     => 'border-taupe-300 bg-white focus-within:border-taupe-500 focus-within:ring-2 focus-within:ring-taupe-500/30 dark:border-taupe-600 dark:bg-taupe-950 dark:focus-within:border-taupe-400',
            'mauve'     => 'border-mauve-300 bg-white focus-within:border-mauve-500 focus-within:ring-2 focus-within:ring-mauve-500/30 dark:border-mauve-600 dark:bg-mauve-950 dark:focus-within:border-mauve-400',
            'mist'      => 'border-mist-300 bg-white focus-within:border-mist-500 focus-within:ring-2 focus-within:ring-mist-500/30 dark:border-mist-600 dark:bg-mist-950 dark:focus-within:border-mist-400',
            'olive'     => 'border-olive-300 bg-white focus-within:border-olive-500 focus-within:ring-2 focus-within:ring-olive-500/30 dark:border-olive-600 dark:bg-olive-950 dark:focus-within:border-olive-400',
            'primary'   => 'border-primary-300 bg-white focus-within:border-primary-500 focus-within:ring-2 focus-within:ring-primary-500/30 dark:border-primary-600 dark:bg-primary-950 dark:focus-within:border-primary-400',
            'secondary' => 'border-secondary-300 bg-white focus-within:border-secondary-500 focus-within:ring-2 focus-within:ring-secondary-500/30 dark:border-secondary-600 dark:bg-secondary-950 dark:focus-within:border-secondary-400',
            'accent'    => 'border-accent-300 bg-white focus-within:border-accent-500 focus-within:ring-2 focus-within:ring-accent-500/30 dark:border-accent-600 dark:bg-accent-950 dark:focus-within:border-accent-400',
            'base'      => 'border-base-300 bg-white focus-within:border-base-500 focus-within:ring-2 focus-within:ring-base-500/30 dark:border-base-600 dark:bg-base-950 dark:focus-within:border-base-400',
            'info'      => 'border-info-300 bg-white focus-within:border-info-500 focus-within:ring-2 focus-within:ring-info-500/30 dark:border-info-600 dark:bg-info-950 dark:focus-within:border-info-400',
            'success'   => 'border-success-300 bg-white focus-within:border-success-500 focus-within:ring-2 focus-within:ring-success-500/30 dark:border-success-600 dark:bg-success-950 dark:focus-within:border-success-400',
            'warning'   => 'border-warning-300 bg-white focus-within:border-warning-500 focus-within:ring-2 focus-within:ring-warning-500/30 dark:border-warning-600 dark:bg-warning-950 dark:focus-within:border-warning-400',
            'danger'    => 'border-danger-300 bg-white focus-within:border-danger-500 focus-within:ring-2 focus-within:ring-danger-500/30 dark:border-danger-600 dark:bg-danger-950 dark:focus-within:border-danger-400',
        ];

        $this->frameClasses = 'overflow-hidden rounded-md border shadow-sm transition '.($frameMap[$color] ?? $frameMap['base']);
        $this->inputClasses = 'block w-full resize-y border-0 bg-transparent px-3 py-2 font-mono text-sm leading-6 focus:outline-none focus:ring-0 dark:[color-scheme:dark] '.\Fsteltenkamp\TwcssComponents\Support\Shades::primary($color);
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.form.markdown');
    }
}
