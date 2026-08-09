<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\TeamMember;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __invoke(): View
    {
        $settings = SiteSetting::query()
            ->whereIn('key', ['about_intro', 'mission', 'vision'])
            ->pluck('value', 'key');

        return view('about', [
            'aboutIntro' => $settings->get('about_intro', 'Colors Nepal brings strategy, design, technology, and digital growth support into one practical partnership. We focus on work that is clear, maintainable, and useful to the people it serves.'),
            'mission' => $settings->get('mission', 'Help organizations build a stronger online presence through thoughtful, reliable, and understandable digital work.'),
            'vision' => $settings->get('vision', 'Make professional digital capability more accessible to growing organizations in Nepal and beyond.'),
            'teamMembers' => TeamMember::query()
                ->where('status', 'published')
                ->orderBy('sort_order')
                ->get(),
        ]);
    }
}
