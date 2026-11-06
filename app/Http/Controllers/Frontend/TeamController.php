<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;

class TeamController extends Controller
{
    public function index(int $columns = 3)
    {
        $members = TeamMember::active()->orderByDesc('is_featured')->orderBy('order')->orderBy('id')->get();

        return view('frontend.pages.team.index', compact('members', 'columns'));
    }
}
