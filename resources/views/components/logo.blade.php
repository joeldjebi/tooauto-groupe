{{--
    Drop the official logo in public/images/logo.svg (preferred) or logo.png and it replaces this fallback automatically.
--}}
@if (file_exists(public_path('images/logo.svg')))
    <img src="{{ asset('images/logo.svg') }}" alt="TOOAUTO GROUP" {{ $attributes->class('w-auto') }}>
@elseif (file_exists(public_path('images/logo.png')))
    <img src="{{ asset('images/logo.png') }}" alt="TOOAUTO GROUP" {{ $attributes->class('w-auto') }}>
@else
    <svg viewBox="0 0 196 44" role="img" aria-label="TOOAUTO GROUP" {{ $attributes->class('w-auto') }}>
        <circle cx="22" cy="22" r="14" fill="none" stroke="#FFC20E" stroke-width="7" />
        <circle cx="22" cy="22" r="19.5" fill="none" stroke="#F58220" stroke-width="2" />
        <text x="50" y="25" fill="#fff" font-family="Inter, sans-serif" font-size="21" font-weight="700" letter-spacing="0.4">TOOAUTO</text>
        <text x="51" y="38" fill="#8a8a8e" font-family="Inter, sans-serif" font-size="8" font-weight="600" letter-spacing="3.2">GROUP</text>
    </svg>
@endif
