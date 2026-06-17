@php $tableLabel = !empty($prefix) ? $prefix : 'root'; @endphp
<table {{ $attributes->class([$classList]) }}>
    <thead>
        <tr>
            <th class="px-3 py-2 {{ $headClasses }}">{{ $tableLabel }} - Indexe</th>
            <th class="px-3 py-2 {{ $headClasses }}">Werte</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($array as $key => $value)
        @php
            $index = !empty($prefix) ? $prefix . '.' . $key : $key;
            $varId = ($idPrefix ?? '') . $index . ($idSuffix ?? '');
        @endphp
        <tr id="{{ $index }}" class="transition-colors duration-150 {{ $hoverClasses }} {{ $stripeClasses }}">
            <td class="whitespace-nowrap w-[35%] {{ $cellClasses }} border-b {{ $borderClasses }}">
                @if (is_array($value))
                    <button
                        class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold rounded border {{ $borderClasses }} {{ $cellClasses }} hover:opacity-75 transition-opacity"
                        onclick="att_toggleChildren('{{ $index }}')"
                        aria-expanded="false"
                    >+</button>
                @else
                    <span class="inline-block w-6"></span>
                    <button
                        class="inline-flex items-center justify-center w-6 h-6 ml-1 text-xs rounded border {{ $borderClasses }} {{ $cellClasses }} hover:opacity-75 transition-opacity"
                        data-copy="{{ $varId }}"
                        onclick="att_copyIndex(this)"
                        title="Kopieren"
                    ><x-fltc::icon name="copy" class="text-sm" /></button>
                @endif
                <span class="font-mono ml-2 text-xs">{{ $varId }}</span>
            </td>
            <td class="{{ $cellClasses }} border-b {{ $borderClasses }}">
                @if (!is_array($value))
                    @if (strlen($value) > 100)
                        <textarea readonly class="w-full font-mono text-xs rounded border p-1 resize-y bg-transparent {{ $borderClasses }} {{ $cellClasses }}">{{ $value }}</textarea>
                    @else
                        <code class="font-mono text-xs">{{ $value }}</code>
                    @endif
                @else
                    <span class="text-xs opacity-60">({{ count($value) }})</span>
                @endif
            </td>
        </tr>

        @if (is_array($value))
            <tr id="children-row-{{ $index }}" style="display: none;">
                <td colspan="2" class="p-0 border-b {{ $borderClasses }}">
                    <div class="pl-4 py-1">
                        @if (!empty($debug) && $debug === true)
                            <details class="mb-2">
                                <summary class="cursor-pointer text-xs opacity-60">Show raw array</summary>
                                <pre class="text-xs rounded p-2 mt-1 bg-black/5 dark:bg-white/5">{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </details>
                        @endif

                        <x-fltc::array-to-table
                            :array="$value"
                            prefix="{{ $index }}"
                            idPrefix="{{ $idPrefix ?? '' }}"
                            idSuffix="{{ $idSuffix ?? '' }}"
                            :debug="$debug ?? false"
                            :theme="$theme"
                        />
                    </div>
                </td>
            </tr>
        @endif

    @endforeach
    </tbody>
</table>

<script>
    function att_toggleChildren(index) {
        const row = document.getElementById('children-row-' + index);
        if (!row) return;
        const isHidden = row.style.display === 'none';
        row.style.display = isHidden ? '' : 'none';
        const btn = document.querySelector('tr[id="' + index + '"] button');
        if (btn) {
            btn.textContent = isHidden ? '-' : '+';
            btn.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
        }
    }

    function att_copyIndex(el) {
        if (!el) return;
        const value = el.dataset && el.dataset.copy ? el.dataset.copy : '';
        if (!value) return;
        const originalText = el.textContent;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(value).then(() => {
                el.classList.add('!bg-green-500', '!text-white', '!border-green-600');
                setTimeout(() => el.classList.remove('!bg-green-500', '!text-white', '!border-green-600'), 1200);
            }).catch(() => fallbackCopy());
        } else {
            fallbackCopy();
        }

        function fallbackCopy() {
            const ta = document.createElement('textarea');
            ta.value = value;
            ta.style.position = 'fixed'; ta.style.top = '-9999px';
            document.body.appendChild(ta);
            ta.select();
            try {
                document.execCommand('copy');
                el.textContent = 'Copied';
                setTimeout(() => el.textContent = originalText, 1200);
            } catch (e) {
                // ignore
            }
            document.body.removeChild(ta);
        }
    }
</script>
