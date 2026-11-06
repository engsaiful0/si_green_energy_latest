<?php

namespace App\Models;

use App\Support\Media;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'client_name',
        'project_date',
        'location',
        'budget',
        'short_description',
        'description',
        'challenge',
        'solution',
        'results',
        'featured_image',
        'video_url',
        'website_url',
        'is_featured',
        'status',
        'meta_title',
        'meta_description',
        'views',
    ];

    protected $casts = [
        'project_date' => 'date',
        'budget' => 'decimal:2',
        'is_featured' => 'boolean',
        'views' => 'integer',
    ];

    /**
     * Get the category that owns the project.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    /**
     * Get the images for the project.
     */
    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('order')->orderBy('id');
    }

    /**
     * The tags that belong to the project.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(ProjectTag::class, 'project_tag');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function imageUrl(): string
    {
        return Media::url($this->featured_image);
    }
}
