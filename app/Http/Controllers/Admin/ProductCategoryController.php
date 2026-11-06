<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductCategory;

class ProductCategoryController extends CategoryController
{
    protected function model(): string
    {
        return ProductCategory::class;
    }

    protected function config(): array
    {
        return [
            'route' => 'admin.product-categories',
            'title' => 'Product Categories',
            'singular' => 'Product Category',
            'items' => 'products',
            'items_route' => 'admin.products.index',
            'frontend' => 'products.category',
            'icon' => false,
        ];
    }
}
