<?php

namespace App\View\Components;

use App\Models\Banner;
use App\Services\BannerManager;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageBanner extends Component
{
    public ?Banner $banner;

    public function __construct(
        public string $title,
        public ?string $description = null,
        public ?string $eyebrow = null,
        public ?string $breadcrumb = null,
        public ?string $parentLabel = null,
        public ?string $parentUrl = null,
    ) {
        $this->banner = app(BannerManager::class)->current();
    }

    public function render(): View|Closure|string
    {
        return view('components.page-banner');
    }
}
