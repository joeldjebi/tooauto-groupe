@php
    use App\Support\Localized;

    $home = Localized::route('home');
    $links = [
        ['label' => __('site.nav.group'), 'href' => $home.'#groupe'],
        ['label' => __('site.nav.directions'), 'href' => $home.'#directions'],
        ['label' => __('site.nav.tooauto'), 'href' => $home.'#tooauto'],
        ['label' => __('site.nav.pro'), 'href' => $home.'#pro'],
        ['label' => __('site.nav.contact'), 'href' => $home.'#contact'],
    ];
@endphp

<header
    data-header
    class="fixed inset-x-0 top-0 z-50 border-b-2 border-asphalt bg-asphalt transition-[translate,border-color] duration-500 ease-apple data-[hidden]:-translate-y-full data-[scrolled]:border-brand-yellow"
>
    <div class="container-site flex h-16 items-center justify-between gap-6">
        <a href="{{ $home }}" class="shrink-0" aria-label="TOOAUTO GROUP">
            <x-logo class="h-8" />
        </a>

        <nav aria-label="{{ __('site.nav.label') }}" class="hidden lg:block">
            <ul class="flex items-center gap-1 font-display text-[1.05rem] font-semibold tracking-[0.03em] text-white/70 uppercase">
                @foreach ($links as $link)
                    <li>
                        <a href="{{ $link['href'] }}" class="px-3.5 py-2 transition-colors duration-300 hover:text-brand-yellow">{{ $link['label'] }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="flex items-center gap-3">
            <x-locale-switch class="hidden sm:flex" />
            <x-button :href="$home.'#tooauto'" size="sm" class="hidden sm:inline-flex">{{ __('site.nav.cta') }}</x-button>
            <button
                type="button"
                data-menu-toggle
                aria-expanded="false"
                aria-controls="mobile-menu"
                aria-label="{{ __('site.nav.open_menu') }}"
                data-label-open="{{ __('site.nav.open_menu') }}"
                data-label-close="{{ __('site.nav.close_menu') }}"
                class="group -mr-2 grid size-10 place-items-center rounded-full text-white transition-colors hover:bg-white/10 lg:hidden"
            >
                <x-icon name="menu" class="size-6 group-aria-expanded:hidden" />
                <x-icon name="close" class="hidden size-6 group-aria-expanded:block" />
            </button>
        </div>
    </div>
</header>

{{-- Kept outside <header> so the header's translate never traps this fixed panel. --}}
<div id="mobile-menu" data-mobile-menu hidden class="fixed inset-0 z-40 bg-asphalt lg:hidden">
    <div class="container-site flex h-full flex-col pt-24 pb-10">
        <ul class="flex flex-col gap-1">
            @foreach ($links as $link)
                <li data-menu-item>
                    <a href="{{ $link['href'] }}" class="block border-b border-white/10 py-4 font-display text-4xl font-bold text-white uppercase transition-colors hover:text-brand-yellow">{{ $link['label'] }}</a>
                </li>
            @endforeach
        </ul>
        <div data-menu-item class="mt-auto flex items-center justify-between gap-4">
            <x-locale-switch class="flex" />
            <x-button :href="$home.'#tooauto'">{{ __('site.nav.cta') }}</x-button>
        </div>
    </div>
</div>
