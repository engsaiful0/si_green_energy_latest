<?php

namespace App\Http\Controllers\Admin;

use App\Models\Solution;
use App\Models\SolutionCategory;

class SolutionController extends CatalogItemController
{
    protected function model(): string
    {
        return Solution::class;
    }

    protected function categoryModel(): string
    {
        return SolutionCategory::class;
    }

    protected function config(): array
    {
        return [
            'route' => 'admin.solutions',
            'title' => 'Solutions',
            'singular' => 'Solution',
            'folder' => 'solutions',
            'frontend' => 'solutions.show',
            'categories_route' => 'admin.solution-categories.index',
            'content_page' => 'solutions',
            'icon' => 'optional',
            'price' => null,
            'features_column' => 'features',
            'show_route' => false,
        ];
    }
}
