<x-layouts.app title="Create Account" description="Create a Colors Nepal customer account to track project requests.">
<section class="bg-slate-50 py-16 sm:py-24"><div class="mx-auto max-w-md px-4 sm:px-6"><div class="rounded-feature border border-slate-200 bg-white p-6 shadow-card sm:p-8">
<p class="text-sm font-bold uppercase tracking-[0.16em] text-brand-700">Customer account</p><h1 class="mt-3 text-3xl font-bold text-ink-950">Create your account.</h1><p class="mt-3 text-sm leading-6 text-slate-600">Use one secure account to follow your project requests.</p>
<form method="POST" action="{{ route('register') }}" class="mt-8 grid gap-5">@csrf
<x-ui.input label="Name" name="name" autocomplete="name" required autofocus />
<x-ui.input label="Email" name="email" type="email" autocomplete="email" required />
<x-ui.input label="Password" name="password" type="password" autocomplete="new-password" required help="Use at least eight characters." />
<x-ui.input label="Confirm password" name="password_confirmation" type="password" autocomplete="new-password" required />
<x-ui.button type="submit" class="w-full">Create account</x-ui.button></form>
<p class="mt-6 text-center text-sm text-slate-600">Already registered? <a href="{{ route('login') }}" class="font-semibold text-brand-700 hover:underline">Sign in</a></p>
</div></div></section></x-layouts.app>
