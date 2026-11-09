@props(['body' => '#F58220', 'roof' => '#D96F14', 'headlights' => true])

{{-- A car seen from above, nose pointing up. Flat shapes only. --}}
<svg viewBox="0 0 64 128" overflow="visible" aria-hidden="true" {{ $attributes }}>
    @if ($headlights)
        <path d="M14 4 0 -90h64L50 4Z" fill="#FFC20E" opacity="0.07" />
    @endif
    <rect x="12" y="10" width="46" height="116" rx="17" fill="#000" opacity="0.45" />
    <rect x="3" y="20" width="8" height="20" rx="3" fill="#0a0a0a" />
    <rect x="53" y="20" width="8" height="20" rx="3" fill="#0a0a0a" />
    <rect x="3" y="86" width="8" height="20" rx="3" fill="#0a0a0a" />
    <rect x="53" y="86" width="8" height="20" rx="3" fill="#0a0a0a" />
    <rect x="7" y="4" width="50" height="118" rx="17" fill="{{ $body }}" />
    <path d="M13 34c6-4 32-4 38 0l-3 15H16Z" fill="#111" />
    <rect x="15" y="50" width="34" height="34" rx="5" fill="{{ $roof }}" />
    <path d="M16 86h32l3 14c-6 3-32 3-38 0Z" fill="#111" />
    <rect x="3" y="41" width="6" height="4" rx="1.5" fill="{{ $body }}" />
    <rect x="55" y="41" width="6" height="4" rx="1.5" fill="{{ $body }}" />
    <rect x="12" y="6" width="10" height="4" rx="2" fill="#FFF6D6" />
    <rect x="42" y="6" width="10" height="4" rx="2" fill="#FFF6D6" />
    <rect x="12" y="117" width="10" height="3" rx="1.5" fill="#E0301E" />
    <rect x="42" y="117" width="10" height="3" rx="1.5" fill="#E0301E" />
</svg>
