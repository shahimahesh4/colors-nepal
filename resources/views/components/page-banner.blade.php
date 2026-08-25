@php
    $displayTitle = $banner?->title ?: $title;
    $displayDescription = $banner?->description ?: $description;
    $image = $banner?->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($banner->image)
        ? $banner->image
        : \App\Models\Banner::DEFAULT_IMAGE;
    $buttonUrl = $banner?->button_url;
    $buttonUrl = $buttonUrl && ! str_starts_with($buttonUrl, 'http') ? url($buttonUrl) : $buttonUrl;
@endphp

<section class="brand-hero relative isolate overflow-hidden bg-ink-950 py-16 text-white sm:py-20 lg:py-24">
    <div class="absolute inset-0 -z-10 opacity-50" aria-hidden="true">
        <div class="absolute -left-24 bottom-0 size-72 rounded-full bg-brand-600/25 blur-3xl"></div>
        <div class="absolute -right-20 top-0 size-72 rounded-full bg-accent-500/15 blur-3xl"></div>
    </div>
    <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 sm:px-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
        <div>
            <nav class="text-sm text-slate-400" aria-label="Breadcrumb">
                <a wire:navigate href="{{ route('home') }}" class="hover:text-white">Home</a>
                @if ($parentLabel && $parentUrl)
                    <span class="mx-2" aria-hidden="true">/</span><a wire:navigate href="{{ $parentUrl }}" class="hover:text-white">{{ $parentLabel }}</a>
                @endif
                <span class="mx-2" aria-hidden="true">/</span><span aria-current="page">{{ $breadcrumb ?: $title }}</span>
            </nav>
            @if ($eyebrow)<x-ui.badge class="mt-8 bg-white/10 text-brand-100 ring-white/15">{{ $eyebrow }}</x-ui.badge>@endif
            <h1 class="mt-6 text-balance text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">{{ $displayTitle }}</h1>
            @if ($displayDescription)<p class="mt-6 max-w-3xl text-lg leading-8 text-slate-300">{{ $displayDescription }}</p>@endif
            @if ($banner?->button_text && $buttonUrl)<div class="mt-8"><x-ui.button :href="$buttonUrl" size="lg">{{ $banner->button_text }}</x-ui.button></div>@endif
        </div>
        <div class="mx-auto flex min-h-52 w-full max-w-lg items-center justify-center sm:min-h-64">
            <x-responsive-image :path="$image" alt="" sizes="(min-width: 1024px) 42vw, 100vw" loading="eager" fetchpriority="high" class="max-h-72 w-full object-contain drop-shadow-[0_22px_35px_rgb(0_0_0/0.35)]" />
        </div>
    </div>
</section>
