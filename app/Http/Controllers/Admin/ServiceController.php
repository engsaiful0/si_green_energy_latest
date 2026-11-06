<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use App\Models\ServiceCategory;

class ServiceController extends CatalogItemController
{
    protected function model(): string
    {
        return Service::class;
    }

    protected function categoryModel(): string
    {
        return ServiceCategory::class;
    }

    protected function config(): array
    {
        return [
            'route' => 'admin.services',
            'title' => 'Services',
            'singular' => 'Service',
            'folder' => 'services',
            'frontend' => 'services.show',
            'categories_route' => 'admin.service-categories.index',
            'content_page' => 'services',
            'icon' => 'required',
            'price' => 'price_from',
            'features_column' => 'benefits',
            'show_route' => true,
        ];
    }

    public function show(string $id)
    {
        $service = $this->find($id)->load('category', 'images');

        return view('admin.services.show', compact('service'));
    }
}
