<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImages;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Shared CRUD for products, services and solutions. Views live in admin/catalog.
 */
abstract class CatalogItemController extends Controller
{
    use HandlesImages;

    abstract protected function model(): string;

    abstract protected function categoryModel(): string;

    /**
     * [
     *   'route' => 'admin.services', 'title' => 'Services', 'singular' => 'Service',
     *   'folder' => 'services', 'frontend' => 'services.show',
     *   'categories_route' => 'admin.service-categories.index',
     *   'icon' => 'required'|'optional'|null, 'price' => 'price'|'price_from'|null,
     *   'features_column' => 'benefits', 'show_route' => bool (admin details page exists)
     * ]
     */
    abstract protected function config(): array;

    public function index(Request $request)
    {
        $items = $this->model()::with('category')
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%' . $request->search . '%'))
            ->when($request->filled('category'), fn ($query) => $query->where('category_id', $request->category))
            ->when(in_array($request->status, ['draft', 'published'], true), fn ($query) => $query->where('status', $request->status))
            ->orderBy('order')->latest()
            ->paginate(15)->withQueryString();

        return view('admin.catalog.index', [
            'items' => $items,
            'categories' => $this->categoryModel()::ordered()->get(),
            'config' => $this->config(),
        ]);
    }

    public function create()
    {
        return view('admin.catalog.create', $this->formData(null));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data = $this->resolveImages($request, $data, ['featured_image'], null, $this->config()['folder']);

        $this->model()::create($data);

        return redirect()->route($this->config()['route'] . '.index')
            ->with('success', $this->config()['singular'] . ' created successfully.');
    }

    public function edit(string $id)
    {
        return view('admin.catalog.edit', $this->formData($this->find($id)));
    }

    public function update(Request $request, string $id)
    {
        $item = $this->find($id);

        $data = $this->validatedData($request, $item);
        $data = $this->resolveImages($request, $data, ['featured_image'], $item, $this->config()['folder']);

        $item->update($data);

        return redirect()->route($this->config()['route'] . '.index')
            ->with('success', $this->config()['singular'] . ' updated successfully.');
    }

    public function destroy(string $id)
    {
        // Soft delete: the image is kept so the record can be restored.
        $this->find($id)->delete();

        return redirect()->route($this->config()['route'] . '.index')
            ->with('success', $this->config()['singular'] . ' deleted successfully.');
    }

    protected function find(string $id): Model
    {
        return $this->model()::findOrFail($id);
    }

    private function formData(?Model $item): array
    {
        return [
            'item' => $item,
            'categories' => $this->categoryModel()::ordered()->get(),
            'config' => $this->config(),
        ];
    }

    private function validatedData(Request $request, ?Model $item = null): array
    {
        $config = $this->config();
        $table = (new ($this->model()))->getTable();
        $categoryTable = (new ($this->categoryModel()))->getTable();

        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('name'))]);

        $rules = array_merge([
            'category_id' => ['nullable', Rule::exists($categoryTable, 'id')],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique($table)->ignore($item?->id)],
            'short_description' => ['required', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'features' => ['nullable', 'string', 'max:5000'],
            'order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:draft,published'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ], $this->imageRules('featured_image', true));

        if ($config['icon']) {
            $rules['icon'] = [$config['icon'] === 'required' ? 'required' : 'nullable', 'string', 'max:100'];
        }
        foreach (array_keys($config['list_fields'] ?? []) as $listField) {
            $rules[$listField] = ['nullable', 'string', 'max:5000'];
        }
        if ($config['specifications'] ?? false) {
            $rules['specifications'] = ['nullable', 'string', 'max:5000'];
        }
        if ($config['price']) {
            $rules[$config['price']] = ['nullable', 'numeric', 'min:0', 'max:99999999'];
        }

        $data = $request->validate($rules);

        // Features are entered one per line and stored as a JSON list.
        $features = array_values(array_filter(array_map('trim', preg_split('/\R/', $data['features'] ?? ''))));
        unset($data['features']);
        $data[$config['features_column']] = $features;

        // Extra one-per-line lists (e.g. solution applications).
        foreach (array_keys($config['list_fields'] ?? []) as $listField) {
            $data[$listField] = array_values(array_filter(array_map('trim', preg_split('/\R/', $data[$listField] ?? ''))));
        }

        // Specifications: "Label: value" per line.
        if ($config['specifications'] ?? false) {
            $data['specifications'] = collect(preg_split('/\R/', $data['specifications'] ?? ''))
                ->map(fn ($line) => array_map('trim', explode(':', $line, 2)))
                ->filter(fn ($pair) => $pair[0] !== '')
                ->map(fn ($pair) => ['label' => $pair[0], 'value' => $pair[1] ?? ''])
                ->values()->all();
        }

        $data['description'] = $data['description'] ?? '';
        $data['order'] = $data['order'] ?? 0;
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }
}
