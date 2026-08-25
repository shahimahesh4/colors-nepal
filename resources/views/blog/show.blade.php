@php
    $articleSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $post->title,
        'description' => $post->meta_description ?: $post->excerpt,
        'datePublished' => $post->published_at->toIso8601String(),
        'dateModified' => $post->updated_at->toIso8601String(),
        'mainEntityOfPage' => route('blog.show', $post),
        'author' => [
            '@type' => $post->author ? 'Person' : 'Organization',
            'name' => $post->author?->name ?? config('app.name'),
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => config('app.name'),
            'url' => route('home'),
        ],
    ];

    if ($post->featured_image) {
        $articleSchema['image'] = asset('storage/'.$post->featured_image);
    }
@endphp

<x-layouts.app
    :title="$post->meta_title ?: $post->title"
    :description="$post->meta_description ?: $post->excerpt"
    :keywords="$post->meta_keywords"
    :image="$post->og_image ? asset('storage/'.$post->og_image) : ($post->featured_image ? asset('storage/'.$post->featured_image) : null)"
    type="article"
>
    <x-slot:head>
        <script type="application/ld+json">{!! json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
    </x-slot:head>

    <article>
        <section class="brand-surface border-t border-brand-100 py-10 sm:py-14">
            <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[minmax(0,2fr)_minmax(17rem,0.75fr)] lg:items-start lg:px-8">
                <div class="brand-panel overflow-hidden rounded-feature border border-brand-100 bg-white shadow-card">
                    @if ($post->featured_image)
                        <div class="overflow-hidden bg-ink-950">
                            <x-responsive-image :path="$post->featured_image" :alt="$post->title" sizes="(min-width: 1024px) 68vw, 100vw" loading="eager" fetchpriority="high" class="aspect-[16/9] w-full object-contain p-4 sm:p-6" />
                        </div>
                    @else
                        <div class="grid aspect-[16/9] place-items-center bg-gradient-to-br from-brand-100 via-white to-accent-400/20" aria-hidden="true">
                            <span class="text-5xl font-black tracking-[0.12em] text-brand-700/20">INSIGHT</span>
                        </div>
                    @endif

                    <div class="px-6 py-8 sm:px-10 sm:py-10">
                        <div class="flex flex-wrap items-center gap-x-5 gap-y-4 border-b border-slate-200 pb-6 text-sm text-slate-600">
                            <span class="grid size-11 place-items-center rounded-full bg-brand-50 font-bold text-brand-700" aria-hidden="true">{{ mb_strtoupper(mb_substr($post->author?->name ?? config('app.name'), 0, 1)) }}</span>
                            <span><span class="block text-xs text-slate-500">Author</span><span class="font-semibold text-ink-950">{{ $post->author?->name ?? config('app.name') }}</span></span>
                            <span class="hidden h-10 w-px bg-slate-200 sm:block" aria-hidden="true"></span>
                            <span><span class="block text-xs text-slate-500">Published</span><span class="font-semibold text-ink-950">{{ $post->published_at->format('F j, Y') }}</span></span>
                            @if ($post->category)<span class="ml-auto rounded-full bg-brand-50 px-3 py-1 font-semibold text-brand-700">{{ $post->category->name }}</span>@endif
                        </div>

                        <h1 class="mt-8 text-3xl font-bold tracking-tight text-ink-950 sm:text-4xl">{{ $post->title }}</h1>
                        @if ($post->excerpt)<p class="mt-5 text-lg leading-8 text-slate-600">{{ $post->excerpt }}</p>@endif

                        <div class="mt-8 space-y-5 text-base leading-8 text-slate-700 [&_a]:font-semibold [&_a]:text-brand-700 [&_blockquote]:border-l-4 [&_blockquote]:border-brand-500 [&_blockquote]:pl-5 [&_h2]:border-t [&_h2]:border-slate-200 [&_h2]:pt-7 [&_h2]:text-2xl [&_h2]:font-bold [&_h2]:text-ink-950 [&_h3]:pt-4 [&_h3]:text-xl [&_h3]:font-bold [&_li]:ml-5 [&_li]:list-disc [&_ol_li]:list-decimal">{!! $post->content !!}</div>
                    </div>
                </div>

                <aside class="space-y-6 lg:sticky lg:top-24" aria-label="Blog sidebar">
                    <form action="{{ route('blog.index') }}" method="GET" class="brand-panel rounded-card border border-brand-100 bg-white p-5 shadow-card">
                        <label for="blog-search" class="text-sm font-bold text-ink-950">Search articles</label>
                        <div class="mt-3 flex overflow-hidden rounded-control border border-slate-300 bg-white focus-within:border-brand-500 focus-within:ring-2 focus-within:ring-brand-100">
                            <input id="blog-search" name="search" type="search" class="min-w-0 flex-1 border-0 px-4 py-3 text-sm outline-none" placeholder="Enter your search" required>
                            <button type="submit" class="grid min-h-11 w-12 place-items-center bg-brand-600 text-white hover:bg-brand-700" aria-label="Search blog">
                                <svg class="size-5" viewBox="0 0 20 20" fill="none" aria-hidden="true"><circle cx="8.5" cy="8.5" r="5.5" stroke="currentColor" stroke-width="2"/><path d="m13 13 4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            </button>
                        </div>
                    </form>

                    @if ($recentPosts->isNotEmpty())
                        <div class="brand-panel rounded-card border border-brand-100 bg-white p-5 shadow-card">
                            <div class="flex items-center justify-between gap-4 border-b border-slate-200 pb-4">
                                <h2 class="text-xl font-bold text-ink-950">Recent posts</h2>
                                <a wire:navigate href="{{ route('blog.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-800">View all</a>
                            </div>
                            <div class="divide-y divide-slate-100">
                                @foreach ($recentPosts as $recent)
                                    <article class="group flex gap-3 py-4">
                                        <a wire:navigate href="{{ route('blog.show', $recent) }}" class="shrink-0 overflow-hidden rounded-full" tabindex="-1" aria-hidden="true">
                                            @if ($recent->featured_image)
                                                <x-responsive-image :path="$recent->featured_image" alt="" sizes="48px" class="size-12 object-cover group-hover:scale-105" />
                                            @else
                                                <span class="grid size-12 place-items-center bg-brand-50 text-xs font-bold text-brand-700">CN</span>
                                            @endif
                                        </a>
                                        <div class="min-w-0">
                                            <h3 class="line-clamp-2 text-sm font-bold leading-5 text-ink-950"><a wire:navigate href="{{ route('blog.show', $recent) }}" class="hover:text-brand-700">{{ $recent->title }}</a></h3>
                                            <p class="mt-1 text-xs text-slate-500">{{ $recent->published_at->format('F j, Y') }}</p>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </aside>
            </div>
        </section>
    </article>
</x-layouts.app>
