@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    'align' => 'left',
])

<div {{ $attributes->class([
    'max-w-3xl',
    'mx-auto text-center' => $align === 'center',
]) }}>
    @if ($eyebrow)
        <p class="mb-3 text-sm font-bold uppercase tracking-[0.16em] text-brand-600">{{ $eyebrow }}</p>
    @endif

    <h2 class="text-balance text-3xl font-bold tracking-tight text-ink-950 sm:text-4xl lg:text-5xl">
        {{ $title }}
    </h2>

    @if ($description)
        <p class="mt-5 text-pretty text-base text-slate-600 sm:text-lg">{{ $description }}</p>
    @endif
</div>
