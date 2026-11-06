<?php

namespace App\Support;

use App\Models\BlogPost;
use App\Models\GalleryImage;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Service;
use App\Models\Slider;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Support\Collection;

/**
 * Records listed by CMS sections that have a "source" (only queried for visible sections).
 */
class SectionData
{
    /**
     * @param  Collection  $sections  visible PageSection rows of one page
     * @return array<string, Collection>  section_key => records
     */
    public static function load(string $page, Collection $sections): array
    {
        $data = [];

        foreach ($sections as $section) {
            $source = PageSections::definition($page, $section->section_key)['source'] ?? null;
            $data[$section->section_key] = $source ? static::records($source, $section->content) : collect();
        }

        return $data;
    }

    public static function records(string $source, array $content): Collection
    {
        $limit = max(1, (int) ($content['limit'] ?? 6));

        return match ($source) {
            'sliders' => Slider::active()->orderBy('order')->orderBy('id')->get(),
            'services' => Service::published()->ordered()->take($limit)->get(),
            'projects' => Project::published()->with('category')
                ->orderByDesc('is_featured')->orderByDesc('project_date')->latest()
                ->take($limit)->get(),
            'team' => TeamMember::active()
                ->orderByDesc('is_featured')->orderBy('order')->orderBy('id')
                ->take($limit)->get(),
            'testimonials' => Testimonial::approved()
                ->orderByDesc('is_featured')->orderBy('order')->latest()
                ->take($limit)->get(),
            'partners' => Partner::active()->orderBy('order')->orderBy('id')->take($limit)->get(),
            'blog' => BlogPost::published()->latest('publish_date')->take($limit)->get(),
            'gallery' => GalleryImage::published()->onHome()->with('category')->take($limit)->get(),
            default => collect(),
        };
    }
}
