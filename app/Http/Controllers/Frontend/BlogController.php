<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts.
     */
    public function index()
    {
        $posts = BlogPost::where('status', 'published')
            ->with(['category', 'author', 'tags'])
            ->latest('publish_date')
            ->paginate(10);

        $categories = BlogCategory::withCount('posts')->get();
        $tags = BlogTag::withCount('posts')->get();
        $featuredPosts = BlogPost::where('status', 'published')
            ->where('is_featured', true)
            ->take(3)
            ->get();

        return view('frontend.blog.index', compact('posts', 'categories', 'tags', 'featuredPosts'));
    }

    /**
     * Display the specified blog post.
     */
    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'author', 'tags'])
            ->firstOrFail();

        $relatedPosts = BlogPost::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->take(3)
            ->get();

        return view('frontend.blog.show', ['blogPost' => $post, 'relatedPosts' => $relatedPosts]);
    }

    /**
     * Display posts by category.
     */
    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)->firstOrFail();

        $posts = BlogPost::where('category_id', $category->id)
            ->where('status', 'published')
            ->with(['category', 'author', 'tags'])
            ->latest('publish_date')
            ->paginate(10);

        $categories = BlogCategory::withCount('posts')->get();
        $tags = BlogTag::withCount('posts')->get();

        return view('frontend.blog.index', compact('posts', 'categories', 'tags', 'category'));
    }

    /**
     * Display posts by tag.
     */
    public function tag($slug)
    {
        $tag = BlogTag::where('slug', $slug)->firstOrFail();

        $posts = $tag->posts()
            ->where('status', 'published')
            ->with(['category', 'author', 'tags'])
            ->latest('publish_date')
            ->paginate(10);

        $categories = BlogCategory::withCount('posts')->get();
        $tags = BlogTag::withCount('posts')->get();

        return view('frontend.blog.index', compact('posts', 'categories', 'tags', 'tag'));
    }
}
