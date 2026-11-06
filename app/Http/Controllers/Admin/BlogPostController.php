<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImages;
use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BlogPostController extends Controller
{
    use HandlesImages;

    public function index()
    {
        $posts = BlogPost::with(['category', 'author'])->latest()->paginate(15);
        return view('admin.blog-posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        return view('admin.blog-posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(array_merge([
            'category_id' => ['required', 'exists:blog_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:blog_posts', 'regex:/^[a-z0-9-]+$/'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'in:draft,published'],
            'is_featured' => ['boolean'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:blog_tags,id'],
        ], $this->imageRules('featured_image', true)));

        $validated = $this->resolveImages($request, $validated, ['featured_image'], null, 'blog');
        $validated['author_id'] = auth()->id();
        $validated['is_featured'] = $request->has('is_featured');
        $validated['excerpt'] = $validated['excerpt'] ?? '';
        $validated['content'] = $validated['content'] ?? '';
        $validated['publish_date'] = now();

        $post = BlogPost::create(collect($validated)->except('tags')->all());

        if (!empty($validated['tags'])) {
            $post->tags()->attach($validated['tags']);
        }

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post created successfully.');
    }

    public function show(BlogPost $blogPost)
    {
        $blogPost->load(['category', 'author', 'tags']);
        return view('admin.blog-posts.show', compact('blogPost'));
    }

    public function edit(BlogPost $blogPost)
    {
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        $blogPost->load('tags');
        return view('admin.blog-posts.edit', compact('blogPost', 'categories', 'tags'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $request->validate(array_merge([
            'category_id' => ['required', 'exists:blog_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('blog_posts')->ignore($blogPost->id), 'regex:/^[a-z0-9-]+$/'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'in:draft,published'],
            'is_featured' => ['boolean'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:blog_tags,id'],
        ], $this->imageRules('featured_image', true)));

        $validated = $this->resolveImages($request, $validated, ['featured_image'], $blogPost, 'blog');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['excerpt'] = $validated['excerpt'] ?? '';
        $validated['content'] = $validated['content'] ?? '';

        // publish_date is required; a draft that gets published is dated now.
        if ($validated['status'] === 'published' && $blogPost->status !== 'published') {
            $validated['publish_date'] = now();
        }

        $blogPost->update(collect($validated)->except('tags')->all());
        $blogPost->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blogPost)
    {
        $blogPost->tags()->detach();
        $blogPost->delete();

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post deleted successfully.');
    }
}
