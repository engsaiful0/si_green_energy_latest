<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProjectCategory;

class ProjectCategoryController extends CategoryController
{
    protected function model(): string
    {
        return ProjectCategory::class;
    }

    protected function config(): array
    {
        return [
            'route' => 'admin.project-categories',
            'title' => 'Project Categories',
            'singular' => 'Project Category',
            'items' => 'projects',
            'items_route' => 'admin.projects.index',
            'frontend' => null,
            'icon' => false,
        ];
    }
}
