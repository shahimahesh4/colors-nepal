<x-layouts.app title="Dashboard" description="Review your Colors Nepal project requests and account details.">
    <section class="brand-hero relative isolate overflow-hidden bg-ink-950 pb-24 pt-14 text-white sm:pb-28 sm:pt-16">
        <div class="absolute inset-0 -z-10" aria-hidden="true">
            <div class="absolute -left-20 top-0 size-72 rounded-full bg-creative-pink/20 blur-3xl"></div>
            <div class="absolute right-0 top-10 size-80 rounded-full bg-accent-500/15 blur-3xl"></div>
        </div>
        <div class="mx-auto flex max-w-6xl flex-col gap-7 px-4 sm:px-6 lg:flex-row lg:items-end lg:justify-between lg:px-8">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-accent-400">Customer dashboard</p>
                <h1 class="mt-3 text-balance text-4xl font-bold tracking-tight sm:text-5xl">Welcome back, {{ auth()->user()->name }}.</h1>
                <p class="mt-4 max-w-2xl text-slate-300">Track your project requests, review progress, and keep your account details up to date.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <x-ui.button href="{{ route('quote.create') }}">New project request</x-ui.button>
                <x-ui.button href="{{ route('profile.edit') }}" variant="secondary">Edit profile</x-ui.button>
            </div>
        </div>
    </section>

    <section class="relative -mt-12 pb-16 sm:-mt-14 sm:pb-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <h2 class="sr-only">Request summary</h2>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['label' => 'All requests', 'value' => $stats['total'], 'color' => 'text-creative-pink', 'surface' => 'bg-creative-pink/10'],
                    ['label' => 'New', 'value' => $stats['new'], 'color' => 'text-creative-orange', 'surface' => 'bg-creative-orange/10'],
                    ['label' => 'In progress', 'value' => $stats['active'], 'color' => 'text-accent-500', 'surface' => 'bg-accent-500/10'],
                    ['label' => 'Completed', 'value' => $stats['completed'], 'color' => 'text-brand-600', 'surface' => 'bg-brand-600/10'],
                ] as $stat)
                    <article class="brand-panel rounded-card border border-brand-100 bg-white p-5 shadow-card transition hover:-translate-y-1 hover:shadow-card-hover">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-500">{{ $stat['label'] }}</p>
                                <p class="mt-2 text-3xl font-bold text-ink-950">{{ $stat['value'] }}</p>
                            </div>
                            <span class="grid size-11 place-items-center rounded-xl {{ $stat['surface'] }} {{ $stat['color'] }}" aria-hidden="true">
                                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                            </span>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8 grid gap-8 lg:grid-cols-[minmax(0,1fr)_20rem] lg:items-start">
                <section class="overflow-hidden rounded-feature border border-slate-200 bg-white shadow-card" aria-labelledby="requests-heading">
                    <div class="flex flex-col gap-4 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <div>
                            <h2 id="requests-heading" class="text-xl font-bold text-ink-950">Your project requests</h2>
                            <p class="mt-1 text-sm text-slate-500">Updates from your submitted enquiries appear here.</p>
                        </div>
                        <x-ui.button href="{{ route('quote.create') }}" variant="secondary" size="sm">Submit request</x-ui.button>
                    </div>

                    @if($quotes->isNotEmpty())
                        <div class="divide-y divide-slate-200 md:hidden">
                            @foreach($quotes as $quote)
                                @php
                                    $badgeVariant = match ($quote->status) {
                                        'won' => 'success',
                                        'reviewing', 'quoted' => 'warning',
                                        'lost' => 'danger',
                                        default => 'neutral',
                                    };
                                @endphp
                                <article class="p-5">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $quote->created_at->format('M j, Y') }}</p>
                                            <h3 class="mt-2 font-bold text-ink-950">{{ implode(', ', $quote->services ?? []) }}</h3>
                                        </div>
                                        <x-ui.badge :variant="$badgeVariant">{{ str($quote->status)->headline() }}</x-ui.badge>
                                    </div>
                                    <a wire:navigate class="mt-4 inline-flex text-sm font-bold text-brand-700 hover:text-brand-800" href="{{ route('dashboard.quotes.show', $quote) }}">View request <span class="ml-1" aria-hidden="true">&rarr;</span></a>
                                </article>
                            @endforeach
                        </div>

                        <div class="hidden overflow-x-auto md:block">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                                    <tr><th class="px-6 py-4">Submitted</th><th class="px-6 py-4">Services</th><th class="px-6 py-4">Status</th><th class="px-6 py-4"><span class="sr-only">Action</span></th></tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @foreach($quotes as $quote)
                                        @php
                                            $badgeVariant = match ($quote->status) {
                                                'won' => 'success',
                                                'reviewing', 'quoted' => 'warning',
                                                'lost' => 'danger',
                                                default => 'neutral',
                                            };
                                        @endphp
                                        <tr class="transition hover:bg-brand-50/50">
                                            <td class="whitespace-nowrap px-6 py-5 text-sm text-slate-600">{{ $quote->created_at->format('M j, Y') }}</td>
                                            <td class="px-6 py-5 font-semibold text-ink-950">{{ implode(', ', $quote->services ?? []) }}</td>
                                            <td class="px-6 py-5"><x-ui.badge :variant="$badgeVariant">{{ str($quote->status)->headline() }}</x-ui.badge></td>
                                            <td class="px-6 py-5 text-right"><a wire:navigate class="font-semibold text-brand-700 hover:text-brand-800" href="{{ route('dashboard.quotes.show', $quote) }}">View</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($quotes->hasPages())<div class="border-t border-slate-200 px-5 py-5 sm:px-6">{{ $quotes->links() }}</div>@endif
                    @else
                        <div class="px-5 py-12 text-center sm:px-8">
                            <span class="mx-auto grid size-14 place-items-center rounded-2xl bg-brand-50 text-brand-600" aria-hidden="true">
                                <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z"/></svg>
                            </span>
                            <h3 class="mt-5 text-lg font-bold text-ink-950">No project requests yet</h3>
                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-600">Tell us what you are planning and your request will appear here for easy tracking.</p>
                            <x-ui.button href="{{ route('quote.create') }}" class="mt-6">Start a request</x-ui.button>
                        </div>
                    @endif
                </section>

                <aside class="grid gap-6">
                    <section class="rounded-feature border border-brand-100 bg-white p-6 shadow-card" aria-labelledby="account-heading">
                        <div class="flex items-center gap-4">
                            <span class="grid size-12 shrink-0 place-items-center rounded-2xl bg-ink-950 font-bold text-white" aria-hidden="true">{{ str(auth()->user()->name)->substr(0, 2)->upper() }}</span>
                            <div class="min-w-0"><h2 id="account-heading" class="font-bold text-ink-950">Account details</h2><p class="truncate text-sm text-slate-500">Customer account</p></div>
                        </div>
                        <dl class="mt-6 grid gap-4 border-t border-slate-200 pt-5 text-sm">
                            <div><dt class="text-slate-500">Name</dt><dd class="mt-1 font-semibold text-ink-950">{{ auth()->user()->name }}</dd></div>
                            <div><dt class="text-slate-500">Email</dt><dd class="mt-1 break-all font-semibold text-ink-950">{{ auth()->user()->email }}</dd></div>
                            @if(auth()->user()->phone)<div><dt class="text-slate-500">Phone</dt><dd class="mt-1 font-semibold text-ink-950">{{ auth()->user()->phone }}</dd></div>@endif
                        </dl>
                        <x-ui.button href="{{ route('profile.edit') }}" variant="secondary" class="mt-6 w-full">Manage profile</x-ui.button>
                    </section>

                    <section class="rounded-feature bg-ink-950 p-6 text-white shadow-card" aria-labelledby="help-heading">
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-accent-400">Need help?</p>
                        <h2 id="help-heading" class="mt-3 text-xl font-bold">Let’s discuss your next step.</h2>
                        <p class="mt-3 text-sm leading-6 text-slate-300">Contact the team if you need an update or want to explore another service.</p>
                        <div class="mt-5 grid gap-2">
                            <a wire:navigate href="{{ route('contact.create') }}" class="rounded-control bg-white/10 px-4 py-3 text-sm font-semibold transition hover:bg-white/15">Contact support</a>
                            <a wire:navigate href="{{ route('services.index') }}" class="rounded-control px-4 py-3 text-sm font-semibold text-accent-400 transition hover:bg-white/10">Browse services</a>
                        </div>
                    </section>

                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <x-ui.button type="submit" variant="ghost" class="w-full border border-slate-200 bg-white">Sign out</x-ui.button>
                    </form>
                </aside>
            </div>
        </div>
    </section>
</x-layouts.app>