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
<div><a wire:navigate href="{{ url('/') }}" class="inline-flex rounded-control bg-white px-3 py-2" aria-label="Colors Nepal home"><x-brand /></a><p class="mt-5 text-sm leading-7 text-slate-400">Practical digital services for a clear, reliable, and maintainable online presence.</p>@if($socialLinks->isNotEmpty())<div class="mt-6 flex flex-wrap gap-3" aria-label="Social media">@foreach($socialLinks as $social)<a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer" class="grid size-10 place-items-center rounded-full border border-white/10 bg-white/5 text-slate-300 transition hover:-translate-y-1 hover:border-accent-400 hover:bg-accent-500 hover:text-white" aria-label="{{ $social->name }} (opens in a new tab)"><x-social-icon :platform="$social->icon" class="size-5" /></a>@endforeach</div>@endif</div>
<div>
    <h2 class="text-sm font-bold uppercase tracking-wider text-white">Contact</h2>
    <address class="mt-4 grid gap-3 text-sm not-italic leading-6">
        <p class="flex items-center gap-3">
            <span class="w-5 shrink-0 text-center text-creative-pink" aria-hidden="true">&#9679;</span>
            <strong class="text-white">{{ $siteName }}</strong>
        </p>
        <p class="flex items-center gap-3">
            <span class="w-5 shrink-0 text-center text-accent-400" aria-hidden="true">&#9673;</span>
            <span>{{ $contactAddress }}</span>
        </p>
        <a class="flex items-center gap-3 hover:text-white" href="tel:{{ preg_replace('/[^+0-9]/', '', $contactPhone) }}">
            <span class="w-5 shrink-0 text-center text-creative-orange" aria-hidden="true">&#9742;</span>
            <span>{{ $contactPhone }}</span>
        </a>
        <a class="flex items-center gap-3 hover:text-white" href="mailto:{{ $contactEmail }}">
            <span class="w-5 shrink-0 text-center text-creative-yellow" aria-hidden="true">&#9993;</span>
            <span>{{ $contactEmail }}</span>
        </a>
        <a wire:navigate class="flex items-center gap-3 hover:text-white" href="{{ route('home') }}">
            <span class="w-5 shrink-0 text-center text-brand-400" aria-hidden="true">&#9678;</span>
            <span>www.coloursnepal.com</span>
        </a>
    </address>
</div>
<div><h2 class="text-sm font-bold uppercase tracking-wider text-white">Company</h2><ul class="mt-4 grid gap-3 text-sm"><li><a wire:navigate class="hover:text-white" href="{{ url('/about') }}">About</a></li><li><a wire:navigate class="hover:text-white" href="{{ url('/portfolio') }}">Portfolio</a></li><li><a wire:navigate class="hover:text-white" href="{{ url('/blog') }}">Insights</a></li><li><a wire:navigate class="hover:text-white" href="{{ url('/contact') }}">Contact</a></li></ul></div>
<div><h2 class="text-sm font-bold uppercase tracking-wider text-white">Services</h2><ul class="mt-4 grid gap-3 text-sm"><li><a wire:navigate class="hover:text-white" href="{{ url('/services') }}">Website development</a></li><li><a wire:navigate class="hover:text-white" href="{{ url('/services') }}">Digital marketing</a></li><li><a wire:navigate class="hover:text-white" href="{{ url('/services') }}">SEO</a></li><li><a wire:navigate class="hover:text-white" href="{{ url('/hosting') }}">Hosting</a></li><li><a wire:navigate class="hover:text-white" href="{{ url('/domains') }}">Domains</a></li></ul></div>
</div>
<div class="mt-12 flex flex-col gap-3 border-t border-slate-800 pt-6 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between"><p>&copy; {{ now()->year }} Colors Nepal. All rights reserved.</p><p>Built for speed, accessibility, and maintainability.</p></div>
</div></footer>