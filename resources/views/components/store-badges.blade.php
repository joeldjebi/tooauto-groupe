@php
    $stores = [
        ['url' => config('site.stores.google_play'), 'label' => __('site.app.store_google'), 'icon' => 'google-play'],
        ['url' => config('site.stores.app_store'), 'label' => __('site.app.store_apple'), 'icon' => 'apple'],
    ];
    $isLive = collect($stores)->contains(fn (array $store): bool => filled($store['url']));
@endphp

<div {{ $attributes->class('flex flex-col gap-3') }}>
    @unless ($isLive)
        <p class="flex items-center gap-2 text-sm text-white/50">
            <span class="relative flex size-2"><span class="absolute inline-flex size-full animate-ping rounded-full bg-brand-orange opacity-60"></span><span class="relative inline-flex size-2 rounded-full bg-brand-orange"></span></span>
            {{ __('site.app.coming_soon') }}
        </p>
    @endunless

    <div class="flex flex-wrap gap-3">
        @foreach ($stores as $store)
            @if (filled($store['url']))
                <a href="{{ $store['url'] }}" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-2xl border border-white/15 bg-white/[0.04] px-4 py-2.5 transition-colors hover:border-white/40">
            @else
                <span aria-disabled="true" class="flex cursor-default items-center gap-3 rounded-2xl border border-white/10 px-4 py-2.5 opacity-60">
            @endif
                <x-icon :name="$store['icon']" class="size-6" />
                <span class="leading-tight">
                    <span class="block text-[0.68rem] text-white/50">{{ __('site.app.download_on') }}</span>
                    <span class="block text-sm font-semibold">{{ $store['label'] }}</span>
                </span>
            @if (filled($store['url']))
                </a>
            @else
                </span>
            @endif
        @endforeach
    </div>
</div>
