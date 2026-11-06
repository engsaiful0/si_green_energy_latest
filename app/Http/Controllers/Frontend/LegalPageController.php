<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\PageSections;
use App\Support\Seo;

/**
 * Privacy policy and terms pages, edited in the page CMS.
 */
class LegalPageController extends Controller
{
    public function show(string $page)
    {
        $settings = PageSections::settings($page);
        $sections = PageSections::visible($page);
        $data = [];
        $seo = Seo::page($page);

        return view('frontend.legal.show', compact('page', 'settings', 'sections', 'data', 'seo'));
    }
}
