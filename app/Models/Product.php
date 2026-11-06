<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'features',
        'specifications',
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
