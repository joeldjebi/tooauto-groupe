@php
    use App\Http\Requests\ContactRequest;
    use Illuminate\Support\Number;

    $locale = app()->getLocale();
    $formatPrice = fn (int $amount): string => Number::format($amount, locale: $locale);
    $appSteps = __('site.app.steps');
@endphp

<x-layouts.app>

    {{-- ============================================================
         01 · HERO — the road seen from above; scrolling is driving.
    ============================================================= --}}
    <section data-hero class="relative isolate overflow-hidden bg-asphalt">
        <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-[-10rem] -z-10 w-[19rem] max-lg:opacity-45 sm:right-[-3rem] lg:right-[3%] lg:w-[22rem] xl:right-[6%]">
            <div data-road class="relative h-full bg-road">
                <span class="absolute inset-y-0 left-5 w-1.5 bg-lane/80"></span>
                <span class="absolute inset-y-0 right-5 w-1.5 bg-lane/80"></span>
                <span class="lane-dashes-y absolute inset-y-0 left-1/2 w-2 -translate-x-1/2"></span>

                {{-- Oncoming traffic, left lane --}}
                <div class="absolute top-0 left-[19%] w-14 motion-safe:animate-oncoming lg:w-16">
                    <x-car-top body="#e9e8e3" roof="#cfcec8" class="w-full rotate-180" />
                </div>

                {{-- Pedestrian crossing where the road meets the next section --}}
                <span class="absolute inset-x-5 bottom-8 flex h-20 justify-between bg-road px-3 py-2">
                    @foreach (range(1, 7) as $stripe)
                        <span class="w-[9%] bg-lane/85"></span>
                    @endforeach
                </span>
                <span class="absolute inset-x-5 bottom-[7.5rem] h-1.5 bg-lane/85"></span>

                {{-- Our car, right lane --}}
                <div data-hero-car class="absolute top-[58%] right-[17%] w-14 lg:w-[4.4rem]">
                    <x-car-top class="w-full" />
                </div>
            </div>
        </div>

        <div data-hero-content class="container-site flex min-h-svh flex-col justify-center pt-28 pb-24">
            <div data-hero-fade class="flex items-end gap-5">
                <x-milestone :top="__('site.hero.milestone_top')" value="0" label="km" />
                <p class="max-w-[17rem] pb-1 font-display text-lg leading-tight font-bold tracking-[0.04em] text-white/70 uppercase">{{ __('site.hero.kicker') }}</p>
            </div>

            <h1 data-hero-title class="mt-10 max-w-4xl font-display text-[clamp(3.4rem,7vw,8rem)] lg:max-w-[62%] leading-[0.86] font-extrabold uppercase">
                <span data-wipe-line data-wipe-color="#FFC20E" class="block"><span>{{ __('site.hero.title_a') }}</span></span>
                <span data-wipe-line data-wipe-color="#ECEBE6" class="block text-brand-yellow"><span>{{ __('site.hero.title_b') }}</span></span>
            </h1>

            <p data-hero-fade class="mt-8 max-w-lg text-xl text-white/70">{{ __('site.hero.lead') }}</p>

            <div data-hero-fade class="mt-10 flex flex-wrap gap-3">
                <x-button href="#tooauto" size="lg" icon="arrow-right">{{ __('site.hero.cta_primary') }}</x-button>
                <x-button href="#pro" size="lg" variant="ghost">{{ __('site.hero.cta_secondary') }}</x-button>
            </div>
        </div>
    </section>

    {{-- ============================================================
         02 · CHOOSE YOUR SPACE
    ============================================================= --}}
    <section id="espaces" class="relative py-24 sm:py-36">
        <div class="container-site">
            <x-section-heading :tag="__('site.spaces.tag')" :title="__('site.spaces.title')" />

            <div data-reveal-stagger class="mt-14 grid gap-4 md:grid-cols-3 [perspective:1400px]">
                @foreach (__('site.spaces.items') as $space)
                    <a
                        href="#{{ $space['target'] }}"
                        data-tilt
                        class="group relative flex min-h-[21rem] flex-col overflow-hidden rounded-[6px] border border-white/10 bg-ink-800 p-8 transition-[border-color] duration-500 hover:border-brand-yellow [transform-style:preserve-3d]"
                    >
                        <span class="grid size-12 place-items-center rounded-2xl bg-white/[0.08] text-brand-yellow">
                            <x-icon :name="$space['icon']" class="size-6" />
                        </span>

                        <h3 class="mt-auto pt-14 font-display text-3xl leading-none font-bold uppercase text-balance">{{ $space['who'] }}</h3>
                        <p class="mt-3 text-white/60">{{ $space['text'] }}</p>

                        <span class="mt-8 inline-flex items-center gap-2 font-display text-base font-bold tracking-[0.04em] text-brand-yellow uppercase">
                            {{ $space['cta'] }}
                            <x-icon name="arrow-right" class="size-4 transition-transform duration-500 ease-apple group-hover:translate-x-1" />
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================
         03 · SEVEN DIRECTIONS — motorway exit signs passing by
         (pinned horizontal drive on desktop, stacked signs on mobile)
    ============================================================= --}}
    <section id="directions" data-directions class="relative overflow-hidden bg-ink-800 pt-24 sm:pt-32 lg:flex lg:h-svh lg:flex-col lg:pt-24">
        <div class="container-site flex flex-col justify-between gap-8 lg:flex-row lg:items-end">
            <x-section-heading :tag="__('site.directions.tag')" :title="__('site.directions.title')" />

            <p aria-hidden="true" class="hidden shrink-0 items-center gap-2.5 font-display text-xl font-bold tracking-[0.04em] uppercase lg:flex">
                <span class="text-white/50">{{ __('site.directions.exit') }}</span>
                <span data-directions-current class="rounded-[3px] bg-brand-yellow px-2 text-ink-950 tabular-nums">01</span>
                <span class="text-white/40">/ {{ str_pad(count(__('site.directions.items')), 2, '0', STR_PAD_LEFT) }}</span>
            </p>
        </div>

        <div class="relative mt-14 lg:mt-auto">
            <ol data-directions-track class="track-gutter relative z-10 grid gap-x-5 gap-y-12 sm:grid-cols-2 lg:flex lg:w-max lg:items-end lg:gap-28">
                @foreach (__('site.directions.items') as $index => $direction)
                    <li data-direction-sign class="flex flex-col items-center lg:w-[22rem] lg:shrink-0">
                        <a href="#{{ $direction['target'] }}" class="group block w-full rounded-[10px] bg-sign p-1.5 shadow-[0_16px_0_-8px_rgba(0,0,0,0.55)] transition-transform duration-500 ease-apple hover:-translate-y-1">
                            <span class="flex min-h-[16rem] flex-col rounded-[6px] border-[3px] border-lane/90 p-5 transition-colors duration-300 group-hover:border-brand-yellow">
                                <span class="flex items-start justify-between">
                                    <span class="rounded-[3px] bg-brand-yellow px-2.5 py-1 font-display text-sm font-extrabold tracking-[0.06em] text-ink-950 uppercase">
                                        {{ __('site.directions.exit') }} {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <x-icon name="arrow-up-right" class="size-9 text-lane transition-transform duration-500 ease-apple group-hover:translate-x-1 group-hover:-translate-y-1" />
                                </span>
                                <x-icon :name="$direction['icon']" class="mt-5 size-8 text-lane" />
                                <span class="mt-3 font-display text-[2rem] leading-none font-extrabold uppercase">{{ $direction['name'] }}</span>
                                <span class="mt-2.5 text-[0.95rem] leading-snug text-white/65">{{ $direction['text'] }}</span>
                                <span class="mt-auto flex items-center gap-2 pt-5 font-display text-base font-bold tracking-[0.04em] text-brand-yellow uppercase">
                                    {{ $direction['cta'] }}
                                    <x-icon name="arrow-right" class="size-4" />
                                </span>
                            </span>
                        </a>
                        <span aria-hidden="true" class="flex w-[55%] justify-between">
                            <span class="h-10 w-2.5 bg-pole lg:h-16"></span>
                            <span class="h-10 w-2.5 bg-pole lg:h-16"></span>
                        </span>
                    </li>
                @endforeach
            </ol>

            {{-- Kerb and road: the lane dashes run past while the signs drift by. --}}
            <div aria-hidden="true">
                <div class="h-3 bg-ink-600"></div>
                <div data-directions-road class="relative h-20 bg-road lg:h-24">
                    <span class="absolute inset-x-0 top-3 h-1.5 bg-lane/80"></span>
                    <span class="lane-dashes-x absolute inset-x-0 top-1/2 h-1.5 -translate-y-1/2"></span>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         04 · TOOAUTO APP (sticky phone, steps scroll past)
    ============================================================= --}}
    <section id="tooauto" class="relative py-24 sm:py-36">
        <div class="container-site">
            <div class="flex flex-col justify-between gap-10 lg:flex-row lg:items-end">
                <x-section-heading :tag="__('site.app.tag')" :title="__('site.app.title')" :lead="__('site.app.lead')" />
                <x-store-badges class="shrink-0" />
            </div>

            <div data-app class="mt-16 grid gap-14 lg:mt-8 lg:grid-cols-2 lg:gap-20">
                <div class="lg:order-2">
                    <div class="lg:sticky lg:top-[calc(50svh-19.5rem)]">
                        <div data-phone class="relative mx-auto w-[16.5rem] sm:w-[18.5rem] [perspective:1400px]">
                            <div data-phone-body class="relative aspect-[9/19.2] rounded-[3.1rem] border border-white/15 bg-ink-700 p-[0.6rem] shadow-[0_50px_100px_-30px_rgba(0,0,0,0.9)] ring-1 ring-black">
                                <div class="relative size-full overflow-hidden rounded-[2.6rem] bg-ink-800">
                                    <span aria-hidden="true" class="absolute top-3 left-1/2 z-20 h-[1.6rem] w-[5.5rem] -translate-x-1/2 rounded-full bg-black"></span>

                                    @foreach ($appSteps as $index => $step)
                                        <div
                                            data-phone-screen="{{ $index }}"
                                            @if ($index === 0) data-active @endif
                                            class="absolute inset-0 flex translate-y-3 flex-col px-4 pt-14 pb-4 opacity-0 transition-[opacity,translate] duration-700 ease-apple data-[active]:translate-y-0 data-[active]:opacity-100"
                                            aria-hidden="{{ $index === 0 ? 'false' : 'true' }}"
                                        >
                                            <div class="flex items-center justify-between px-1">
                                                <p class="text-[0.7rem] font-semibold tracking-[0.2em] text-brand-yellow">TOOAUTO</p>
                                                <x-icon name="bell" class="size-4 text-white/50" />
                                            </div>
                                            <p class="mt-3 px-1 text-xl leading-tight font-semibold tracking-tight">{{ $step['title'] }}</p>

                                            <ul class="mt-4 grid gap-2">
                                                @foreach (array_slice($step['modules'], 0, 4) as $module)
                                                    <li class="flex items-center gap-3 rounded-2xl bg-white/[0.06] px-3 py-2.5">
                                                        <span class="grid size-8 shrink-0 place-items-center rounded-xl bg-brand-orange/15 text-brand-orange">
                                                            <x-icon :name="$step['icon']" class="size-4" />
                                                        </span>
                                                        <span class="truncate text-[0.82rem] text-white/90">{{ $module }}</span>
                                                        <x-icon name="chevron-right" class="ml-auto size-4 shrink-0 text-white/25" />
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach

                                    {{-- Tab bar --}}
                                    <div class="absolute inset-x-3 bottom-3 z-10 flex justify-around rounded-[1.4rem] border border-white/10 bg-ink-950/80 py-2.5 backdrop-blur">
                                        @foreach ($appSteps as $index => $step)
                                            <span data-phone-tab="{{ $index }}" @if ($index === 0) data-active @endif class="grid size-9 place-items-center rounded-full text-white/35 transition-colors duration-500 data-[active]:bg-brand-orange data-[active]:text-ink-950">
                                                <x-icon :name="$step['icon']" class="size-4" />
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <ol class="lg:order-1">
                    @foreach ($appSteps as $index => $step)
                        <li
                            data-app-step="{{ $index }}"
                            @if ($index === 0) data-active @endif
                            class="border-t border-white/10 py-10 transition-opacity duration-700 first:border-t-0 lg:flex lg:min-h-[78svh] lg:flex-col lg:justify-center lg:border-t-0 lg:py-0 lg:opacity-25 lg:data-[active]:opacity-100"
                        >
                            <span class="font-mono text-sm text-brand-orange">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }} / {{ str_pad(count($appSteps), 2, '0', STR_PAD_LEFT) }}</span>
                            <h3 class="mt-3 text-3xl font-semibold tracking-tight sm:text-5xl">{{ $step['title'] }}</h3>
                            <p class="mt-4 max-w-md text-lg text-white/60">{{ $step['text'] }}</p>
                            <ul class="mt-7 flex max-w-lg flex-wrap gap-2">
                                @foreach ($step['modules'] as $module)
                                    <li class="rounded-full border border-white/10 bg-white/[0.04] px-3.5 py-1.5 text-sm text-white/80">{{ $module }}</li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </section>

    {{-- ============================================================
         05 · PRICING (light section)
    ============================================================= --}}
    <section id="forfaits" class="relative bg-paper py-24 text-ink-950 sm:py-36">
        <div class="container-site">
            <x-section-heading :tag="__('site.pricing.tag')" :title="__('site.pricing.title')" :lead="__('site.pricing.lead')" tone="light" align="center" />

            <div data-reveal-stagger class="mx-auto mt-16 grid max-w-4xl gap-5 md:grid-cols-2">
                @foreach (__('site.pricing.plans') as $plan)
                    <article @class([
                        'relative flex flex-col rounded-[6px] p-8 sm:p-10',
                        'bg-ink-950 text-white' => $plan['featured'],
                        'bg-white ring-1 ring-ink-950/[0.06]' => ! $plan['featured'],
                    ])>
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-2xl font-semibold tracking-tight">{{ $plan['name'] }}</h3>
                                <p @class(['mt-1', 'text-white/50' => $plan['featured'], 'text-ink-950/50' => ! $plan['featured']])>{{ $plan['vehicles'] }}</p>
                            </div>
                            @if ($plan['featured'])
                                <span class="rounded-[3px] bg-brand-yellow px-2.5 py-1 font-display text-sm font-bold tracking-[0.04em] text-ink-950 uppercase">{{ __('site.pricing.badge') }}</span>
                            @endif
                        </div>

                        <p class="mt-10 flex items-baseline gap-2">
                            <span data-count="{{ $plan['price'] }}" class="text-6xl font-semibold tracking-[-0.04em] tabular-nums">{{ $formatPrice($plan['price']) }}</span>
                            <span @class(['text-sm font-medium', 'text-white/50' => $plan['featured'], 'text-ink-950/50' => ! $plan['featured']])>{{ __('site.pricing.currency') }} {{ __('site.pricing.per_year') }}</span>
                        </p>
                        <p @class(['mt-2 text-sm', 'text-white/40' => $plan['featured'], 'text-ink-950/40' => ! $plan['featured']])>
                            {{ __('site.pricing.instead_of') }}
                            <span class="relative inline-block">
                                {{ $formatPrice($plan['old_price']) }} {{ __('site.pricing.currency') }}
                                <span data-strike class="absolute inset-x-0 top-1/2 h-[1.5px] origin-left bg-brand-orange"></span>
                            </span>
                        </p>

                        <ul class="mt-8 space-y-3 text-[15px]">
                            @foreach (__('site.pricing.features') as $feature)
                                <li class="flex items-center gap-3">
                                    <span class="grid size-5 place-items-center rounded-full bg-brand-orange/15 text-brand-orange"><x-icon name="check" class="size-3" /></span>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>

                        <x-button href="#tooauto" :variant="$plan['featured'] ? 'primary' : 'dark'" class="mt-10 w-full">{{ __('site.pricing.cta') }}</x-button>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================
         06 · TOOAUTO PRO
    ============================================================= --}}
    <section id="pro" class="relative isolate overflow-hidden py-24 sm:py-36">
        <div class="container-site">
            <x-section-heading :tag="__('site.pro.tag')" :title="__('site.pro.title')" :lead="__('site.pro.lead')" />

            <div class="mt-16 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach (__('site.pro.pillars') as $pillar)
                    <article data-pillar class="group flex flex-col rounded-[6px] border border-white/10 bg-white/[0.02] p-7 transition-[border-color,background-color] duration-700 data-[active]:border-brand-orange/40 data-[active]:bg-brand-orange/[0.06]">
                        <div class="flex items-center justify-between">
                            <span class="text-4xl font-semibold tracking-tight text-white/20 transition-colors duration-700 group-data-[active]:text-brand-orange">{{ $pillar['roman'] }}</span>
                            <x-icon :name="$pillar['icon']" class="size-6 text-white/40 transition-colors duration-700 group-data-[active]:text-brand-yellow" />
                        </div>
                        <h3 class="mt-12 text-xl font-semibold tracking-tight">{{ $pillar['title'] }}</h3>
                        <p class="mt-2 text-white/60">{{ $pillar['text'] }}</p>
                        <p class="mt-auto pt-8 text-sm font-semibold text-brand-yellow">{{ $pillar['price'] }}</p>
                    </article>
                @endforeach
            </div>

            <div data-reveal class="mt-5 grid gap-8 rounded-[6px] border border-white/10 bg-ink-800 p-8 sm:p-12 lg:grid-cols-[1.2fr_1fr] lg:items-center">
                <div>
                    <h3 class="text-2xl font-semibold tracking-tight sm:text-3xl">{{ __('site.pro.drivers_title') }}</h3>
                    <p class="mt-3 max-w-xl text-white/60">{{ __('site.pro.drivers_text') }}</p>
                    <div class="mt-8 flex gap-4 rounded-2xl bg-white/[0.04] p-5">
                        <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-brand-orange text-ink-950"><x-icon name="alert" class="size-5" /></span>
                        <div>
                            <p class="font-semibold">{{ __('site.pro.incident_title') }}</p>
                            <p class="mt-1 text-sm text-white/60">{{ __('site.pro.incident_text') }}</p>
                        </div>
                    </div>
                </div>
                <div class="lg:justify-self-end">
                    <x-button href="#contact" size="lg" icon="arrow-right">{{ __('site.pro.cta') }}</x-button>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         07 · THE GROUP
    ============================================================= --}}
    <section id="groupe" class="relative bg-ink-900 py-24 sm:py-36">
        <div class="container-site">
            <x-section-heading :tag="__('site.group.tag')" :title="__('site.group.title')" :lead="__('site.group.lead')" />

            <dl data-reveal-stagger class="mt-16 grid gap-px overflow-hidden rounded-[6px] border border-white/10 bg-white/10 sm:grid-cols-3">
                @foreach (__('site.group.facts') as $fact)
                    <div class="bg-ink-900 p-8 sm:p-10">
                        <dt class="sr-only">{{ $fact['label'] }}</dt>
                        <dd>
                            <p class="flex items-baseline gap-3">
                                <span data-count="{{ $fact['value'] }}" class="font-display text-8xl leading-none font-extrabold text-brand-yellow tabular-nums">{{ $fact['value'] }}</span>
                                <span class="text-xl font-semibold">{{ $fact['label'] }}</span>
                            </p>
                            <p class="mt-3 text-white/50">{{ $fact['text'] }}</p>
                        </dd>
                    </div>
                @endforeach
            </dl>

            <div data-reveal-stagger class="mt-5 grid gap-5 md:grid-cols-2">
                <div class="rounded-[6px] border border-white/10 p-8 sm:p-10">
                    <h3 class="text-xl font-semibold tracking-tight">{{ __('site.group.ecosystem_title') }}</h3>
                    <p class="mt-3 text-white/60">{{ __('site.group.ecosystem_text') }}</p>
                </div>
                <div class="flex flex-col rounded-[6px] border border-white/10 p-8 sm:p-10">
                    <h3 class="text-xl font-semibold tracking-tight">{{ __('site.group.holding_title') }}</h3>
                    <p class="mt-3 text-white/60">{{ __('site.group.holding_text') }}</p>
                    <p class="mt-auto pt-6 text-sm font-semibold tracking-[0.2em] text-brand-yellow uppercase">{{ config('site.legal.parent_company') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         08 · AMBITION (words light up while scrolling) + CTA BAND
    ============================================================= --}}
    <section class="relative py-28 sm:py-44">
        <div class="container-site">
            <p data-reveal class="text-sm font-semibold tracking-[0.18em] text-brand-orange uppercase">{{ __('site.ambition.tag') }}</p>
            <p data-words-scrub class="mt-6 max-w-5xl text-[clamp(1.9rem,4.4vw,3.75rem)] leading-[1.12] font-semibold tracking-[-0.03em] text-balance">{{ __('site.ambition.text') }}</p>
        </div>
    </section>

    <section class="px-3 pb-3 sm:px-5 sm:pb-5">
        <div data-cta-band class="relative overflow-hidden rounded-[6px] bg-brand-yellow px-6 py-20 text-center text-ink-950 sm:py-28">
            <svg aria-hidden="true" viewBox="0 0 400 400" fill="none" class="pointer-events-none absolute -top-1/2 -right-40 size-[40rem] opacity-20 motion-safe:animate-spin-slow">
                <circle cx="200" cy="200" r="180" stroke="currentColor" stroke-width="30" />
                <circle cx="200" cy="200" r="40" stroke="currentColor" stroke-width="12" />
            </svg>
            <h2 data-split class="relative mx-auto max-w-4xl text-[clamp(2rem,5vw,3.9rem)] leading-[1.05] font-semibold tracking-[-0.035em] text-balance">{{ __('site.cta_band.title') }}</h2>
            <div data-reveal class="relative mt-10">
                <x-button href="#contact" variant="dark" size="lg" icon="arrow-right">{{ __('site.cta_band.cta') }}</x-button>
            </div>
        </div>
    </section>

    {{-- ============================================================
         09 · CONTACT
    ============================================================= --}}
    <section id="contact" class="relative py-24 sm:py-36">
        <div class="container-site grid gap-14 lg:grid-cols-[1fr_1.15fr] lg:gap-20">
            <div>
                <x-section-heading :tag="__('site.contact.tag')" :title="__('site.contact.title')" :lead="__('site.contact.lead')" />

                <dl data-reveal-stagger class="mt-12 divide-y divide-white/10 border-y border-white/10 text-[15px]">
                    @foreach ([
                        ['label' => __('site.contact.labels.address'), 'value' => config('site.contact.address'), 'href' => null],
                        ['label' => __('site.contact.labels.postal'), 'value' => config('site.contact.postal_address'), 'href' => null],
                        ['label' => __('site.contact.labels.mobile'), 'value' => config('site.contact.mobile'), 'href' => 'tel:'.preg_replace('/\s+/', '', config('site.contact.mobile'))],
                        ['label' => __('site.contact.labels.landline'), 'value' => config('site.contact.landline'), 'href' => 'tel:'.preg_replace('/\s+/', '', config('site.contact.landline'))],
                        ['label' => __('site.contact.labels.email'), 'value' => config('site.contact.email'), 'href' => 'mailto:'.config('site.contact.email')],
                    ] as $line)
                        <div class="flex flex-col gap-1 py-4 sm:flex-row sm:gap-6">
                            <dt class="w-36 shrink-0 text-white/40">{{ $line['label'] }}</dt>
                            <dd>
                                @if ($line['href'])
                                    <a href="{{ $line['href'] }}" class="transition-colors hover:text-brand-orange">{{ $line['value'] }}</a>
                                @else
                                    {{ $line['value'] }}
                                @endif
                            </dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            <div data-reveal>
                @if (session('contact_sent'))
                    <div role="status" class="flex h-full min-h-[24rem] flex-col items-center justify-center rounded-[6px] border border-white/10 bg-white/[0.03] p-10 text-center">
                        <span class="grid size-14 place-items-center rounded-full bg-brand-orange text-ink-950"><x-icon name="check" class="size-7" /></span>
                        <p class="mt-6 text-2xl font-semibold tracking-tight">{{ __('site.contact.success_title') }}</p>
                        <p class="mt-2 text-white/60">{{ __('site.contact.success_text') }}</p>
                    </div>
                @else
                    <form method="POST" action="{{ \App\Support\Localized::route('contact.store') }}" data-contact-form class="rounded-[6px] border border-white/10 bg-white/[0.03] p-6 sm:p-10" novalidate>
                        @csrf

                        {{-- Honeypot --}}
                        <div class="hidden" aria-hidden="true">
                            <label for="website">Website</label>
                            <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                        </div>

                        @php
                            $inputClasses = 'mt-2 block w-full rounded-[4px] border bg-ink-950/60 px-4 py-3.5 text-white placeholder-white/30 transition-colors duration-300 outline-none focus:border-brand-orange focus:ring-0';
                        @endphp

                        <div class="grid gap-5 sm:grid-cols-2">
                            @foreach (['name' => ['text', 'name'], 'phone' => ['tel', 'tel'], 'email' => ['email', 'email']] as $field => [$type, $autocomplete])
                                <div @class(['sm:col-span-2' => $field === 'email'])>
                                    <label for="{{ $field }}" class="text-sm font-medium text-white/80">{{ __('site.contact.fields.'.$field) }}</label>
                                    <input
                                        id="{{ $field }}"
                                        name="{{ $field }}"
                                        type="{{ $type }}"
                                        autocomplete="{{ $autocomplete }}"
                                        value="{{ old($field) }}"
                                        required
                                        @error($field) aria-invalid="true" aria-describedby="{{ $field }}-error" @enderror
                                        @class([$inputClasses, 'border-red-400/70' => $errors->has($field), 'border-white/10' => ! $errors->has($field)])
                                    >
                                    @error($field)
                                        <p id="{{ $field }}-error" class="mt-1.5 text-sm text-red-300">{{ __('site.contact.error') }}</p>
                                    @enderror
                                </div>
                            @endforeach

                            <div class="sm:col-span-2">
                                <label for="profile" class="text-sm font-medium text-white/80">{{ __('site.contact.fields.profile') }}</label>
                                <div class="relative">
                                    <select id="profile" name="profile" required @class([$inputClasses, 'appearance-none pr-12', 'border-red-400/70' => $errors->has('profile'), 'border-white/10' => ! $errors->has('profile')])>
                                        @foreach (ContactRequest::PROFILES as $profile)
                                            <option value="{{ $profile }}" @selected(old('profile') === $profile)>{{ __('site.contact.profiles.'.$profile) }}</option>
                                        @endforeach
                                    </select>
                                    <x-icon name="chevron-right" class="pointer-events-none absolute top-1/2 right-4 mt-1 size-4 -translate-y-1/2 rotate-90 text-white/50" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="message" class="text-sm font-medium text-white/80">{{ __('site.contact.fields.message') }}</label>
                                <textarea
                                    id="message"
                                    name="message"
                                    rows="5"
                                    required
                                    @error('message') aria-invalid="true" aria-describedby="message-error" @enderror
                                    @class([$inputClasses, 'resize-y', 'border-red-400/70' => $errors->has('message'), 'border-white/10' => ! $errors->has('message')])
                                >{{ old('message') }}</textarea>
                                @error('message')
                                    <p id="message-error" class="mt-1.5 text-sm text-red-300">{{ __('site.contact.error') }}</p>
                                @enderror
                            </div>
                        </div>

                        <x-button type="submit" size="lg" icon="arrow-right" class="mt-8 w-full" data-sending-label="{{ __('site.contact.sending') }}">{{ __('site.contact.submit') }}</x-button>
                    </form>
                @endif
            </div>
        </div>
    </section>

</x-layouts.app>
