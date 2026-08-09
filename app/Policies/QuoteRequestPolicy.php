<?php

namespace App\Policies;

use App\Models\QuoteRequest;
use App\Models\User;

class QuoteRequestPolicy
{
    public function view(User $user, QuoteRequest $quote): bool
    {
        return $quote->user_id === $user->getKey();
    }
}
