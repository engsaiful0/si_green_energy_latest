<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::withCount('products')->latest()->paginate(15);
        return view('admin.product-categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = ProductCategory::whereNull('parent_id')->get();
        return view('admin.product-categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:product_categories', 'regex:/^[a-z0-9-]+$/'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:product_categories,id'],
            'image' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        ProductCategory::create($validated);

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product category created successfully.');
    }

    public function edit(ProductCategory $productCategory)
    {
        $categories = ProductCategory::whereNull('parent_id')
            ->where('id', '!=', $productCategory->id)->get();
        return view('admin.product-categories.edit', compact('productCategory', 'categories'));
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('product_categories')->ignore($productCategory->id), 'regex:/^[a-z0-9-]+$/'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:product_categories,id'],
            'image' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        $productCategory->update($validated);

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product category updated successfully.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        if ($productCategory->products()->count() > 0) {
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'Cannot delete category that has products.');
        }

        $productCategory->delete();

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product category deleted successfully.');
    }
}
