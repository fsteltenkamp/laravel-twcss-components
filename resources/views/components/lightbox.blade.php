<div
    x-data="{
        open: false,
        items: [],
        index: 0,
        get current() { return this.items[this.index] ?? { src: '', name: '' }; },
        describe(el) {
            return {
                src: el.dataset.fltcLightboxSrc || el.getAttribute('href') || el.getAttribute('src') || '',
                name: el.dataset.fltcLightboxName || el.getAttribute('title') || el.getAttribute('alt') || '',
            };
        },
        click(event) {
            const el = event.target.closest?.('[data-fltc-lightbox]');
            if (! el || event.ctrlKey || event.metaKey || event.shiftKey) return;
            event.preventDefault();
            const group = el.dataset.fltcLightbox;
            const members = group ? [...document.querySelectorAll('[data-fltc-lightbox]')].filter((m) => m.dataset.fltcLightbox === group) : [el];
            // One page per image, even when a card links it twice (preview and name).
            const items = members.map((m) => this.describe(m)).filter((item, i, all) => all.findIndex((o) => o.src === item.src) === i);
            const src = this.describe(el).src;
            this.show({ items, index: Math.max(0, items.findIndex((item) => item.src === src)) });
        },
        show(detail) {
            this.items = detail?.items ?? [{ src: detail?.src ?? '', name: detail?.name ?? '' }];
            this.index = detail?.index ?? 0;
            this.open = this.items.length > 0;
        },
        step(by) { this.index = (this.index + by + this.items.length) % this.items.length; },
    }"
    x-on:click.window="click($event)"
    x-on:fltc-lightbox.window="show($event.detail)"
    x-on:keydown.window="if (! open) return; if ($event.key === 'Escape') open = false; if ($event.key === 'ArrowRight') step(1); if ($event.key === 'ArrowLeft') step(-1)"
    {{ $attributes->class(['contents']) }}
>
    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            x-transition.opacity
            style="display: none;"
            class="fltc-lightbox-overlay fltc-color-{{ $color }} fixed inset-0 z-[60] flex flex-col items-center justify-center gap-3 bg-black/85 p-4 backdrop-blur-sm"
            x-on:click.self="open = false"
            role="dialog"
            aria-modal="true"
            aria-label="{{ __('Image viewer') }}"
        >
            <div class="absolute top-3 right-3 flex items-center gap-2">
                <span class="text-sm text-white/70 tabular-nums" x-show="items.length > 1" x-text="(index + 1) + ' / ' + items.length"></span>
                <x-fltc::button variant="ghost" square height="sm" color="base" icon="x" class="fltc-lightbox-close !text-white hover:!bg-white/10" x-on:click="open = false" :aria-label="__('Close')" />
            </div>
            <template x-if="items.length > 1">
                <div>
                    <x-fltc::button variant="ghost" square height="lg" color="base" icon="caret-left" class="fltc-lightbox-prev absolute top-1/2 left-3 -translate-y-1/2 !text-white hover:!bg-white/10" x-on:click="step(-1)" :aria-label="__('Previous')" />
                    <x-fltc::button variant="ghost" square height="lg" color="base" icon="caret-right" class="fltc-lightbox-next absolute top-1/2 right-3 -translate-y-1/2 !text-white hover:!bg-white/10" x-on:click="step(1)" :aria-label="__('Next')" />
                </div>
            </template>
            <img :src="current.src" :alt="current.name" class="fltc-lightbox-image max-h-[80vh] max-w-full rounded-md object-contain shadow-2xl" />
            <div class="fltc-lightbox-caption flex max-w-full items-center gap-3 text-sm text-white/90">
                <span class="truncate" x-text="current.name"></span>
                @if ($download)
                    <a :href="current.src" :download="current.name || true" class="inline-flex shrink-0 items-center gap-1 underline-offset-2 hover:underline"><x-fltc::icon name="download-simple" /> {{ __('Download') }}</a>
                @endif
            </div>
        </div>
    </template>
</div>
