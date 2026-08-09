<?php

namespace App\Http\Controllers;

use App\Models\PortfolioCategory;
use App\Models\PortfolioProject;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(Request $request): View
    {
        $category = null;

        if ($request->filled('category')) {
            $category = PortfolioCategory::query()
                ->where('slug', $request->string('category')->toString())
                ->whereHas('projects', fn ($query) => $query->where('status', 'published'))
                ->firstOrFail();
        }

        return view('portfolio.index', [
            'activeCategory' => $category,
            'categories' => PortfolioCategory::query()
                ->whereHas('projects', fn ($query) => $query->where('status', 'published'))
                ->withCount(['projects' => fn ($query) => $query->where('status', 'published')])
                ->orderBy('sort_order')
                ->get(),
            'projects' => PortfolioProject::query()
                ->with('category')
                ->where('status', 'published')
                ->when($category, fn ($query) => $query->whereBelongsTo($category, 'category'))
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->paginate(9)
                ->withQueryString(),
        ]);
    }

    public function show(PortfolioProject $project): View
    {
        abort_unless($project->status === 'published', 404);

        $project->load('category');

        return view('portfolio.show', [
            'project' => $project,
            'relatedProjects' => PortfolioProject::query()
                ->with('category')
                ->where('status', 'published')
                ->whereKeyNot($project->getKey())
                ->when($project->portfolio_category_id, fn ($query) => $query->where('portfolio_category_id', $project->portfolio_category_id))
                ->orderByDesc('is_featured')
                ->limit(3)
                ->get(),
        ]);
    }
}
