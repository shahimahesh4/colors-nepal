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
>
    <x-slot:head>
        <script type="application/ld+json">{!! json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
    </x-slot:head>

    <article>
        <header class="bg-ink-950 py-16 text-white sm:py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <nav class="text-sm text-slate-400" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-white">Home</a><span class="mx-2" aria-hidden="true">/</span>
                    <a href="{{ route('blog.index') }}" class="hover:text-white">Blog</a><span class="mx-2" aria-hidden="true">/</span>
                    <span aria-current="page">{{ $post->title }}</span>
                </nav>
                <div class="mt-8">
                    <p class="text-sm font-bold uppercase tracking-[0.16em] text-accent-400">{{ $post->category?->name ?? 'Insights' }}</p>
                    <h1 class="mt-4 text-balance text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">{{ $post->title }}</h1>
                    <p class="mt-6 max-w-3xl text-lg leading-8 text-slate-300">{{ $post->excerpt }}</p>
                    <div class="mt-7 flex flex-wrap gap-x-5 gap-y-2 text-sm text-slate-300">
                        @if ($post->author)<span>By {{ $post->author->name }}</span>@endif
                        <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('F j, Y') }}</time>
                    </div>
                </div>
            </div>
        </header>

        @if ($post->featured_image)
            <div class="bg-ink-950 pb-12 sm:pb-16">
                <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                    <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->title }}" class="aspect-[16/9] w-full rounded-feature object-cover shadow-2xl">
                </div>
            </div>
        @endif

        <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
            <div class="space-y-5 text-base leading-8 text-slate-700 [&_a]:font-semibold [&_a]:text-brand-700 [&_blockquote]:border-l-4 [&_blockquote]:border-brand-500 [&_blockquote]:pl-5 [&_h2]:pt-5 [&_h2]:text-2xl [&_h2]:font-bold [&_h2]:text-ink-950 [&_h3]:pt-4 [&_h3]:text-xl [&_h3]:font-bold [&_li]:ml-5 [&_li]:list-disc [&_ol_li]:list-decimal">{!! $post->content !!}</div>
        </div>
    </article>

    @if ($relatedPosts->isNotEmpty())
        <section class="bg-slate-50 py-20 sm:py-24">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <x-ui.section-heading eyebrow="Continue reading" title="Related insights." />
                <div class="mt-10 grid gap-5 md:grid-cols-3">
                    @foreach ($relatedPosts as $related)
                        <x-ui.card interactive>
                            <p class="text-xs font-bold uppercase tracking-wider text-brand-600">{{ $related->category?->name ?? 'Insights' }}</p>
                            <h2 class="mt-3 text-xl font-bold text-ink-950"><a href="{{ route('blog.show', $related) }}">{{ $related->title }}</a></h2>
                            <p class="mt-3 text-sm leading-6 text-slate-600">{{ $related->excerpt }}</p>
                        </x-ui.card>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
