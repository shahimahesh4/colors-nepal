<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $category = null;

        if ($request->filled('category')) {
            $category = BlogCategory::query()
                ->where('slug', $request->string('category')->toString())
                ->whereHas('posts', fn ($query) => $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now()))
                ->firstOrFail();
        }

        $published = fn ($query) => $query
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        return view('blog.index', [
            'activeCategory' => $category,
            'categories' => BlogCategory::query()
                ->whereHas('posts', $published)
                ->withCount(['posts' => $published])
                ->orderBy('name')
                ->get(),
            'posts' => BlogPost::query()
                ->with(['author', 'category'])
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->when($category, fn ($query) => $query->whereBelongsTo($category, 'category'))
                ->latest('published_at')
                ->paginate(9)
                ->withQueryString(),
        ]);
    }

    public function show(BlogPost $post): View
    {
        abort_unless($post->status === 'published' && $post->published_at?->isPast(), 404);

        $post->load(['author', 'category']);

        return view('blog.show', [
            'post' => $post,
            'relatedPosts' => BlogPost::query()
                ->with(['author', 'category'])
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->whereKeyNot($post->getKey())
                ->when($post->blog_category_id, fn ($query) => $query->where('blog_category_id', $post->blog_category_id))
                ->latest('published_at')
                ->limit(3)
                ->get(),
        ]);
    }
}
