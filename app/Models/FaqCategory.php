<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get the FAQs in this category.
     */
    public function faqs()
    {
        return $this->hasMany(Faq::class, 'category_id')->orderBy('order');
    }
}
