<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'page_key',
        'section_key',
        'section_name',
        'content',
        'is_active',
        'order',
    ];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Sections of the homepage.
     */
    public function scopeHomepage(Builder $query): Builder
    {
        return $query->forPage('home');
    }

    /**
     * Sections of a CMS-managed page (see App\Support\PageSections).
     */
    public function scopeForPage(Builder $query, string $page): Builder
    {
        return $query->whereNull('page_id')->where('page_key', $page);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
