<div>
    <section class="brand-hero bg-ink-950 py-16 text-white sm:py-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-slate-400" aria-label="Breadcrumb">
                <a wire:navigate href="{{ route('home') }}" class="hover:text-white">Home</a>
                <span class="mx-2" aria-hidden="true">/</span>
                <span aria-current="page">{{ $page->title }}</span>
            </nav>
            <h1 class="mt-8 max-w-4xl text-balance text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">{{ $page->title }}</h1>
            @if ($page->excerpt)
                <p class="mt-6 max-w-3xl text-lg leading-8 text-slate-300">{{ $page->excerpt }}</p>
            @endif
        </div>
    </section>

    @if ($page->image)
        <div class="bg-ink-950 pb-12 sm:pb-16"><div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8"><img src="{{ asset('storage/'.$page->image) }}" alt="{{ $page->title }}" class="aspect-[16/9] w-full rounded-feature object-cover shadow-2xl"></div></div>
    @endif
    <section class="brand-surface py-16 sm:py-20">
        <article class="brand-panel mx-auto max-w-4xl rounded-feature border border-brand-100 bg-white px-6 py-10 shadow-card sm:px-10 sm:py-12">
            <div class="space-y-5 text-base leading-8 text-slate-700 [&_a]:font-semibold [&_a]:text-brand-700 [&_blockquote]:border-l-4 [&_blockquote]:border-creative-pink [&_blockquote]:pl-5 [&_h2]:pt-5 [&_h2]:text-2xl [&_h2]:font-bold [&_h2]:text-ink-950 [&_h3]:pt-4 [&_h3]:text-xl [&_h3]:font-bold [&_h3]:text-ink-950 [&_li]:ml-5 [&_li]:list-disc">
                {!! $page->content !!}
            </div>
        </article>
    </section>
</div>
