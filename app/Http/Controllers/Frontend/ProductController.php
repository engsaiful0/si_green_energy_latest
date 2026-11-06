<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends CatalogController
{
    protected function model(): string
    {
        return Product::class;
    }

    protected function categoryModel(): string
    {
        return ProductCategory::class;
    }

    protected function prefix(): string
    {
        return 'products';
    }

    protected function singular(): string
    {
        return 'Product';
    }
}
