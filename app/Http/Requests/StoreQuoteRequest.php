<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuoteRequest extends FormRequest
{
    public const SERVICES = [
        'Website Design & Development',
        'Digital Marketing',
        'SEO',
        'Social Media Marketing',
        'Web Hosting',
        'Domain Registration',
        'Website Maintenance',
        'Branding & Online Promotion',
    ];

    public const BUDGETS = [
        'under-50000' => [null, 5000000],
        '50000-100000' => [5000000, 10000000],
        '100000-250000' => [10000000, 25000000],
        '250000-plus' => [25000000, null],
        'not-sure' => [null, null],
    ];

    public const TIMELINES = ['As soon as possible', 'Within 1 month', '1-3 months', '3-6 months', 'Flexible'];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'company' => ['nullable', 'string', 'max:150'],
            'services' => ['required', 'array', 'min:1', 'max:5'],
            'services.*' => ['string', Rule::in(self::SERVICES)],
            'budget' => ['required', Rule::in(array_keys(self::BUDGETS))],
            'timeline' => ['required', Rule::in(self::TIMELINES)],
            'message' => ['required', 'string', 'min:20', 'max:5000'],
            'consent' => ['accepted'],
            'website' => ['nullable', 'max:0'],
        ];
    }
}
