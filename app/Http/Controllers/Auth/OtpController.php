<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OtpController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        return $request->session()->has('auth_otp') ? view('auth.verify-otp') : to_route('login');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['code' => ['required', 'digits:6']]);
        $pending = $request->session()->get('auth_otp');

        if (! $pending || now()->timestamp > $pending['expires_at'] || ! hash_equals($pending['hash'], hash('sha256', $request->string('code')->toString()))) {
            throw ValidationException::withMessages(['code' => 'The verification code is invalid or has expired.']);
        }

        $payload = $pending['payload'];
        if ($payload['type'] === 'register') {
            $user = User::query()->create($payload['user']);
            event(new Registered($user));
        } else {
            $user = User::query()->findOrFail($payload['user_id']);
        }

        Auth::login($user, (bool) ($payload['remember'] ?? false));
        $request->session()->forget('auth_otp');
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }
}
