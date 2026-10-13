<?php

namespace Fsteltenkamp\TwcssComponents\View\Components;

use Closure;
use Fsteltenkamp\TwcssComponents\Support\Shades;
use Fsteltenkamp\TwcssComponents\View\Component;
use Illuminate\Contracts\View\View;

/**
 * A file in a list: a preview, the name (a link with `href`), type and size, and an
 * `actions` slot (open, edit, delete). The preview is chosen from the extension: the
 * image itself for images (`src`, or `href`), the `excerpt` for text files, otherwise
 * an icon for the file type. A `preview` slot replaces it.
 */
class FileCard extends Component
{
    public const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif', 'svg', 'bmp'];
    public const TEXT_EXTENSIONS = ['txt', 'md', 'markdown', 'csv', 'log', 'json', 'xml', 'yml', 'yaml'];

    public string $classList;
    public string $previewClasses;
    public string $nameClasses;
    public string $metaClasses;
    public string $excerptClasses;
    public string $previewType;
    public string $fileIcon;
    public string $sizeLabel;

    public function __construct(
        public string $name = '',
        public string $href = '',
        public string $extension = '',
        public int|string|null $size = null,
        public string $src = '',
        public string $excerpt = '',
        public string $meta = '',
        public string $theme = 'slate',
    ) {
        $this->extension = strtolower($extension !== '' ? ltrim($extension, '.') : pathinfo($name, PATHINFO_EXTENSION));

        $this->previewType = match (true) {
            in_array($this->extension, static::IMAGE_EXTENSIONS, true) && ($src !== '' || $href !== '') => 'image',
            in_array($this->extension, static::TEXT_EXTENSIONS, true) && $excerpt !== '' => 'text',
            default => 'icon',
        };

        $this->fileIcon = static::iconFor($this->extension);
        $this->sizeLabel = is_int($size) ? static::formatBytes($size) : (string) $size;

        $surfaceMap = [
            'slate'     => 'border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900',
            'gray'      => 'border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900',
            'zinc'      => 'border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900',
            'neutral'   => 'border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900',
            'stone'     => 'border-stone-200 bg-white dark:border-stone-700 dark:bg-stone-900',
            'red'       => 'border-red-200 bg-white dark:border-red-700 dark:bg-red-900',
            'orange'    => 'border-orange-200 bg-white dark:border-orange-700 dark:bg-orange-900',
            'amber'     => 'border-amber-200 bg-white dark:border-amber-700 dark:bg-amber-900',
            'yellow'    => 'border-yellow-200 bg-white dark:border-yellow-700 dark:bg-yellow-900',
            'lime'      => 'border-lime-200 bg-white dark:border-lime-700 dark:bg-lime-900',
            'green'     => 'border-green-200 bg-white dark:border-green-700 dark:bg-green-900',
            'emerald'   => 'border-emerald-200 bg-white dark:border-emerald-700 dark:bg-emerald-900',
            'teal'      => 'border-teal-200 bg-white dark:border-teal-700 dark:bg-teal-900',
            'cyan'      => 'border-cyan-200 bg-white dark:border-cyan-700 dark:bg-cyan-900',
            'sky'       => 'border-sky-200 bg-white dark:border-sky-700 dark:bg-sky-900',
            'blue'      => 'border-blue-200 bg-white dark:border-blue-700 dark:bg-blue-900',
            'indigo'    => 'border-indigo-200 bg-white dark:border-indigo-700 dark:bg-indigo-900',
            'violet'    => 'border-violet-200 bg-white dark:border-violet-700 dark:bg-violet-900',
            'purple'    => 'border-purple-200 bg-white dark:border-purple-700 dark:bg-purple-900',
            'fuchsia'   => 'border-fuchsia-200 bg-white dark:border-fuchsia-700 dark:bg-fuchsia-900',
            'pink'      => 'border-pink-200 bg-white dark:border-pink-700 dark:bg-pink-900',
            'rose'      => 'border-rose-200 bg-white dark:border-rose-700 dark:bg-rose-900',
            'taupe'     => 'border-taupe-200 bg-white dark:border-taupe-700 dark:bg-taupe-900',
            'mauve'     => 'border-mauve-200 bg-white dark:border-mauve-700 dark:bg-mauve-900',
            'mist'      => 'border-mist-200 bg-white dark:border-mist-700 dark:bg-mist-900',
            'olive'     => 'border-olive-200 bg-white dark:border-olive-700 dark:bg-olive-900',
            'palette'      => 'border-palette-200 bg-white dark:border-palette-700 dark:bg-palette-900',
            'cyberpunk' => 'border-cyberpunk-200 bg-white dark:border-cyberpunk-700 dark:bg-cyberpunk-900',
            'fantasy'   => 'border-fantasy-200 bg-white dark:border-fantasy-700 dark:bg-fantasy-900',
            'wh40k'     => 'border-wh40k-200 bg-white dark:border-wh40k-700 dark:bg-wh40k-900',
        ];

        $previewMap = [
            'slate'     => 'border-slate-200 bg-slate-50 text-slate-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-400',
            'gray'      => 'border-gray-200 bg-gray-50 text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400',
            'zinc'      => 'border-zinc-200 bg-zinc-50 text-zinc-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400',
            'neutral'   => 'border-neutral-200 bg-neutral-50 text-neutral-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-400',
            'stone'     => 'border-stone-200 bg-stone-50 text-stone-500 dark:border-stone-700 dark:bg-stone-800 dark:text-stone-400',
            'red'       => 'border-red-200 bg-red-50 text-red-500 dark:border-red-700 dark:bg-red-800 dark:text-red-400',
            'orange'    => 'border-orange-200 bg-orange-50 text-orange-500 dark:border-orange-700 dark:bg-orange-800 dark:text-orange-400',
            'amber'     => 'border-amber-200 bg-amber-50 text-amber-500 dark:border-amber-700 dark:bg-amber-800 dark:text-amber-400',
            'yellow'    => 'border-yellow-200 bg-yellow-50 text-yellow-500 dark:border-yellow-700 dark:bg-yellow-800 dark:text-yellow-400',
            'lime'      => 'border-lime-200 bg-lime-50 text-lime-500 dark:border-lime-700 dark:bg-lime-800 dark:text-lime-400',
            'green'     => 'border-green-200 bg-green-50 text-green-500 dark:border-green-700 dark:bg-green-800 dark:text-green-400',
            'emerald'   => 'border-emerald-200 bg-emerald-50 text-emerald-500 dark:border-emerald-700 dark:bg-emerald-800 dark:text-emerald-400',
            'teal'      => 'border-teal-200 bg-teal-50 text-teal-500 dark:border-teal-700 dark:bg-teal-800 dark:text-teal-400',
            'cyan'      => 'border-cyan-200 bg-cyan-50 text-cyan-500 dark:border-cyan-700 dark:bg-cyan-800 dark:text-cyan-400',
            'sky'       => 'border-sky-200 bg-sky-50 text-sky-500 dark:border-sky-700 dark:bg-sky-800 dark:text-sky-400',
            'blue'      => 'border-blue-200 bg-blue-50 text-blue-500 dark:border-blue-700 dark:bg-blue-800 dark:text-blue-400',
            'indigo'    => 'border-indigo-200 bg-indigo-50 text-indigo-500 dark:border-indigo-700 dark:bg-indigo-800 dark:text-indigo-400',
            'violet'    => 'border-violet-200 bg-violet-50 text-violet-500 dark:border-violet-700 dark:bg-violet-800 dark:text-violet-400',
            'purple'    => 'border-purple-200 bg-purple-50 text-purple-500 dark:border-purple-700 dark:bg-purple-800 dark:text-purple-400',
            'fuchsia'   => 'border-fuchsia-200 bg-fuchsia-50 text-fuchsia-500 dark:border-fuchsia-700 dark:bg-fuchsia-800 dark:text-fuchsia-400',
            'pink'      => 'border-pink-200 bg-pink-50 text-pink-500 dark:border-pink-700 dark:bg-pink-800 dark:text-pink-400',
            'rose'      => 'border-rose-200 bg-rose-50 text-rose-500 dark:border-rose-700 dark:bg-rose-800 dark:text-rose-400',
            'taupe'     => 'border-taupe-200 bg-taupe-50 text-taupe-500 dark:border-taupe-700 dark:bg-taupe-800 dark:text-taupe-400',
            'mauve'     => 'border-mauve-200 bg-mauve-50 text-mauve-500 dark:border-mauve-700 dark:bg-mauve-800 dark:text-mauve-400',
            'mist'      => 'border-mist-200 bg-mist-50 text-mist-500 dark:border-mist-700 dark:bg-mist-800 dark:text-mist-400',
            'olive'     => 'border-olive-200 bg-olive-50 text-olive-500 dark:border-olive-700 dark:bg-olive-800 dark:text-olive-400',
            'palette'      => 'border-palette-200 bg-palette-50 text-palette-500 dark:border-palette-700 dark:bg-palette-800 dark:text-palette-400',
            'cyberpunk' => 'border-cyberpunk-200 bg-cyberpunk-50 text-cyberpunk-500 dark:border-cyberpunk-700 dark:bg-cyberpunk-800 dark:text-cyberpunk-400',
            'fantasy'   => 'border-fantasy-200 bg-fantasy-50 text-fantasy-500 dark:border-fantasy-700 dark:bg-fantasy-800 dark:text-fantasy-400',
            'wh40k'     => 'border-wh40k-200 bg-wh40k-50 text-wh40k-500 dark:border-wh40k-700 dark:bg-wh40k-800 dark:text-wh40k-400',
        ];

        $this->classList = 'flex items-center gap-3 rounded-lg border p-2 pr-3 '.($surfaceMap[$theme] ?? $surfaceMap['slate']);
        $this->previewClasses = 'relative flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-md border '.($previewMap[$theme] ?? $previewMap['slate']);
        $this->nameClasses = 'block truncate text-sm font-medium '.Shades::primary($theme);
        $this->metaClasses = 'block truncate text-xs uppercase tracking-wide '.Shades::tertiary($theme);
        $this->excerptClasses = 'absolute inset-0 overflow-hidden p-1 font-mono text-[0.45rem] leading-[0.6rem] normal-case '.Shades::secondary($theme);
    }

