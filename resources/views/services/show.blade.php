<x-layouts.app
    :title="$service->meta_title ?: $service->title"
    :description="$service->meta_description ?: $service->summary"
    :keywords="$service->meta_keywords"
    :image="$service->og_image ? asset('storage/'.$service->og_image) : ($service->image ? asset('storage/'.$service->image) : null)"
>
    <x-page-banner :title="$service->title" :eyebrow="$service->is_featured ? 'Featured service' : 'Service'" :description="$service->summary" parent-label="Services" :parent-url="route('services.index')" />

    @if ($service->features->isNotEmpty())
        <section class="py-20 sm:py-24">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <x-ui.section-heading eyebrow="What is included" title="A focused service, clearly explained." />
                <div class="mt-12 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($service->features as $feature)
                        <x-ui.card>
                            <span class="grid size-10 place-items-center rounded-full bg-brand-50 font-bold text-brand-700" aria-hidden="true">{{ $loop->iteration }}</span>
                            <h2 class="mt-5 text-lg font-bold text-ink-950">{{ $feature->title }}</h2>
                            @if ($feature->description)<p class="mt-3 text-sm leading-6 text-slate-600">{{ $feature->description }}</p>@endif
                        </x-ui.card>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($service->content)
        <section class="brand-surface py-20 sm:py-24">
            <div class="mx-auto grid max-w-6xl gap-10 px-4 sm:px-6 lg:grid-cols-[0.7fr_1.3fr] lg:px-8">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand-700">Service details</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-ink-950">What to expect.</h2>
                </div>
                <div class="space-y-5 text-base leading-8 text-slate-700 [&_a]:font-semibold [&_a]:text-brand-700 [&_h2]:pt-4 [&_h2]:text-2xl [&_h2]:font-bold [&_h2]:text-ink-950 [&_h3]:pt-3 [&_h3]:text-xl [&_h3]:font-bold [&_h3]:text-ink-950 [&_li]:ml-5 [&_li]:list-disc [&_p]:text-slate-700">
                    {!! $service->content !!}
                </div>
            </div>
        </section>
    @endif

    @if ($service->faqs->isNotEmpty())
        <section class="py-20 sm:py-24">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <x-ui.section-heading eyebrow="Frequently asked questions" title="Helpful details before we begin." align="center" />
                <div class="mt-10 divide-y divide-slate-200 brand-panel rounded-card border border-brand-100 bg-white px-5 sm:px-7">
                    @foreach ($service->faqs as $faq)
                        <details class="group py-5">
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-bold text-ink-950 [&::-webkit-details-marker]:hidden">
                                {{ $faq->question }}
                                <span class="text-xl text-brand-600 transition group-open:rotate-45" aria-hidden="true">+</span>
                            </summary>
                            <p class="mt-3 max-w-3xl pr-8 text-sm leading-7 text-slate-600">{{ $faq->answer }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="px-4 pb-20 sm:px-6 sm:pb-24 lg:px-8">
        <div class="mx-auto max-w-6xl rounded-feature color-spectrum px-6 py-12 text-white sm:px-10 lg:flex lg:items-center lg:justify-between lg:px-14">
            <div class="max-w-2xl">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand-100">Next step</p>
                <h2 class="mt-3 text-3xl font-bold">Let us shape the right scope together.</h2>
                <p class="mt-4 text-brand-100">A short conversation can clarify priorities, timing, and the most useful starting point.</p>
            </div>
            <div class="mt-8 lg:mt-0"><x-ui.button href="{{ url('/request-quote') }}" variant="secondary" size="lg" class="border-white bg-white text-brand-700 hover:bg-brand-50">Request a quote</x-ui.button></div>
        </div>
    </section>
</x-layouts.app>
