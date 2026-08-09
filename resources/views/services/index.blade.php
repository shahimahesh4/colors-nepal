<x-layouts.app
    title="Services"
    description="Explore Colors Nepal services for website design and development, digital marketing, SEO, social media, hosting, domains, and maintenance."
>
    <section class="relative overflow-hidden bg-ink-950 py-20 text-white sm:py-24">
        <div class="absolute -right-24 -top-24 size-80 rounded-full bg-brand-600/30 blur-3xl" aria-hidden="true"></div>
        <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-slate-400" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <span class="mx-2" aria-hidden="true">/</span>
                <span aria-current="page">Services</span>
            </nav>
            <div class="mt-8 max-w-3xl">
                <x-ui.badge class="bg-white/10 text-brand-100 ring-white/15">Services</x-ui.badge>
                <h1 class="mt-6 text-balance text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">Useful digital capability, without unnecessary complexity.</h1>
                <p class="mt-6 text-lg leading-8 text-slate-300">Choose a focused service or combine several into a coordinated plan built around your priorities.</p>
            </div>
        </div>
    </section>

    <section class="py-20 sm:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if ($services->isNotEmpty())
                <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($services as $service)
                        <x-ui.card interactive class="group flex h-full flex-col">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-bold text-brand-600">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                @if ($service->is_featured)<x-ui.badge>Featured</x-ui.badge>@endif
                            </div>
                            <h2 class="mt-8 text-2xl font-bold text-ink-950">
                                <a href="{{ route('services.show', $service) }}" class="rounded-control">{{ $service->title }}</a>
                            </h2>
                            <p class="mt-4 flex-1 leading-7 text-slate-600">{{ $service->summary }}</p>
                            <a href="{{ route('services.show', $service) }}" class="mt-7 inline-flex items-center gap-2 text-sm font-bold text-brand-700">
                                Explore service <span aria-hidden="true">-&gt;</span>
                            </a>
                        </x-ui.card>
                    @endforeach
                </div>
            @else
                <x-ui.alert title="Services are being prepared.">Please contact us to discuss the support you need.</x-ui.alert>
            @endif
        </div>
    </section>

    <section class="px-4 pb-20 sm:px-6 sm:pb-24 lg:px-8">
        <div class="mx-auto max-w-6xl rounded-feature bg-brand-50 px-6 py-12 sm:px-10 lg:flex lg:items-center lg:justify-between lg:px-14">
            <div class="max-w-2xl">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand-700">Not sure where to begin?</p>
                <h2 class="mt-3 text-3xl font-bold text-ink-950">Start with the business goal.</h2>
                <p class="mt-4 text-slate-600">Share the outcome you want, and we can identify the smallest practical combination of services.</p>
            </div>
            <div class="mt-8 lg:mt-0"><x-ui.button href="{{ url('/request-quote') }}" size="lg">Request a quote</x-ui.button></div>
        </div>
    </section>
</x-layouts.app>
