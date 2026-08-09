<x-layouts.app title="Contact" description="Contact Colors Nepal about websites, SEO, marketing, hosting, maintenance, and other digital services.">
    <section class="bg-ink-950 py-16 text-white sm:py-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-slate-400" aria-label="Breadcrumb"><a href="{{ route('home') }}" class="hover:text-white">Home</a><span class="mx-2" aria-hidden="true">/</span><span aria-current="page">Contact</span></nav>
            <div class="mt-8 max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-accent-400">Start a conversation</p>
                <h1 class="mt-4 text-balance text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">Tell us what you need help with.</h1>
                <p class="mt-6 text-lg leading-8 text-slate-300">Share a question or challenge. We will review it and respond with a practical next step.</p>
            </div>
        </div>
    </section>

    <section class="py-16 sm:py-20">
        <div class="mx-auto grid max-w-6xl gap-10 px-4 sm:px-6 lg:grid-cols-[0.75fr_1.25fr] lg:px-8">
            <aside class="rounded-feature bg-brand-50 p-6 sm:p-8">
                <h2 class="text-2xl font-bold text-ink-950">What happens next?</h2>
                <ol class="mt-6 grid gap-5 text-sm leading-6 text-slate-700">
                    <li><strong class="block text-ink-950">1. We review your message</strong>We identify the most useful person to respond.</li>
                    <li><strong class="block text-ink-950">2. We clarify the scope</strong>We may ask a few focused questions.</li>
                    <li><strong class="block text-ink-950">3. You get a practical next step</strong>No pressure and no unnecessary complexity.</li>
                </ol>
                <p class="mt-8 border-t border-brand-200 pt-6 text-sm text-slate-600">Need project pricing? <a href="{{ route('quote.create') }}" class="font-semibold text-brand-700 hover:underline">Request a quote instead.</a></p>
            </aside>

            <div>
                @if (session('success'))<div class="mb-6"><x-ui.alert title="Message sent" variant="success">{{ session('success') }}</x-ui.alert></div>@endif
                <form method="POST" action="{{ route('contact.store') }}" class="grid gap-6 rounded-feature border border-slate-200 bg-white p-6 shadow-card sm:grid-cols-2 sm:p-8">
                    @csrf
                    <div class="hidden" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
                    <x-ui.input label="Name" name="name" autocomplete="name" required />
                    <x-ui.input label="Email" name="email" type="email" autocomplete="email" required />
                    <x-ui.input label="Phone" name="phone" type="tel" autocomplete="tel" />
                    <x-ui.input label="Subject" name="subject" required />
                    <div class="sm:col-span-2"><x-ui.textarea label="How can we help?" name="message" :rows="7" required help="Please include enough detail for us to understand your request." /></div>
                    <div class="sm:col-span-2 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-xs leading-5 text-slate-500">By submitting, you allow us to use these details to respond to your enquiry.</p>
                        <x-ui.button type="submit" size="lg">Send message</x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
