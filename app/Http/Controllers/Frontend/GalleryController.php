<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Support\PageSections;
use App\Support\Seo;

/**
 * Gallery page: filterable image grid (Slaze project-four portfolio layout) with a lightbox.
 */
class GalleryController extends Controller
{
    public function index()
    {
        $settings = PageSections::settings('gallery');
        $listing = PageSections::sections('gallery')->firstWhere('section_key', 'listing')->content;

        $images = GalleryImage::published()->with('category')->ordered()
            ->take(max(1, (int) $listing['limit']))->get();

        // Only active categories that have published images become filter buttons.
        $categories = GalleryCategory::active()->ordered()->get()
            ->filter(fn ($category) => $images->contains('category_id', $category->id))
            ->values();

        $seo = Seo::page('gallery');

        return view('frontend.gallery.index', compact('settings', 'listing', 'images', 'categories', 'seo'));
    }
}
