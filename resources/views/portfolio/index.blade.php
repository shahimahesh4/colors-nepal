<x-layouts.app
    title="Portfolio"
    description="Explore published Colors Nepal website, marketing, branding, and digital project case studies."
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
                <span aria-current="page">Portfolio</span>
            </nav>
            <div class="mt-8 max-w-4xl">
                <x-ui.badge class="bg-white/10 text-brand-100 ring-white/15">Selected work</x-ui.badge>
                <h1 class="mt-6 text-balance text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">Work shaped around the problem, not a template.</h1>
                <p class="mt-6 max-w-3xl text-lg leading-8 text-slate-300">Browse published projects and case studies across web, marketing, branding, and digital experience work.</p>
            </div>
        </div>
    </section>

    <section class="py-20 sm:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if ($categories->isNotEmpty())
                <nav class="mb-10 flex flex-wrap gap-2" aria-label="Portfolio categories">
                    <a href="{{ route('portfolio.index') }}" @class(['rounded-full px-4 py-2 text-sm font-semibold ring-1 ring-inset', 'bg-brand-600 text-white ring-brand-600' => ! $activeCategory, 'bg-white text-slate-700 ring-slate-300 hover:bg-slate-50' => $activeCategory])>
                        All projects
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('portfolio.index', ['category' => $category->slug]) }}" @class(['rounded-full px-4 py-2 text-sm font-semibold ring-1 ring-inset', 'bg-brand-600 text-white ring-brand-600' => $activeCategory?->is($category), 'bg-white text-slate-700 ring-slate-300 hover:bg-slate-50' => ! $activeCategory?->is($category)])>
                            {{ $category->name }} <span class="ml-1 opacity-70">{{ $category->projects_count }}</span>
                        </a>
                    @endforeach
                </nav>
            @endif

            @if ($projects->isNotEmpty())
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($projects as $project)
                        <article class="group overflow-hidden rounded-feature border border-slate-200 bg-white transition hover:-translate-y-1 hover:shadow-card-hover">
                            <a href="{{ route('portfolio.show', $project) }}" class="block overflow-hidden">
                                @if ($project->cover_image)
                                    <img src="{{ asset('storage/'.$project->cover_image) }}" alt="{{ $project->title }}" class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-[1.03]" loading="lazy">
                                @else
                                    <div class="grid aspect-[4/3] place-items-center bg-gradient-to-br from-brand-100 via-slate-100 to-cyan-100" aria-hidden="true">
                                        <span class="text-5xl font-bold text-brand-700/25">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                @endif
                            </a>
                            <div class="p-6">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="text-xs font-bold uppercase tracking-wider text-brand-600">{{ $project->category?->name ?? 'Project' }}</p>
                                    @if ($project->is_featured)<x-ui.badge>Featured</x-ui.badge>@endif
                                </div>
                                <h2 class="mt-3 text-xl font-bold text-ink-950"><a href="{{ route('portfolio.show', $project) }}">{{ $project->title }}</a></h2>
                                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $project->summary }}</p>
                                @if ($project->technologies)
                                    <div class="mt-5 flex flex-wrap gap-2">
                                        @foreach (array_slice($project->technologies, 0, 3) as $technology)<x-ui.badge variant="neutral">{{ $technology }}</x-ui.badge>@endforeach
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                @if ($projects->hasPages())
                    <div class="mt-12">{{ $projects->links() }}</div>
                @endif
            @else
                <x-ui.alert title="No published projects in this category.">Choose another category or contact us to discuss the kind of work you need.</x-ui.alert>
            @endif
        </div>
    </section>

    <section class="px-4 pb-20 sm:px-6 sm:pb-24 lg:px-8">
        <div class="mx-auto max-w-6xl rounded-feature bg-brand-600 px-6 py-12 text-white sm:px-10 lg:flex lg:items-center lg:justify-between lg:px-14">
            <div class="max-w-2xl"><p class="text-sm font-bold uppercase tracking-[0.16em] text-brand-100">Your project could be next</p><h2 class="mt-3 text-3xl font-bold sm:text-4xl">Bring us the challenge.</h2><p class="mt-4 text-brand-100">We will help turn it into a clear, useful digital scope.</p></div>
            <div class="mt-8 lg:mt-0"><x-ui.button href="{{ url('/request-quote') }}" variant="secondary" size="lg" class="border-white bg-white text-brand-700 hover:bg-brand-50">Start a project</x-ui.button></div>
        </div>
    </section>
</x-layouts.app>
