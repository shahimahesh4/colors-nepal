<?php

namespace App\Livewire;

use App\Models\Page;
use Illuminate\View\View;
use Livewire\Component;

class PageShow extends Component
{
    public Page $page;

    public function mount(Page $page): void
    {
        abort_unless($page->status === 'published', 404);

        $this->page = $page;
    }

    public function render(): View
    {
        return view('livewire.page-show')->layout('components.layouts.app', [
            'title' => $this->page->meta_title ?: $this->page->title,
            'description' => $this->page->meta_description ?: $this->page->excerpt,
            'keywords' => $this->page->meta_keywords,
            'canonical' => route('pages.show', $this->page),
            'image' => $this->page->og_image ? asset('storage/'.$this->page->og_image) : ($this->page->image ? asset('storage/'.$this->page->image) : null),
        ]);
    }
}
