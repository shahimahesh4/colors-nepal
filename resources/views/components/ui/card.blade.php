@props([
    'padding' => 'md',
    'interactive' => false,
])

@php
    $paddingClasses = ['sm' => 'p-5', 'md' => 'p-6 sm:p-8', 'lg' => 'p-8 sm:p-10'];
@endphp

<div {{ $attributes->class([
    'brand-panel rounded-card border border-brand-100 bg-white',
    'transition duration-200 hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-card-hover' => $interactive,
    $paddingClasses[$padding] ?? $paddingClasses['md'],
]) }}>
    {{ $slot }}
</div>
