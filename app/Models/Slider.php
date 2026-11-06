<?php

namespace App\Models;

use App\Support\Media;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'button_text',
        'button_link',
        'background_image',
        'background_image_dark',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function imageUrl(): string
    {
        return $this->resolveUrl($this->background_image);
    }

    public function darkImageUrl(): string
    {
        return $this->resolveUrl($this->background_image_dark);
    }

    private function resolveUrl(?string $path): string
    {
        return Media::url($path);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
