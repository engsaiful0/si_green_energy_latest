<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\PageSection;
use App\Models\Partner;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Solution;
use App\Models\SolutionCategory;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use App\Support\PageSections;
use App\Support\SiteSettings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Initial Si Green Energy content: branded page content, sliders, product / service /
 * solution catalogs and blog articles (database/data/*.php).
 *
 * - Removes the template's demo records (fake team members, testimonials, partner logos,
 *   projects and demo catalog entries) so nothing is presented as Si Green Energy's own.
 * - Creates records with firstOrCreate, so admin edits are never overwritten on re-runs.
 * - Resets the CMS page sections to the branded defaults once (tracked by a settings flag).
 */
class SiGreenEnergyContentSeeder extends Seeder
{
    private const BRANDING_FLAG = 'content.si_green_energy_v1';

    public function run(): void
    {
        DB::transaction(function () {
            $this->removeTemplateDemoContent();
            $this->pages();
            $this->sliders();
            $this->catalog();
            $this->blog();
        });

        SiteSettings::flush();
    }

    /**
     * Template demo records that must not appear as Si Green Energy content.
     */
    private function removeTemplateDemoContent(): void
    {
        $demo = [
            Product::class => ['mono-perc-panel-550w', 'bifacial-panel-600w', 'hybrid-inverter-5kw', 'lithium-battery-5kwh', 'test-charge-controller'],
            Service::class => ['hydropower-solutions', 'wind-turbines', 'solar-panel-services', 'solar-installation', 'sun-power-solutions', 'maintenance-support', 'battery-storage'],
            Solution::class => ['rooftop-solar-systems', 'hybrid-home-systems', 'factory-rooftop-plants', 'solar-irrigation-pumps', 'battery-energy-storage', 'off-grid-power-kits', 'village-microgrid'],
            BlogPost::class => ['solar-power-for-a-cleaner-brighter-world', 'solar-symphony-harmony-in-sustainability', 'exploring-the-bright-future-of-solar-energy', 'net-metering-explained', 'future-post'],
            Project::class => ['sun-power-hub', 'sunwave-solar-tech', 'sunspark-modules', 'ecoharvest-panels', 'solar-bliss-haven'],
            TeamMember::class => ['steve-rhodes', 'derya-kurtulus', 'lisa-thompson', 'david-martinez'],
        ];

        foreach ($demo as $model => $slugs) {
            $model::withTrashed()->whereIn('slug', $slugs)->get()->each(function ($record) {
                if ($record instanceof BlogPost) {
                    $record->tags()->detach();
                }
                $record->forceDelete();
            });
        }

        Testimonial::whereIn('client_name', ['William Lowe', 'Sarah Mitchell'])->delete();
        Partner::where('name', 'like', 'Partner %')->where('logo', 'like', 'img/brand/%')->delete();
        Slider::whereIn('title', ["Eco Friendly\nPower", "Largest\nSolar Energy"])->delete();

        // Demo categories, once nothing is assigned to them any more.
        $demoCategories = [
            ProjectCategory::class => ['eco-innovate', 'ecobright-panels', 'solar-radiance', 'sustainable-suns', 'clean-charge'],
            ServiceCategory::class => ['residential', 'commercial'],
            SolutionCategory::class => ['residential-solar', 'commercial-industrial', 'energy-storage', 'test-microgrids'],
            ProductCategory::class => ['inverters', 'batteries'],
            BlogCategory::class => ['solar-energy'],
        ];
        foreach ($demoCategories as $model => $slugs) {
            $model::whereIn('slug', $slugs)->get()
                ->filter(fn ($category) => $category->items()->getQuery()->withoutGlobalScopes()->count() === 0)
                ->each->delete();
        }

        BlogTag::doesntHave('posts')->delete();
    }

    /**
     * Branded page content (once) and any missing sections such as the new CTAs.
     */
    private function pages(): void
    {
        $alreadyApplied = Setting::where('key', self::BRANDING_FLAG)->exists();

        foreach (array_keys(PageSections::pages()) as $page) {
            PageSections::ensureExists($page);

            if ($alreadyApplied) {
                continue;
            }

            foreach (PageSection::forPage($page)->get() as $section) {
                if (PageSections::has($page, $section->section_key)) {
                    $section->update([
                        'content' => PageSections::defaults($page, $section->section_key),
                        'section_name' => PageSections::definition($page, $section->section_key)['name'],
                        'is_active' => true,
                    ]);
                }
            }
        }

        // Site settings fall back to the official details in App\Support\Company.
        if (!$alreadyApplied) {
            Setting::where('group', 'site')->delete();
            Setting::set(self::BRANDING_FLAG, now()->toDateTimeString(), 'text', 'system');
        }
    }

    private function sliders(): void
    {
        $slides = [
            ['title' => "Clean Solar Power\nfor Bangladesh", 'subtitle' => 'Si Green Energy', 'description' => 'Solar systems for homes, businesses and industry, designed and installed by our engineering team in Chattogram.', 'button_text' => 'Explore Solutions', 'button_link' => '/solutions', 'background_image' => 'img/banner/banner-1.jpg'],
            ['title' => "Power Through\nLoad-Shedding", 'subtitle' => 'Hybrid & Battery Systems', 'description' => 'Keep essential loads running during power cuts with solar, battery storage and smart hybrid inverters.', 'button_text' => 'Hybrid Solutions', 'button_link' => '/solutions/category/hybrid-solar-solutions', 'background_image' => 'img/banner/banner-3.jpg'],
            ['title' => "Solar for Factories\n& Businesses", 'subtitle' => 'Commercial & Industrial', 'description' => 'Rooftop and ground-mounted solar that uses your daytime demand to reduce grid and diesel consumption.', 'button_text' => 'Get a Free Consultation', 'button_link' => '/contact', 'background_image' => 'img/banner/banner-6.jpg'],
        ];

        foreach ($slides as $order => $slide) {
            Slider::firstOrCreate(['title' => $slide['title']], $slide + ['order' => $order + 1, 'is_active' => true]);
        }
    }

    private function catalog(): void
    {
        $data = require database_path('data/catalog.php');

        // Products
        $productCategories = [];
        foreach ($data['product_categories'] as $order => $category) {
            $productCategories[$category['slug']] = ProductCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category + ['order' => $order + 1, 'is_active' => true]
            );
        }
        foreach ($data['products'] as $order => $product) {
            Product::withTrashed()->firstOrCreate(['slug' => Str::slug($product['name'])], [
                'name' => $product['name'],
                'category_id' => $productCategories[$product['category']]->id,
                'short_description' => $product['short'],
                'description' => $product['description'],
                'features' => $product['features'],
                'specifications' => collect($product['specs'])->map(fn ($value, $label) => ['label' => $label, 'value' => $value])->values()->all(),
                'featured_image' => $product['image'],
                'meta_title' => $product['meta_title'],
                'meta_description' => $product['meta_description'],
                'status' => 'published',
                'is_featured' => $order < 4,
                'order' => $order + 1,
            ]);
        }

        // Services
        $serviceCategories = [];
        foreach ($data['service_categories'] as $order => $category) {
            $serviceCategories[$category['slug']] = ServiceCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category + ['order' => $order + 1, 'is_active' => true]
            );
        }
        foreach ($data['services'] as $order => $service) {
            Service::withTrashed()->firstOrCreate(['slug' => Str::slug($service['name'])], [
                'name' => $service['name'],
                'category_id' => $serviceCategories[$service['category']]->id,
                'icon' => $service['icon'],
                'short_description' => $service['short'],
                'description' => $service['description'],
                'benefits' => $service['benefits'],
                'featured_image' => $service['image'],
                'meta_title' => $service['name'] . ' | Si Green Energy',
                'meta_description' => Str::limit($service['short'] . ' Si Green Energy, Chattogram, Bangladesh.', 155, ''),
                'status' => 'published',
                'is_featured' => $order < 6,
                'order' => $order + 1,
            ]);
        }

        // Solutions
        $solutionCategories = [];
        foreach ($data['solution_categories'] as $order => $category) {
            $solutionCategories[$category['slug']] = SolutionCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category + ['order' => $order + 1, 'is_active' => true, 'description' => $category['name'] . ' designed and installed by Si Green Energy.']
            );
        }
        foreach ($data['solutions'] as $order => $solution) {
            Solution::withTrashed()->firstOrCreate(['slug' => Str::slug($solution['name'])], [
                'name' => $solution['name'],
                'category_id' => $solutionCategories[$solution['category']]->id,
                'icon' => $solution['icon'],
                'short_description' => $solution['short'],
                'description' => $solution['description'],
                'features' => $solution['features'],
                'applications' => $solution['applications'],
                'featured_image' => $solution['image'],
                'meta_title' => $solution['name'] . ' in Bangladesh | Si Green Energy',
                'meta_description' => Str::limit($solution['short'] . ' Designed and installed by Si Green Energy.', 155, ''),
                'status' => 'published',
                'is_featured' => $order < 6,
                'order' => $order + 1,
            ]);
        }

        // Use the first solution category image-free; give each category the image of its solution.
        foreach ($data['solutions'] as $solution) {
            $solutionCategories[$solution['category']]->image ??= $solution['image'];
            $solutionCategories[$solution['category']]->save();
        }
    }

    private function blog(): void
    {
        $data = require database_path('data/blog.php');

        $author = User::orderBy('id')->first();
        if (!$author) {
            return;
        }
        if ($author->name === 'Admin User') {
            $author->update(['name' => 'Si Green Energy Team']);
        }

        $categories = [];
        foreach ($data['categories'] as $order => $category) {
            $categories[$category['slug']] = BlogCategory::firstOrCreate(['slug' => $category['slug']], $category + ['order' => $order + 1]);
        }

        foreach ($data['posts'] as $post) {
            $record = BlogPost::withTrashed()->firstOrCreate(['slug' => Str::slug($post['title'])], [
                'author_id' => $author->id,
                'category_id' => $categories[$post['category']]->id,
                'title' => $post['title'],
                'excerpt' => $post['excerpt'],
                'content' => trim($post['content']),
                'featured_image' => $post['image'],
                'status' => 'published',
                'publish_date' => now()->subDays($post['days_ago'])->setTime(10, 0),
                'meta_title' => $post['title'] . ' | Si Green Energy',
                'meta_description' => $post['meta_description'],
            ]);

            if ($record->wasRecentlyCreated) {
                $record->tags()->sync(collect($post['tags'])
                    ->map(fn ($name) => BlogTag::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name])->id)
                    ->all());
            }
        }
    }
}
