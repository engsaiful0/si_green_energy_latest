<?php

namespace App\Models;

use App\Support\Media;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'logo_dark',
        'website_url',
        'description',
        'is_featured',
        'order',
        'status',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function logoUrl(): string
    {
        return Media::url($this->logo);
    }

    public function darkLogoUrl(): string
    {
        return Media::url($this->logo_dark);
    }
}
