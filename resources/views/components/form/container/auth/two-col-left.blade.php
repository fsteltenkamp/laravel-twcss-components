<div @if (filled($id)) id="{{ $id }}" @endif class="{{ $classList }}">
    <div class="grid min-h-[560px] w-full md:grid-cols-12">
        <main class="{{ $mainClasses }}">
            <div class="w-full">
                {{$slot ?? ''}}
            </div>
        </main>
        <aside class="{{ $sideClasses }}">
            {{$side ?? ''}}
        </aside>
    </div>
</div>
