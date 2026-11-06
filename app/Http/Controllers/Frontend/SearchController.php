<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Product;
use App\Models\Service;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $results = [];

        if ($query) {
            // Search Pages
            $pages = Page::where('status', 'published')
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('content', 'like', "%{$query}%");
                })
                ->take(10)
                ->get();

            // Search Products
            $products = Product::where('status', 'published')
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })
                ->with('category')
                ->take(10)
                ->get();

            // Search Services
            $services = Service::where('status', 'published')
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })
                ->with('category')
                ->take(10)
                ->get();

            // Search Blog Posts
            $posts = BlogPost::where('status', 'published')
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('excerpt', 'like', "%{$query}%")
                      ->orWhere('content', 'like', "%{$query}%");
                })
                ->with(['category', 'author'])
                ->take(10)
                ->get();

            $results = [
                'pages' => $pages,
                'products' => $products,
                'services' => $services,
                'posts' => $posts,
            ];
        }

        return view('frontend.search', compact('query', 'results'));
    }
}
