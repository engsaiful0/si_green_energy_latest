<?php

namespace Tests\Feature;

use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Models\PageSection;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Database\Seeders\GallerySeeder;
use Database\Seeders\ProductCatalogSeeder;
use Database\Seeders\SiGreenEnergyContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryAndProductsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();
        $this->seed([SiGreenEnergyContentSeeder::class, ProductCatalogSeeder::class, GallerySeeder::class]);
    }

    public function test_gallery_is_in_the_about_menu_and_renders_with_filters(): void
    {
        $this->get('/')->assertSee(route('gallery'), false);

        $response = $this->get('/gallery')->assertOk();
        $response->assertSee('data-filter=".gallery-cat-', false)->assertSee('img-popup', false);
        $this->assertSame(GalleryImage::published()->count(), substr_count($response->getContent(), 'gallery__grid-item '));
    }

    public function test_unpublished_images_are_hidden_everywhere(): void
    {
        $image = GalleryImage::where('show_on_home', true)->firstOrFail();
        $image->update(['status' => 'draft']);

        $this->get('/gallery')->assertDontSee($image->image);
        $this->get('/')->assertDontSee('alt="' . $image->altText() . '"', false);
    }

    public function test_homepage_carousel_shows_selected_images_in_order(): void
    {
        $selected = GalleryImage::published()->onHome()->get();
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertSame($selected->count(), substr_count($html, 'portfolio__one-item swiper-slide'));
        $this->assertStringContainsString('View All Gallery', $html);

        // Reorder: put the last selected image first.
        $last = $selected->last();
        $this->actingAs($this->admin)->put(route('admin.gallery.home.update'), [
            'images' => $selected->mapWithKeys(fn ($image) => [$image->id => ['keep' => 1, 'home_order' => $image->is($last) ? 0 : $image->home_order + 10]])->all(),
        ])->assertRedirect(route('admin.gallery.home'));

        $this->assertTrue(GalleryImage::onHome()->first()->is($last));
    }

    public function test_admin_uploads_multiple_images_and_toggles_homepage(): void
    {
        Storage::fake('public');
        $category = GalleryCategory::firstOrFail();

        $this->actingAs($this->admin)->post(route('admin.gallery.store'), [
            'images' => [UploadedFile::fake()->image('roof-one.jpg'), UploadedFile::fake()->image('roof-two.jpg'), UploadedFile::fake()->image('roof-three.jpg')],
            'category_id' => $category->id,
            'title' => 'Rooftop work',
            'status' => 'published',
        ])->assertRedirect(route('admin.gallery.index'));

        $uploaded = GalleryImage::where('title', 'like', 'Rooftop work%')->get();
        $this->assertCount(3, $uploaded);
        $uploaded->each(fn ($image) => Storage::disk('public')->assertExists(substr($image->image, strlen('storage/'))));

        $image = $uploaded->first();
        $this->actingAs($this->admin)->patch(route('admin.gallery.toggle', $image), ['field' => 'show_on_home']);
        $this->assertTrue($image->fresh()->show_on_home);

        $this->actingAs($this->admin)->put(route('admin.gallery.update', $image), [
            'title' => 'Updated title', 'alt_text' => 'Updated alt', 'status' => 'published', 'image' => $image->image,
            'category_id' => $category->id, 'show_on_home' => 1, 'home_order' => 1,
        ])->assertRedirect(route('admin.gallery.index'));
        $this->assertSame('Updated alt', $image->fresh()->alt_text);

        $this->actingAs($this->admin)->delete(route('admin.gallery.destroy', $image));
        $this->assertModelMissing($image);
        Storage::disk('public')->assertMissing(substr($image->image, strlen('storage/')));
    }

    public function test_every_product_category_has_real_branded_products(): void
    {
        foreach (ProductCategory::all() as $category) {
            $products = Product::published()->where('category_id', $category->id)->get();
            $this->assertGreaterThanOrEqual(2, $products->count(), "{$category->name} has too few products");
            $products->each(function (Product $product) {
                $this->assertNotEmpty($product->brand);
                $this->assertNotEmpty($product->model);
                $this->assertNotEmpty($product->source_url);
                $this->assertNotEmpty($product->specifications);
            });
        }

        $this->assertNull(Product::where('slug', 'monocrystalline-perc-solar-panel')->first(), 'generic sample products removed');
    }

    public function test_product_seeder_is_idempotent_and_keeps_admin_edits(): void
    {
        $product = Product::where('brand', 'Victron Energy')->firstOrFail();
        $product->update(['short_description' => 'Edited by admin']);
        $count = Product::count();

        $this->seed(ProductCatalogSeeder::class);

        $this->assertSame($count, Product::count());
        $this->assertSame('Edited by admin', $product->fresh()->short_description);
    }

    public function test_product_page_shows_brand_links_and_note(): void
    {
        $product = Product::where('brand', 'JinkoSolar')->firstOrFail();

        $this->get('/products/' . $product->slug)->assertOk()
            ->assertSee('JinkoSolar')
            ->assertSee('Manufacturer Website')
            ->assertSee('View Datasheet')
            ->assertSee('confirm the exact model');
    }

    public function test_cta_titles_are_single_line_and_styles_are_present(): void
    {
        foreach (PageSection::whereIn('section_key', ['cta', 'footer_cta'])->get() as $section) {
            $this->assertStringNotContainsString("\n", $section->content['title']);
            $this->assertLessThanOrEqual(45, mb_strlen($section->content['title']), $section->page_key . ' CTA title is too long');
        }

        $css = file_get_contents(public_path('css/site.css'));
        $this->assertStringContainsString('white-space: nowrap', $css);
        $this->assertStringContainsString('text-align: justify', $css);
        $this->get('/services')->assertSee('class="cta__title-line"', false);
    }
}
