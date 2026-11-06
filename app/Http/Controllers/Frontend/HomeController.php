<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Service;
use App\Models\Slider;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Support\HomepageSections;

class HomeController extends Controller
{
    public function index()
    {
        $sections = HomepageSections::sections()->where('is_active', true)->values();

        $data = [];
        foreach ($sections as $section) {
            $data[$section->section_key] = $this->records($section->section_key, $section->content);
        }

        return view('frontend.home.index', compact('sections', 'data'));
    }

    /**
     * Records listed by a section (only queried when the section is visible).
     */
    private function records(string $key, array $content)
    {
        $limit = max(1, (int) ($content['limit'] ?? 6));

        return match ($key) {
            'banner' => Slider::active()->orderBy('order')->orderBy('id')->get(),
            'services' => Service::published()
                ->orderByDesc('is_featured')->orderBy('order')->latest()
                ->take($limit)->get(),
            'portfolio' => Project::published()->with('category')
                ->orderByDesc('is_featured')->orderByDesc('project_date')->latest()
                ->take($limit)->get(),
            'team' => TeamMember::active()
                ->orderByDesc('is_featured')->orderBy('order')->orderBy('id')
                ->take($limit)->get(),
            'testimonials' => Testimonial::approved()
                ->orderByDesc('is_featured')->orderBy('order')->latest()
                ->take($limit)->get(),
            'brands' => Partner::active()->orderBy('order')->orderBy('id')->take($limit)->get(),
            'blog' => BlogPost::published()->latest('publish_date')->take($limit)->get(),
            default => collect(),
        };
    }
}
