<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\PageSection;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Project;
use App\Models\Service;
use App\Models\Solution;
use App\Models\SolutionCategory;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use App\Support\PageSections;
use Database\Seeders\CatalogContentSeeder;
use Database\Seeders\HomepageContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InnerPagesTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();
        $this->seed([HomepageContentSeeder::class, CatalogContentSeeder::class]);
    }

    public function test_every_inner_page_renders(): void
    {
        $urls = [
            '/company-profile', '/testimonials', '/team', '/products', '/solutions', '/services',
            '/projects', '/blog', '/contact',
            '/team/' . TeamMember::first()->slug,
            '/projects/' . Project::first()->slug,
            '/blog/' . BlogPost::first()->slug,
            '/services/' . Service::first()->slug,
            '/solutions/' . Solution::first()->slug,
            '/products/' . Product::first()->slug,
            '/solutions/category/' . SolutionCategory::first()->slug,
            '/products/category/' . ProductCategory::first()->slug,
        ];

        $statuses = array_map(fn ($url) => $this->get($url)->getStatusCode(), array_combine($urls, $urls));

        $this->assertSame(array_fill_keys($urls, 200), $statuses);
        $this->get('/about')->assertRedirect('/company-profile');
    }

    public function test_navbar_lists_catalog_categories(): void
    {
        $response = $this->get('/');

        foreach (['Company Profile', 'Solar Design Engineer', 'Testimonial'] as $label) {
            $response->assertSee($label);
        }
        foreach ([ProductCategory::class, SolutionCategory::class] as $model) {
            $response->assertSee($model::first()->name);
        }
    }

    public function test_inactive_category_is_hidden_and_404s(): void
    {
        $category = SolutionCategory::first();
        $category->update(['is_active' => false]);

        $this->get('/')->assertDontSee('/solutions/category/' . $category->slug);
        $this->get('/solutions/category/' . $category->slug)->assertNotFound();
    }

    public function test_details_pages_show_the_requested_record_and_seo(): void
    {
        $solution = Solution::first();
        $solution->update(['meta_title' => 'Custom Solution Title', 'meta_description' => 'Custom solution meta']);

        $this->get('/solutions/' . $solution->slug)
            ->assertOk()
            ->assertSee('<title>Custom Solution Title</title>', false)
            ->assertSee('Custom solution meta')
            ->assertSee($solution->name);

        $solution->update(['status' => 'draft']);
        $this->get('/solutions/' . $solution->slug)->assertNotFound();
    }

    public function test_category_filters_listings(): void
    {
        [$first, $second] = SolutionCategory::orderBy('id')->take(2)->get()->all();
        $inSecond = Solution::where('category_id', $second->id)->first();

        $this->get('/solutions/category/' . $first->slug)
            ->assertOk()
            ->assertDontSee('solutions/' . $inSecond->slug . '"', false);
    }

    public function test_contact_form_stores_message_and_validates(): void
    {
        $this->post('/contact', ['name' => 'Ada', 'email' => 'ada@example.com', 'message' => 'Hello'])
            ->assertRedirect()
            ->assertSessionHas('contact_success');

        $this->assertDatabaseHas('contact_messages', ['email' => 'ada@example.com', 'subject' => 'Website enquiry', 'status' => 'new']);

        $this->post('/contact', ['name' => '', 'email' => 'bad'])->assertSessionHasErrors(['name', 'email', 'message']);

        // Honeypot
        $this->post('/contact', ['name' => 'Bot', 'email' => 'bot@example.com', 'message' => 'x', 'website' => 'spam'])
            ->assertSessionHasErrors('website');
        $this->assertDatabaseMissing('contact_messages', ['email' => 'bot@example.com']);
    }

    public function test_admin_manages_contact_messages(): void
    {
        $message = ContactMessage::create(['name' => 'Ada', 'email' => 'ada@example.com', 'subject' => 'Hi', 'message' => 'Hello']);

        $this->actingAs($this->admin)->get(route('admin.contacts.index'))->assertOk()->assertSee('Ada');
        $this->actingAs($this->admin)->get(route('admin.contacts.show', $message))->assertOk();
        $this->assertSame('read', $message->fresh()->status);

        $this->actingAs($this->admin)->put(route('admin.contacts.update', $message), ['status' => 'replied']);
        $this->assertSame('replied', $message->fresh()->status);

        $this->actingAs($this->admin)->delete(route('admin.contacts.destroy', $message));
        $this->assertModelMissing($message);
    }

    public function test_category_with_records_cannot_be_deleted(): void
    {
        $category = SolutionCategory::has('solutions')->first();

        $this->actingAs($this->admin)
            ->delete(route('admin.solution-categories.destroy', $category->id))
            ->assertSessionHas('error');
        $this->assertModelExists($category);

        Solution::where('category_id', $category->id)->update(['category_id' => null]);

        $this->actingAs($this->admin)
            ->delete(route('admin.solution-categories.destroy', $category->id))
            ->assertSessionHas('success');
        $this->assertModelMissing($category);
    }

    public function test_admin_creates_a_solution_with_upload(): void
    {
        Storage::fake('public');
        $category = SolutionCategory::first();

        $this->actingAs($this->admin)->post(route('admin.solutions.store'), [
            'name' => 'Village Microgrid',
            'category_id' => $category->id,
            'short_description' => 'Solar microgrid for remote villages.',
            'features' => "Remote monitoring\nBattery backup",
            'status' => 'published',
            'featured_image_file' => UploadedFile::fake()->image('grid.jpg'),
        ])->assertRedirect(route('admin.solutions.index'));

        $solution = Solution::where('slug', 'village-microgrid')->firstOrFail();
        $this->assertSame(['Remote monitoring', 'Battery backup'], $solution->features);
        Storage::disk('public')->assertExists(substr($solution->featured_image, strlen('storage/')));

        $this->get('/solutions/village-microgrid')->assertOk()->assertSee('Battery backup');
    }

    public function test_project_gallery_upload_and_delete(): void
    {
        Storage::fake('public');
        $project = Project::first();

        $this->actingAs($this->admin)->put(route('admin.projects.update', $project), [
            'name' => $project->name,
            'short_description' => $project->short_description,
            'status' => 'published',
            'featured_image' => $project->featured_image,
            'gallery_files' => [UploadedFile::fake()->image('a.jpg'), UploadedFile::fake()->image('b.jpg')],
        ])->assertRedirect(route('admin.projects.index'));

        $image = $project->images()->where('image_path', 'like', 'storage/%')->firstOrFail();
        $this->get('/projects/' . $project->slug)->assertSee($image->image_path);

        $this->actingAs($this->admin)->delete(route('admin.projects.images.destroy', [$project, $image]));
        $this->assertModelMissing($image);
        Storage::disk('public')->assertMissing(substr($image->image_path, strlen('storage/')));
    }

    public function test_blog_post_with_tags_author_and_schedule(): void
    {
        $this->actingAs($this->admin)->post(route('admin.blog-posts.store'), [
            'author_id' => $this->admin->id,
            'title' => 'Future Post',
            'content' => 'Body',
            'tags_input' => 'Solar, Net Metering, solar',
            'publish_date' => now()->addDay()->format('Y-m-d\TH:i'),
            'status' => 'published',
            'featured_image' => 'img/blog/blog-1.jpg',
        ])->assertRedirect(route('admin.blog-posts.index'));

        $post = BlogPost::where('slug', 'future-post')->firstOrFail();
        $this->assertEqualsCanonicalizing(['Solar', 'Net Metering'], $post->tags->pluck('name')->all());

        // Scheduled: not visible until the publish date
        $this->get('/blog/future-post')->assertNotFound();
        $post->update(['publish_date' => now()->subMinute()]);
        $this->get('/blog/future-post')->assertOk()->assertSee($this->admin->name);
        $this->get('/blog/tag/net-metering')->assertOk()->assertSee('Future Post');
    }

    public function test_cms_page_section_edits_appear_on_the_page(): void
    {
        $section = PageSection::forPage('contact')->where('section_key', 'contact')->firstOrFail();

        $this->actingAs($this->admin)->put(route('admin.content.update', ['contact', $section]), [
            'is_active' => 1,
            'content' => ['title' => 'Talk to our solar team', 'button_text' => 'Send Now', 'items' => []],
        ])->assertRedirect();

        $this->get('/contact')->assertSee('Talk to our solar team')->assertSee('Send Now');

        // A section of another page cannot be edited through this page's URL.
        $this->actingAs($this->admin)->get(route('admin.content.edit', ['home', $section]))->assertNotFound();
    }

    public function test_page_seo_settings_are_used(): void
    {
        $page = PageSection::forPage('blog')->where('section_key', PageSections::PAGE_SETTINGS)->firstOrFail();

        $page->update(['content' => array_merge($page->content, ['meta_title' => 'Solar Blog Custom', 'meta_description' => 'Blog meta X'])]);

        $this->get('/blog')->assertSee('<title>Solar Blog Custom</title>', false)->assertSee('Blog meta X');
    }

    public function test_unpublished_testimonials_and_inactive_members_are_hidden(): void
    {
        $testimonial = Testimonial::first();
        $testimonial->update(['status' => 'pending']);
        $this->get('/testimonials')->assertDontSee($testimonial->client_name);

        $member = TeamMember::first();
        $member->update(['status' => 'inactive']);
        $this->get('/team')->assertDontSee($member->full_name);
        $this->get('/team/' . $member->slug)->assertNotFound();
    }
}
