<?php

namespace Tests\Feature;

use App\Models\PageSection;
use App\Models\Partner;
use App\Models\User;
use Database\Seeders\HomepageContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create();
    }

    private function section(string $key): PageSection
    {
        return PageSection::homepage()->where('section_key', $key)->firstOrFail();
    }

    public function test_homepage_renders_every_seeded_section(): void
    {
        $this->admin(); // blog posts need an author
        $this->seed(HomepageContentSeeder::class);

        $response = $this->get('/')->assertOk();

        foreach (['banner__one', 'features__one', 'about__one', 'service__one', 'cta__one', 'choose__us',
                  'portfolio__one', 'work__process', 'team__one', 'testimonial__one', 'brand__area',
                  'blog__one', 'footer__cta'] as $class) {
            $response->assertSee('class="' . $class, false);
        }

        $response->assertSee('Eco Friendly')->assertSee('Solar Panel Services')->assertSee('Steve Rhodes');
    }

    public function test_homepage_works_with_an_empty_database(): void
    {
        $this->get('/')->assertOk()->assertSee('Your Trusted Energy Partner');
        $this->assertSame(count(\App\Support\PageSections::definitions('home')), PageSection::homepage()->count());
    }

    public function test_hidden_sections_are_not_rendered(): void
    {
        $this->get('/');
        $this->section('cta')->update(['is_active' => false]);

        $this->get('/')->assertOk()->assertDontSee('class="cta__one"', false);
    }

    public function test_admin_pages_require_login(): void
    {
        $this->get('/admin/content/home')->assertRedirect(route('admin.login'));
        $this->get('/admin/partners')->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_edit_a_section_with_repeater_items_and_an_upload(): void
    {
        Storage::fake('public');
        $this->get('/');
        $section = $this->section('features');

        $this->actingAs($this->admin())
            ->put(route('admin.content.update', ['home', $section]), [
                'is_active' => 1,
                'content' => [
                    'title' => 'Powering Tomorrow',
                    'items' => [
                        ['icon' => 'flaticon-trophy', 'title' => 'Award Winning', 'text' => 'Recognised'],
                        ['icon' => '', 'title' => '', 'text' => ''],
                    ],
                ],
                'files' => ['client_image' => UploadedFile::fake()->image('clients.png')],
            ])
            ->assertRedirect(route('admin.content.edit', ['home', $section]));

        $content = $section->fresh()->content;
        $this->assertSame('Powering Tomorrow', $content['title']);
        $this->assertCount(1, $content['items'], 'Empty repeater rows are dropped');
        $this->assertStringStartsWith('storage/uploads/pages/home/', $content['client_image']);
        Storage::disk('public')->assertExists(substr($content['client_image'], strlen('storage/')));

        $this->get('/')->assertSee('Powering Tomorrow')->assertSee('Award Winning');
    }

    public function test_admin_can_reorder_and_hide_sections(): void
    {
        $this->get('/');
        $sections = PageSection::homepage()->where('section_key', '!=', 'page')->get();
        $payload = [];
        foreach ($sections as $section) {
            $payload[$section->id] = ['order' => $section->section_key === 'blog' ? 0 : $section->order,
                                      'is_active' => $section->section_key === 'about' ? 0 : 1];
        }

        $this->actingAs($this->admin())
            ->put(route('admin.content.arrange', 'home'), ['sections' => $payload])
            ->assertRedirect(route('admin.content.index', 'home'));

        $this->assertSame(0, $this->section('blog')->order);
        $this->assertFalse($this->section('about')->is_active);
    }

    public function test_partner_crud_with_image_replacement(): void
    {
        Storage::fake('public');
        $this->actingAs($this->admin());

        $this->post(route('admin.partners.store'), [
            'name' => 'Acme Solar',
            'status' => 'active',
            'logo_file' => UploadedFile::fake()->image('acme.png'),
        ])->assertRedirect(route('admin.partners.index'));

        $partner = Partner::where('name', 'Acme Solar')->firstOrFail();
        $first = $partner->logo;
        Storage::disk('public')->assertExists(substr($first, strlen('storage/')));

        $this->put(route('admin.partners.update', $partner), [
            'name' => 'Acme Solar',
            'status' => 'active',
            'logo' => $first,
            'logo_file' => UploadedFile::fake()->image('acme-new.png'),
        ])->assertRedirect(route('admin.partners.index'));

        Storage::disk('public')->assertMissing(substr($first, strlen('storage/')));

        $this->delete(route('admin.partners.destroy', $partner))->assertRedirect(route('admin.partners.index'));
        $this->assertDatabaseMissing('partners', ['id' => $partner->id]);
    }

    public function test_required_image_is_validated(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.partners.store'), ['name' => 'No Logo', 'status' => 'active'])
            ->assertSessionHasErrors('logo');
    }

    public function test_site_settings_drive_the_layout(): void
    {
        $this->actingAs($this->admin())
            ->put(route('admin.settings.general.update'), [
                'site_name' => 'SI Green Energy',
                'phone' => '+880 1700 000000',
                'copyright' => 'Copyright :year - SI Green Energy',
            ])
            ->assertRedirect(route('admin.settings.general'));

        $this->get('/')->assertSee('+880 1700 000000')
            ->assertSee('Copyright ' . date('Y') . ' - SI Green Energy')
            ->assertSee('img/logo-1.png'); // cleared logo falls back to the theme logo
    }

    public function test_listing_pages_linked_from_the_homepage_load(): void
    {
        $this->admin(); // blog posts need an author
        $this->seed(HomepageContentSeeder::class);

        $urls = ['/team', '/projects/4-columns', '/blog', '/blog/solar-power-for-a-cleaner-brighter-world', '/services/wind-turbines'];
        $statuses = array_map(fn ($url) => $this->get($url)->getStatusCode(), array_combine($urls, $urls));

        $this->assertSame(array_fill_keys($urls, 200), $statuses);
    }
}
