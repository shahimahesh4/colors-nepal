<x-layouts.app
    title="Blog"
    description="Practical articles from Colors Nepal about websites, SEO, digital marketing, hosting, and online growth."
>
    <x-page-banner title="Useful thinking for better digital decisions." breadcrumb="Blog" eyebrow="Ideas and insights" description="Explore practical guidance on websites, search visibility, marketing, hosting, and sustainable online growth." />

    <section class="py-20 sm:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if ($categories->isNotEmpty())
                <nav class="mb-10 flex flex-wrap gap-2" aria-label="Blog categories">
                    <a wire:navigate href="{{ route('blog.index') }}" @class(['rounded-full px-4 py-2 text-sm font-semibold ring-1 ring-inset', 'bg-brand-600 text-white ring-brand-600' => ! $activeCategory, 'bg-white text-slate-700 ring-slate-300 hover:bg-slate-50' => $activeCategory])>All articles</a>
                    @foreach ($categories as $category)
                        <a wire:navigate href="{{ route('blog.index', ['category' => $category->slug]) }}" @class(['rounded-full px-4 py-2 text-sm font-semibold ring-1 ring-inset', 'bg-brand-600 text-white ring-brand-600' => $activeCategory?->is($category), 'bg-white text-slate-700 ring-slate-300 hover:bg-slate-50' => ! $activeCategory?->is($category)])>
                            {{ $category->name }} <span class="ml-1 opacity-70">{{ $category->posts_count }}</span>
                        </a>
                    @endforeach
                </nav>
            @endif

            @if ($posts->isNotEmpty())
                <div class="colorful-grid grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                        <article class="group overflow-hidden brand-panel rounded-feature border border-brand-100 bg-white transition hover:-translate-y-1 hover:shadow-card-hover">
                            <a wire:navigate href="{{ route('blog.show', $post) }}" class="block overflow-hidden">
                                @if ($post->featured_image)
                                    <x-responsive-image :path="$post->featured_image" :alt="$post->title" sizes="(min-width: 1024px) 33vw, (min-width: 768px) 50vw, 100vw" class="aspect-[16/10] w-full object-cover transition duration-500 group-hover:scale-[1.03]" />
                                @else
                                    <div class="grid aspect-[16/10] place-items-center bg-gradient-to-br from-brand-100 via-slate-100 to-accent-400/20" aria-hidden="true">
                                        <span class="text-4xl font-bold text-brand-700/25">INSIGHT</span>
                                    </div>
                                @endif
                            </a>
                            <div class="p-6">
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs font-semibold uppercase tracking-wider text-brand-700">
                                    <span>{{ $post->category?->name ?? 'Insights' }}</span>
                                    <span class="text-slate-400">{{ $post->published_at->format('M j, Y') }}</span>
                                </div>
                                <h2 class="mt-3 text-xl font-bold leading-7 text-ink-950"><a wire:navigate href="{{ route('blog.show', $post) }}">{{ $post->title }}</a></h2>
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
