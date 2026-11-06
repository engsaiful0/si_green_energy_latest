<?php

namespace App\Models;

use App\Support\Media;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamMember extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Social networks a member can link to, with their Font Awesome icon.
     */
    public const SOCIAL_NETWORKS = [
        'facebook' => 'fab fa-facebook-f',
        'twitter' => 'fa-brands fa-x-twitter',
        'instagram' => 'fab fa-instagram',
        'linkedin' => 'fab fa-linkedin-in',
    ];

    protected $fillable = [
        'department_id',
        'full_name',
        'slug',
        'position',
        'email',
        'phone',
        'bio',
        'short_bio',
        'photo',
        'skills',
        'experience_years',
        'social_links',
        'is_featured',
        'order',
        'status',
    ];

    protected $casts = [
        'skills' => 'array',
        'social_links' => 'array',
        'is_featured' => 'boolean',
        'experience_years' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get the department that owns the team member.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function photoUrl(): string
    {
        return Media::url($this->photo);
    }

    /**
     * Filled social links as [['url' => ..., 'icon' => ...], ...].
     */
    public function socialLinks(): array
    {
        $links = [];

        foreach (self::SOCIAL_NETWORKS as $network => $icon) {
            if (!empty($this->social_links[$network])) {
                $links[] = ['url' => $this->social_links[$network], 'icon' => $icon];
            }
        }

        return $links;
    }
}