    /**
     * Phosphor icon for a file extension.
     */
    public static function iconFor(string $extension): string
    {
        $groups = [
            'file-pdf'   => ['pdf'],
            'file-doc'   => ['doc', 'docx', 'odt', 'rtf'],
            'file-xls'   => ['xls', 'xlsx', 'ods', 'csv'],
            'file-ppt'   => ['ppt', 'pptx', 'odp'],
            'file-zip'   => ['zip', 'rar', '7z', 'tar', 'gz'],
            'file-audio' => ['mp3', 'wav', 'ogg', 'flac', 'm4a'],
            'file-video' => ['mp4', 'mov', 'webm', 'mkv', 'avi'],
            'file-image' => self::IMAGE_EXTENSIONS,
            'file-code'  => ['php', 'js', 'ts', 'html', 'css', 'json', 'xml', 'yml', 'yaml', 'sh'],
            'file-text'  => ['txt', 'md', 'markdown', 'log', 'epub'],
        ];

        foreach ($groups as $icon => $extensions) {
            if (in_array($extension, $extensions, true)) {
                return $icon;
            }
        }

        return 'file';
    }

    public static function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $bytes > 0 ? min((int) floor(log($bytes, 1024)), count($units) - 1) : 0;
        $value = $bytes / (1024 ** $power);

        return ($power === 0 ? $value : number_format($value, $value < 10 ? 1 : 0)).' '.$units[$power];
    }

    public function render(): View|Closure|string
    {
        return view('fltc::components.file-card');
    }
}
