<x-layouts.app title="Profile" description="Update your Colors Nepal customer account.">
<section class="bg-slate-50 py-16 sm:py-20"><div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8"><div class="rounded-feature border border-slate-200 bg-white p-6 shadow-card sm:p-8">
<h1 class="text-3xl font-bold text-ink-950">Account profile</h1><p class="mt-3 text-sm leading-6 text-slate-600">Update your details or set a new password.</p>
@if(session('success'))<div class="mt-6"><x-ui.alert title="Saved" variant="success">{{ session('success') }}</x-ui.alert></div>@endif
<form method="POST" action="{{ route('profile.update') }}" class="mt-8 grid gap-5">@csrf @method('PUT')
<x-ui.input label="Name" name="name" :value="$user->name" autocomplete="name" required />
<x-ui.input label="Email" name="email" type="email" :value="$user->email" autocomplete="email" required />
<div class="border-t border-slate-200 pt-6"><h2 class="font-bold text-ink-950">Change password</h2><p class="mt-1 text-sm text-slate-500">Leave blank to keep your current password.</p></div>
<x-ui.input label="Current password" name="current_password" type="password" autocomplete="current-password" />
<x-ui.input label="New password" name="password" type="password" autocomplete="new-password" />
<x-ui.input label="Confirm new password" name="password_confirmation" type="password" autocomplete="new-password" />
<div class="flex flex-wrap justify-between gap-3"><x-ui.button href="{{ route('dashboard') }}" variant="secondary">Back</x-ui.button><x-ui.button type="submit">Save profile</x-ui.button></div>
</form></div></div></section></x-layouts.app>
