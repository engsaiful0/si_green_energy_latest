<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImages;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    use HandlesImages;

    private const IMAGES = ['featured_image'];

    public function index()
    {
        $services = Service::with('category')->orderBy('order')->latest()->paginate(15);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $categories = ServiceCategory::where('is_active', true)->get();
        return view('admin.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validatedData($request);
        $validated = $this->resolveImages($request, $validated, self::IMAGES, null, 'services');

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function show(Service $service)
    {
        $service->load('category', 'images');
        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $categories = ServiceCategory::where('is_active', true)->get();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $this->validatedData($request, $service);
        $validated = $this->resolveImages($request, $validated, self::IMAGES, $service, 'services');

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        // Soft delete: images are kept so the service can be restored.
        $service->images()->delete();
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    private function validatedData(Request $request, ?Service $service = null): array
    {
        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('name'))]);

        $validated = $request->validate(array_merge([
            'category_id' => ['nullable', 'exists:service_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('services')->ignore($service?->id), 'regex:/^[a-z0-9-]+$/'],
            'icon' => ['required', 'string', 'max:100'],
            'short_description' => ['required', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'features' => ['nullable', 'string'],
            'price_from' => ['nullable', 'numeric', 'min:0'],
            'order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:draft,published'],
            'is_featured' => ['boolean'],
        ], $this->imageRules('featured_image', true)));

        // Features are entered one per line and stored in the "benefits" JSON column.
        $validated['benefits'] = array_values(array_filter(array_map('trim', preg_split('/\R/', $validated['features'] ?? ''))));
        unset($validated['features']);

        $validated['description'] = $validated['description'] ?? '';
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_featured'] = $request->boolean('is_featured');

        return $validated;
    }
}
