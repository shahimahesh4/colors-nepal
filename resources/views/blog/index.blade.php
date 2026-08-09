<x-layouts.app
    title="Blog"
    description="Practical articles from Colors Nepal about websites, SEO, digital marketing, hosting, and online growth."
>
    <section class="relative overflow-hidden bg-ink-950 py-20 text-white sm:py-24">
        <div class="absolute inset-0 opacity-50" aria-hidden="true">
            <div class="absolute -left-24 bottom-0 size-72 rounded-full bg-brand-600/25 blur-3xl"></div>
            <div class="absolute -right-20 top-0 size-72 rounded-full bg-accent-500/15 blur-3xl"></div>
        </div>
        <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-slate-400" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <span class="mx-2" aria-hidden="true">/</span>
                <span aria-current="page">Blog</span>
            </nav>
            <div class="mt-8 max-w-4xl">
                <x-ui.badge class="bg-white/10 text-brand-100 ring-white/15">Ideas and insights</x-ui.badge>
                <h1 class="mt-6 text-balance text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">Useful thinking for better digital decisions.</h1>
                <p class="mt-6 max-w-3xl text-lg leading-8 text-slate-300">Explore practical guidance on websites, search visibility, marketing, hosting, and sustainable online growth.</p>
            </div>
        </div>
    </section>

    <section class="py-20 sm:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if ($categories->isNotEmpty())
                <nav class="mb-10 flex flex-wrap gap-2" aria-label="Blog categories">
                    <a href="{{ route('blog.index') }}" @class(['rounded-full px-4 py-2 text-sm font-semibold ring-1 ring-inset', 'bg-brand-600 text-white ring-brand-600' => ! $activeCategory, 'bg-white text-slate-700 ring-slate-300 hover:bg-slate-50' => $activeCategory])>All articles</a>
                    @foreach ($categories as $category)
                        <a href="{{ route('blog.index', ['category' => $category->slug]) }}" @class(['rounded-full px-4 py-2 text-sm font-semibold ring-1 ring-inset', 'bg-brand-600 text-white ring-brand-600' => $activeCategory?->is($category), 'bg-white text-slate-700 ring-slate-300 hover:bg-slate-50' => ! $activeCategory?->is($category)])>
                            {{ $category->name }} <span class="ml-1 opacity-70">{{ $category->posts_count }}</span>
                        </a>
                    @endforeach
                </nav>
            @endif

            @if ($posts->isNotEmpty())
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                        <article class="group overflow-hidden rounded-feature border border-slate-200 bg-white transition hover:-translate-y-1 hover:shadow-card-hover">
                            <a href="{{ route('blog.show', $post) }}" class="block overflow-hidden">
                                @if ($post->featured_image)
                                    <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->title }}" class="aspect-[16/10] w-full object-cover transition duration-500 group-hover:scale-[1.03]" loading="lazy">
                                @else
                                    <div class="grid aspect-[16/10] place-items-center bg-gradient-to-br from-brand-100 via-slate-100 to-cyan-100" aria-hidden="true">
                                        <span class="text-4xl font-bold text-brand-700/25">INSIGHT</span>
                                    </div>
                                @endif
                            </a>
                            <div class="p-6">
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs font-semibold uppercase tracking-wider text-brand-700">
                                    <span>{{ $post->category?->name ?? 'Insights' }}</span>
                                    <span class="text-slate-400">{{ $post->published_at->format('M j, Y') }}</span>
                                </div>
                                <h2 class="mt-3 text-xl font-bold leading-7 text-ink-950"><a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a></h2>
                                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $post->excerpt }}</p>
                                @if ($post->author)
                                    <p class="mt-5 text-sm font-semibold text-slate-700">By {{ $post->author->name }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
                @if ($posts->hasPages())<div class="mt-12">{{ $posts->links() }}</div>@endif
            @else
                <x-ui.alert title="No published articles in this category.">Choose another category or check back soon for new practical insights.</x-ui.alert>
            @endif
        </div>
    </section>
</x-layouts.app>
