<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $settings->get('maintenance_title') ?: 'Under Construction' }} | {{ $settings->get('site_name') ?: config('app.name') }}</title>
    @if($settings->get('favicon'))<link rel="icon" href="{{ asset('storage/'.$settings->get('favicon')) }}">@endif
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-ink-950 text-white antialiased">
    <main class="relative isolate grid min-h-screen place-items-center overflow-hidden px-4 py-12 sm:px-6">
        <div class="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_15%_15%,rgba(230,57,128,.22),transparent_30rem),radial-gradient(circle_at_85%_80%,rgba(0,180,166,.2),transparent_32rem)]" aria-hidden="true"></div>
        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-creative-pink via-creative-orange to-accent-500" aria-hidden="true"></div>
        <div class="absolute left-[8%] top-[12%] size-36 rounded-full border border-white/10 sm:size-52" aria-hidden="true"></div>
        <div class="absolute bottom-[8%] right-[6%] size-48 rounded-full border-[2rem] border-white/5 sm:size-72" aria-hidden="true"></div>

        <section class="w-full max-w-3xl text-center">
            <div class="mx-auto inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-accent-400 backdrop-blur">
                <span class="size-2 animate-pulse rounded-full bg-creative-orange" aria-hidden="true"></span>
                Website update in progress
            </div>

            <h1 class="mt-7 text-balance text-4xl font-bold tracking-tight sm:text-6xl lg:text-7xl">
                {{ $settings->get('maintenance_title') ?: 'We are currently under construction' }}
            </h1>
            <p class="mx-auto mt-6 max-w-2xl text-pretty text-base leading-8 text-slate-300 sm:text-lg">
                {{ $settings->get('maintenance_message') ?: 'We are improving our website and will be back soon. Thank you for your patience.' }}
            </p>

            <div class="mx-auto mt-10 h-1.5 max-w-sm overflow-hidden rounded-full bg-white/10" aria-hidden="true">
                <div class="h-full w-2/3 rounded-full bg-gradient-to-r from-creative-pink via-creative-orange to-accent-500"></div>
            </div>

            @if($settings->get('maintenance_show_contact') === '1' && $settings->get('contact_email'))
                <p class="mt-9 text-sm text-slate-400">
                    Need to reach us? <a href="mailto:{{ $settings->get('contact_email') }}" class="font-semibold text-white underline decoration-accent-500 underline-offset-4 hover:text-accent-400">{{ $settings->get('contact_email') }}</a>
                </p>
            @endif
        </section>
    </main>
</body>
</html>
