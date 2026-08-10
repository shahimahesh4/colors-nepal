<?php

namespace App\Http\Middleware;

use App\Services\Recaptcha;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyRecaptcha
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! app(Recaptcha::class)->verify($request->input('g-recaptcha-response'), $request->ip())) {
            return back()->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['g-recaptcha-response' => 'Please confirm that you are not a robot.']);
        }

        return $next($request);
    }
}
