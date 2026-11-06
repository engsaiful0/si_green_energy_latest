<?php

namespace App\Support\Pages;

class SolutionsPage extends CatalogPage
{
    protected static function label(): string
    {
        return 'Solutions';
    }

    protected static function singular(): string
    {
        return 'Solution';
    }

    protected static function route(): string
    {
        return 'solutions';
    }
}
