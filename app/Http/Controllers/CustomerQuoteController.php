<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CustomerQuoteController extends Controller
{
    public function show(QuoteRequest $quote): View
    {
        Gate::authorize('view', $quote);

        return view('dashboard.quotes.show', ['quote' => $quote]);
    }
}
