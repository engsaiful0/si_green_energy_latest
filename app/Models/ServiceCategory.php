<?php

namespace App\Models;

use App\Models\Concerns\IsCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceCategory extends Model
{
    use HasFactory, IsCategory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'icon',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];



    /**
     * Get the services in this category.
     */
    public function items()
    {
        return $this->services();
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}
