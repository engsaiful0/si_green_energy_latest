<?php

namespace Database\Seeders;

use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Models\PageSection;
use App\Models\Setting;
use App\Support\PageSections;
use Illuminate\Database\Seeder;

/**
 * Gallery categories and demonstration images.
 *
 * The images are licensed stock photographs from the website template, used for
 * demonstration only. They are NOT photos of Si Green Energy projects, which is
 * stated in each image description; replace them with real project photos.
 */
class GallerySeeder extends Seeder
{
    private const HOME_LAYOUT_FLAG = 'content.home_layout_gallery_v1';

    private const DEMO_NOTE = 'Demonstration image (stock photograph), not a Si Green Energy project.';

    public function run(): void
    {
        $categories = [];
        foreach ([
            'Solar Panel Installation', 'Industrial Solar Projects', 'Commercial Solar Projects', 'Residential Solar Projects',
            'Solar Equipment', 'Engineering & Installation', 'Company Activities',
        ] as $order => $name) {
            $slug = \Illuminate\Support\Str::slug($name);
            $categories[$slug] = GalleryCategory::firstOrCreate(['slug' => $slug], ['name' => $name, 'order' => $order + 1, 'is_active' => true]);
        }

        $images = [
            ['solar-panel-installation', 'img/about/about-5.jpg', 'Fixing solar panels on a rooftop'],
            ['solar-panel-installation', 'img/about/about-4.jpg', 'Mounting a solar module'],
            ['solar-panel-installation', 'img/blog/blog-d-1.jpg', 'Installer working on a solar array'],
            ['solar-panel-installation', 'img/pages/experience.jpg', 'Panel installation at height'],
            ['industrial-solar-projects', 'img/banner/banner-4.jpg', 'Ground-mounted solar array'],
            ['industrial-solar-projects', 'img/banner/banner-6.jpg', 'Large solar plant in operation'],
            ['industrial-solar-projects', 'img/portfolio/portfolio-9.jpg', 'Rooftop solar in an urban area'],
            ['commercial-solar-projects', 'img/portfolio/portfolio-6.jpg', 'Commercial rooftop solar inspection'],
            ['commercial-solar-projects', 'img/blog/blog-6.jpg', 'Engineers reviewing a rooftop system'],
            ['commercial-solar-projects', 'img/portfolio/portfolio-3.jpg', 'Solar array site visit'],
            ['residential-solar-projects', 'img/about/about-6.jpg', 'Residential rooftop installation'],
            ['residential-solar-projects', 'img/pages/who-we-2.jpg', 'Solar panels on a house roof'],
            ['solar-equipment', 'img/service/service-1.jpg', 'Monocrystalline solar panels'],
            ['solar-equipment', 'img/service/service-4.jpg', 'Solar modules in a field array'],
            ['engineering-installation', 'img/pages/work-1.jpg', 'Site survey and planning'],
            ['engineering-installation', 'img/pages/work-2.jpg', 'System design review'],
            ['engineering-installation', 'img/pages/consultation.jpg', 'Engineering discussion on site'],
            ['engineering-installation', 'img/blog/blog-3.jpg', 'Testing a solar installation'],
            ['company-activities', 'img/pages/choose-us-1.jpg', 'Team at work on a solar roof'],
            ['company-activities', 'img/portfolio/portfolio-4.jpg', 'Planning meeting at a solar site'],
        ];

        foreach ($images as $order => [$category, $path, $title]) {
            GalleryImage::firstOrCreate(['image' => $path], [
                'category_id' => $categories[$category]->id,
                'title' => $title,
                'description' => self::DEMO_NOTE,
                'alt_text' => $title,
                'status' => 'published',
                'is_featured' => $order < 4,
                'show_on_home' => $order % 2 === 0, // 10 images in the homepage carousel
                'home_order' => $order + 1,
                'order' => $order + 1,
            ]);
        }

        $this->placeHomeGalleryOnce();
    }

    /**
     * Put the new homepage gallery section in its intended place (once, so admin ordering is kept).
     */
    private function placeHomeGalleryOnce(): void
    {
        if (Setting::where('key', self::HOME_LAYOUT_FLAG)->exists()) {
            return;
        }

        PageSections::ensureExists('home');

        $position = 0;
        foreach (array_keys(PageSections::definitions('home')) as $key) {
            PageSection::forPage('home')->where('section_key', $key)
                ->update(['order' => $key === PageSections::PAGE_SETTINGS ? 0 : ++$position]);
        }

        Setting::set(self::HOME_LAYOUT_FLAG, now()->toDateTimeString(), 'text', 'system');
    }
}
