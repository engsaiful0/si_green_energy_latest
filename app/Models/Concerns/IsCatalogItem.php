<?php

namespace App\Models\Concerns;

use App\Support\Media;
use Illuminate\Database\Eloquent\Builder;

/**
 * Shared behaviour of products, services and solutions (published listing + details pages).
 */
trait IsCatalogItem
{
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('is_featured')->orderBy('order')->orderBy('name');
    }

    public function imageUrl(): string
    {
        return Media::url($this->featured_image);
    }

    /**
     * "Price: $1,200" (products) or "Starting from $1,200" (services); null when no price is set.
     */
    public function priceLabel(): ?string
    {
        $attributes = $this->getAttributes();

        if (isset($attributes['price_from'])) {
            return 'Starting from $' . number_format((float) $attributes['price_from'], 2);
        }

        if (isset($attributes['price'])) {
            return 'Price: $' . number_format((float) $attributes['price'], 2);
        }

        return null;
    }

    /**
     * Feature list as plain strings, whatever JSON column the model stores them in.
     */
    public function featureList(): array
    {
        $features = $this->{static::FEATURES_COLUMN} ?? [];

        return array_values(array_filter(array_map(
            fn ($feature) => is_array($feature) ? ($feature['title'] ?? '') : (string) $feature,
            (array) $features
        )));
    }
}
