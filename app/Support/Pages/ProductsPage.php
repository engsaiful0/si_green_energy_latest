<?php

namespace App\Support\Pages;

class ProductsPage extends CatalogPage
{
    protected static function label(): string
    {
        return 'Products';
    }

    protected static function singular(): string
    {
        return 'Product';
    }

    protected static function route(): string
    {
        return 'products';
    }
}
