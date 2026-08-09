@php
$links=[
 ['label'=>'Home','href'=>route('home'),'active'=>request()->is('/')],
 ['label'=>'About','href'=>route('about'),'active'=>request()->is('about')],
 ['label'=>'Services','href'=>route('services.index'),'active'=>request()->is('services*')],
 ['label'=>'Portfolio','href'=>route('portfolio.index'),'active'=>request()->is('portfolio*')],
 ['label'=>'Blog','href'=>route('blog.index'),'active'=>request()->is('blog*')],
 ['label'=>'Contact','href'=>route('contact.create'),'active'=>request()->is('contact')],
];
@endphp
<header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/95 backdrop-blur"><div class="mx-auto flex min-h-18 max-w-6xl items-center justify-between gap-6 px-4 sm:px-6 lg:px-8">
<a href="{{ route('home') }}" class="shrink-0 rounded-control" aria-label="Colors Nepal home"><x-brand /></a>
<nav class="hidden items-center gap-1 lg:flex" aria-label="Primary navigation">@foreach($links as $link)<a href="{{ $link['href'] }}" @class(['rounded-control px-3 py-2 text-sm font-semibold transition','bg-brand-50 text-brand-700'=>$link['active'],'text-slate-600 hover:bg-slate-100'=>!$link['active']]) @if($link['active']) aria-current="page" @endif>{{ $link['label'] }}</a>@endforeach</nav>
<div class="hidden items-center gap-2 lg:flex">@auth<x-ui.button href="{{ route('dashboard') }}" variant="ghost">Dashboard</x-ui.button>@else<x-ui.button href="{{ route('login') }}" variant="ghost">Sign in</x-ui.button>@endauth<x-ui.button href="{{ route('quote.create') }}">Get a quote</x-ui.button></div>
<details class="group relative lg:hidden"><summary class="flex min-h-11 cursor-pointer list-none items-center rounded-control border border-slate-300 px-3 py-2 text-sm font-semibold">Menu</summary>
<div class="absolute right-0 top-full mt-3 w-[min(20rem,calc(100vw-2rem))] rounded-card border border-slate-200 bg-white p-3 shadow-card"><nav class="grid gap-1" aria-label="Mobile navigation">
@foreach($links as $link)<a href="{{ $link['href'] }}" class="rounded-control px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">{{ $link['label'] }}</a>@endforeach
@auth<a href="{{ route('dashboard') }}" class="rounded-control px-4 py-3 text-sm font-semibold">Dashboard</a><form method="POST" action="{{ route('logout') }}">@csrf<x-ui.button type="submit" variant="ghost" class="w-full">Sign out</x-ui.button></form>@else<a href="{{ route('login') }}" class="rounded-control px-4 py-3 text-sm font-semibold">Sign in</a>@endauth
<x-ui.button href="{{ route('quote.create') }}" class="mt-2 w-full">Get a quote</x-ui.button></nav></div></details>
</div></header>
