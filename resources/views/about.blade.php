<x-layouts.app
    title="About"
    description="Learn how Colors Nepal approaches digital strategy, design, development, marketing, and long-term support."
>
    <section class="brand-hero relative isolate overflow-hidden bg-ink-950 py-20 text-white sm:py-24 lg:py-28">
        <div class="absolute inset-0 -z-10" aria-hidden="true">
            <div class="absolute -left-20 top-10 size-72 rounded-full bg-brand-600/25 blur-3xl"></div>
            <div class="absolute -right-24 bottom-0 size-80 rounded-full bg-accent-500/15 blur-3xl"></div>
        </div>
        <div class="mx-auto grid max-w-6xl gap-12 px-4 sm:px-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-center lg:px-8">
            <div>
                <nav class="text-sm text-slate-400" aria-label="Breadcrumb">
                    <a wire:navigate href="{{ route('home') }}" class="hover:text-white">Home</a>
                    <span class="mx-2" aria-hidden="true">/</span>
                    <span aria-current="page">About</span>
                </nav>
                <x-ui.badge class="mt-8 bg-white/10 text-brand-100 ring-white/15">About Colors Nepal</x-ui.badge>
                <h1 class="mt-6 text-balance text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">Digital capability with a practical point of view.</h1>
                <p class="mt-6 max-w-3xl text-lg leading-8 text-slate-300">{{ $aboutIntro }}</p>
            </div>

            <div class="relative mx-auto w-full max-w-md">
                <div class="grid rotate-2 grid-cols-2 gap-3 rounded-feature border border-white/10 bg-white/5 p-5 backdrop-blur">
                    @foreach ([
                        ['01', 'Listen closely'],
                        ['02', 'Think clearly'],
                        ['03', 'Build carefully'],
                        ['04', 'Improve steadily'],
                    ] as [$number, $label])
                        <div class="aspect-square rounded-card border border-white/10 bg-white/5 p-4">
                            <span class="text-xs font-bold text-accent-400">{{ $number }}</span>
                            <p class="mt-12 font-bold text-white">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="absolute -bottom-5 -left-4 rounded-card bg-brand-600 px-5 py-3 text-sm font-bold shadow-xl">Clear work. Useful outcomes.</div>
            </div>
        </div>
    </section>

    <section class="py-20 sm:py-24">
        <div class="mx-auto grid max-w-6xl gap-12 px-4 sm:px-6 lg:grid-cols-[0.85fr_1.15fr] lg:items-start lg:px-8">
            <x-ui.section-heading
                eyebrow="Our approach"
                title="Start with what needs to change."
                description="Tools and trends matter only when they support the audience, the business, and the people responsible for maintaining the work."
            />
            <div class="grid gap-5 sm:grid-cols-2">
                @foreach ([
                    ['Clarity', 'Make decisions and priorities understandable before adding complexity.'],
                    ['Usefulness', 'Design around real tasks, real audiences, and meaningful business needs.'],
                    ['Reliability', 'Choose maintainable technology and careful delivery over fragile shortcuts.'],
                    ['Improvement', 'Treat launch as a starting point for learning, support, and steady progress.'],
                ] as [$title, $copy])
                    <x-ui.card>
                        <span class="text-xs font-bold tracking-wider text-brand-600">0{{ $loop->iteration }}</span>
                        <h2 class="mt-5 text-xl font-bold text-ink-950">{{ $title }}</h2>
                        <p class="mt-3 text-sm leading-7 text-slate-600">{{ $copy }}</p>
                    </x-ui.card>
                @endforeach
            </div>
        </div>
    </section>

    <section class="brand-surface py-20 sm:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-2">
                <article class="relative overflow-hidden rounded-feature color-spectrum p-7 text-white sm:p-10">
                    <span class="text-sm font-bold uppercase tracking-[0.16em] text-brand-100">Our mission</span>
                    <h2 class="mt-5 text-3xl font-bold tracking-tight">Make digital work more useful.</h2>
                    <p class="mt-5 text-lg leading-8 text-brand-100">{{ $mission }}</p>
                    <div class="absolute -bottom-20 -right-16 size-56 rounded-full border-[32px] border-white/10" aria-hidden="true"></div>
                </article>
                <article class="relative overflow-hidden rounded-feature bg-ink-950 p-7 text-white sm:p-10">
                    <span class="text-sm font-bold uppercase tracking-[0.16em] text-accent-400">Our vision</span>
                    <h2 class="mt-5 text-3xl font-bold tracking-tight">Capability that grows with you.</h2>
                    <p class="mt-5 text-lg leading-8 text-slate-300">{{ $vision }}</p>
                    <div class="absolute -right-12 -top-12 size-40 rounded-full bg-accent-500/10 blur-2xl" aria-hidden="true"></div>
                </article>
            </div>
        </div>
    </section>

    <section class="py-20 sm:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                <div>
                    <x-ui.section-heading
                        eyebrow="How we collaborate"
                        title="Small, visible steps. Shared decisions."
                        description="A clear process reduces surprises and keeps effort focused on the most valuable work."
                    />
                    <div class="mt-8"><x-ui.button href="{{ url('/contact') }}" variant="secondary">Talk with us</x-ui.button></div>
                </div>
                <ol class="grid gap-3">
                    @foreach ([
                        ['Understand', 'Clarify goals, users, constraints, and current context.'],
                        ['Prioritize', 'Agree on the smallest useful scope and a sensible sequence.'],
                        ['Create', 'Design and build with regular review points.'],
                        ['Support', 'Launch carefully, measure what matters, and keep improving.'],
                    ] as [$title, $copy])
                        <li class="flex gap-4 brand-panel rounded-card border border-brand-100 p-5">
                            <span class="grid size-10 shrink-0 place-items-center rounded-full bg-brand-50 font-bold text-brand-700">{{ $loop->iteration }}</span>
                            <div><h2 class="font-bold text-ink-950">{{ $title }}</h2><p class="mt-1 text-sm leading-6 text-slate-600">{{ $copy }}</p></div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </section>

    @if ($teamMembers->isNotEmpty())
        <section class="brand-surface py-20 sm:py-24">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <x-ui.section-heading eyebrow="Our team" title="The people behind the work." description="Meet the published team members responsible for planning, creating, and supporting digital work." align="center" />
                <div class="colorful-grid mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($teamMembers as $member)
                        <x-ui.card class="overflow-hidden p-0">
                            @if ($member->photo)
                                <img src="{{ asset('storage/'.$member->photo) }}" alt="{{ $member->name }}" class="aspect-[4/3] w-full object-cover" loading="lazy">
                            @else
                                <div class="grid aspect-[4/3] place-items-center bg-gradient-to-br from-brand-100 to-accent-400/20" aria-hidden="true">
                                    <span class="text-4xl font-bold text-brand-700">{{ collect(explode(' ', $member->name))->map(fn ($part) => mb_substr($part, 0, 1))->take(2)->join('') }}</span>
                                </div>
                            @endif
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-ink-950">{{ $member->name }}</h2>
                                <p class="mt-1 text-sm font-semibold text-brand-700">{{ $member->role }}</p>
                                @if ($member->bio)<p class="mt-4 text-sm leading-6 text-slate-600">{{ $member->bio }}</p>@endif
                                @if ($member->linkedin_url)
                                    <a href="{{ $member->linkedin_url }}" rel="noopener noreferrer" target="_blank" class="mt-5 inline-flex text-sm font-bold text-brand-700">LinkedIn <span class="sr-only">for {{ $member->name }} (opens in a new tab)</span></a>
                                @endif
                            </div>
                        </x-ui.card>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="px-4 py-20 sm:px-6 sm:py-24 lg:px-8">
        <div class="mx-auto max-w-6xl rounded-feature color-spectrum px-6 py-12 text-white sm:px-10 lg:flex lg:items-center lg:justify-between lg:px-14">
            <div class="max-w-2xl">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand-100">Work with us</p>
                <h2 class="mt-3 text-3xl font-bold sm:text-4xl">Bring us the goal, not a perfect brief.</h2>
                <p class="mt-4 text-brand-100">We can help turn an early idea or a known challenge into a sensible next step.</p>
            </div>
            <div class="mt-8 lg:mt-0"><x-ui.button href="{{ url('/request-quote') }}" variant="secondary" size="lg" class="border-white bg-white text-brand-700 hover:bg-brand-50">Start a conversation</x-ui.button></div>
        </div>
    </section>
</x-layouts.app>
