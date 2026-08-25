<x-layouts.app
    title="Digital Agency"
    description="Colors Nepal builds practical websites, digital marketing campaigns, SEO strategies, hosting solutions, and maintainable online experiences."
>
    <section class="relative isolate overflow-hidden bg-ink-950 text-white">
        <div class="absolute inset-0 -z-10 opacity-60" aria-hidden="true">
            <div class="absolute -left-32 top-20 size-80 rounded-full bg-creative-pink/35 blur-3xl"></div>
            <div class="absolute -right-32 bottom-0 size-96 rounded-full bg-creative-orange/25 blur-3xl"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,rgb(255_255_255/0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgb(255_255_255/0.04)_1px,transparent_1px)] bg-[size:48px_48px]"></div>
        </div>

        @php
            $heroUrl = fn (?string $value, string $fallback): string => str_starts_with($value ?: '', 'http') ? $value : url($value ?: $fallback);
        @endphp
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-16 sm:px-6 sm:py-20 lg:grid-cols-[0.95fr_1.05fr] lg:px-8 lg:py-24">
            <div>
                <h1 class="text-balance text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                    {{ $hero['title'] }}
                </h1>
                <p class="mt-6 max-w-2xl text-pretty text-lg leading-8 text-slate-300">
                    {{ $hero['description'] }}
                </p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    @if($hero['primary_label'])<x-ui.button href="{{ $heroUrl($hero['primary_url'], '/request-quote') }}" size="lg">{{ $hero['primary_label'] }}</x-ui.button>@endif
                </div>
            </div>

            <div class="home-hero-media relative mx-auto flex min-h-[20rem] w-full max-w-2xl items-center justify-center lg:min-h-[30rem]">
                @if($hero['image'])
                    <x-responsive-image :path="$hero['image']" :alt="$hero['image_alt']" sizes="(min-width: 1024px) 50vw, 100vw" loading="eager" fetchpriority="high" class="max-h-[34rem] w-full object-contain drop-shadow-[0_28px_45px_rgb(0_0_0/0.38)]" />
                @else
                    <x-home-hero-placeholder class="max-h-[32rem] drop-shadow-[0_28px_45px_rgb(0_0_0/0.28)]" />
                @endif
            </div>
        </div>
    </section>

    <section class="color-spectrum border-b border-white/20" aria-label="Capabilities">
        <div class="mx-auto grid max-w-6xl grid-cols-2 gap-px bg-white/25 sm:grid-cols-4">
            @foreach (['Strategy', 'Design', 'Development', 'Growth'] as $capability)
                <div class="bg-white/90 px-4 py-5 text-center text-sm font-bold uppercase tracking-[0.14em] text-ink-950">{{ $capability }}</div>
            @endforeach
        </div>
    </section>

    @if ($services->isNotEmpty())
        <section class="service-showcase">
            <div class="service-showcase__dots service-showcase__dots--left" aria-hidden="true"></div>
            <div class="service-showcase__ring" aria-hidden="true"></div>
            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center">
                    <x-ui.badge>What we do</x-ui.badge>
                    <h2 class="mt-5 text-balance text-3xl font-bold tracking-tight text-ink-950 sm:text-4xl lg:text-5xl">Services designed to move ideas forward.</h2>
                    <p class="mx-auto mt-5 max-w-2xl text-base leading-8 text-slate-600 sm:text-lg">Focused digital capability, thoughtful execution, and practical support at every stage.</p>
                </div>
                <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ($services as $service)
                        <article class="service-card group" style="--service-delay: {{ $loop->index * 90 }}ms">
                            <x-service-icon :title="$service->title" />
                            <h3 class="service-card__title"><a wire:navigate href="{{ route('services.show', $service) }}" class="after:absolute after:inset-0">{{ $service->title }}</a></h3>
                            <p class="service-card__copy">{{ $service->summary }}</p>
                            <span class="service-card__link">Learn more <svg class="service-card__arrow" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="m7 4 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                        </article>
                    @endforeach
                </div>
                <div class="mt-12 flex flex-col items-center justify-center gap-5 text-center sm:flex-row">
                    <p class="text-xl text-ink-950 sm:text-2xl">Have a project in mind? <strong>Let us build it together.</strong></p>
                    <x-ui.button href="{{ route('quote.create') }}" size="lg">Get a quote <span aria-hidden="true">-&gt;</span></x-ui.button>
                </div>
            </div>
        </section>
    @endif

    <section class="bg-gradient-to-br from-creative-yellow/10 via-white to-accent-400/15 py-20 sm:py-24">
        <div class="mx-auto grid max-w-6xl gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:items-center lg:px-8">
            <div>
                <x-ui.section-heading
                    eyebrow="Why Colors Nepal"
                    title="Practical thinking before digital noise."
                    description="Every recommendation should earn its place by improving clarity, performance, or business outcomes."
                />
                <div class="mt-8">
                    <x-ui.button href="{{ url('/about') }}" variant="secondary">More about our approach</x-ui.button>
                </div>
            </div>
            <div class="value-card-list colorful-grid grid gap-5">
                @foreach ([
                    ['Outcome-led planning', 'We begin with the business problem, audience, and useful measures of progress.'],
                    ['Maintainable delivery', 'Simple architecture and reusable systems keep future updates understandable.'],
                    ['Support beyond launch', 'Hosting, maintenance, SEO, and promotion can continue as the business evolves.'],
                ] as [$title, $copy])
                    <article class="value-card flex gap-5 rounded-card border p-5 sm:p-6">
                        <span class="value-card__number" aria-hidden="true">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="relative">
                            <span class="value-card__eyebrow">Our advantage</span>
                            <h2 class="mt-2 text-lg font-bold text-ink-950">{{ $title }}</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-20 sm:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <x-ui.section-heading
                eyebrow="How we work"
                title="A clear path from idea to improvement."
                description="Each step produces something useful and keeps decisions visible."
                align="center"
            />
            <ol class="process-grid colorful-grid mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['Consult', 'Understand goals and constraints.', 'consult'],
                    ['Strategize', 'Choose the right priorities.', 'strategize'],
                    ['Design', 'Shape the experience and message.', 'design'],
                    ['Develop', 'Build a reliable implementation.', 'develop'],
                    ['Launch', 'Prepare and release carefully.', 'launch'],
                    ['Market', 'Reach the intended audience.', 'market'],
                    ['Optimize', 'Learn and improve over time.', 'optimize'],
                ] as [$title, $copy, $icon])
                    <li class="process-card rounded-card border p-6">
                        <div class="process-card__heading">
                            <span class="process-card__icon" aria-hidden="true"><x-process-icon :name="$icon" /></span>
                            <span class="process-card__label">Step {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <h2 class="mt-6 text-lg font-bold text-ink-950">{{ $title }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    @if ($projects->isNotEmpty())
        <section class="bg-ink-950 py-20 text-white sm:py-24">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <x-ui.section-heading eyebrow="Selected work" title="Work shaped around real goals." description="A selection of published projects and case studies." />
                    <x-ui.button href="{{ url('/portfolio') }}" variant="secondary" class="border-white/20 bg-white/5 text-white hover:bg-white/10">View portfolio</x-ui.button>
                </div>
                <div class="mt-12 grid gap-6 md:grid-cols-2">
                    @foreach ($projects as $project)
                        <article class="overflow-hidden rounded-feature border border-white/10 bg-white/5">
                            @if ($project->cover_image)
                                <x-responsive-image :path="$project->cover_image" alt="" sizes="(min-width: 1024px) 25vw, (min-width: 640px) 50vw, 100vw" class="aspect-[16/10] w-full object-cover" />
                            @else
                                <div class="aspect-[16/10] bg-gradient-to-br from-brand-600/40 to-accent-500/20" aria-hidden="true"></div>
                            @endif
                            <div class="p-6">
                                @if ($project->category)<p class="text-xs font-bold uppercase tracking-wider text-accent-400">{{ $project->category->name }}</p>@endif
                                <h2 class="mt-2 text-xl font-bold">{{ $project->title }}</h2>
                                <p class="mt-3 text-sm leading-6 text-slate-300">{{ $project->summary }}</p>
                                <a wire:navigate href="{{ url('/portfolio/'.$project->slug) }}" class="mt-5 inline-flex text-sm font-bold text-white">View case study -&gt;</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($testimonials->isNotEmpty())
        <section class="bg-gradient-to-br from-creative-pink/10 via-brand-50 to-accent-400/15 py-20 sm:py-24">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <x-ui.section-heading eyebrow="Client feedback" title="What clients say." align="center" />
                <div class="mt-12 grid gap-5 lg:grid-cols-3">
                    @foreach ($testimonials as $testimonial)
                        <x-ui.card>
                            <p class="text-lg leading-8 text-slate-700">&ldquo;{{ $testimonial->content }}&rdquo;</p>
                            <div class="mt-6 border-t border-slate-200 pt-5">
                                <p class="font-bold text-ink-950">{{ $testimonial->name }}</p>
                                @if ($testimonial->role || $testimonial->company)
                                    <p class="mt-1 text-sm text-slate-500">{{ collect([$testimonial->role, $testimonial->company])->filter()->join(', ') }}</p>
                                @endif
                            </div>
                        </x-ui.card>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($posts->isNotEmpty())
        <section class="py-20 sm:py-24">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <x-ui.section-heading eyebrow="Insights" title="Useful thinking for digital growth." />
                    <x-ui.button href="{{ url('/blog') }}" variant="secondary">View all insights</x-ui.button>
                </div>
                <div class="colorful-grid mt-12 grid gap-6 md:grid-cols-3">
                    @foreach ($posts as $post)
                        <article class="flex flex-col rounded-card border p-6">
                            <p class="text-xs font-bold uppercase tracking-wider text-brand-600">{{ $post->category?->name ?? 'Insight' }}</p>
                            <h2 class="mt-3 text-xl font-bold text-ink-950">{{ $post->title }}</h2>
                            <p class="mt-3 flex-1 text-sm leading-6 text-slate-600">{{ $post->excerpt }}</p>
                            <a wire:navigate href="{{ url('/blog/'.$post->slug) }}" class="mt-5 text-sm font-bold text-brand-700">Read article -&gt;</a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="px-4 pb-20 sm:px-6 sm:pb-24 lg:px-8">
        <div class="relative mx-auto max-w-6xl overflow-hidden rounded-feature color-spectrum px-6 py-12 text-white sm:px-10 lg:flex lg:items-center lg:justify-between lg:px-14">
            <div class="absolute -right-20 -top-20 size-64 rounded-full border-[40px] border-white/10" aria-hidden="true"></div>
            <div class="relative max-w-2xl">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand-100">Ready when you are</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">Ready to grow your business online?</h2>
                <p class="mt-4 text-brand-100">Tell us what you are working toward. We will help identify a practical next step.</p>
            </div>
            <div class="relative mt-8 lg:mt-0">
                <x-ui.button href="{{ url('/request-quote') }}" variant="secondary" size="lg" class="border-white bg-white text-brand-700 hover:bg-brand-50">
                    Request a quote
                </x-ui.button>
            </div>
        </div>
    </section>
</x-layouts.app>
