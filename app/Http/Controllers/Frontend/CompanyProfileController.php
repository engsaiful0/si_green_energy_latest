<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\PageSections;
use App\Support\SectionData;
use App\Support\Seo;

class CompanyProfileController extends Controller
{
    public function show()
    {
        $page = 'company-profile';
        $settings = PageSections::settings($page);
        $sections = PageSections::visible($page);
        $data = SectionData::load($page, $sections);
        $seo = Seo::page($page);

        return view('frontend.company-profile.show', compact('page', 'settings', 'sections', 'data', 'seo'));
    }
}
