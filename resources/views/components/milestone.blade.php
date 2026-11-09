@props(['top', 'value', 'label'])

{{-- A roadside kilometre marker (borne kilométrique): coloured cap, white body. --}}
<div aria-hidden="true" {{ $attributes->class('relative flex w-[4.4rem] shrink-0 flex-col overflow-hidden rounded-t-[2.2rem] rounded-b-[3px] bg-lane text-center text-ink-950') }}>
    <span class="bg-brand-yellow pt-3.5 pb-1 font-display text-[0.7rem] leading-none font-bold tracking-[0.08em] uppercase">{{ $top }}</span>
    <span class="pt-1.5 font-display text-[1.7rem] leading-none font-extrabold">{{ $value }}</span>
    <span class="pb-2 font-display text-[0.62rem] font-bold tracking-[0.06em] text-ink-950/60 uppercase">{{ $label }}</span>
</div>
