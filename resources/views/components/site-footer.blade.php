@php
    $contactEmail = $siteSettings->get('contact_email') ?: 'info@colorsnepal.com';
    $contactPhone = $siteSettings->get('contact_phone') ?: '+977 9800000000';
    $contactAddress = $siteSettings->get('contact_address') ?: 'Kathmandu, Nepal';
    $siteName = $siteSettings->get('site_name') ?: config('app.name');
@endphp
<footer class="relative border-t border-slate-800 bg-ink-950 text-slate-300">
<div class="color-spectrum absolute inset-x-0 top-0 h-1" aria-hidden="true"></div>
<div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-18">
<div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
<div><h2 class="text-sm font-bold uppercase tracking-wider text-white">About Us</h2><p class="mt-4 text-sm leading-7 text-slate-400">Practical digital services for a clear, reliable, and maintainable online presence.</p>@if($socialLinks->isNotEmpty())<div class="mt-6 flex flex-wrap gap-3" aria-label="Social media">@foreach($socialLinks as $social)<a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer" class="grid size-10 place-items-center rounded-full border border-white/10 bg-white/5 text-slate-300 transition hover:-translate-y-1 hover:border-accent-400 hover:bg-accent-500 hover:text-white" aria-label="{{ $social->name }} (opens in a new tab)"><x-social-icon :platform="$social->icon" class="size-5" /></a>@endforeach</div>@endif</div>
<div>
    <h2 class="text-sm font-bold uppercase tracking-wider text-white">Contact</h2>
    <address class="mt-4 grid gap-3 text-sm not-italic leading-6">
        <p class="flex items-center gap-3">
            <svg class="size-5 shrink-0 text-creative-pink" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 21h16M6 21V7l6-4 6 4v14M9 10h6M9 14h6M9 18h6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <strong class="text-white">{{ $siteName }}</strong>
        </p>
        <p class="flex items-center gap-3">
            <svg class="size-5 shrink-0 text-accent-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="10" r="2.5"/></svg>
            <span>{{ $contactAddress }}</span>
        </p>
        <a class="flex items-center gap-3 hover:text-white" href="tel:{{ preg_replace('/[^+0-9]/', '', $contactPhone) }}">
            <svg class="size-5 shrink-0 text-creative-orange" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M7.2 3.5 4.6 4.7c-1 .5-1.5 1.6-1.2 2.7 1.6 6.3 6.9 11.6 13.2 13.2 1.1.3 2.2-.2 2.7-1.2l1.2-2.6-4.2-2-1.3 2a15 15 0 0 1-7.8-7.8l2-1.3-2-4.2Z" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>{{ $contactPhone }}</span>
        </a>
        <a class="flex items-center gap-3 hover:text-white" href="mailto:{{ $contactEmail }}">
            <svg class="size-5 shrink-0 text-creative-yellow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>{{ $contactEmail }}</span>
        </a>
        <a wire:navigate class="flex items-center gap-3 hover:text-white" href="{{ route('home') }}">
            <svg class="size-5 shrink-0 text-brand-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>www.coloursnepal.com</span>
        </a>
    </address>
</div>
<div><h2 class="text-sm font-bold uppercase tracking-wider text-white">Company</h2><ul class="mt-4 grid gap-3 text-sm"><li><a wire:navigate class="hover:text-white" href="{{ url('/about') }}">About</a></li><li><a wire:navigate class="hover:text-white" href="{{ url('/portfolio') }}">Portfolio</a></li><li><a wire:navigate class="hover:text-white" href="{{ url('/blog') }}">Insights</a></li><li><a wire:navigate class="hover:text-white" href="{{ url('/contact') }}">Contact</a></li></ul></div>
<div><h2 class="text-sm font-bold uppercase tracking-wider text-white">Services</h2><ul class="mt-4 grid gap-3 text-sm"><li><a wire:navigate class="hover:text-white" href="{{ url('/services') }}">Website development</a></li><li><a wire:navigate class="hover:text-white" href="{{ url('/services') }}">Digital marketing</a></li><li><a wire:navigate class="hover:text-white" href="{{ url('/services') }}">SEO</a></li><li><a wire:navigate class="hover:text-white" href="{{ url('/hosting') }}">Hosting</a></li><li><a wire:navigate class="hover:text-white" href="{{ url('/domains') }}">Domains</a></li></ul></div>
</div>
<div class="mt-12 flex flex-col gap-3 border-t border-slate-800 pt-6 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between"><p>&copy; {{ now()->year }} Colors Nepal. All rights reserved.</p><p>Built for speed, accessibility, and maintainability.</p></div>
</div></footer>
