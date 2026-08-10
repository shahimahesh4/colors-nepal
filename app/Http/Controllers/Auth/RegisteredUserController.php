<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthOtpService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(AuthOtpService $otp): View
    {
        return view('auth.register', ['otpChannels' => $otp->channels()]);
    }

    public function store(Request $request, AuthOtpService $otp): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'regex:/^(?:\+977)?9[78]\d{8}$/', Rule::unique('users', 'phone')],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if ($otp->enabled()) {
            $channel = $request->validate(['otp_channel' => ['required', 'in:email,phone']])['otp_channel'];
            $data['password'] = Hash::make($data['password']);
            $otp->issue($request, $channel, $data['email'], $data['phone'] ?? null, ['type' => 'register', 'user' => $data]);

            return to_route('otp.create');
        }

        $user = User::query()->create($data);
        event(new Registered($user));
        Auth::login($user);
        $request->session()->regenerate();

        return to_route('dashboard');
    }
}