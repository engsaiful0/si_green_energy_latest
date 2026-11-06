<?php

namespace App\Models;

use App\Models\Concerns\IsCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SolutionCategory extends Model
{
    use HasFactory, IsCategory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'icon',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function solutions(): HasMany
    {
        return $this->hasMany(Solution::class, 'category_id');
    }

    public function items(): HasMany
    {
        return $this->solutions();
    }
}
