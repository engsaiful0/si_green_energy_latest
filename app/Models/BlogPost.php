<?php

namespace App\Models;

use App\Support\Media;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'layout',
        'is_featured',
        'reading_time',
        'status',
        'publish_date',
        'meta_title',
        'meta_description',
        'views',
        'likes',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'reading_time' => 'integer',
        'publish_date' => 'datetime',
        'views' => 'integer',
        'likes' => 'integer',
    ];

    /**
     * Get the author that owns the blog post.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the category that owns the blog post.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }

    /**
     * The tags that belong to the blog post.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag', 'post_id', 'tag_id');
    }

    /**
     * Posts that are published and whose publish date has passed.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')->where('publish_date', '<=', now());
    }

    /**
     * Alias kept for views that read "published_at"; the column is publish_date.
     */
    public function getPublishedAtAttribute()
    {
        return $this->publish_date;
    }

    public function imageUrl(): string
    {
        return Media::url($this->featured_image);
    }

    /**
     * Reading time in minutes, estimated from the content when not set.
     */
    public function readingMinutes(): int
    {
        return $this->reading_time ?: max(1, (int) ceil(str_word_count(strip_tags((string) $this->content)) / 200));
    }
}
