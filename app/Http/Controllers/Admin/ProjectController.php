<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImages;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    use HandlesImages;

    private const IMAGES = ['featured_image'];

    public function index(Request $request)
    {
        $projects = Project::with('category')
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%' . $request->search . '%'))
            ->orderByDesc('is_featured')->latest()
            ->paginate(15)->withQueryString();

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create', ['categories' => $this->categories()]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data = $this->resolveImages($request, $data, self::IMAGES, null, 'projects');

        Project::create($data);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', ['project' => $project, 'categories' => $this->categories()]);
    }

    public function update(Request $request, Project $project)
    {
        $data = $this->validatedData($request, $project);
        $data = $this->resolveImages($request, $data, self::IMAGES, $project, 'projects');

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        // Soft delete: the image is kept so the record can be restored.
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }

    private function categories()
    {
        return ProjectCategory::orderBy('order')->orderBy('name')->get();
    }

    private function validatedData(Request $request, ?Project $project = null): array
    {
        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('name'))]);

        $data = $request->validate(array_merge([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('projects')->ignore($project?->id)],
            'category_id' => ['nullable', 'exists:project_categories,id'],
            'new_category' => ['nullable', 'string', 'max:255'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'project_date' => ['nullable', 'date'],
            'short_description' => ['required', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'video_url' => ['nullable', 'url', 'max:255'],
            'status' => ['required', 'in:draft,published'],
        ], $this->imageRules('featured_image', true)));

        // Create the category on the fly when a new name is typed.
        if (!empty($data['new_category'])) {
            $data['category_id'] = ProjectCategory::firstOrCreate(
                ['slug' => Str::slug($data['new_category'])],
                ['name' => $data['new_category'], 'is_active' => true]
            )->id;
        }
        unset($data['new_category']);

        $data['description'] = $data['description'] ?? '';
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }
}
