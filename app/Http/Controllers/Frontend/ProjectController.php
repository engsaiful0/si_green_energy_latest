<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Support\PageSections;
use App\Support\Seo;
use Illuminate\Http\Request;

/**
 * Projects: listing (project-three.html, filterable by category) and details (project-details.html).
 */
class ProjectController extends Controller
{
    public function index(Request $request, int $columns = 3)
    {
        $settings = PageSections::settings('projects');
        $listing = $this->listing();

        $categories = ProjectCategory::active()->ordered()
            ->whereHas('projects', fn ($query) => $query->where('status', 'published'))
            ->get();
        $category = $request->filled('category')
            ? $categories->firstWhere('slug', $request->query('category'))
            : null;

        $projects = Project::published()->with('category')
            ->when($category, fn ($query) => $query->where('category_id', $category->id))
            ->orderByDesc('is_featured')->orderByDesc('project_date')->latest()
            ->paginate(max(1, (int) $listing['per_page']))
            ->withQueryString();

        $seo = $category
            ? Seo::record($category->name . ' Projects', null, $category->description, $settings['meta_description'])
            : Seo::page('projects');

        return view('frontend.projects.index', compact('projects', 'columns', 'settings', 'listing', 'categories', 'category', 'seo'));
    }

    public function show(string $slug)
    {
        $project = Project::published()->with(['category', 'images'])->where('slug', $slug)->firstOrFail();
        $project->increment('views');

        $settings = PageSections::settings('projects');
        $listing = $this->listing();

        $related = Project::published()->where('id', '!=', $project->id)
            ->when($project->category_id, fn ($query) => $query->where('category_id', $project->category_id))
            ->latest('project_date')->take(3)->get();

        $seo = Seo::record($project->name, $project->meta_title, $project->meta_description, $project->short_description);
        $seo['image'] = $project->imageUrl();

        return view('frontend.projects.show', compact('project', 'related', 'settings', 'listing', 'seo'));
    }

    private function listing(): array
    {
        return PageSections::sections('projects')->firstWhere('section_key', 'listing')->content;
    }
}
