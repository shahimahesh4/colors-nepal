<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        $quotesQuery = $user->quoteRequests()->latest();
        $statusCounts = (clone $quotesQuery)
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        return view('dashboard.index', [
            'quotes' => $quotesQuery->paginate(10),
            'stats' => [
                'total' => $statusCounts->sum(),
                'new' => $statusCounts->get('new', 0),
                'active' => $statusCounts->only(['reviewing', 'quoted'])->sum(),
                'completed' => $statusCounts->get('won', 0),
            ],
        ]);
    }
}