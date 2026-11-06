<?php

namespace App\Http\Controllers\Admin;

use App\Models\GalleryCategory;

class GalleryCategoryController extends CategoryController
{
    protected function model(): string
    {
        return GalleryCategory::class;
    }

    protected function config(): array
    {
        return [
            'route' => 'admin.gallery-categories',
            'title' => 'Gallery Categories',
            'singular' => 'Gallery Category',
            'items' => 'images',
            'items_route' => 'admin.gallery.index',
            'frontend' => null,
            'icon' => false,
        ];
    }
}
