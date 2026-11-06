<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Partner;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\Slider;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use App\Support\HomepageSections;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Sample homepage content based on the Slaze "Solar Energy" template.
 * Safe to run more than once: existing records (matched by slug/title/name) are left untouched.
 */
class HomepageContentSeeder extends Seeder
{
    public function run(): void
    {
        HomepageSections::ensureExists();

        $this->sliders();
        $this->services();
        $this->projects();
        $this->team();
        $this->testimonials();
        $this->partners();
        $this->blogPosts();
    }

    private function sliders(): void
    {
        $slides = [
            ['title' => "Eco Friendly\nPower", 'subtitle' => 'Green Energy', 'description' => 'We stand at the forefront of the eco-friendly power movement, dedicated to harnessing sustainable energy.', 'background_image' => 'img/banner/banner-1.jpg'],
            ['title' => "Largest\nSolar Energy", 'subtitle' => "We're the best", 'description' => 'Reliable solar systems designed, installed and maintained by certified engineers.', 'background_image' => 'img/banner/banner-3.jpg'],
        ];

        foreach ($slides as $order => $slide) {
            Slider::firstOrCreate(['title' => $slide['title']], $slide + [
                'button_text' => 'Discover More',
                'button_link' => '/about',
                'order' => $order + 1,
                'is_active' => true,
            ]);
        }
    }

    private function services(): void
    {
        $services = [
            ['name' => 'Hydropower Solutions', 'icon' => 'flaticon-ecology', 'short_description' => 'Harness the power of water with our hydropower solutions.', 'featured_image' => 'img/service/service-1.jpg'],
            ['name' => 'Wind Turbines', 'icon' => 'flaticon-renewable-energy', 'short_description' => 'Wind turbines powering a greener tomorrow effortlessly.', 'featured_image' => 'img/service/service-2.jpg'],
            ['name' => 'Solar Panel Services', 'icon' => 'flaticon-solar-energy', 'short_description' => 'Ensure the longevity and efficiency of your solar panels.', 'featured_image' => 'img/service/service-3.jpg'],
        ];

        foreach ($services as $order => $service) {
            Service::withTrashed()->firstOrCreate(['slug' => Str::slug($service['name'])], $service + [
                'description' => $service['short_description'],
                'benefits' => ['Free site assessment', 'Certified installation', 'Ongoing maintenance'],
                'is_featured' => true,
                'status' => 'published',
                'order' => $order + 1,
            ]);
        }
    }

    private function projects(): void
    {
        $projects = [
            ['name' => 'Sun Power Hub', 'category' => 'Eco Innovate'],
            ['name' => 'SunWave Solar Tech', 'category' => 'EcoBright Panels'],
            ['name' => 'SunSpark Modules', 'category' => 'Solar Radiance'],
            ['name' => 'EcoHarvest Panels', 'category' => 'Sustainable Suns'],
            ['name' => 'Solar Bliss Haven', 'category' => 'Clean Charge'],
        ];

        foreach ($projects as $i => $project) {
            $category = ProjectCategory::firstOrCreate(
                ['slug' => Str::slug($project['category'])],
                ['name' => $project['category'], 'is_active' => true, 'order' => $i + 1]
            );

            Project::withTrashed()->firstOrCreate(['slug' => Str::slug($project['name'])], [
                'name' => $project['name'],
                'category_id' => $category->id,
                'short_description' => 'A turnkey solar installation delivering clean, affordable power.',
                'description' => 'Site assessment, system design, installation and commissioning delivered by our in-house team.',
                'featured_image' => 'img/portfolio/portfolio-' . ($i + 1) . '.jpg',
                'project_date' => now()->subMonths($i * 2)->toDateString(),
                'is_featured' => true,
                'status' => 'published',
            ]);
        }
    }

    private function team(): void
    {
        $members = [
            ['full_name' => 'Steve Rhodes', 'position' => 'Senior Manager'],
            ['full_name' => 'Derya Kurtulus', 'position' => 'Heating Expert'],
            ['full_name' => 'Lisa Thompson', 'position' => 'Senior Engineer'],
            ['full_name' => 'David Martinez', 'position' => 'Senior Technician'],
        ];

        foreach ($members as $i => $member) {
            TeamMember::withTrashed()->firstOrCreate(['slug' => Str::slug($member['full_name'])], $member + [
                'photo' => 'img/team/team-' . ($i + 1) . '.jpg',
                'social_links' => [
                    'facebook' => 'https://facebook.com/',
                    'twitter' => 'https://twitter.com/',
                    'instagram' => 'https://instagram.com/',
                    'linkedin' => 'https://linkedin.com/',
                ],
                'is_featured' => true,
                'order' => $i + 1,
                'status' => 'active',
            ]);
        }
    }

    private function testimonials(): void
    {
        $testimonials = [
            ['client_name' => 'William Lowe', 'position' => 'CEO', 'company' => 'Peerspark', 'avatar' => 'img/avatar/avatar-1.jpg'],
            ['client_name' => 'Sarah Mitchell', 'position' => 'Facilities Director', 'company' => 'Brightline', 'avatar' => 'img/avatar/avatar-2.jpg'],
        ];

        foreach ($testimonials as $i => $testimonial) {
            Testimonial::firstOrCreate(['client_name' => $testimonial['client_name']], $testimonial + [
                'testimonial' => 'Their team brought a wealth of experience and skill to our project. From the first site survey to the final handover, every detail was handled professionally.',
                'company_logo' => 'img/brand/brand-1.png',
                'rating' => 5,
                'is_featured' => true,
                'status' => 'approved',
                'order' => $i + 1,
            ]);
        }
    }

    private function partners(): void
    {
        foreach (range(2, 8) as $order => $n) {
            Partner::firstOrCreate(['name' => "Partner {$n}"], [
                'logo' => "img/brand/brand-{$n}.png",
                'status' => 'active',
                'order' => $order + 1,
            ]);
        }
    }

    private function blogPosts(): void
    {
        $author = User::orderBy('id')->first();
        if (!$author) {
            return;
        }

        $category = BlogCategory::firstOrCreate(['slug' => 'solar-energy'], ['name' => 'Solar Energy']);

        $posts = [
            ['title' => 'Solar Power for a Cleaner, Brighter World', 'reading_time' => 3],
            ['title' => 'Solar Symphony: Harmony in Sustainability', 'reading_time' => 11],
            ['title' => 'Exploring the Bright Future of Solar Energy', 'reading_time' => 15],
        ];

        foreach ($posts as $i => $post) {
            BlogPost::withTrashed()->firstOrCreate(['slug' => Str::slug($post['title'])], $post + [
                'author_id' => $author->id,
                'category_id' => $category->id,
                'excerpt' => 'How solar energy is helping homes and businesses cut costs and emissions.',
                'content' => "Solar energy has become one of the most affordable sources of electricity.\n\nIn this article we look at how modern panels, inverters and batteries work together, and what to consider before installing a system.",
                'featured_image' => 'img/blog/blog-' . ($i + 1) . '.jpg',
                'status' => 'published',
                'publish_date' => now()->subDays(($i + 1) * 5),
            ]);
        }
    }
}
