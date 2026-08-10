<x-layouts.app title="Sign In" description="Sign in to your Colors Nepal customer account.">
<section class="brand-surface py-16 sm:py-24"><div class="mx-auto max-w-md px-4 sm:px-6"><div class="brand-panel rounded-feature border border-brand-100 bg-white p-6 shadow-card sm:p-8">
<p class="text-sm font-bold uppercase tracking-[0.16em] text-brand-700">Customer account</p><h1 class="mt-3 text-3xl font-bold text-ink-950">Welcome back.</h1><p class="mt-3 text-sm leading-6 text-slate-600">Sign in to review your submitted project requests.</p>
<form method="POST" action="{{ route('login') }}" class="mt-8 grid gap-5">@csrf
<x-ui.input label="Email" name="email" type="email" autocomplete="email" required autofocus />
<x-ui.input label="Password" name="password" type="password" autocomplete="current-password" required />
@if (in_array(true, $otpChannels, true))
<label class="grid gap-2 text-sm font-semibold text-ink-950">Send verification code by
<select name="otp_channel" required class="rounded-control border border-slate-300 bg-white px-4 py-3 font-normal text-slate-900 focus:border-brand-500 focus:ring-brand-500">
@if($otpChannels['email'])<option value="email" @selected(old('otp_channel') === 'email')>Email</option>@endif
@if($otpChannels['phone'])<option value="phone" @selected(old('otp_channel') === 'phone')>Phone (Sparrow SMS)</option>@endif
</select></label>
@endif
<label class="flex items-center gap-3 text-sm text-slate-700"><input type="checkbox" name="remember" value="1" class="size-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">Remember me</label>
<x-recaptcha />
<x-ui.button type="submit" class="w-full">Sign in</x-ui.button></form>
<p class="mt-6 text-center text-sm text-slate-600">New customer? <a wire:navigate href="{{ route('register') }}" class="font-semibold text-brand-700 hover:underline">Create an account</a></p>
</div></div></section></x-layouts.app>
