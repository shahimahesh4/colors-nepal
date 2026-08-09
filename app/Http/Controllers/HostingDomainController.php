<?php

namespace App\Http\Controllers;

use App\Models\DomainTld;
use App\Models\HostingPlan;
use Illuminate\View\View;

class HostingDomainController extends Controller
{
    public function hosting(): View
    {
        return view('hosting.index', [
            'plans' => HostingPlan::query()
                ->where('status', 'published')
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->get(),
        ]);
    }

    public function domains(): View
    {
        return view('domains.index', [
            'domains' => DomainTld::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('extension')
                ->get(),
        ]);
    }
}
