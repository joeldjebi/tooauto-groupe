{{--
    Dashboard cluster pinned to the corner: the page scroll is the distance driven (1 px = 1 m),
    the scroll velocity is the speed. Purely decorative, so hidden from assistive tech.
--}}
<div data-odometer aria-hidden="true" class="pointer-events-none fixed bottom-5 left-5 z-40 hidden items-stretch gap-1.5 motion-reduce:!hidden md:flex">
    <div class="flex flex-col justify-between rounded-[4px] bg-sign px-3 py-2 ring-1 ring-white/10">
        <span class="font-display text-[0.65rem] font-bold tracking-[0.14em] text-white/40 uppercase">km/h</span>
        <span data-speed class="mt-1 w-[2.6ch] text-right font-display text-2xl leading-none font-bold text-white tabular-nums">0</span>
    </div>

    <div class="rounded-[4px] bg-sign px-3 py-2 ring-1 ring-white/10">
        <span class="font-display text-[0.65rem] font-bold tracking-[0.14em] text-white/40 uppercase">km</span>
        <div class="mt-1 flex items-end gap-[3px]">
            @foreach (range(1, 4) as $cell)
                @if ($cell === 4)
                    <span class="mb-0.5 font-display text-lg leading-none font-bold text-white/60">.</span>
                @endif
                <span @class(['odo-cell', 'odo-cell--tenth' => $cell === 4])>
                    <span class="odo-strip" data-odo-digit="{{ $cell }}">
                        @foreach ([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0] as $digit)
                            <span>{{ $digit }}</span>
                        @endforeach
                    </span>
                </span>
            @endforeach
        </div>
    </div>
</div>
