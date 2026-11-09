@props(['tag', 'title', 'lead' => null, 'tone' => 'dark', 'align' => 'left'])

<div {{ $attributes->class(['max-w-3xl', 'mx-auto text-center' => $align === 'center']) }}>
    <p data-reveal @class([
        'flex items-center gap-3 font-display text-base font-bold tracking-[0.06em] uppercase',
        'justify-center' => $align === 'center',
        'text-white/60' => $tone === 'dark',
        'text-ink-950/60' => $tone === 'light',
    ])>
        <span aria-hidden="true" class="h-1 w-7 bg-brand-yellow"></span>
        {{ $tag }}
    </p>
    <h2 data-split class="mt-4 font-display text-[clamp(2.6rem,6vw,5rem)] leading-[0.92] font-bold uppercase text-balance">{{ $title }}</h2>
    @if ($lead)
        <p data-reveal @class([
            'mt-6 text-lg text-pretty sm:text-xl',
            'text-white/65' => $tone === 'dark',
            'text-ink-950/65' => $tone === 'light',
        ])>{{ $lead }}</p>
    @endif
</div>
