@props([
    'href' => null,
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
])

@php
    $variants = [
        'primary' => 'bg-brand-600 text-white shadow-sm hover:bg-brand-700',
        'secondary' => 'border border-slate-300 bg-white text-slate-900 hover:border-brand-300 hover:bg-brand-50',
        'ghost' => 'text-slate-700 hover:bg-slate-100 hover:text-slate-950',
        'danger' => 'bg-red-600 text-white shadow-sm hover:bg-red-700',
    ];

    $sizes = [
        'sm' => 'min-h-10 px-4 py-2 text-sm',
        'md' => 'min-h-11 px-5 py-2.5 text-sm',
        'lg' => 'min-h-12 px-6 py-3 text-base',
    ];

    $classes = 'inline-flex items-center justify-center gap-2 rounded-control font-semibold transition duration-200 disabled:pointer-events-none disabled:opacity-50 '
        . ($variants[$variant] ?? $variants['primary']) . ' '
        . ($sizes[$size] ?? $sizes['md']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>{{ $slot }}</button>
@endif
