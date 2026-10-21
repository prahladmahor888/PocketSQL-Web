@props([
    'variant' => 'primary',
    'href' => null,
    'type' => 'button',
    'class' => '',
])

@php
    $baseClasses = "inline-flex items-center justify-center font-semibold text-sm rounded-[10px] transform active:scale-[0.98] hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2";
    
    $variants = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 shadow-sm shadow-blue-500/20 focus:ring-blue-500 px-5 py-2.5',
        'secondary' => 'bg-white text-slate-800 border border-slate-300 hover:bg-slate-50 hover:border-slate-400 shadow-sm focus:ring-slate-400 px-5 py-2.5',
        'dark' => 'bg-slate-900 text-white hover:bg-slate-800 shadow-sm focus:ring-slate-800 px-5 py-2.5',
        'emerald' => 'bg-emerald-600 text-white hover:bg-emerald-700 shadow-sm shadow-emerald-500/20 focus:ring-emerald-500 px-5 py-2.5',
        'outline' => 'bg-transparent text-blue-600 border border-blue-600 hover:bg-blue-50 focus:ring-blue-500 px-5 py-2.5',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . $class;
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
