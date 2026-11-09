@php
    use App\Support\Localized;
@endphp

<nav aria-label="{{ __('site.nav.language') }}" {{ $attributes->class('items-center gap-0.5 rounded-[4px] border border-white/20 p-0.5 font-display text-sm font-bold') }}>
    @foreach (config('site.locales') as $locale)
        <a
            href="{{ Localized::switchTo($locale) }}"
            hreflang="{{ $locale }}"
            lang="{{ $locale }}"
            @if (app()->isLocale($locale)) aria-current="true" @endif
            @class([
                'rounded-[2px] px-2 py-0.5 uppercase transition-colors duration-300',
                'bg-brand-yellow text-ink-950' => app()->isLocale($locale),
                'text-white/60 hover:text-white' => ! app()->isLocale($locale),
            ])
        >{{ $locale }}</a>
    @endforeach
</nav>
