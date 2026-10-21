@props([
    'as' => 'div',
    'class' => '',
])

<{{ $as }} {{ $attributes->merge(['class' => 'bg-white border border-slate-200 rounded-[10px] p-6 shadow-sm hover:border-slate-300 hover-lift hover:shadow-md transition-all duration-300 ' . $class]) }}>
    {{ $slot }}
</{{ $as }}>
