<x-layouts.app title="Verify Account" description="Verify your account with a one-time code.">
<section class="brand-surface py-16 sm:py-24"><div class="mx-auto max-w-md px-4 sm:px-6"><div class="brand-panel rounded-feature border border-brand-100 bg-white p-6 shadow-card sm:p-8">
<p class="text-sm font-bold uppercase tracking-[0.16em] text-brand-700">Security check</p><h1 class="mt-3 text-3xl font-bold text-ink-950">Enter verification code.</h1><p class="mt-3 text-sm leading-6 text-slate-600">We sent a six-digit code to your selected contact method. It expires in 10 minutes.</p>
<form method="POST" action="{{ route('otp.verify') }}" class="mt-8 grid gap-5">@csrf<x-ui.input label="Verification code" name="code" inputmode="numeric" autocomplete="one-time-code" maxlength="6" required autofocus /><x-ui.button type="submit" class="w-full">Verify and continue</x-ui.button></form>
</div></div></section></x-layouts.app>
