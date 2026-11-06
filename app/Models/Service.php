<?php

namespace App\Models;

use App\Support\Media;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'benefits',
        'process_steps',
        'icon',
        'featured_image',
        'layout',
        'is_featured',
        'price_from',
        'status',
        'meta_title',
        'meta_description',
        'order',
        'views',
    ];

    protected $casts = [
        'benefits' => 'array',
        'process_steps' => 'array',
        'price_from' => 'decimal:2',
        'is_featured' => 'boolean',
        'order' => 'integer',
        'views' => 'integer',
    ];

    /**
     * Get the category that owns the service.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    /**
     * Get the images for the service.
     */
    public function images()
    {
        return $this->hasMany(ServiceImage::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function imageUrl(): string
    {
        return Media::url($this->featured_image);
    }

    /**
     * Benefits as newline-separated text (used by the admin form and service pages).
     */
    public function getFeaturesAttribute(): ?string
    {
        return $this->benefits ? implode("
", $this->benefits) : null;
    }

    /**
     * Formatted starting price, e.g. "$1,500".
     */
    public function getPriceAttribute(): ?string
    {
        return $this->price_from !== null ? '$' . number_format((float) $this->price_from, 0) : null;
    }
}
