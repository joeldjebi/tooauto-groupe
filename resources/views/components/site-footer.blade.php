@php
    use App\Support\Localized;

    $home = Localized::route('home');
@endphp

<footer class="border-t border-white/10 bg-ink-950 pt-20 pb-10 text-sm text-white/50">
    <div class="container-site">
        <div class="grid gap-12 md:grid-cols-[1.5fr_1fr_1fr]">
            <div>
                <a href="{{ $home }}" aria-label="TOOAUTO GROUP" class="inline-block"><x-logo class="h-10" /></a>
                <p class="mt-5 max-w-xs text-pretty">{{ __('site.footer.tagline') }}</p>
                <x-locale-switch class="mt-6 inline-flex" />
            </div>

            <div>
                <h2 class="text-sm font-semibold text-white">{{ __('site.footer.directions') }}</h2>
                <ul class="mt-4 space-y-2.5">
                    @foreach (__('site.directions.items') as $direction)
                        <li><a href="{{ $home.'#'.$direction['target'] }}" class="transition-colors hover:text-white">{{ $direction['name'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h2 class="text-sm font-semibold text-white">{{ __('site.footer.group') }}</h2>
                <ul class="mt-4 space-y-2.5">
                    <li><a href="{{ $home }}#groupe" class="transition-colors hover:text-white">{{ __('site.footer.about') }}</a></li>
                    <li><a href="{{ $home }}#contact" class="transition-colors hover:text-white">{{ __('site.footer.contact') }}</a></li>
                    <li><a href="mailto:{{ config('site.contact.email') }}" class="transition-colors hover:text-white">{{ config('site.contact.email') }}</a></li>
                    <li><a href="tel:{{ preg_replace('/\s+/', '', config('site.contact.mobile')) }}" class="transition-colors hover:text-white">{{ config('site.contact.mobile') }}</a></li>
                </ul>
            </div>
        </div>

        <details class="group mt-16 border-t border-white/10 pt-6">
            <summary class="flex cursor-pointer list-none items-center gap-2 font-medium text-white/70 transition-colors hover:text-white [&::-webkit-details-marker]:hidden">
                {{ __('site.footer.legal') }}
                <x-icon name="chevron-right" class="size-4 transition-transform duration-300 group-open:rotate-90" />
            </summary>
            <p class="mt-4 max-w-3xl leading-relaxed">
                {{ __('site.footer.legal_text', [
                    'rcc' => config('site.legal.rcc'),
                    'cc' => config('site.legal.cc'),
                    'address' => config('site.contact.address'),
                    'postal' => config('site.contact.postal_address'),
                ]) }}
            </p>
        </details>

        <div class="mt-8 flex flex-col justify-between gap-3 border-t border-white/10 pt-6 sm:flex-row">
            <p>© {{ now()->year }} TOOAUTO GROUP. {{ __('site.footer.rights') }}</p>
            <p>RCC {{ config('site.legal.rcc') }} · CC {{ config('site.legal.cc') }}</p>
        </div>
    </div>
</footer>
