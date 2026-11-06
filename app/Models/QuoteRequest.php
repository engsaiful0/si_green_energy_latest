<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'service_type',
        'project_details',
        'budget',
        'preferred_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'preferred_date' => 'date',
    ];
}
