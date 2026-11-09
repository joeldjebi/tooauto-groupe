@props(['href' => null, 'variant' => 'primary', 'size' => 'md', 'icon' => null])

@php
    $sizes = [
        'sm' => 'px-4 py-2 text-[0.95rem]',
        'md' => 'px-6 py-3 text-base',
        'lg' => 'px-7 py-3.5 text-lg',
    ];

    $variants = [
        'primary' => 'bg-brand-yellow text-ink-950 hover:bg-white',
        'ghost' => 'border border-white/20 text-white hover:border-white/50 hover:bg-white/5',
        'light' => 'bg-white text-ink-950 hover:bg-brand-yellow',
        'dark' => 'bg-ink-950 text-white hover:bg-ink-700',
        'outline-dark' => 'border border-ink-950/15 text-ink-950 hover:border-ink-950/40',
    ];

    $classes = implode(' ', [
        'group/btn inline-flex items-center justify-center gap-2 rounded-[4px] font-display font-bold tracking-[0.04em] uppercase whitespace-nowrap',
        'transition-[background-color,color,border-color,transform] duration-300 ease-apple active:scale-[0.97]',
        $sizes[$size] ?? $sizes['md'],
        $variants[$variant] ?? $variants['primary'],
    ]);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>
        {{ $slot }}
        @if ($icon)
            <x-icon :name="$icon" class="size-4 transition-transform duration-300 ease-apple group-hover/btn:translate-x-0.5" />
        @endif
    </a>
@else
    <button {{ $attributes->merge(['type' => 'button'])->class($classes) }}>
        {{ $slot }}
        @if ($icon)
            <x-icon :name="$icon" class="size-4 transition-transform duration-300 ease-apple group-hover/btn:translate-x-0.5" />
        @endif
    </button>
@endif
