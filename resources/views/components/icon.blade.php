@props(['name', 'class' => 'w-5 h-5'])

<svg {{ $attributes->merge(['class' => $class, 'fill' => 'none', 'stroke' => 'currentColor', 'viewBox' => '0 0 24 24']) }}>
    @switch($name)
        @case('currency-dollar') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /> @break
        @case('chart-pie') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3v8H3a9 9 0 1018 0 9 9 0 00-9-9z" /> @break
        @case('tag') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M3 3l7.586 7.586a2 2 0 002.828 0L21 5a2 2 0 00-2.828-2.828L10.414 7.586a2 2 0 010 2.828L3 21z" /> @break
        @case('refresh') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v6h6M20 20v-6h-6M4 20l16-16" /> @break
        @case('clipboard-list') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293L19.707 9a1 1 0 01.293.707V19a2 2 0 01-2 2z" /> @break
        @case('mail') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 9h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /> @break
    @endswitch
</svg>
