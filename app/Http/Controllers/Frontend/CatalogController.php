<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\Media;
use App\Support\PageSections;
use App\Support\SectionData;
use App\Support\Seo;
use Illuminate\Database\Eloquent\Model;

/**
 * Listing (service-two.html) and details (service-right-sidebar.html) pages shared by
 * products, services and solutions. Subclasses only describe their models and routes.
 */
abstract class CatalogController extends Controller
{
    /** Item model class, e.g. Service::class (uses IsCatalogItem). */
    abstract protected function model(): string;

    /** Category model class, e.g. ServiceCategory::class (uses IsCategory). */
    abstract protected function categoryModel(): string;

    /** Route name prefix and CMS page key, e.g. "services". */
    abstract protected function prefix(): string;

    /** Singular label, e.g. "Service". */
    abstract protected function singular(): string;

    public function index()
    {
        return $this->listing();
    }

    public function category(string $slug)
    {
        $category = $this->categoryModel()::active()->where('slug', $slug)->firstOrFail();

        return $this->listing($category);
    }

    public function show(string $slug)
    {
        $item = $this->model()::published()->with('category')->where('slug', $slug)->firstOrFail();
        $item->increment('views');

        $page = $this->prefix();
        $sections = PageSections::sections($page)->keyBy('section_key');
        $settings = PageSections::settings($page);

        $seo = Seo::record($item->name, $item->meta_title, $item->meta_description, $item->short_description);
        $seo['image'] = $item->imageUrl();

        $related = $this->model()::published()
            ->where('id', '!=', $item->id)
            ->when($item->category_id, fn ($query) => $query->where('category_id', $item->category_id))
            ->ordered()->take(5)->get();

        return view('frontend.catalog.show', [
            'item' => $item,
            'related' => $related,
            'categories' => $this->categoryLinks($item->category),
            'sidebar' => $sections['sidebar']->content,
            'faq' => $sections['faq']->is_active ? $sections['faq']->content : null,
            'settings' => $settings,
            'catalog' => $this->catalog(),
            'seo' => $seo,
        ]);
    }

    private function listing(?Model $category = null)
    {
        $page = $this->prefix();
        $settings = PageSections::settings($page);
        $sections = PageSections::visible($page);
        $listing = PageSections::sections($page)->firstWhere('section_key', 'listing')->content;

        $items = $this->model()::published()->with('category')
            ->when($category, fn ($query) => $query->where('category_id', $category->id))
            ->ordered()
            ->paginate(max(1, (int) $listing['per_page']))
            ->withQueryString();

        $data = SectionData::load($page, $sections);
        $data['listing'] = $items;

        $title = $category ? $category->name : $settings['title'];
        $seo = $category
            ? Seo::record($category->name, null, $category->description, $settings['meta_description'])
            : Seo::page($page);

        return view('frontend.catalog.index', [
            'page' => $page,
            'sections' => $sections,
            'data' => $data,
            'title' => $title,
            'banner' => $category?->image ? Media::url($category->image) : $settings['breadcrumb_image'],
            'category' => $category,
            'categories' => $this->categoryLinks($category),
            'catalog' => $this->catalog(),
            'seo' => $seo,
        ]);
    }

    /**
     * Active categories as sidebar / filter links.
     */
    private function categoryLinks(?Model $current): array
    {
        return $this->categoryModel()::active()->ordered()
            ->withCount(['items' => fn ($query) => $query->where('status', 'published')])
            ->get()
            ->filter(fn ($category) => $category->items_count > 0)
            ->map(fn ($category) => [
                'label' => $category->name,
                'url' => route($this->prefix() . '.category', $category->slug),
                'active' => $current && $current->is($category),
                'count' => $category->items_count,
            ])->values()->all();
    }

    private function catalog(): array
    {
        return [
            'prefix' => $this->prefix(),
            'singular' => $this->singular(),
            'label' => PageSections::settings($this->prefix())['title'] ?? $this->singular(),
        ];
    }
}
