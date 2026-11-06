<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Support\PageSections;
use App\Support\Seo;
use Illuminate\Http\Request;

/**
 * Blog listing (standard-right-sidebar.html) and post (single-right-sidebar.html).
 */
class BlogController extends Controller
{
    public function index(Request $request)
    {
        return $this->listing($request);
    }

    public function category(Request $request, string $slug)
    {
        $category = BlogCategory::where('slug', $slug)->firstOrFail();

        return $this->listing($request, category: $category);
    }

    public function tag(Request $request, string $slug)
    {
        $tag = BlogTag::where('slug', $slug)->firstOrFail();

        return $this->listing($request, tag: $tag);
    }

    public function show(string $slug)
    {
        $post = BlogPost::published()->with(['category', 'author', 'tags'])->where('slug', $slug)->firstOrFail();
        $post->increment('views');

        $settings = PageSections::settings('blog');
        $listing = $this->listingSettings();

        $relatedPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->when($post->category_id, fn ($query) => $query->where('category_id', $post->category_id))
            ->latest('publish_date')->take(3)->get();

        $previous = BlogPost::published()->where('publish_date', '<', $post->publish_date)->latest('publish_date')->first();
        $next = BlogPost::published()->where('publish_date', '>', $post->publish_date)->oldest('publish_date')->first();

        $seo = Seo::record($post->title, $post->meta_title, $post->meta_description, $post->excerpt ?: $post->content);
        $seo['image'] = $post->imageUrl();

        return view('frontend.blog.show', array_merge(
            compact('post', 'settings', 'listing', 'relatedPosts', 'previous', 'next', 'seo'),
            $this->sidebar()
        ));
    }

    private function listing(Request $request, ?BlogCategory $category = null, ?BlogTag $tag = null)
    {
        $settings = PageSections::settings('blog');
        $listing = $this->listingSettings();
        $search = trim((string) $request->query('q'));

        $posts = BlogPost::published()->with(['category', 'author'])
            ->when($category, fn ($query) => $query->where('category_id', $category->id))
            ->when($tag, fn ($query) => $query->whereHas('tags', fn ($tags) => $tags->whereKey($tag->id)))
            ->when($search !== '', fn ($query) => $query->where(fn ($inner) => $inner
                ->where('title', 'like', "%{$search}%")
                ->orWhere('excerpt', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%")))
            ->latest('publish_date')
            ->paginate(max(1, (int) $listing['per_page']))
            ->withQueryString();

        $title = match (true) {
            (bool) $category => $category->name,
            (bool) $tag => 'Tag: ' . $tag->name,
            $search !== '' => 'Search: ' . $search,
            default => $settings['title'],
        };

        $seo = $category || $tag || $search !== ''
            ? Seo::record($title, null, $category?->description, $settings['meta_description'])
            : Seo::page('blog');

        return view('frontend.blog.index', array_merge(
            compact('posts', 'settings', 'listing', 'title', 'category', 'tag', 'search', 'seo'),
            $this->sidebar($category)
        ));
    }

    /**
     * Sidebar widgets shared by the listing and post pages.
     */
    private function sidebar(?BlogCategory $current = null): array
    {
        $categories = BlogCategory::withCount(['posts' => fn ($query) => $query->published()])
            ->orderBy('order')->orderBy('name')->get()
            ->filter(fn ($category) => $category->posts_count > 0)
            ->map(fn ($category) => [
                'label' => $category->name,
                'url' => route('blog.category', $category->slug),
                'active' => $current && $current->is($category),
                'count' => $category->posts_count,
            ])->values()->all();

        return [
            'sidebarCategories' => $categories,
            'recentPosts' => BlogPost::published()->latest('publish_date')->take(3)->get(),
            'popularTags' => BlogTag::whereHas('posts', fn ($query) => $query->published())
                ->withCount('posts')->orderByDesc('posts_count')->take(12)->get(),
        ];
    }

    private function listingSettings(): array
    {
        return PageSections::sections('blog')->firstWhere('section_key', 'listing')->content;
    }
}
