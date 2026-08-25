<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShowConstructionPage
{
    public function handle(Request $request, Closure $next): Response
    {
        if (
            $request->is('stnapanel')
            || $request->is('stnapanel/*')
            || $request->is('livewire/*')
        ) {
            return $next($request);
        }

        $settings = SiteSetting::values();

        if ($settings->get('maintenance_enabled') !== '1') {
            return $next($request);
        }

        return response()->view('maintenance', [
            'settings' => $settings,
        ], Response::HTTP_SERVICE_UNAVAILABLE, [
            'Retry-After' => '3600',
        ]);
    }
}
