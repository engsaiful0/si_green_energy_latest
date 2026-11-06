<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Project;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Solution;
use App\Models\SolutionCategory;
use App\Models\TeamMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Sample categories, solutions, products and details for the inner pages.
 * Safe to run more than once: only missing records/fields are filled in.
 */
class CatalogContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->services();
        $this->solutions();
        $this->products();
        $this->projects();
        $this->team();
        $this->blogTags();
    }

    private function category(string $model, string $name, int $order, array $extra = [])
    {
        return $model::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'order' => $order, 'is_active' => true] + $extra);
    }

    private function services(): void
    {
        $residential = $this->category(ServiceCategory::class, 'Residential', 1, ['icon' => 'flaticon-solar-panel', 'description' => 'Solar services for homes.']);
        $commercial = $this->category(ServiceCategory::class, 'Commercial', 2, ['icon' => 'flaticon-solar-panels', 'description' => 'Solar services for businesses and industry.']);

        $assign = ['hydropower-solutions' => $commercial, 'wind-turbines' => $commercial, 'solar-panel-services' => $residential];
        foreach ($assign as $slug => $category) {
            Service::where('slug', $slug)->whereNull('category_id')->update(['category_id' => $category->id]);
        }

        $extra = [
            ['name' => 'Solar Installation', 'icon' => 'flaticon-energy', 'image' => 'img/service/service-4.jpg', 'category' => $residential, 'short' => 'Transform your space into an eco-friendly powerhouse.'],
            ['name' => 'Sun Power Solutions', 'icon' => 'flaticon-solar-panels', 'image' => 'img/service/service-5.jpg', 'category' => $commercial, 'short' => 'Empower your business with innovative solar power.'],
            ['name' => 'Maintenance & Support', 'icon' => 'flaticon-system', 'image' => 'img/service/service-6.jpg', 'category' => $residential, 'short' => 'Reliable inspection, cleaning and repair for your system.'],
        ];
        foreach ($extra as $i => $service) {
            Service::withTrashed()->firstOrCreate(['slug' => Str::slug($service['name'])], [
                'name' => $service['name'],
                'category_id' => $service['category']->id,
                'icon' => $service['icon'],
                'short_description' => $service['short'],
                'description' => "{$service['short']}\n\nOur certified team handles everything from the first site survey to commissioning and aftercare.",
                'benefits' => ['Well Experienced', 'Client Satisfaction', 'Global Expertise'],
                'featured_image' => $service['image'],
                'status' => 'published',
                'order' => 10 + $i,
            ]);
        }
    }

    private function solutions(): void
    {
        $categories = [
            'Residential Solar' => ['icon' => 'flaticon-solar-panel', 'image' => 'img/service/service-1.jpg'],
            'Commercial & Industrial' => ['icon' => 'flaticon-solar-panels', 'image' => 'img/service/service-2.jpg'],
            'Energy Storage' => ['icon' => 'flaticon-battery-charge', 'image' => 'img/service/service-3.jpg'],
        ];

        $order = 0;
        foreach ($categories as $name => $extra) {
            $categories[$name] = $this->category(SolutionCategory::class, $name, ++$order, $extra + ['description' => "{$name} solutions designed and installed by SI Green Energy."]);
        }

        $solutions = [
            ['Rooftop Solar Systems', 'Residential Solar', 'flaticon-solar-panel', 'img/service/service-1.jpg', 'Grid-tied rooftop systems that cut household electricity bills.'],
            ['Hybrid Home Systems', 'Residential Solar', 'flaticon-renewable-energy', 'img/service/service-4.jpg', 'Solar plus battery systems that keep your home powered during outages.'],
            ['Factory Rooftop Plants', 'Commercial & Industrial', 'flaticon-solar-panels', 'img/service/service-2.jpg', 'Large rooftop plants that lower operating costs for factories and warehouses.'],
            ['Solar Irrigation Pumps', 'Commercial & Industrial', 'flaticon-ecology', 'img/service/service-5.jpg', 'Diesel-free irrigation powered directly by the sun.'],
            ['Battery Energy Storage', 'Energy Storage', 'flaticon-battery-charge', 'img/service/service-3.jpg', 'Lithium storage that shifts solar energy to the evening peak.'],
            ['Off-grid Power Kits', 'Energy Storage', 'flaticon-power', 'img/service/service-6.jpg', 'Complete off-grid kits for remote homes, shops and telecom sites.'],
        ];

        foreach ($solutions as $i => [$name, $category, $icon, $image, $short]) {
            Solution::withTrashed()->firstOrCreate(['slug' => Str::slug($name)], [
                'name' => $name,
                'category_id' => $categories[$category]->id,
                'icon' => $icon,
                'short_description' => $short,
                'description' => "{$short}\n\nEach system is sized from your actual consumption, installed by certified engineers and monitored remotely.",
                'features' => ['Free site assessment', 'Tier-1 equipment', 'Remote monitoring', '25-year performance warranty'],
                'featured_image' => $image,
                'status' => 'published',
                'is_featured' => $i < 3,
                'order' => $i + 1,
            ]);
        }
    }

    private function products(): void
    {
        $panels = $this->category(ProductCategory::class, 'Solar Panels', 1, ['description' => 'Monocrystalline and bifacial solar panels.']);
        $inverters = $this->category(ProductCategory::class, 'Inverters', 2, ['description' => 'On-grid, off-grid and hybrid inverters.']);
        $batteries = $this->category(ProductCategory::class, 'Batteries', 3, ['description' => 'Lithium and gel batteries for solar storage.']);

        $products = [
            ['Mono PERC Panel 550W', $panels, 'img/service/service-1.jpg', 189],
            ['Bifacial Panel 600W', $panels, 'img/service/service-2.jpg', 229],
            ['Hybrid Inverter 5kW', $inverters, 'img/service/service-4.jpg', 1150],
            ['Lithium Battery 5kWh', $batteries, 'img/service/service-3.jpg', 1890],
        ];

        foreach ($products as $i => [$name, $category, $image, $price]) {
            Product::withTrashed()->firstOrCreate(['slug' => Str::slug($name)], [
                'name' => $name,
                'category_id' => $category->id,
                'short_description' => "High-efficiency {$name} with manufacturer warranty.",
                'description' => "The {$name} is selected for reliability in local conditions and installed by our certified team.",
                'features' => ['Manufacturer warranty', 'Certified installation', 'After-sales support'],
                'price' => $price,
                'featured_image' => $image,
                'status' => 'published',
                'order' => $i + 1,
            ]);
        }
    }

    private function projects(): void
    {
        foreach (Project::with('images')->get() as $i => $project) {
            $project->fill(array_filter([
                'client_name' => $project->client_name ?: 'Private Client',
                'location' => $project->location ?: 'New Jersey, USA',
                'challenge' => $project->challenge ?: "The client needed to cut rising energy costs without interrupting daily operations.\n\nThe roof had limited space and partial shading in the afternoon.",
                'solution' => $project->solution ?: 'We designed a high-density layout with optimisers on the shaded strings and installed it in phases over two weekends.',
                'results' => $project->results ?: 'The system now covers around 70% of daytime demand and pays for itself in under six years.',
            ]))->save();

            if ($project->images->isEmpty()) {
                foreach ([9, 10, 11] as $order => $n) {
                    $project->images()->create(['image_path' => "img/portfolio/portfolio-{$n}.jpg", 'alt_text' => $project->name, 'order' => $order + 1]);
                }
            }
        }
    }

    private function team(): void
    {
        foreach (TeamMember::all() as $member) {
            $member->fill(array_filter([
                'bio' => $member->bio ?: "{$member->full_name} has spent over a decade designing and delivering solar systems for homes and businesses.\n\nFrom feasibility studies to commissioning, {$member->full_name} makes sure every system performs as promised.",
                'short_bio' => $member->short_bio ?: "{$member->position} at SI Green Energy.",
                'qualifications' => $member->qualifications ?: "B.Sc. in Electrical Engineering\nCertified PV Installation Professional\nOccupational Health & Safety Certificate",
                'experience_years' => $member->experience_years ?: 10,
                'email' => $member->email ?: Str::slug($member->full_name, '.') . '@sigreenenergy.com',
            ]));
            if (empty($member->skills)) {
                $member->skills = [
                    ['label' => 'Solar System Design', 'percent' => 95],
                    ['label' => 'Project Management', 'percent' => 88],
                    ['label' => 'Energy Storage', 'percent' => 76],
                ];
            }
            $member->save();
        }
    }

    private function blogTags(): void
    {
        $tags = collect(['Solar Panel', 'Energy', 'Renewable', 'Batteries'])
            ->map(fn ($name) => BlogTag::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name])->id);

        foreach (BlogPost::doesntHave('tags')->get() as $post) {
            $post->tags()->sync($tags->random(2)->all());
        }
    }
}
