<?php

namespace App\Http\Controllers\Admin;

use App\Models\ServiceCategory;

class ServiceCategoryController extends CategoryController
{
    protected function model(): string
    {
        return ServiceCategory::class;
    }

    protected function config(): array
    {
        return [
            'route' => 'admin.service-categories',
            'title' => 'Service Categories',
            'singular' => 'Service Category',
            'items' => 'services',
            'items_route' => 'admin.services.index',
            'frontend' => 'services.category',
            'icon' => true,
        ];
    }
}
