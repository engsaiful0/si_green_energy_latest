<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        $products = Product::where('status', 'published')
            ->with('category')
            ->latest()
            ->paginate(12);

        $categories = ProductCategory::where('is_active', true)
            ->withCount('products')
            ->get();

        return view('frontend.products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'images'])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'published')
            ->take(4)
            ->get();

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Display products by category.
     */
    public function category($slug)
    {
        $category = ProductCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->where('status', 'published')
            ->with('category')
            ->latest()
            ->paginate(12);

        $categories = ProductCategory::where('is_active', true)
            ->withCount('products')
            ->get();

        return view('frontend.products.index', compact('products', 'categories', 'category'));
    }
}
