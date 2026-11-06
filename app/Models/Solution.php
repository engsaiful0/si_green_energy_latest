<?php

namespace App\Models;

use App\Models\Concerns\IsCatalogItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solution extends Model
{
    use HasFactory, SoftDeletes, IsCatalogItem;

    public const FEATURES_COLUMN = 'features';

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'icon',
        'short_description',
        'description',
        'features',
        'applications',
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
        'applications' => 'array',
        'is_featured' => 'boolean',
        'order' => 'integer',
        'views' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(SolutionCategory::class);
    }
}
