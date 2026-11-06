<?php

namespace App\Http\Controllers\Admin;

use App\Models\SolutionCategory;

class SolutionCategoryController extends CategoryController
{
    protected function model(): string
    {
        return SolutionCategory::class;
    }

    protected function config(): array
    {
        return [
            'route' => 'admin.solution-categories',
            'title' => 'Solution Categories',
            'singular' => 'Solution Category',
            'items' => 'solutions',
            'items_route' => 'admin.solutions.index',
            'frontend' => 'solutions.category',
            'icon' => true,
        ];
    }
}
