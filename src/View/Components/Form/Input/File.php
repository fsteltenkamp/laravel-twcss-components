<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form\Input;

use Fsteltenkamp\TwcssComponents\View\Components\Form\Input;
use Closure;
use Illuminate\Contracts\View\View;

/**
 * Native file picker (<input type="file">). `accept` and `multiple` pass through as
 * attributes; `model` binds a Livewire file upload (WithFileUploads).
 */
class File extends Input
{
    public string $normalClasses;
    public string $errorClasses;
    public string $wrapperClasses;

    // The input has no text padding of its own: the "Choose file" button (the
    // ::file-selector-button, styled with file:) fills the left edge.
    protected string $baseClasses = 'block w-full cursor-pointer rounded-md border text-sm shadow-sm transition duration-150 focus:outline-none focus:ring-2 disabled:cursor-not-allowed disabled:opacity-60 dark:[color-scheme:dark] file:mr-3 file:cursor-pointer file:border-0 file:px-4 file:py-2 file:text-sm file:font-semibold file:transition';

    public function __construct(
        public string $id = '',
        public string $name = '',
        public string $model = '',
        public bool $live = false,
        public bool $required = false,
        public bool $disabled = false,
        public string $theme = 'slate',
        public string $class = '',
        public string $label = '',
        public bool $inline = false,
        public string $wrapperClass = '',
    ) {
        $buttonMap = [
            'slate'     => 'file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 dark:file:bg-slate-800 dark:file:text-slate-200 dark:hover:file:bg-slate-700',
            'gray'      => 'file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-gray-800 dark:file:text-gray-200 dark:hover:file:bg-gray-700',
            'zinc'      => 'file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200 dark:file:bg-zinc-800 dark:file:text-zinc-200 dark:hover:file:bg-zinc-700',
            'neutral'   => 'file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200 dark:file:bg-neutral-800 dark:file:text-neutral-200 dark:hover:file:bg-neutral-700',
            'stone'     => 'file:bg-stone-100 file:text-stone-700 hover:file:bg-stone-200 dark:file:bg-stone-800 dark:file:text-stone-200 dark:hover:file:bg-stone-700',
            'red'       => 'file:bg-red-100 file:text-red-700 hover:file:bg-red-200 dark:file:bg-red-800 dark:file:text-red-200 dark:hover:file:bg-red-700',
            'orange'    => 'file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200 dark:file:bg-orange-800 dark:file:text-orange-200 dark:hover:file:bg-orange-700',
            'amber'     => 'file:bg-amber-100 file:text-amber-700 hover:file:bg-amber-200 dark:file:bg-amber-800 dark:file:text-amber-200 dark:hover:file:bg-amber-700',
            'yellow'    => 'file:bg-yellow-100 file:text-yellow-700 hover:file:bg-yellow-200 dark:file:bg-yellow-800 dark:file:text-yellow-200 dark:hover:file:bg-yellow-700',
            'lime'      => 'file:bg-lime-100 file:text-lime-700 hover:file:bg-lime-200 dark:file:bg-lime-800 dark:file:text-lime-200 dark:hover:file:bg-lime-700',
            'green'     => 'file:bg-green-100 file:text-green-700 hover:file:bg-green-200 dark:file:bg-green-800 dark:file:text-green-200 dark:hover:file:bg-green-700',
            'emerald'   => 'file:bg-emerald-100 file:text-emerald-700 hover:file:bg-emerald-200 dark:file:bg-emerald-800 dark:file:text-emerald-200 dark:hover:file:bg-emerald-700',
            'teal'      => 'file:bg-teal-100 file:text-teal-700 hover:file:bg-teal-200 dark:file:bg-teal-800 dark:file:text-teal-200 dark:hover:file:bg-teal-700',
            'cyan'      => 'file:bg-cyan-100 file:text-cyan-700 hover:file:bg-cyan-200 dark:file:bg-cyan-800 dark:file:text-cyan-200 dark:hover:file:bg-cyan-700',
            'sky'       => 'file:bg-sky-100 file:text-sky-700 hover:file:bg-sky-200 dark:file:bg-sky-800 dark:file:text-sky-200 dark:hover:file:bg-sky-700',
            'blue'      => 'file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 dark:file:bg-blue-800 dark:file:text-blue-200 dark:hover:file:bg-blue-700',
            'indigo'    => 'file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 dark:file:bg-indigo-800 dark:file:text-indigo-200 dark:hover:file:bg-indigo-700',
            'violet'    => 'file:bg-violet-100 file:text-violet-700 hover:file:bg-violet-200 dark:file:bg-violet-800 dark:file:text-violet-200 dark:hover:file:bg-violet-700',
            'purple'    => 'file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200 dark:file:bg-purple-800 dark:file:text-purple-200 dark:hover:file:bg-purple-700',
            'fuchsia'   => 'file:bg-fuchsia-100 file:text-fuchsia-700 hover:file:bg-fuchsia-200 dark:file:bg-fuchsia-800 dark:file:text-fuchsia-200 dark:hover:file:bg-fuchsia-700',
            'pink'      => 'file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200 dark:file:bg-pink-800 dark:file:text-pink-200 dark:hover:file:bg-pink-700',
            'rose'      => 'file:bg-rose-100 file:text-rose-700 hover:file:bg-rose-200 dark:file:bg-rose-800 dark:file:text-rose-200 dark:hover:file:bg-rose-700',
            'taupe'     => 'file:bg-taupe-100 file:text-taupe-700 hover:file:bg-taupe-200 dark:file:bg-taupe-800 dark:file:text-taupe-200 dark:hover:file:bg-taupe-700',
            'mauve'     => 'file:bg-mauve-100 file:text-mauve-700 hover:file:bg-mauve-200 dark:file:bg-mauve-800 dark:file:text-mauve-200 dark:hover:file:bg-mauve-700',
            'mist'      => 'file:bg-mist-100 file:text-mist-700 hover:file:bg-mist-200 dark:file:bg-mist-800 dark:file:text-mist-200 dark:hover:file:bg-mist-700',
            'olive'     => 'file:bg-olive-100 file:text-olive-700 hover:file:bg-olive-200 dark:file:bg-olive-800 dark:file:text-olive-200 dark:hover:file:bg-olive-700',
            'skin'      => 'file:bg-skin-100 file:text-skin-700 hover:file:bg-skin-200 dark:file:bg-skin-800 dark:file:text-skin-200 dark:hover:file:bg-skin-700',
            'cyberpunk' => 'file:bg-cyberpunk-100 file:text-cyberpunk-700 hover:file:bg-cyberpunk-200 dark:file:bg-cyberpunk-800 dark:file:text-cyberpunk-200 dark:hover:file:bg-cyberpunk-700',
            'fantasy'   => 'file:bg-fantasy-100 file:text-fantasy-700 hover:file:bg-fantasy-200 dark:file:bg-fantasy-800 dark:file:text-fantasy-200 dark:hover:file:bg-fantasy-700',
            'wh40k'     => 'file:bg-wh40k-100 file:text-wh40k-700 hover:file:bg-wh40k-200 dark:file:bg-wh40k-800 dark:file:text-wh40k-200 dark:hover:file:bg-wh40k-700',
        ];

        if ($this->name === '') {
            $this->name = $this->id;
        }

        $button = $buttonMap[$theme] ?? $buttonMap['slate'];

        $this->normalClasses  = $this->getNormalClasses($theme, trim($button.' '.$class));
        $this->errorClasses   = $this->getErrorClasses(trim($button.' '.$class));
        $this->wrapperClasses = $this->getWrapperClasses($inline, $wrapperClass);

        if (empty($id)) {
            $this->id = 'file-' . uniqid();
        }
    }

    protected function leftPadding(): string
    {
        return '';
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.form.input.file');
    }
}
