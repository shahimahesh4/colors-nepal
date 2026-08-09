<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Models\QuoteRequest;
use App\Notifications\LeadSubmitted;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class QuoteRequestController extends Controller
{
    public function create(): View
    {
        return view('quote.create', [
            'services' => StoreQuoteRequest::SERVICES,
            'budgets' => [
                'under-50000' => 'Under NPR 50,000',
                '50000-100000' => 'NPR 50,000 - 100,000',
                '100000-250000' => 'NPR 100,000 - 250,000',
                '250000-plus' => 'NPR 250,000+',
                'not-sure' => 'Not sure yet',
            ],
            'timelines' => StoreQuoteRequest::TIMELINES,
        ]);
    }

    public function store(StoreQuoteRequest $request): RedirectResponse
    {
        $data = $request->validated();
        [$budgetMin, $budgetMax] = StoreQuoteRequest::BUDGETS[$data['budget']];

        $quote = QuoteRequest::query()->create([
            'user_id' => $request->user()?->getKey(),
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'company' => $data['company'] ?? null,
            'services' => $data['services'],
            'budget_min' => $budgetMin,
            'budget_max' => $budgetMax,
            'currency' => 'NPR',
            'timeline' => $data['timeline'],
            'message' => $data['message'],
            'status' => 'new',
        ]);

        Notification::route('mail', config('mail.to.address'))->notify(
            LeadSubmitted::forQuote($quote)
        );

        return to_route('quote.create')->with('success', 'Thank you. Your project request has been received.');
    }
}
