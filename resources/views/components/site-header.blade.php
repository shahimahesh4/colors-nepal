@php
$beforeServices = [
    ['label' => 'Home', 'href' => route('home'), 'active' => request()->is('/')],
    ['label' => 'About', 'href' => route('about'), 'active' => request()->is('about')],
];
$afterServices = [
    ['label' => 'Portfolio', 'href' => route('portfolio.index'), 'active' => request()->is('portfolio*')],
    ['label' => 'Blog', 'href' => route('blog.index'), 'active' => request()->is('blog*')],
    ['label' => 'Contact', 'href' => route('contact.create'), 'active' => request()->is('contact')],
];
$servicesActive = request()->is('services*');
@endphp
<header class="site-header sticky top-0 z-50 border-b border-slate-200/80 bg-white/95">
<div class="mx-auto flex min-h-18 max-w-7xl items-center justify-between gap-6 px-4 sm:px-6 lg:px-8">
<a wire:navigate href="{{ route('home') }}" class="shrink-0 rounded-control lg:hidden" aria-label="Colors Nepal home"><x-brand mobile /></a><a wire:navigate href="{{ route('home') }}" class="hidden shrink-0 rounded-control lg:inline-flex" aria-label="Colors Nepal home"><x-brand /></a>
<nav class="hidden items-center gap-1 lg:flex" aria-label="Primary navigation">
@foreach($beforeServices as $link)<a wire:navigate href="{{ $link['href'] }}" @class(['rounded-control px-3 py-2 text-sm font-semibold transition','bg-brand-50 text-brand-700'=>$link['active'],'text-slate-600 hover:bg-slate-100'=>!$link['active']]) @if($link['active']) aria-current="page" @endif>{{ $link['label'] }}</a>@endforeach
<div class="services-menu group relative">
<a wire:navigate href="{{ route('services.index') }}" aria-haspopup="true" @class(['flex items-center gap-1 rounded-control px-3 py-2 text-sm font-semibold transition','bg-brand-50 text-brand-700'=>$servicesActive,'text-slate-600 hover:bg-slate-100'=>!$servicesActive])>Services <svg class="size-4 transition duration-200 group-hover:rotate-180 group-focus-within:rotate-180" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="m5 7 5 5 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
<div class="services-menu__dropdown absolute left-0 top-full z-50 w-80 pt-3">
<div class="rounded-card border border-brand-100 bg-white p-2 shadow-card">
<a wire:navigate href="{{ route('services.index') }}" class="flex items-center justify-between rounded-control bg-brand-50 px-4 py-3 text-sm font-bold text-brand-700">All Services <span aria-hidden="true">&rarr;</span></a>
<div class="mt-1 grid">@foreach($headerServices as $service)<a wire:navigate href="{{ route('services.show', $service) }}" @class(['block rounded-control px-4 py-3 text-sm font-semibold transition','bg-creative-pink/10 text-creative-pink'=>request()->is('services/'.$service->slug),'text-slate-700 hover:bg-brand-50 hover:text-brand-700'=>!request()->is('services/'.$service->slug)])>{{ $service->title }}</a>@endforeach</div>
</div>
</div>
</div>
@foreach($afterServices as $link)<a wire:navigate href="{{ $link['href'] }}" @class(['rounded-control px-3 py-2 text-sm font-semibold transition','bg-brand-50 text-brand-700'=>$link['active'],'text-slate-600 hover:bg-slate-100'=>!$link['active']]) @if($link['active']) aria-current="page" @endif>{{ $link['label'] }}</a>@endforeach
</nav>
<div class="hidden items-center gap-2 lg:flex">@auth<x-ui.button href="{{ route('dashboard') }}" variant="ghost">Dashboard</x-ui.button>@else<x-ui.button href="{{ route('login') }}" variant="ghost">Sign in</x-ui.button>@endauth<x-ui.button href="{{ route('quote.create') }}">Get a quote</x-ui.button></div>
<details class="mobile-menu lg:hidden">
<summary class="mobile-menu__toggle" aria-label="Toggle mobile navigation"><span class="mobile-menu__open inline-flex items-center gap-2"><svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg> Menu</span><span class="mobile-menu__close" aria-hidden="true"><svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 6 12 12M18 6 6 18"/></svg></span></summary>
<div class="mobile-menu__backdrop" aria-hidden="true"></div>
<aside class="mobile-menu__panel" aria-label="Mobile menu">
<div class="border-b border-white/10 px-6 pb-6 pt-7"><x-brand mobile class="text-white" /><p class="mt-4 text-sm leading-6 text-slate-400">Strategy, creativity, and digital growth in one practical partnership.</p></div>
<nav class="grid gap-1 px-4 py-5" aria-label="Mobile navigation">
@foreach($beforeServices as $link)<a wire:navigate href="{{ $link['href'] }}" @class(['rounded-control px-4 py-3 text-sm font-semibold transition','bg-white/10 text-white'=>$link['active'],'text-slate-300 hover:bg-white/10 hover:text-white'=>!$link['active']]) @if($link['active']) aria-current="page" @endif>{{ $link['label'] }}</a>@endforeach
<details class="group/mobile" @if($servicesActive) open @endif>
<summary @class(['flex cursor-pointer list-none items-center justify-between rounded-control px-4 py-3 text-sm font-semibold transition','bg-white/10 text-white'=>$servicesActive,'text-slate-300 hover:bg-white/10 hover:text-white'=>!$servicesActive])>Services <svg class="size-4 transition group-open/mobile:rotate-180" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="m5 7 5 5 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></summary>
<div class="ml-3 mt-1 grid border-l border-white/10 pl-3"><a wire:navigate href="{{ route('services.index') }}" class="rounded-control px-4 py-2.5 text-sm font-bold text-accent-400 hover:bg-white/10">All Services</a>@foreach($headerServices as $service)<a wire:navigate href="{{ route('services.show', $service) }}" @class(['rounded-control px-4 py-2.5 text-sm font-medium','bg-white/10 text-white'=>request()->is('services/'.$service->slug),'text-slate-400 hover:bg-white/10 hover:text-white'=>!request()->is('services/'.$service->slug)])>{{ $service->title }}</a>@endforeach</div>
</details>
@foreach($afterServices as $link)<a wire:navigate href="{{ $link['href'] }}" @class(['rounded-control px-4 py-3 text-sm font-semibold transition','bg-white/10 text-white'=>$link['active'],'text-slate-300 hover:bg-white/10 hover:text-white'=>!$link['active']]) @if($link['active']) aria-current="page" @endif>{{ $link['label'] }}</a>@endforeach
</nav>
<div class="mt-auto border-t border-white/10 p-4">@auth<a wire:navigate href="{{ route('dashboard') }}" class="block rounded-control px-4 py-3 text-sm font-semibold text-white hover:bg-white/10">Dashboard</a><form method="POST" action="{{ route('logout') }}">@csrf<x-ui.button type="submit" variant="ghost" class="w-full text-slate-300 hover:bg-white/10 hover:text-white">Sign out</x-ui.button></form>@else<a wire:navigate href="{{ route('login') }}" class="block rounded-control px-4 py-3 text-sm font-semibold text-white hover:bg-white/10">Sign in</a>@endauth<x-ui.button href="{{ route('quote.create') }}" class="mt-2 w-full">Get a quote</x-ui.button></div>
</aside>
</details>
</div></header>