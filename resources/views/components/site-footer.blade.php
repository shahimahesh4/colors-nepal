<footer class="border-t border-slate-800 bg-ink-950 text-slate-300">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8 lg:py-18">
        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
            <div class="sm:col-span-2">
                <a href="{{ url('/') }}" class="inline-flex rounded-control bg-white px-3 py-2" aria-label="Colors Nepal home">
                    <x-brand />
                </a>
                <p class="mt-5 max-w-md text-sm leading-7 text-slate-400">
                    Practical digital services for organizations that want a clear, reliable, and maintainable online presence.
                </p>
                <div class="mt-6">
                    <x-ui.button href="{{ url('/request-quote') }}">Discuss a project</x-ui.button>
                </div>
            </div>

            <div>
                <h2 class="text-sm font-bold uppercase tracking-wider text-white">Company</h2>
                <ul class="mt-4 grid gap-3 text-sm">
                    <li><a class="hover:text-white" href="{{ url('/about') }}">About</a></li>
                    <li><a class="hover:text-white" href="{{ url('/portfolio') }}">Portfolio</a></li>
                    <li><a class="hover:text-white" href="{{ url('/blog') }}">Insights</a></li>
                    <li><a class="hover:text-white" href="{{ url('/contact') }}">Contact</a></li>
                </ul>
            </div>

            <div>
                <h2 class="text-sm font-bold uppercase tracking-wider text-white">Services</h2>
                <ul class="mt-4 grid gap-3 text-sm">
                    <li><a class="hover:text-white" href="{{ url('/services') }}">Website development</a></li>
                    <li><a class="hover:text-white" href="{{ url('/services') }}">Digital marketing</a></li>
                    <li><a class="hover:text-white" href="{{ url('/services') }}">SEO</a></li>
                    <li><a class="hover:text-white" href="{{ url('/hosting') }}">Hosting</a></li>
                    <li><a class="hover:text-white" href="{{ url('/domains') }}">Domains</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col gap-3 border-t border-slate-800 pt-6 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ now()->year }} Colors Nepal. All rights reserved.</p>
            <p>Built for speed, accessibility, and maintainability.</p>
        </div>
    </div>
</footer>
