@props([
    'variant' => 'info',
    'title' => null,
])

@php
    $variants = [
        'info' => 'border-brand-200 bg-brand-50 text-brand-900',
        'success' => 'border-emerald-200 bg-emerald-50 text-emerald-900',
        'warning' => 'border-amber-200 bg-amber-50 text-amber-950',
        'danger' => 'border-red-200 bg-red-50 text-red-900',
    ];
@endphp

<div role="{{ $variant === 'danger' ? 'alert' : 'status' }}" {{ $attributes->class('rounded-card border p-4 sm:p-5 '.($variants[$variant] ?? $variants['info'])) }}>
    @if ($title)
        <p class="font-semibold">{{ $title }}</p>
    @endif
    <div @class(['mt-1 text-sm' => $title])>{{ $slot }}</div>
</div>
