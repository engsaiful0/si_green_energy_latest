<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'image',
        'alt_text',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get the service that owns the image.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
