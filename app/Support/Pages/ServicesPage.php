<?php

namespace App\Support\Pages;

class ServicesPage extends CatalogPage
{
    protected static function label(): string
    {
        return 'Services';
    }

    protected static function singular(): string
    {
        return 'Service';
    }

    protected static function route(): string
    {
        return 'services';
    }
}
