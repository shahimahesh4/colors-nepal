<x-layouts.app title="Contact" description="Contact Colors Nepal about websites, SEO, marketing, hosting, maintenance, and other digital services.">
    @php
        $contactEmail = $siteSettings->get('contact_email') ?: 'hello@colorsnepal.com';
        $contactPhone = $siteSettings->get('contact_phone') ?: '+977 9800000000';
        $contactAddress = $siteSettings->get('contact_address') ?: 'Kathmandu, Nepal';
    @endphp
    <x-page-banner title="Tell us what you need help with." breadcrumb="Contact" eyebrow="Start a conversation" description="Share a question or challenge. We will review it and respond with a practical next step." />

    <section class="py-16 sm:py-20">
        <div class="mx-auto grid max-w-6xl gap-10 px-4 sm:px-6 lg:grid-cols-[0.75fr_1.25fr] lg:px-8">
            <aside class="brand-panel brand-surface rounded-feature border border-brand-100 p-6 sm:p-8">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-creative-pink">Contact details</p>
                <address class="mt-5 grid gap-4 text-sm not-italic text-slate-700">
                    <a href="mailto:{{ $contactEmail }}" class="font-semibold text-brand-700 hover:underline">{{ $contactEmail }}</a>
                    <a href="tel:{{ preg_replace('/[^+0-9]/', '', $contactPhone) }}" class="font-semibold text-brand-700 hover:underline">{{ $contactPhone }}</a>
                    <p>{{ $contactAddress }}</p>
                </address>
                <h2 class="mt-8 border-t border-brand-200 pt-7 text-2xl font-bold text-ink-950">What happens next?</h2>
                <ol class="mt-6 grid gap-5 text-sm leading-6 text-slate-700">
                    <li><strong class="block text-ink-950">1. We review your message</strong>We identify the most useful person to respond.</li>
                    <li><strong class="block text-ink-950">2. We clarify the scope</strong>We may ask a few focused questions.</li>
                    <li><strong class="block text-ink-950">3. You get a practical next step</strong>No pressure and no unnecessary complexity.</li>
                </ol>
                <p class="mt-8 border-t border-brand-200 pt-6 text-sm text-slate-600">Need project pricing? <a wire:navigate href="{{ route('quote.create') }}" class="font-semibold text-brand-700 hover:underline">Request a quote instead.</a></p>
            </aside>

            <div>
                @if (session('success'))<div class="mb-6"><x-ui.alert title="Message sent" variant="success">{{ session('success') }}</x-ui.alert></div>@endif
                <form method="POST" action="{{ route('contact.store') }}" class="grid gap-6 brand-panel rounded-feature border border-brand-100 bg-white p-6 shadow-card sm:grid-cols-2 sm:p-8">
                    @csrf
                    <div class="hidden" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
                    <x-ui.input label="Name" name="name" autocomplete="name" required />
                    <x-ui.input label="Email" name="email" type="email" autocomplete="email" required />
                    <x-ui.input label="Phone" name="phone" type="tel" autocomplete="tel" />
                    <x-ui.input label="Subject" name="subject" required />
                    <div class="sm:col-span-2"><x-ui.textarea label="How can we help?" name="message" :rows="7" required help="Please include enough detail for us to understand your request." /></div>
                    <div class="sm:col-span-2 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-xs leading-5 text-slate-500">By submitting, you allow us to use these details to respond to your enquiry.</p>
                        <x-recaptcha />
<x-ui.button type="submit" size="lg">Send message</x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
