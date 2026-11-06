<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use App\Support\PageSections;
use App\Support\Seo;

/**
 * Solar Design Engineers: listing (team-two.html) and details (team-details.html).
 */
class TeamController extends Controller
{
    public function index(int $columns = 3)
    {
        $members = TeamMember::active()->orderByDesc('is_featured')->orderBy('order')->orderBy('id')->get();
        $settings = PageSections::settings('team');
        $listing = $this->listing();
        $seo = Seo::page('team');

        return view('frontend.team.index', compact('members', 'columns', 'settings', 'listing', 'seo'));
    }

    public function show(string $slug)
    {
        $member = TeamMember::active()->where('slug', $slug)->firstOrFail();
        $settings = PageSections::settings('team');
        $listing = $this->listing();

        $seo = Seo::record($member->full_name . ' - ' . $member->position, $member->meta_title, $member->meta_description, $member->short_bio ?: $member->bio);
        $seo['image'] = $member->photoUrl();

        return view('frontend.team.show', compact('member', 'settings', 'listing', 'seo'));
    }

    private function listing(): array
    {
        return PageSections::sections('team')->firstWhere('section_key', 'listing')->content;
    }
}
