<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImages;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Shared CRUD for the category modules (product, solution, service, project).
 * Subclasses describe the model and labels; the views live in admin/categories.
 */
abstract class CategoryController extends Controller
{
    use HandlesImages;

    /** Category model class (uses IsCategory and defines items()). */
    abstract protected function model(): string;

    /**
     * [
     *   'route'    => 'admin.service-categories',   // resource route name prefix
     *   'title'    => 'Service Categories',
     *   'singular' => 'Service Category',
     *   'items'    => 'services',                   // label of the assigned records
     *   'items_route' => 'admin.services.index',
     *   'frontend' => 'services.category',          // frontend category route (optional)
     *   'icon'     => true,                         // has an icon column
     * ]
     */
    abstract protected function config(): array;

    public function index(Request $request)
    {
        $categories = $this->model()::query()
            ->withCount('items')
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%' . $request->search . '%'))
            ->ordered()
            ->paginate(20)->withQueryString();

        return view('admin.categories.index', ['categories' => $categories, 'config' => $this->config()]);
    }

    public function create()
    {
        return view('admin.categories.create', ['category' => null, 'config' => $this->config()]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data = $this->resolveImages($request, $data, ['image'], null, 'categories');
        $data['order'] = $data['order'] ?? ((int) $this->model()::max('order') + 1);

        $this->model()::create($data);

        return redirect()->route($this->config()['route'] . '.index')
            ->with('success', $this->config()['singular'] . ' created successfully.');
    }

    public function edit(string $id)
    {
        return view('admin.categories.edit', ['category' => $this->find($id), 'config' => $this->config()]);
    }

    public function update(Request $request, string $id)
    {
        $category = $this->find($id);

        $data = $this->validatedData($request, $category);
        $data = $this->resolveImages($request, $data, ['image'], $category, 'categories');
        $data['order'] = $data['order'] ?? $category->order;

        $category->update($data);

        return redirect()->route($this->config()['route'] . '.index')
            ->with('success', $this->config()['singular'] . ' updated successfully.');
    }

    public function destroy(string $id)
    {
        $category = $this->find($id);
        $config = $this->config();

        // Soft-deleted records still reference the category, so count them too.
        $relation = $category->items();
        $assigned = method_exists($relation->getRelated(), 'trashed')
            ? $relation->withTrashed()->count()
            : $relation->count();

        if ($assigned > 0) {
            return redirect()->route($config['route'] . '.index')
                ->with('error', "\"{$category->name}\" is assigned to {$assigned} {$config['items']}. Reassign them to another category before deleting it.");
        }

        $this->deleteImages($category, ['image']);
        $category->delete();

        return redirect()->route($config['route'] . '.index')
            ->with('success', $config['singular'] . ' deleted successfully.');
    }

    private function find(string $id): Model
    {
        return $this->model()::findOrFail($id);
    }

    private function validatedData(Request $request, ?Model $category = null): array
    {
        $table = (new ($this->model()))->getTable();
        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('name'))]);

        $rules = array_merge([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique($table)->ignore($category?->id)],
            'description' => ['nullable', 'string', 'max:2000'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], $this->imageRules('image'));

        if ($this->config()['icon'] ?? false) {
            $rules['icon'] = ['nullable', 'string', 'max:100'];
        }

        $data = $request->validate($rules);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
