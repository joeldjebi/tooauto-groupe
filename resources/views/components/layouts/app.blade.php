@props(['title' => null, 'description' => null])

@php
    use App\Support\Localized;

    $pageTitle = $title ?? __('site.meta.title');
    $pageDescription = $description ?? __('site.meta.description');
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="bg-asphalt">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="theme-color" content="#111111">

        <title>{{ $pageTitle }}</title>
        <meta name="description" content="{{ $pageDescription }}">
        <link rel="canonical" href="{{ url()->current() }}">

        @foreach (config('site.locales') as $locale)
            <link rel="alternate" hreflang="{{ $locale }}" href="{{ Localized::switchTo($locale) }}">
        @endforeach
        <link rel="alternate" hreflang="x-default" href="{{ Localized::switchTo(config('site.default_locale')) }}">

        <meta property="og:type" content="website">
        <meta property="og:site_name" content="TOOAUTO GROUP">
        <meta property="og:title" content="{{ $pageTitle }}">
        <meta property="og:description" content="{{ $pageDescription }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:locale" content="{{ app()->getLocale() === 'fr' ? 'fr_FR' : 'en_US' }}">
        <meta name="twitter:card" content="summary_large_image">

        {{-- Hide animated elements only when JS runs and motion is accepted; un-hide after 3s if the bundle never boots. --}}
        <script>
            (function () {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                var root = document.documentElement;
                root.classList.add('js');
                setTimeout(function () {
                    if (!root.classList.contains('motion-ready')) root.classList.remove('js');
                }, 3000);
            })();
        </script>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-svh bg-asphalt font-sans text-white antialiased selection:bg-brand-yellow selection:text-ink-950">
        <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[60] focus:rounded-full focus:bg-white focus:px-4 focus:py-2 focus:text-ink-950">
            {{ __('site.nav.skip') }}
        </a>

        <x-site-header />

        <main id="main">
            {{ $slot }}
        </main>

        <x-site-footer />

        <x-odometer />
    </body>
</html>
