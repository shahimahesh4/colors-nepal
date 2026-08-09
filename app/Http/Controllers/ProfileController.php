<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validate(['name' => ['required', 'string', 'max:100'], 'email' => ['required', 'email:rfc', 'max:255', Rule::unique('users')->ignore($user)], 'current_password' => ['required_with:password', 'nullable', 'current_password'], 'password' => ['nullable', 'confirmed', Password::defaults()]]);
        $user->fill(['name' => $data['name'], 'email' => $data['email']]);
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }
        $user->save();

        return to_route('profile.edit')->with('success', 'Profile updated.');
    }
}
