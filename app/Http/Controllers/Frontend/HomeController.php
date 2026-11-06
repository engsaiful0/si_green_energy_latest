<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\PageSections;
use App\Support\SectionData;
use App\Support\Seo;

class HomeController extends Controller
{
    public function index()
    {
        $sections = PageSections::visible('home');
        $data = SectionData::load('home', $sections);
        $seo = Seo::page('home', \App\Support\SiteSettings::get('site_name') . ' - Solar & Renewable Energy');

        return view('frontend.home.index', compact('sections', 'data', 'seo'));
    }
}
