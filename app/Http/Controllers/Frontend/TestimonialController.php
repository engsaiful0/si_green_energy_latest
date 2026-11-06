<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Support\PageSections;
use App\Support\Seo;

class TestimonialController extends Controller
{
    public function index()
    {
        $settings = PageSections::settings('testimonials');
        $listing = PageSections::sections('testimonials')->firstWhere('section_key', 'listing')->content;

        $testimonials = Testimonial::approved()
            ->orderByDesc('is_featured')->orderBy('order')->latest()
            ->paginate(max(1, (int) $listing['per_page']));

        $seo = Seo::page('testimonials');

        return view('frontend.testimonials.index', compact('settings', 'listing', 'testimonials', 'seo'));
    }
}
