<x-layouts.app title="Request a Quote" description="Request a practical website, marketing, SEO, hosting, maintenance, or digital-service quote from Colors Nepal.">
    <section class="bg-ink-950 py-16 text-white sm:py-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-slate-400" aria-label="Breadcrumb"><a href="{{ route('home') }}" class="hover:text-white">Home</a><span class="mx-2" aria-hidden="true">/</span><span aria-current="page">Request a quote</span></nav>
            <div class="mt-8 max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-accent-400">Plan your project</p>
                <h1 class="mt-4 text-balance text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">Give us the essentials. We will help shape the scope.</h1>
                <p class="mt-6 text-lg leading-8 text-slate-300">Choose the services you need and share your goals. Estimates are reviewed by a person, not generated automatically.</p>
            </div>
        </div>
    </section>

    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))<div class="mb-6"><x-ui.alert title="Request received" variant="success">{{ session('success') }}</x-ui.alert></div>@endif
            <form method="POST" action="{{ route('quote.store') }}" class="grid gap-6 rounded-feature border border-slate-200 bg-white p-6 shadow-card sm:grid-cols-2 sm:p-8">
                @csrf
                <div class="hidden" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
                <x-ui.input label="Name" name="name" autocomplete="name" required />
                <x-ui.input label="Email" name="email" type="email" autocomplete="email" required />
                <x-ui.input label="Phone" name="phone" type="tel" autocomplete="tel" />
                <x-ui.input label="Company" name="company" autocomplete="organization" />

                <fieldset class="sm:col-span-2">
                    <legend class="text-sm font-semibold text-slate-800">Services needed <span class="text-red-600" aria-hidden="true">*</span></legend>
                    <div class="mt-3 grid gap-3 sm:grid-cols-2">
                        @foreach ($services as $service)
                            <label class="flex min-h-12 items-center gap-3 rounded-control border border-slate-300 px-4 py-3 text-sm font-medium text-slate-700 hover:border-brand-400 hover:bg-brand-50">
                                <input type="checkbox" name="services[]" value="{{ $service }}" @checked(in_array($service, old('services', []), true)) class="size-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                                <span>{{ $service }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('services')<p class="mt-2 text-sm text-red-700">{{ $message }}</p>@enderror
                    @error('services.*')<p class="mt-2 text-sm text-red-700">{{ $message }}</p>@enderror
                </fieldset>

                <x-ui.select label="Estimated budget" name="budget" required>
                    <option value="">Choose a range</option>
                    @foreach ($budgets as $value => $label)<option value="{{ $value }}" @selected(old('budget') === $value)>{{ $label }}</option>@endforeach
                </x-ui.select>
                <x-ui.select label="Preferred timeline" name="timeline" required>
                    <option value="">Choose a timeline</option>
                    @foreach ($timelines as $timeline)<option value="{{ $timeline }}" @selected(old('timeline') === $timeline)>{{ $timeline }}</option>@endforeach
                </x-ui.select>

                <div class="sm:col-span-2"><x-ui.textarea label="Project goals and requirements" name="message" :rows="8" required help="Describe the outcome you want, important features, and any current website or platform." /></div>

                <div class="sm:col-span-2">
                    <label class="flex items-start gap-3 text-sm leading-6 text-slate-700">
                        <input type="checkbox" name="consent" value="1" @checked(old('consent')) class="mt-1 size-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                        <span>I agree that Colors Nepal may use these details to review and respond to this request.</span>
                    </label>
                    @error('consent')<p class="mt-2 text-sm text-red-700">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs leading-5 text-slate-500">Your request will appear in the secure lead workflow for review.</p>
                    <x-ui.button type="submit" size="lg">Submit project request</x-ui.button>
                </div>
            </form>
        </div>
    </section>
</x-layouts.app>
