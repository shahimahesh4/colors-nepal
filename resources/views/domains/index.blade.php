<x-layouts.app title="Domain Registration" description="Compare active domain registration and renewal pricing available through Colors Nepal.">
    <section class="brand-hero relative overflow-hidden bg-ink-950 py-20 text-white sm:py-24">
        <div class="absolute -left-20 bottom-0 size-72 rounded-full bg-accent-500/20 blur-3xl" aria-hidden="true"></div>
        <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-slate-400" aria-label="Breadcrumb"><a wire:navigate href="{{ route('home') }}" class="hover:text-white">Home</a><span class="mx-2" aria-hidden="true">/</span><span aria-current="page">Domains</span></nav>
            <div class="mt-8 max-w-4xl">
                <x-ui.badge class="bg-white/10 text-brand-100 ring-white/15">Domain services</x-ui.badge>
                <h1 class="mt-6 text-balance text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">Choose a domain you can build around.</h1>
                <p class="mt-6 max-w-3xl text-lg leading-8 text-slate-300">Review currently active extensions and transparent registration and renewal prices. Availability is confirmed before purchase.</p>
            </div>
        </div>
    </section>

    <section class="py-20 sm:py-24">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            @if ($domains->isNotEmpty())
                <div class="overflow-hidden brand-panel rounded-feature border border-brand-100 bg-white shadow-card">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[40rem] text-left">
                            <caption class="sr-only">Available domain extensions and prices</caption>
                            <thead class="bg-slate-50 text-sm text-slate-600">
                                <tr><th scope="col" class="px-6 py-4 font-semibold">Extension</th><th scope="col" class="px-6 py-4 font-semibold">Registration</th><th scope="col" class="px-6 py-4 font-semibold">Renewal</th><th scope="col" class="px-6 py-4"><span class="sr-only">Action</span></th></tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @foreach ($domains as $domain)
                                    <tr class="hover:bg-brand-50/50">
                                        <th scope="row" class="px-6 py-5 text-xl font-bold text-ink-950">{{ $domain->extension }}</th>
                                        <td class="px-6 py-5 font-semibold text-slate-800">{{ $domain->currency }} {{ number_format($domain->registration_price / 100, 0) }}</td>
                                        <td class="px-6 py-5 text-slate-600">{{ $domain->renewal_price !== null ? $domain->currency.' '.number_format($domain->renewal_price / 100, 0) : 'Ask us' }}</td>
                                        <td class="px-6 py-5 text-right"><x-ui.button href="{{ route('quote.create') }}" variant="secondary" size="sm">Check availability</x-ui.button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <p class="mt-5 text-sm leading-6 text-slate-500">Prices are indicative and may change with registry fees, taxes, or promotions. Domain availability is checked manually before confirmation.</p>
            @else
                <x-ui.alert title="Domain pricing is being prepared.">Contact us to check availability and pricing for the extension you need.</x-ui.alert>
            @endif
        </div>
    </section>

    <section class="px-4 pb-20 sm:px-6 sm:pb-24 lg:px-8">
        <div class="mx-auto max-w-5xl rounded-feature color-spectrum px-6 py-12 text-white sm:px-10 lg:flex lg:items-center lg:justify-between">
            <div class="max-w-2xl"><p class="text-sm font-bold uppercase tracking-[0.16em] text-brand-100">Need a name checked?</p><h2 class="mt-3 text-3xl font-bold">Send us your preferred domain.</h2><p class="mt-4 text-brand-100">We will confirm availability and explain registration, renewal, and ownership details.</p></div>
            <div class="mt-8 lg:mt-0"><x-ui.button href="{{ route('contact.create') }}" variant="secondary" size="lg" class="border-white bg-white text-brand-700 hover:bg-brand-50">Contact us</x-ui.button></div>
        </div>
    </section>
</x-layouts.app>
