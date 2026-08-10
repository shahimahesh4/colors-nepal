<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthOtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(AuthOtpService $otp): View
    {
        return view('auth.login', ['otpChannels' => $otp->channels()]);
    }

    public function store(Request $request, AuthOtpService $otp): RedirectResponse
    {
        $credentials = $request->validate(['email' => ['required', 'email:rfc'], 'password' => ['required', 'string']]);
        if (! Auth::validate($credentials)) {
            throw ValidationException::withMessages(['email' => 'The provided credentials do not match our records.']);
        }

        $user = User::query()->where('email', $credentials['email'])->firstOrFail();
        if ($otp->enabled()) {
            $channel = $request->validate(['otp_channel' => ['required', 'in:email,phone']])['otp_channel'];
            $otp->issue($request, $channel, $user->email, $user->phone, ['type' => 'login', 'user_id' => $user->id, 'remember' => $request->boolean('remember')]);

            return to_route('otp.create');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('home');
    }
}