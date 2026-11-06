<?php

namespace App\Models;

use App\Support\Media;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One gallery image. The same records feed the Gallery page and, when show_on_home is set,
 * the homepage gallery carousel (ordered by home_order).
 */
class GalleryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'image',
        'alt_text',
        'is_featured',
        'show_on_home',
        'home_order',
        'order',
        'status',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'show_on_home' => 'boolean',
        'home_order' => 'integer',
        'order' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(GalleryCategory::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    /** Gallery page order: featured first, then manual order. */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('is_featured')->orderBy('order')->orderByDesc('id');
    }

    /** Images selected for the homepage carousel, in carousel order. */
    public function scopeOnHome(Builder $query): Builder
    {
        return $query->where('show_on_home', true)->orderBy('home_order')->orderBy('id');
    }

    public function imageUrl(): string
    {
        return Media::url($this->image);
    }

    public function altText(): string
    {
        return $this->alt_text ?: $this->title;
    }
}
