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
                ->when($request->filled('search'), function ($query) use ($request): void {
                    $search = $request->string('search')->trim()->toString();
                    $query->where(function ($query) use ($search): void {
                        $query->where('title', 'like', '%'.$search.'%')
                            ->orWhere('excerpt', 'like', '%'.$search.'%');
                    });
                })
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
            'recentPosts' => BlogPost::query()
                ->with(['author', 'category'])
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->whereKeyNot($post->getKey())
                ->latest('published_at')
                ->limit(6)
                ->get(),
        ]);
    }
}
