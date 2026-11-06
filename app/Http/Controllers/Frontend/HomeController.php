<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\Company;
use App\Support\PageSections;
use App\Support\SectionData;
use App\Support\Seo;

class HomeController extends Controller
{
    public function index()
    {
        $sections = PageSections::visible('home');
        $data = SectionData::load('home', $sections);
        $seo = Seo::page('home', Company::TAGLINE);

        return view('frontend.home.index', compact('sections', 'data', 'seo'));
    }
}
