<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends CatalogItemController
{
    protected function model(): string
    {
        return Product::class;
    }

    protected function categoryModel(): string
    {
        return ProductCategory::class;
    }

    protected function config(): array
    {
        return [
            'route' => 'admin.products',
            'title' => 'Products',
            'singular' => 'Product',
            'folder' => 'products',
            'frontend' => 'products.show',
            'categories_route' => 'admin.product-categories.index',
            'content_page' => 'products',
            'icon' => null,
            'price' => 'price',
            'features_column' => 'features',
            'show_route' => false,
        ];
    }
}
