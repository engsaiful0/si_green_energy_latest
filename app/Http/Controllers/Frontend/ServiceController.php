<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Service;
use App\Models\ServiceCategory;

class ServiceController extends CatalogController
{
    protected function model(): string
    {
        return Service::class;
    }

    protected function categoryModel(): string
    {
        return ServiceCategory::class;
    }

    protected function prefix(): string
    {
        return 'services';
    }

    protected function singular(): string
    {
        return 'Service';
    }
}
