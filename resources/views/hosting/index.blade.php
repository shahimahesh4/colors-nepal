<x-layouts.app title="Web Hosting" description="Explore managed web hosting plans from Colors Nepal with clear monthly and yearly pricing.">
    <section class="relative overflow-hidden bg-ink-950 py-20 text-white sm:py-24">
        <div class="absolute -right-20 -top-20 size-72 rounded-full bg-brand-600/30 blur-3xl" aria-hidden="true"></div>
        <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-slate-400" aria-label="Breadcrumb"><a href="{{ route('home') }}" class="hover:text-white">Home</a><span class="mx-2" aria-hidden="true">/</span><span aria-current="page">Hosting</span></nav>
            <div class="mt-8 max-w-4xl">
                <x-ui.badge class="bg-white/10 text-brand-100 ring-white/15">Reliable hosting</x-ui.badge>
                <h1 class="mt-6 text-balance text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">Hosting that stays understandable.</h1>
                <p class="mt-6 max-w-3xl text-lg leading-8 text-slate-300">Choose a published plan for your current needs. We can help with setup, migration, SSL, backups, and ongoing maintenance.</p>
            </div>
        </div>
    </section>

    <section class="py-20 sm:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if ($plans->isNotEmpty())
                <div class="grid items-stretch gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($plans as $plan)
                        <article @class(['relative flex h-full flex-col rounded-feature border bg-white p-7 shadow-sm', 'border-brand-500 ring-2 ring-brand-100' => $plan->is_featured, 'border-slate-200' => ! $plan->is_featured])>
                            @if ($plan->is_featured)<x-ui.badge class="absolute right-5 top-5">Recommended</x-ui.badge>@endif
                            <h2 class="pr-24 text-2xl font-bold text-ink-950">{{ $plan->name }}</h2>
                            @if ($plan->description)<p class="mt-4 leading-7 text-slate-600">{{ $plan->description }}</p>@endif

                            <div class="mt-7 border-y border-slate-200 py-6">
                                @if ($plan->monthly_price !== null)
                                    <p><span class="text-4xl font-bold tracking-tight text-ink-950">{{ $plan->currency }} {{ number_format($plan->monthly_price / 100, 0) }}</span><span class="text-sm text-slate-500"> / month</span></p>
                                @endif
                                @if ($plan->yearly_price !== null)
                                    <p class="mt-2 text-sm font-semibold text-brand-700">{{ $plan->currency }} {{ number_format($plan->yearly_price / 100, 0) }} billed yearly</p>
                                @endif
                            </div>

                            @if ($plan->features)
                                <ul class="mt-6 grid flex-1 gap-3 text-sm text-slate-700">
                                    @foreach ($plan->features as $feature)
                                        <li class="flex gap-3"><span class="font-bold text-brand-600" aria-hidden="true">&check;</span><span>{{ $feature }}</span></li>
                                    @endforeach
                                </ul>
                            @endif

                            <x-ui.button href="{{ route('quote.create') }}" class="mt-8 w-full">Ask about this plan</x-ui.button>
                        </article>
                    @endforeach
                </div>
            @else
                <x-ui.alert title="Hosting plans are being prepared.">Contact us for a hosting recommendation based on your website and expected traffic.</x-ui.alert>
            @endif
        </div>
    </section>

    <section class="bg-slate-50 py-20 sm:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <x-ui.section-heading eyebrow="Included support" title="A practical hosting relationship." description="Hosting works best when ownership, maintenance, backups, and support expectations are clear." />
            <div class="mt-10 grid gap-5 md:grid-cols-3">
                <x-ui.card><h2 class="text-xl font-bold text-ink-950">Secure setup</h2><p class="mt-3 text-sm leading-6 text-slate-600">SSL configuration and sensible deployment practices for your website.</p></x-ui.card>
                <x-ui.card><h2 class="text-xl font-bold text-ink-950">Backup planning</h2><p class="mt-3 text-sm leading-6 text-slate-600">A clear backup approach appropriate to your site and update frequency.</p></x-ui.card>
                <x-ui.card><h2 class="text-xl font-bold text-ink-950">Human support</h2><p class="mt-3 text-sm leading-6 text-slate-600">A direct route to discuss migrations, incidents, upgrades, and capacity.</p></x-ui.card>
            </div>
        </div>
    </section>
</x-layouts.app>
