<x-layouts.app title="Dashboard" description="Review your Colors Nepal project requests.">
<section class="bg-ink-950 py-14 text-white sm:py-16"><div class="mx-auto flex max-w-6xl flex-col gap-6 px-4 sm:px-6 lg:flex-row lg:items-end lg:justify-between lg:px-8">
<div><p class="text-sm font-bold uppercase tracking-[0.16em] text-accent-400">Customer dashboard</p><h1 class="mt-3 text-4xl font-bold">Hello, {{ auth()->user()->name }}.</h1><p class="mt-3 text-slate-300">Review requests submitted while signed in.</p></div>
<div class="flex gap-3"><x-ui.button href="{{ route('quote.create') }}">New request</x-ui.button><x-ui.button href="{{ route('profile.edit') }}" variant="secondary">Profile</x-ui.button></div></div></section>
<section class="py-16 sm:py-20"><div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8"><h2 class="text-2xl font-bold text-ink-950">Your project requests</h2>
@if($quotes->isNotEmpty())<div class="mt-7 overflow-hidden rounded-feature border border-slate-200"><div class="overflow-x-auto"><table class="w-full min-w-[42rem] text-left">
<thead class="bg-slate-50 text-sm text-slate-600"><tr><th class="px-5 py-4">Submitted</th><th class="px-5 py-4">Services</th><th class="px-5 py-4">Status</th><th><span class="sr-only">View</span></th></tr></thead><tbody class="divide-y divide-slate-200">
@foreach($quotes as $quote)<tr><td class="px-5 py-4 text-sm text-slate-600">{{ $quote->created_at->format('M j, Y') }}</td><td class="px-5 py-4 font-semibold">{{ implode(', ', $quote->services ?? []) }}</td><td class="px-5 py-4"><x-ui.badge variant="neutral">{{ str($quote->status)->headline() }}</x-ui.badge></td><td class="px-5 py-4 text-right"><a class="font-semibold text-brand-700" href="{{ route('dashboard.quotes.show',$quote) }}">View</a></td></tr>@endforeach
</tbody></table></div></div>@if($quotes->hasPages())<div class="mt-8">{{ $quotes->links() }}</div>@endif
@else<div class="mt-7"><x-ui.alert title="No project requests yet.">Requests submitted while signed in will appear here.</x-ui.alert></div>@endif
</div></section></x-layouts.app>
