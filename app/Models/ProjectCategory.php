<?php

namespace App\Models;

use App\Models\Concerns\IsCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    use HasFactory, IsCategory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'color',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the projects in this category.
     */
    public function items()
    {
        return $this->projects();
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'category_id');
    }
}
