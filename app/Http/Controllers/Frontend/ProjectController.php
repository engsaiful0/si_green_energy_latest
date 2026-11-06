<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index(int $columns = 4)
    {
        $projects = Project::published()->with('category')
            ->orderByDesc('is_featured')->orderByDesc('project_date')->latest()
            ->paginate(12);

        return view('frontend.pages.projects.index', compact('projects', 'columns'));
    }
}
