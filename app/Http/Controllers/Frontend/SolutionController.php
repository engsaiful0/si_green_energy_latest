<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Solution;
use App\Models\SolutionCategory;

class SolutionController extends CatalogController
{
    protected function model(): string
    {
        return Solution::class;
    }

    protected function categoryModel(): string
    {
        return SolutionCategory::class;
    }

    protected function prefix(): string
    {
        return 'solutions';
    }

    protected function singular(): string
    {
        return 'Solution';
    }
}
