<x-layouts.app
    :title="$project->meta_title ?: $project->title"
    :description="$project->meta_description ?: $project->summary"
    :keywords="$project->meta_keywords"
    :image="$project->og_image ? asset('storage/'.$project->og_image) : ($project->cover_image ? asset('storage/'.$project->cover_image) : null)"
>
    <section class="brand-hero bg-ink-950 py-16 text-white sm:py-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-slate-400" aria-label="Breadcrumb">
                <a wire:navigate href="{{ route('home') }}" class="hover:text-white">Home</a><span class="mx-2" aria-hidden="true">/</span>
                <a wire:navigate href="{{ route('portfolio.index') }}" class="hover:text-white">Portfolio</a><span class="mx-2" aria-hidden="true">/</span>
                <span aria-current="page">{{ $project->title }}</span>
            </nav>
            <div class="mt-8 max-w-4xl">
                @if ($project->category)<p class="text-sm font-bold uppercase tracking-[0.16em] text-accent-400">{{ $project->category->name }}</p>@endif
                <h1 class="mt-4 text-balance text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">{{ $project->title }}</h1>
                <p class="mt-6 max-w-3xl text-lg leading-8 text-slate-300">{{ $project->summary }}</p>
            </div>
        </div>
    </section>

    <section class="bg-ink-950 pb-16 sm:pb-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if ($project->cover_image)
                <img src="{{ asset('storage/'.$project->cover_image) }}" alt="{{ $project->title }}" class="aspect-[16/9] w-full rounded-feature object-cover shadow-2xl">
            @else
                <div class="aspect-[16/9] rounded-feature bg-gradient-to-br from-brand-600/60 via-brand-800 to-accent-500/30" aria-hidden="true"></div>
            @endif
        </div>
    </section>

    <section class="py-20 sm:py-24">
        <div class="mx-auto grid max-w-6xl gap-12 px-4 sm:px-6 lg:grid-cols-[0.7fr_1.3fr] lg:px-8">
            <aside>
                <div class="brand-panel rounded-card border border-brand-100 p-6">
                    <h2 class="font-bold text-ink-950">Project details</h2>
                    <dl class="mt-5 grid gap-5 text-sm">
                        @if ($project->client_name)<div><dt class="text-slate-500">Client</dt><dd class="mt-1 font-semibold text-slate-900">{{ $project->client_name }}</dd></div>@endif
                        @if ($project->category)<div><dt class="text-slate-500">Category</dt><dd class="mt-1 font-semibold text-slate-900">{{ $project->category->name }}</dd></div>@endif
                        @if ($project->completed_at)<div><dt class="text-slate-500">Completed</dt><dd class="mt-1 font-semibold text-slate-900">{{ $project->completed_at->format('F Y') }}</dd></div>@endif
                    </dl>
                    @if ($project->technologies)
                        <div class="mt-6 flex flex-wrap gap-2">@foreach ($project->technologies as $technology)<x-ui.badge variant="neutral">{{ $technology }}</x-ui.badge>@endforeach</div>
                    @endif
                    @if ($project->project_url)
                        <div class="mt-6"><x-ui.button href="{{ $project->project_url }}" variant="secondary" target="_blank" rel="noopener noreferrer">Visit project <span class="sr-only">(opens in a new tab)</span></x-ui.button></div>
                    @endif
                </div>
            </aside>

            <article>
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand-700">Case study</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-ink-950">Project overview</h2>
                @if ($project->content)
                    <div class="mt-7 space-y-5 text-base leading-8 text-slate-700 [&_a]:font-semibold [&_a]:text-brand-700 [&_h2]:pt-4 [&_h2]:text-2xl [&_h2]:font-bold [&_h2]:text-ink-950 [&_h3]:pt-3 [&_h3]:text-xl [&_h3]:font-bold [&_li]:ml-5 [&_li]:list-disc">{!! $project->content !!}</div>
                @else
                    <p class="mt-7 text-lg leading-8 text-slate-600">{{ $project->summary }}</p>
                @endif
            </article>
        </div>
    </section>

    @if ($relatedProjects->isNotEmpty())
        <section class="brand-surface py-20 sm:py-24">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <x-ui.section-heading eyebrow="More work" title="Related projects." />
                <div class="mt-10 grid gap-5 md:grid-cols-3">
                    @foreach ($relatedProjects as $related)
                        <x-ui.card interactive>
                            <p class="text-xs font-bold uppercase tracking-wider text-brand-600">{{ $related->category?->name ?? 'Project' }}</p>
                            <h2 class="mt-3 text-xl font-bold text-ink-950"><a wire:navigate href="{{ route('portfolio.show', $related) }}">{{ $related->title }}</a></h2>
                            <p class="mt-3 text-sm leading-6 text-slate-600">{{ $related->summary }}</p>
                        </x-ui.card>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="px-4 py-20 sm:px-6 sm:py-24 lg:px-8">
        <div class="mx-auto max-w-6xl rounded-feature color-spectrum px-6 py-12 text-white sm:px-10 lg:flex lg:items-center lg:justify-between lg:px-14">
            <div><p class="text-sm font-bold uppercase tracking-[0.16em] text-brand-100">Have a similar challenge?</p><h2 class="mt-3 text-3xl font-bold">Let us explore a practical solution.</h2></div>
            <div class="mt-8 lg:mt-0"><x-ui.button href="{{ url('/request-quote') }}" variant="secondary" size="lg" class="border-white bg-white text-brand-700 hover:bg-brand-50">Discuss your project</x-ui.button></div>
        </div>
    </section>
</x-layouts.app>
