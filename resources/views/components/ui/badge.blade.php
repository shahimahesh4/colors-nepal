@props(['variant' => 'brand'])

@php
    $variants = [
        'brand' => 'bg-creative-pink/10 text-creative-pink ring-creative-pink/20',
        'neutral' => 'bg-slate-100 text-slate-700 ring-slate-200',
        'success' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'warning' => 'bg-amber-50 text-amber-800 ring-amber-200',
        'danger' => 'bg-red-50 text-red-700 ring-red-200',
    ];
@endphp

<span {{ $attributes->class('inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset '.($variants[$variant] ?? $variants['brand'])) }}>
    {{ $slot }}
</span>
