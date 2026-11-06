<?php

namespace App\Models;

use App\Models\Concerns\IsCatalogItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, IsCatalogItem;

    public const FEATURES_COLUMN = 'features';

    protected $fillable = [
        'category_id',
        'name',
        'brand',
        'model',
        'slug',
        'short_description',
        'description',
        'features',
        'specifications',
        'applications',
        'manufacturer_url',
        'datasheet_url',
        'source_url',
        'price',
        'featured_image',
        'is_featured',
        'status',
        'meta_title',
        'meta_description',
        'order',
        'views',
    ];

    protected $casts = [
        'features' => 'array',
        'specifications' => 'array',
        'applications' => 'array',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'order' => 'integer',
        'views' => 'integer',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    /**
     * Get the images for the product.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
