<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImages;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogPostController extends Controller
{
    use HandlesImages;

    public function index(Request $request)
    {
        $posts = BlogPost::with(['category', 'author'])
            ->when($request->filled('search'), fn ($query) => $query->where('title', 'like', '%' . $request->search . '%'))
            ->when($request->filled('category'), fn ($query) => $query->where('category_id', $request->category))
            ->when(in_array($request->status, ['draft', 'published'], true), fn ($query) => $query->where('status', $request->status))
            ->latest('publish_date')
            ->paginate(15)->withQueryString();

        $categories = BlogCategory::orderBy('name')->get();

        return view('admin.blog-posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        return view('admin.blog-posts.create', $this->formData());
    }

    public function store(Request $request)
    {
        [$data, $tagIds] = $this->validatedData($request);
        $data = $this->resolveImages($request, $data, ['featured_image'], null, 'blog');

        $post = BlogPost::create($data);
        $post->tags()->sync($tagIds);

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
        $blogPost->load('tags');

        return view('admin.blog-posts.edit', $this->formData() + compact('blogPost'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        [$data, $tagIds] = $this->validatedData($request, $blogPost);
        $data = $this->resolveImages($request, $data, ['featured_image'], $blogPost, 'blog');

        $blogPost->update($data);
        $blogPost->tags()->sync($tagIds);

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blogPost)
    {
        // Soft delete: tags and image are kept so the post can be restored.
        $blogPost->delete();

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post deleted successfully.');
    }

    private function formData(): array
    {
        return [
            'categories' => BlogCategory::orderBy('name')->get(),
            'tags' => BlogTag::orderBy('name')->get(),
            'authors' => User::orderBy('name')->get(['id', 'name']),
        ];
    }

    /**
     * @return array{0: array, 1: array<int>} post attributes and tag ids
     */
    private function validatedData(Request $request, ?BlogPost $post = null): array
    {
        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('title'))]);

        $data = $request->validate(array_merge([
            'author_id' => ['required', 'exists:users,id'],
            'category_id' => ['nullable', 'exists:blog_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('blog_posts')->ignore($post?->id)],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'tags_input' => ['nullable', 'string', 'max:500'],
            'reading_time' => ['nullable', 'integer', 'min:1', 'max:600'],
            'publish_date' => ['required', 'date'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'in:draft,published'],
        ], $this->imageRules('featured_image', true)));

        $tagIds = $this->tagIds($data['tags_input'] ?? '');
        unset($data['tags_input']);

        $data['excerpt'] = $data['excerpt'] ?? '';
        $data['is_featured'] = $request->boolean('is_featured');

        return [$data, $tagIds];
    }

    /**
     * "solar, Maintenance" -> ids of existing or newly created tags.
     */
    private function tagIds(string $input): array
    {
        return collect(explode(',', $input))
            ->map(fn ($name) => trim($name))
            ->filter()
            ->unique(fn ($name) => Str::slug($name))
            ->map(fn ($name) => BlogTag::firstOrCreate(['slug' => Str::slug($name)], ['name' => Str::limit($name, 100, '')])->id)
            ->values()->all();
    }
}
