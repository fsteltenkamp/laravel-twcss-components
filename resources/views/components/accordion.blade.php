<div
    {{ $attributes->class([
        $classList,
    ])->merge([
        'data-tailwind-accordion' => '',
        'data-tailwind-accordion-draggable' => $draggable ? 'true' : 'false',
        'data-tailwind-accordion-open-first' => $openFirst ? 'true' : 'false',
    ]) }}
>
    {{ $slot }}
</div>

@once
    <script>
        if (!window.__tailwindAccordionInitialized) {
            window.__tailwindAccordionInitialized = true;

            const containerSelector = '[data-tailwind-accordion]';
            const itemSelector = '[data-accordion-item]';
            const handleSelector = '[data-accordion-drag-handle]';

            const setItemExpanded = (item, expanded) => {
                if (!item) {
                    return;
                }

                const trigger = item.querySelector('[data-accordion-trigger]');
                const content = item.querySelector('[data-accordion-content]');
                const chevron = trigger?.querySelector('[data-accordion-chevron]');

                if (!trigger || !content) {
                    return;
                }

                trigger.setAttribute('aria-expanded', expanded ? 'true' : 'false');
                content.hidden = !expanded;

                if (chevron) {
                    chevron.classList.toggle('rotate-180', expanded);
                }
            };

            const setupContainer = (container) => {
                if (!container || container.__tailwindAccordionSetup) {
                    return;
                }

                container.__tailwindAccordionSetup = true;

                container.addEventListener('click', (event) => {
                    const trigger = event.target.closest('[data-accordion-trigger]');

                    if (!trigger || !container.contains(trigger)) {
                        return;
                    }

                    if (event.target.closest(handleSelector)) {
                        return;
                    }

                    const item = trigger.closest(itemSelector);

                    if (!item) {
                        return;
                    }

                    const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
                    setItemExpanded(item, !isExpanded);
                });

                const refreshItems = () => {
                    const allowContainerDrag = container.getAttribute('data-tailwind-accordion-draggable') === 'true';

                    container.querySelectorAll(itemSelector).forEach((item) => {
                        const allowItemDrag = item.getAttribute('data-accordion-item-draggable') === 'true';
                        item.draggable = allowContainerDrag && allowItemDrag;
                    });
                };

                container.__refreshAccordionItems = refreshItems;

                const getDropTarget = (containerElement, yPos) => {
                    const candidates = [...containerElement.querySelectorAll(itemSelector)].filter((item) => {
                        return item !== containerElement.__draggingItem;
                    });

                    return candidates.reduce((closest, item) => {
                        const bounds = item.getBoundingClientRect();
                        const offset = yPos - bounds.top - bounds.height / 2;

                        if (offset < 0 && offset > closest.offset) {
                            return {
                                offset,
                                element: item,
                            };
                        }

                        return closest;
                    }, {
                        offset: Number.NEGATIVE_INFINITY,
                        element: null,
                    }).element;
                };

                container.addEventListener('pointerdown', (event) => {
                    const item = event.target.closest(itemSelector);

                    if (!item || !container.contains(item)) {
                        return;
                    }

                    item.__dragFromHandle = event.target.closest(handleSelector) !== null;
                });

                container.addEventListener('dragstart', (event) => {
                    const item = event.target.closest(itemSelector);

                    if (!item || !container.contains(item) || !item.draggable || !item.__dragFromHandle) {
                        event.preventDefault();
                        return;
                    }

                    container.__draggingItem = item;
                    item.classList.add('opacity-60');

                    if (event.dataTransfer) {
                        event.dataTransfer.effectAllowed = 'move';
                        event.dataTransfer.setData('text/plain', 'tailwind-accordion-item');
                    }
                });

                container.addEventListener('dragover', (event) => {
                    if (!container.__draggingItem) {
                        return;
                    }

                    event.preventDefault();

                    const target = getDropTarget(container, event.clientY);
                    const draggingItem = container.__draggingItem;

                    if (!draggingItem) {
                        return;
                    }

                    if (target === null) {
                        container.appendChild(draggingItem);
                        return;
                    }

                    if (target !== draggingItem) {
                        container.insertBefore(draggingItem, target);
                    }
                });

                const clearDragState = () => {
                    const draggingItem = container.__draggingItem;

                    if (!draggingItem) {
                        return;
                    }

                    draggingItem.classList.remove('opacity-60');
                    draggingItem.__dragFromHandle = false;
                    container.__draggingItem = null;
                };

                container.addEventListener('drop', (event) => {
                    if (!container.__draggingItem) {
                        return;
                    }

                    event.preventDefault();
                    clearDragState();
                });

                container.addEventListener('dragend', () => {
                    clearDragState();
                });

                refreshItems();
            };

            const openFirstIfNeeded = (container) => {
                if (container.getAttribute('data-tailwind-accordion-open-first') === 'false') return;
                const items = [...container.querySelectorAll(itemSelector)];
                const hasExpandedItem = items.some((item) => {
                    const trigger = item.querySelector('[data-accordion-trigger]');
                    return trigger?.getAttribute('aria-expanded') === 'true';
                });
                if (!hasExpandedItem && items.length > 0) {
                    setItemExpanded(items[0], true);
                }
            };

            const initAll = () => {
                document.querySelectorAll(containerSelector).forEach((container) => {
                    setupContainer(container);
                    container.__refreshAccordionItems?.();
                    openFirstIfNeeded(container);
                });
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initAll);
            } else {
                initAll();
            }

            let __accordionInitTimer;
            const observer = new MutationObserver(() => {
                clearTimeout(__accordionInitTimer);
                __accordionInitTimer = setTimeout(initAll, 0);
            });

            observer.observe(document.documentElement, {
                childList: true,
                subtree: true,
            });
        }
    </script>
@endonce
