<?php

namespace App\Models\Concerns;

use App\Support\Media;
use Illuminate\Database\Eloquent\Builder;

/**
 * Shared behaviour of the product / service / solution / project category models.
 * The model must define items(): the relation to the records assigned to the category.
 */
trait IsCategory
{
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order')->orderBy('name');
    }

    public function imageUrl(?string $fallback = null): string
    {
        return Media::url($this->image ?? null, $fallback);
    }
}
