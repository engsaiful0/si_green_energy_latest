<?php

namespace App\Models;

use App\Support\Media;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'position',
        'company',
        'company_logo',
        'rating',
        'testimonial',
        'avatar',
        'is_featured',
        'status',
        'order',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function avatarUrl(): string
    {
        return Media::url($this->avatar);
    }

    public function companyLogoUrl(): string
    {
        return Media::url($this->company_logo);
    }

    /**
     * "Position, Company" byline.
     */
    public function byline(): string
    {
        return collect([$this->position, $this->company])->filter()->implode(', ');
    }
}
